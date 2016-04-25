<div id="container">

  <div id="pag_login" class="page center" data-from="left" data-to="left">
    <form name="frm_login" id="frm_login" method="post" action="{{URL_LOGIN}}" novalidate>
      <input type="hidden" name="login_fingerprint" id="login_fingerprint" value="" />
      <div class="login_title">Checker</div>
      <div class="login_form">
        <input type="email" name="login_email" id="login_email" placeholder="Email" autofocus />
        <input type="password" name="login_pass" id="login_pass" placeholder="Contraseña" />
        <input type="submit" name="login_go" id="login_go" value="Entrar" />
        <div id="login_loading">
          <img src="img/loading.gif" alt="Cargando..." />
        </div>
      </div>
    </form>
    <a href="#" id="login_pass_forgotten">¿Olvidaste tu contraseña?</a>
    <a href="#" id="login_register">¡Registrate!</a>
    {{ERROR_MENS}}
  </div>

  <div id="pag_pass" class="page right" data-previous="login" data-from="right" data-to="right">
    <header>
      <a href="#" id="pass_forgotten_back" class="header_btn header_btn_left">Volver</a>
      <div class="header_title">Checker</div>
    </header>
    <div class="pag_body">
      <div class="pass_forgotten_text">
        Para obtener una nueva contraseña introduce tu email.
        Te enviaremos un email con instrucciones para que restablezcas tu contraseña.
      </div>
      <input type="email" name="pass_forgotten_email" id="pass_forgotten_email" value="" placeholder="Email" />
      <input type="button" name="pass_forgotten_go" id="pass_forgotten_go" value="Enviar" />
      <div id="pass_forgotten_loading">
        <img src="img/loading.gif" alt="Cargando..." />
      </div>
    </div>
  </div>
  
  <div id="pag_reg" class="page right" data-previous="login" data-from="right" data-to="right">
    <header>
      <a href="#" id="register_back" class="header_btn header_btn_left">Volver</a>
      <div class="header_title">Checker</div>
    </header>
    <div class="pag_body">
      <div class="pag_description">
        Registrarte en Checker es tan simple como introducir el nombre de usuario que quieras tener, una dirección de email (que solo usaremos para contactar contigo en caso de que pierdas tu contraseña) y la contraseña con la que quieras acceder al sitio o la aplicación.
      </div>
      <input type="text" name="register_user" id="register_user" value="" placeholder="Usuario" />
      <input type="email" name="register_email" id="register_email" value="" placeholder="Email" />
      <input type="password" name="register_pass" id="register_pass" value="" placeholder="Contraseña" />
      <input type="button" name="register_go" id="register_go" value="Enviar" />
      <div id="register_loading">
        <img src="img/loading.gif" alt="Cargando..." />
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var api_url = '{{API_URL}}';
</script>