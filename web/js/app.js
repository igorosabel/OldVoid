function startApp() {
  angular
    .module('VoidApp', ['ngRoute']);
}

function configApp() {
  angular
    .module('VoidApp')
    .config(function ($routeProvider, $locationProvider) {
      angular.voidgame = {
      };

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
        .otherwise({redirectTo: '/'});
      //$locationProvider.html5Mode(true);
    });
}

startApp();
configApp();