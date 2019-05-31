(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('WSService', WSService);

  WSService.$inject = [];
  function WSService($http,$location,DataShareService){
    var ws_config = {
      url: 'osumi.es',
      port: '9000'
    };
    var service = {};
 
    service.callbacks      = {};
    service.Socket         = null;
    service.OnOpen         = OnOpen;
    service.OnMessage      = OnMessage;
    service.OnClose        = OnClose;
    service.Init           = Init;
    service.Quit           = Quit;
    service.Reconnect      = Reconnect;
    service.Send           = Send;
    service.DeleteCallback = DeleteCallback;
    
    service.Login        = Login;
    service.LoginReceive = null;

    return service;

    function Init(){
      var host = 'ws://'+ws_config.url+':'+ws_config.port;
      try {
        service.Socket           = new WebSocket(host);
        service.Socket.onopen    = OnOpen;
        service.Socket.onmessage = OnMessage;
        service.Socket.onclose   = OnClose;
	    }
      catch(ex){ 
        console.log(ex); 
	    }
    }

    function OnOpen(msg){
      console.log('Welcome - status '+this.readyState);
    }

    function OnMessage(msg){
      var data = JSON.parse(msg.data);
      console.log('Received: ',data);

      service.callbacks[data.uuid](data);
    }

    function OnClose(msg){
      console.log('Disconnected - status '+this.readyState);
    }

    function Quit(){
      if (service.Socket != null){
        service.Socket.close();
        service.Socket = null;
	    }
    }

    function Reconnect(){
      service.Quit();
      service.Init();
    }

    function Send(data){
      service.Socket.send(JSON.stringify(data));
    }
    
    function DeleteCallback(uuid){
      delete service.callbacks[uuid];
    }

    function Login(email, pass, callback){
      var data = {
        action: 'voidLogin',
        email: urlencode(email),
        pass: urlencode(pass),
        uuid: guid()
      };
      service.callbacks[data.uuid] = callback;
      service.Send(data);
    }
  }
})();