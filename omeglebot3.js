/*Version027*/

function includeScript(src){
  new Element('script', {type: 'text/javascript', src: src}).inject(document.head)
  //http://192.168.1.149/chatbot/handlemsg?noadd=true&nolog=true&norep=true&callback=$empty&version=0
  
}

if(!window.botvars){
  window.botvars = "defined";
  
  var chatid = Math.floor(Math.random()*720575069); //arbitrary bases are fun
  var botname = "Bot";
  var lasttime = 0;
  var postdelay = 500;
  var learnonly = false;
  var activetimeout = 40000;
  var codeversion = 0;
  
  var lastmsg = "";
  var lastuser = "";
  var botposts = 1;
  var strangerposts = 1;
  var botconsec = 0;
}

var botsig = "           ";

window.confirm=function(){return true};

function nowstat(){
  $("tagline").innerHTML = "v"+codeversion+" R: "+(Math.floor(100*botposts/strangerposts)/100)+" C: "+botconsec+" Chat: #"+chatid;
}

function disco(){
  $$(".disconnectbtn")[0].fireEvent("click");
}

function logconv(user, message, conf){
  if(!conf) conf={};
  if(message.length > 512){
    message = message.substr(0, 500)+"... Message Truncated";
  }
  if(message.length > 140){ //should fit in a tweet
    conf.noadd = true;
  }
  //?last=&new=Hi&user=Bot&id=1337
  //?last=lastmsg&new=message&user=user&id=chatid
  /*
  var xhr = new unsafeXMLHttpRequest();
  xhr.open("GET", "", false);
  xhr.onload = function(e){
    console.log(e.responseText)
  }
  xhr.send(null);
  */
  new Request.JSONP({
  url: 'http://192.168.1.149/chatbot/handlemsg.php',
    data: $extend({
      'last': lastmsg,
      'new': message,
      'user': user,
      'version': codeversion,
      'id': chatid,
      'type': lastuser==botname?"topic":"reply"
    }, conf),
    onComplete: function(e){
      if(e.text && (lastuser != botname || (new Date).getTime() - lasttime > activetimeout)){
        if(botposts == 0){
          e.text += botsig; //unique Frs0t Ps0t Id3nt1f1er (to prevent bot-to-bot action)
        }
        sendmsg(e.text);
        lasttime = (new Date).getTime();
      }
      nowstat();
    }
  }).send();

  
  lastuser = user;
  lastmsg = message;
}

function endconv(){
  //reply with blank topic
  setTimeout(function(){
    //sendmsg("Hi")
    lastmsg = "";
    botposts = 1;
    strangerposts = 1;
    logconv(botname, "", {noadd: true, nolog: true, endlog: true})
    lasttime = 0;
    chatid = Math.floor(Math.random()*99999999);
  },1000)
}

function checkmsg(){
  $each($$(".youmsg:not(.checked)"),function(el){
    Element.addClass(el,"checked");
    var text = el.textContent.substr(5)
    logconv(botname, text);
    botposts++;
    botconsec++;
  })

  $each($$(".strangermsg:not(.checked)"),function(el){
    Element.addClass(el,"checked");
    var text = el.textContent.substr(10)
    if(strangerposts < 2 && el.innerHTML.indexOf(botsig) != -1){
      return disco();
    }
    logconv("Stranger", text);
    strangerposts++;
    botconsec = 0;
  })
}


function checkdisconnect(){
  $("adwrapper").style.display = "block";
  if((botposts/strangerposts > 3.1415926535897932384626433827950 || botconsec > 5) && (botposts+strangerposts) > 14 /*age*/){
    disco(); //Hear the music? Cuz u just got disco-nnected!
  }
  if($$("input[type=submit]")[0]){ //press the reconnect button if disconnected
    $$("input[type=submit]")[0].fireEvent("click");
    endconv();
  }else if((new Date).getTime() - lasttime > activetimeout){
    logconv(botname, "", {noadd: true, nolog: true});
  }
}

function setai(mode){
learnonly = !(mode.checked)
}

function sendmsg(txt){
  if(learnonly)return;
  $$(".chatmsg")[0].value = txt
  $$(".chatmsg")[0].fireEvent("keydown")
  setTimeout(function(){
    if($$(".chatmsg")[0].value == txt){
    $$(".sendbtn")[0].fireEvent("click")
  }

  },postdelay + (txt.length/5) * (Math.floor(Math.random()*1000) + 1000/60))
}

$("adwrapper").innerHTML = "Learn Only: <input type='checkbox' checked onchange='setai(this)'>";

if(!window.botrunning){
  window.botrunning = true;
  setInterval(function(){checkdisconnect()}, 5000);
  setInterval(function(){checkmsg()}, 100);

  if($("chatbutton")){
    $("chatbutton").firstChild.fireEvent('click');
}
}

//ugh a mootools module. Hafta add this or else JSONP wawnt wurk. y dunt u add it in cawre?
Request.JSONP=new Class({Implements:[Chain,Events,Options],options:{url:"",data:{},retries:0,timeout:0,link:"ignore",callbackKey:"callback",injectScript:document.head},initialize:function(A){this.setOptions(A);this.running=false;this.requests=0;this.triesRemaining=[]},check:function(){if(!this.running){return true}switch(this.options.link){case"cancel":this.cancel();return true;case"chain":this.chain(this.caller.bind(this,arguments));return false}return false},send:function(C){if(!$chk(arguments[1])&&!this.check(C)){return this}var E=$type(C),A=this.options,B=$chk(arguments[1])?arguments[1]:this.requests++;if(E=="string"||E=="element"){C={data:C}}C=$extend({data:A.data,url:A.url},C);if(!$chk(this.triesRemaining[B])){this.triesRemaining[B]=this.options.retries}var D=this.triesRemaining[B];(function(){var F=this.getScript(C);this.fireEvent("request",F);this.running=true;(function(){if(D){this.triesRemaining[B]=D-1;if(F){F.destroy();this.send(C,B);this.fireEvent("retry",this.triesRemaining[B])}}else{if(F&&this.options.timeout){F.destroy();this.cancel();this.fireEvent("failure")}}}).delay(this.options.timeout,this)}).delay(Browser.Engine.trident?50:0,this);return this},cancel:function(){if(!this.running){return this}this.running=false;this.fireEvent("cancel");return this},getScript:function(C){var B=Request.JSONP.counter,D;Request.JSONP.counter++;switch($type(C.data)){case"element":D=document.id(C.data).toQueryString();break;case"object":case"hash":D=Hash.toQueryString(C.data)}var E=C.url+(C.url.test("\\?")?"&":"?")+(C.callbackKey||this.options.callbackKey)+"=Request.JSONP.request_map.request_"+B+(D?"&"+D:"");var A=new Element("script",{type:"text/javascript",src:E});Request.JSONP.request_map["request_"+B]=function(F){this.success(F,A)}.bind(this);return A.inject(this.options.injectScript)},success:function(B,A){if(A){A.destroy()}this.running=false;this.fireEvent("complete",[B]).fireEvent("success",[B]).callChain()}});Request.JSONP.counter=0;Request.JSONP.request_map={};
//argh. i think botbash is stupidifying me.
