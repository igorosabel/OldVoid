function startApp() {
  angular
    .module('VoidApp', ['ngMaterial','ngRoute']);
}

function configApp() {
  angular
    .module('VoidApp')
    .config(function ($routeProvider, $locationProvider){

      $routeProvider
        .when('/', {
          templateUrl: 'partials/login.html',
          controller: 'LoginController',
          controllerAs: 'vm'
        })
        .when('/register', {
          templateUrl: 'partials/register.html',
          controller: 'RegisterController',
          controllerAs: 'vm'
        })
        .when('/main', {
          templateUrl: 'partials/main.html',
          controller: 'MainController',
          controllerAs: 'vm'
        })
        .when('/system', {
          templateUrl: 'partials/main.html',
          controller: 'MainController',
          controllerAs: 'vm'
        })
        .when('/system/:system_id/:system_name', {
          templateUrl: 'partials/main.html',
          controller: 'MainController',
          controllerAs: 'vm'
        })
        .otherwise({redirectTo: '/'});
      //$locationProvider.html5Mode(true);
    })
    .filter('urldecode', function () {
      return function (str) {
        str = urldecode(str);
        return str;
      };
    })
    .filter('showtime', function () {
      return function (num) {
        var m = Math.floor(num / 60);
        var s = Math.floor(num - (m * 60) );
        return ((m<10)?'0'+m:m)+':'+((s<10)?'0'+s:s);
      };
    });
}

startApp();
configApp();