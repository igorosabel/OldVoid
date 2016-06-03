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
        .when('/loading', {
          templateUrl: 'partials/loading.html',
          controller: 'LoadingController',
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
    });
}

startApp();
configApp();