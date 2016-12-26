<?php
class G_Config{
  private $debug_mode = false;
  private $allow_cross_origin = false;
  private $default_fw_modules = array();

  private $base_dir         = '';
  private $cache_dir        = '';
  private $config_dir       = '';
  private $controllers_dir  = '';
  private $model_dir        = '';
  private $model_dir_app    = '';
  private $model_dir_base   = '';
  private $model_dir_static = '';
  private $logs_dir         = '';
  private $debug_log_dir    = '';
  private $tasks_dir        = '';
  private $sql_dir          = '';
  private $templates_dir    = '';
  private $tmp_dir          = '';
  private $web_dir          = '';
  private $img_dir          = '';
  private $thumb_dir        = '';

  private $db_user = '';
  private $db_pass = '';
  private $db_host = '';
  private $db_name = '';
  
  private $base_url   = '';
  private $folder_url = '';
  private $api_url    = '';
  
  private $closed = false;
  
  private $cookie_prefix = '';
  private $cookie_url    = '';
  
  private $css_list              = array();
  private $ext_css_list          = array();
  private $js_list               = array();
  private $ext_js_list           = array();
  private $default_title         = '';
  private $default_lang          = 'es';
  private $admin_email           = '';
  private $mailing_from          = '';
  private $lang                  = '';
  private $image_types           = array();

  /* Void */
  private $max_connections        = 3;
  private $life_bonus             = 2;
  private $max_npc                = 2;
  private $npc_prob               = 3;
  private $system_name_chars      = 3;
  private $system_name_nums       = 3;
  private $default_ship_hull      = 1;
  private $default_ship_shield    = 1;
  private $default_ship_engine    = 1;
  private $default_ship_generator = 1;
  private $default_gun            = 1;
  private $default_modules        = array(1,2);
  private $max_sell_hulls         = 2;
  private $max_sell_shields       = 2;
  private $max_sell_engines       = 2;
  private $max_sell_generators    = 2;
  private $max_sell_guns          = 2;
  private $max_sell_modules       = 2;
  private $max_sell_crew          = 2;
  private $max_sell_resources     = 4;

  function __construct(){}
  
  // Debug mode
  function setDebugMode($dm){
    $this->debug_mode = $dm;
  }
  function getDebugMode(){
    return $this->debug_mode;
  }
  
  // Allow Cross-Origin
  public function setAllowCrossOrigin($aco){
    $this->allow_cross_origin = $aco;
  }
  public function getAllowCrossOrigin(){
    return $this->allow_cross_origin;
  }
  
  // Default modules
  public function setDefaultFwModules($dfm){
    $this->default_fw_modules = $dfm;
  }
  public function getDefaultFwModules(){
    return $this->default_fw_modules;
  }

  public function loadDefaultFwModules(){
    $ruta_base_json = $this->getConfigDir().'base.json';
    if (file_exists($ruta_base_json)){
      $base_json = json_decode( file_get_contents($ruta_base_json), true );
      $this->setDefaultFwModules($base_json);
    }
  }

  public function getDefaultFwModule($m){
    $base_modules = $this->getDefaultFwModules();
    if (array_key_exists($m,$base_modules['base_modules']) && $base_modules['base_modules'][$m]===true){
      return true;
    }
    else{
      return false;
    }
  }
  
  // Dirs
  function setBaseDir($bd){
    $this->base_dir = $bd;
    $this->setCacheDir(       $bd.'cache/');
    $this->setConfigDir(      $bd.'config/');
    $this->setControllersDir( $bd.'controllers/');
    $this->setModelDir(       $bd.'model/');
    $this->setModelDirApp(    $bd.'model/app/');
    $this->setModelDirBase(   $bd.'model/base/');
    $this->setModelDirStatic( $bd.'model/static/');
    $this->setLogsDir(        $bd.'logs/');
    $this->setDebugLogDir(    $bd.'logs/debug.log');
    $this->setTasksDir(       $bd.'task/');
    $this->setSQLDir(         $bd.'sql/');
    $this->setTemplatesDir(   $bd.'templates/');
    $this->setTmpDir(         $bd.'tmp/');
    $this->setWebDir(         $bd.'web/');
    $this->setImgDir(         $bd.'web/img/');
    $this->setThumbDir(       $bd.'web/img/thumb');
  }
  
  function getBaseDir(){
    return $this->base_dir;
  }

  function setCacheDir($cd){
    $this->cache_dir = $cd;
  }
  function getCacheDir(){
    return $this->cache_dir;
  }
  
