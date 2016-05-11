(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('JobService', JobService);

  JobService.$inject = ['$rootScope','$mdToast','DataShareService'];
  function JobService($rootScope,$mdToast,DataShareService){
    var service = {};

    service.job_list    = {};
    service.job_running = false;
    service.job_timer   = null;

    service.AddJob = AddJob;
    service.CheckJobs = CheckJobs;
 
    return service;

    function AddJob(job){
      service.job_list['job_'+job.id] = job;
      if (!service.job_running){
        service.job_running = true;
        DataShareService.SetGlobal('working',true);
        service.job_timer = setTimeout(service.CheckJobs,1000);
      }
    }

    function CheckJobs(){
      clearTimeout(service.job_timer);
      var d        = new Date();
      var finished = [];
      var id_job, job;

      for (id_job in service.job_list){
        job = service.job_list[id_job];
        if (d.getTime()>(job.start+job.duration)){
          finished.push(job.id);
          ShowMessage(job);
          $rootScope.$broadcast('job_finish', job);
        }
      }

      for (var id_job in finished){
        delete service.job_list['job_'+finished[id_job]];
      }

      if (Object.keys(service.job_list).length==0){
        service.job_running = false;
        DataShareService.SetGlobal('working',false);
      }
      else {
        service.job_timer = setTimeout(service.CheckJobs(), 1000);
      }
    }

    function ShowMessage(job){
      $mdToast.show(
        $mdToast.simple()
          .textContent(template('toast_template',{name:urldecode(job.type_name)+'('+job.value.name+')'}))
          .position('bottom right')
          .hideDelay(3000)
      );
    }
  }
})();