(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('JobService', JobService);

  JobService.$inject = ['$rootScope','$timeout','$mdToast','DataShareService'];
  function JobService($rootScope,$timeout,$mdToast,DataShareService){
    var service = {};

    service.delay       = 1000;
    service.job         = {};
    service.job_running = false;
    service.job_toast   = null;

    service.AddJob = AddJob;
    service.CheckJob = CheckJob;
 
    return service;

    function AddJob(job){
      service.job = job;
      service.job.type_name = urldecode(service.job.type_name);
      service.job.time = GetTime();
      service.job_toast = $mdToast.simple()
                            .textContent(job.type_name+' ('+job.value.name+') '+FormatDate())
                            .position('bottom right')
                            .hideDelay(0);

      $mdToast.show( service.job_toast );

      if (!service.job_running){
        service.job_running = true;
        DataShareService.SetGlobal('working',true);
        $timeout(service.CheckJob,service.delay);
      }
    }

    function GetTime(){
      var d = new Date();
      var t = (service.job.start+service.job.duration) - (d.getTime()/1000);
      if (t<0){
        return {t:0,m:0,s:0};
      }
      else{
        var obj = {};
        obj.t = Math.floor(t);

        return obj;
      }
    }

    function GetTimePretty(){
      if (service.job.time.t>0) {
        service.job.time.m = Math.floor(service.job.time.t / 60);
        service.job.time.s = Math.floor(service.job.time.t - (service.job.time.m * 60));
      }
      else{
        service.job.time.m = 0;
        service.job.time.s = 0;
      }
    }

    function FormatDate(){
      GetTimePretty();
      return ((service.job.time.m<10)?'0'+service.job.time.m:service.job.time.m)+':'+((service.job.time.s<10)?'0'+service.job.time.s:service.job.time.s);
    }

    function CheckJob(){
      if (service.job.time.t==0){
        var new_text = service.job.type_name+' terminada ('+service.job.value.name+')';
        $rootScope.$apply(function(){
          $mdToast.updateTextContent(new_text);
        });
        service.job_running = false;
        $timeout(function(){
          $mdToast.hide(service.job_toast);
          $rootScope.$broadcast('job_finish', service.job);
          service.job         = {};
          service.job_timer   = null;
          service.job_toast   = null;
        }, 3000);
      }
      else{
        service.job.time.t--;
        var new_text = service.job.type_name+' ('+service.job.value.name+') '+FormatDate();
        $rootScope.$apply(function(){
          $mdToast.updateTextContent(new_text);
        });
      }

      if (!service.job_running){
        DataShareService.SetGlobal('working',false);
      }
      else {
        $timeout(service.CheckJob, service.delay);
      }
    }
  }
})();