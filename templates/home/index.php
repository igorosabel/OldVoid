<div ng-app="VoidApp">
  <div id="views" ng-view></div>
</div>

<script>
  var api_url = '{{API_URL}}';
</script>
<script src="js/lib/common.js"></script>
<script src="js/lib/angular.min.js"></script>
<script src="js/lib/angular-route.min.js"></script>
<script src="js/app.js"></script>
<script src="js/controllers/login-controller.js"></script>
<script src="js/controllers/register-controller.js"></script>
<script src="js/controllers/main-controller.js"></script>
<script src="js/controllers/header-controller.js"></script>
<script src="js/controllers/panel-controller.js"></script>
<script src="js/controllers/system-controller.js"></script>
<script src="js/services/authentication-service.js"></script>
<script src="js/services/data-share-service.js"></script>
<script src="js/services/api-service.js"></script>
<script src="js/directives/header-directive.js"></script>
<script src="js/directives/panel-directive.js"></script>
<script src="js/directives/system-directive.js"></script>