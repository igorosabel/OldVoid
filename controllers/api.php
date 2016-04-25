<?php
  /*
    Función para comprobar un login de un usuario
  */
  function executeCheckLogin($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status      = 'ok';
    $email       = Base::getParam('email',       $req['url_params'], false);
    $pass        = Base::getParam('pass',        $req['url_params'], false);
    $fingerprint = Base::getParam('fingerprint', $req['url_params'], 0);
    
    $id_user        = 0;
    $user           = '';
    $auth           = '';
    $default_public = 'false';
    $default_geo    = 'false';
    $show_private   = 'false';
    $num            = 0;
    $device_name    = '';

    if ($email===false || $pass===false || $fingerprint===0){
      $status = 'error';
    }

    if ($status=='ok'){
      $email = urldecode($email);
      $pass  = sha1(urldecode($pass));

      $u = new G_Usuario();
      if ($u->login($email,$pass)){
        $auth = sha1('chk_'.rand().'_chk');

        $ua = $_SERVER['HTTP_USER_AGENT'];
        $device_name = General::getDeviceName($ua);

        $a = new G_Auth();
        $a->set('id_usuario',$u->get('id'));
        $a->set('fingerprint',$fingerprint);
        $a->set('device_name',$device_name);
        $a->set('auth_key',$auth);
        $a->set('last_checked',date('Y-m-d h:i:s',time()));
        $a->salvar();
        
        $id_user        = $u->get('id');
        $user           = $u->get('user');
        $default_public = ($u->get('default_public')==1)?'true':'false';
        $default_geo    = ($u->get('default_geo')==1)?'true':'false';
        $show_private   = ($u->get('show_private')==1)?'true':'false';
        $num            = $u->get('num');
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->add('id_user',$id_user);
    $t->add('fingerprint',$fingerprint);
    $t->add('device_name',$device_name);
    $t->add('user',$user);
    $t->add('auth',$auth);
    $t->add('default_public',$default_public);
    $t->add('default_geo',$default_geo);
    $t->add('show_private',$show_private);
    $t->add('email',$email);
    $t->add('num',$num);

    $t->process();
  }