  function setConfigDir($cd){
    $this->config_dir = $cd;
  }
  function getConfigDir(){
    return $this->config_dir;
  }

  function setControllersDir($cd){
    $this->controllers_dir = $cd;
  }
  function getControllersDir(){
    return $this->controllers_dir;
  }
  
  function setModelDir($md){
    $this->model_dir = $md;
  }
  function getModelDir(){
    return $this->model_dir;
  }
  
  function setModelDirApp($mda){
    $this->model_dir_app = $mda;
  }
  function getModelDirApp(){
    return $this->model_dir_app;
  }
  
  function setModelDirBase($mdb){
    $this->model_dir_base = $mdb;
  }
  function getModelDirBase(){
    return $this->model_dir_base;
  }
  
  function setModelDirStatic($mds){
    $this->model_dir_static = $mds;
  }
  function getModelDirStatic(){
    return $this->model_dir_static;
  }
  
  function setLogsDir($ld){
    $this->logs_dir = $ld;
  }
  function getLogsDir(){
    return $this->logs_dir;
  }
  
  function setDebugLogDir($dld){
    $this->debug_log_dir = $dld;
  }
  function getDebugLogDir(){
    return $this->debug_log_dir;
  }
  
  function setTasksDir($td){
    $this->tasks_dir = $td;
  }
  function getTasksDir(){
    return $this->tasks_dir;
  }

  function setSQLDir($sd){
    $this->sql_dir = $sd;
  }
  function getSQLDir(){
    return $this->sql_dir;
  }

  function setTemplatesDir($td){
    $this->templates_dir = $td;
  }
  function getTemplatesDir(){
    return $this->templates_dir;
  }

  function setTmpDir($td){
    $this->tmp_dir = $td;
  }
  function getTmpDir(){
    return $this->tmp_dir;
  }
  
  function setWebDir($wd){
    $this->web_dir = $wd;
  }
  function getWebDir(){
    return $this->web_dir;
  }

  function setImgDir($id){
    $this->img_dir = $id;
  }
  function getImgDir(){
    return $this->img_dir;
  }

  function setThumbDir($td){
    $this->thumb_dir = $td;
  }
  function getThumbDir(){
    return $this->thumb_dir;
  }
  
  // Base de datos
  function setDbUser($du){
    $this->db_user = $du;
  }
  function getDbUser(){
    return $this->db_user;
  }
  
  function setDbPass($dp){
    $this->db_pass = $dp;
  }
  function getDbPass(){
    return $this->db_pass;
  }
  
  function setDbHost($dh){
    $this->db_host = $dh;
  }
  function getDbHost(){
    return $this->db_host;
  }
  
  function setDbName($dn){
    $this->db_name = $dn;
  }
  function getDbName(){
    return $this->db_name;
  }
  
  // Urls
  function setBaseUrl($bu){
    $this->base_url = $bu;
    $this->setApiUrl($bu.$this->getFolderUrl().'api/');
  }
  function getBaseUrl(){
    return $this->base_url;
  }
  
  function setFolderUrl($fu){
    $this->folder_url = $fu;
  }
  function getFolderUrl(){
    return $this->folder_url;
  }
    
  function setApiUrl($au){
    $this->api_url = $au;
  }
  function getApiUrl(){
    return $this->api_url;
  }
  
  // Extras
  function setClosed($c){
    $this->closed = $c;
  }
  function getClosed(){
    return $this->closed;
  }
  
  public function setImageTypes($it){
    $this->image_types = $it;
  }
  public function getImageTypes(){
    return $this->image_types;
  }
  
  // Cookies
  public function setCookiePrefix($cp){
    $this->cookie_prefix = $cp;
  }
  public function getCookiePrefix(){
    return $this->cookie_prefix;
  }

  public function setCookieUrl($cu){
    $this->cookie_url = $cu;
  }
  public function getCookieUrl(){
    return $this->cookie_url;
  }
  
  // Templates
  public function setCssList($cl){
    $this->css_list = $cl;
  }
  public function getCssList(){
    return $this->css_list;
  }
  public function addCssList($item){
    $css_list = $this->getCssList();
    array_push($css_list,$item);
    $this->setCssList($css_list);
  }
  
  public function setExtCssList($ecl){
    $this->ext_css_list = $ecl;
  }
  public function getExtCssList(){
    return $this->ext_css_list;
  }
  public function addExtCssList($item){
    $css_list = $this->getExtCssList();
    array_push($css_list,$item);
    $this->setExtCssList($css_list);
  }
  
