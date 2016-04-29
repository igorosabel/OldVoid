function startApp() {
  angular
    .module('VoidApp', ['ngRoute']);
}

function configApp() {
  angular
    .module('VoidApp')
    .config(function ($routeProvider, $locationProvider) {
      angular.void = {
      };

      $routeProvider
        .when('/', {
          templateUrl: 'partials/login.html',
          controller: 'LoginController',
          controllerAs: 'vm'
        })
        .when('/registro', {
          templateUrl: 'partials/register.html',
          controller: 'RegisterController',
          controllerAs: 'vm'
        })
        .otherwise({redirectTo: '/'});
      $locationProvider.html5Mode(true);
    });
}

startApp();
configApp();