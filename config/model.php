<?php
  // Base
  include($c->getModelDirBase().'G_Base.php');
  include($c->getModelDirBase().'G_DB.php');
  include($c->getModelDirBase().'G_Log.php');
  include($c->getModelDirBase().'G_Url.php');
  include($c->getModelDirBase().'G_Template.php');
  include($c->getModelDirBase().'G_Session.php');
  include($c->getModelDirBase().'G_Cookie.php');
  include($c->getModelDirBase().'G_Browser.php');
  include($c->getModelDirBase().'SimpleImage.php');
  include($c->getModelDirBase().'G_Image.php');
  include($c->getModelDirBase().'G_Email.php');
  include($c->getModelDirBase().'G_Translate.php');
  include($c->getModelDirBase().'base.php');
  
  // App
  if ($model = opendir($c->getModelDirApp())) {
    while (false !== ($entry = readdir($model))) {
      if ($entry != "." && $entry != "..") {
        include($c->getModelDirApp().$entry);
      }
    }
    closedir($model);
  }
  
  // Static
  if ($model = opendir($c->getModelDirStatic())) {
    while (false !== ($entry = readdir($model))) {
      if ($entry != "." && $entry != "..") {
        include($c->getModelDirStatic().$entry);
      }
    }
    closedir($model);
  }