  public function setJsList($jl){
    $this->js_list = $jl;
  }
  public function getJsList(){
    return $this->js_list;
  }
  public function addJsList($item){
    $js_list = $this->getJsList();
    array_push($js_list,$item);
    $this->setJsList($js_list);
  }
  
  public function setExtJsList($ejl){
    $this->ext_js_list = $ejl;
  }
  public function getExtJsList(){
    return $this->ext_js_list;
  }
  public function addExtJsList($item){
    $js_list = $this->getExtJsList();
    array_push($js_list,$item);
    $this->setExtJsList($js_list);
  }
  
  public function setDefaultTitle($dt){
    $this->default_title = $dt;
  }
  public function getDefaultTitle(){
    return $this->default_title;
  }
  
  public function setDefaultLang($dl){
    $this->default_lang = $dl;
  }
  public function getDefaultLang(){
    return $this->default_lang;
  }
  
  function setAdminEmail($ae){
    $this->admin_email = $ae;
  }
  function getAdminEmail(){
    return $this->admin_email;
  }
  
  function setMailingFrom($mf){
    $this->mailing_from = $mf;
  }
  function getMailingFrom(){
    return $this->mailing_from;
  }

  function setLang($l){
    $this->lang = $l;
  }
  function getLang(){
    return $this->lang;
  }

  // Void
  function setMaxConnections($mc){
    $this->max_connections = $mc;
  }
  function getMaxConnections(){
    return $this->max_connections;
  }

  function setLifeBonus($lb){
    $this->life_bonus = $lb;
  }
  function getLifeBonus(){
    return $this->life_bonus;
  }

  function setMaxNPC($mn){
    $this->max_npc = $mn;
  }
  function getMaxNPC(){
    return $this->max_npc;
  }

  function setNPCProb($np){
    $this->npc_prob = $np;
  }
  function getNPCProb(){
    return $this->npc_prob;
  }

  function setSystemNameChars($snc){
    $this->system_name_chars = $snc;
  }
  function getSystemNameChars(){
    return $this->system_name_chars;
  }

  function setSystemNameNums($snn){
    $this->system_name_nums = $snn;
  }
  function getSystemNameNums(){
    return $this->system_name_nums;
  }

  function setDefaultShipHull($dsh){
    $this->default_ship_hull = $dsh;
  }
  function getDefaultShipHull(){
    return $this->default_ship_hull;
  }

  function setDefaultShipShield($dss){
    $this->default_ship_shield = $dss;
  }
  function getDefaultShipShield(){
    return $this->default_ship_shield;
  }

  function setDefaultShipEngine($dse){
    $this->default_ship_engine = $dse;
  }
  function getDefaultShipEngine(){
    return $this->default_ship_engine;
  }

  function setDefaultShipGenerator($dsg){
    $this->default_ship_generator = $dsg;
  }
  function getDefaultShipGenerator(){
    return $this->default_ship_generator;
  }

  function setDefaultGun($dg){
    $this->default_gun = $dg;
  }
  function getDefaultGun(){
    return $this->default_gun;
  }

  function setDefaultModules($dm){
    $this->default_modules = $dm;
  }
  function getDefaultModules(){
    return $this->default_modules;
  }

  function setMaxSellHulls($msh){
    $this->max_sell_hulls = $msh;
  }
  function getMaxSellHulls(){
    return $this->max_sell_hulls;
  }

  function setMaxSellShields($mss){
    $this->max_sell_shields = $mss;
  }
  function getMaxSellShields(){
    return $this->max_sell_shields;
  }

  function setMaxSellEngines($mse){
    $this->max_sell_engines = $mse;
  }
  function getMaxSellEngines(){
    return $this->max_sell_engines;
  }

  function setMaxSellGenerators($msg){
    $this->max_sell_generators = $msg;
  }
  function getMaxSellGenerators(){
    return $this->max_sell_generators;
  }

  function setMaxSellGuns($msg){
    $this->max_sell_guns = $msg;
  }
  function getMaxSellGuns(){
    return $this->max_sell_guns;
  }

  function setMaxSellModules($msm){
    $this->max_sell_modules = $msm;
  }
  function getMaxSellModules(){
    return $this->max_sell_modules;
  }

  function setMaxSellCrew($msc){
    $this->max_sell_crew = $msc;
  }
  function getMaxSellCrew(){
    return $this->max_sell_crew;
  }

  function setMaxSellResources($msr){
    $this->max_sell_resources = $msr;
  }
  function getMaxSellResources(){
    return $this->max_sell_resources;
  }
}