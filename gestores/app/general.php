<?php
class General{
  public static function generateSystem(){
    global $c;
    $s = new G_System();
    $system_types = Base::getCache('system');
    $type         = $system_types['system_types'][array_rand($system_types['system_types'])];
    $s_name       = Base::getRandomCharacters(array('num'=>3,'upper'=>true)).'-'.Base::getRandomCharacters(array('num'=>3,'numbers'=>true));
    $num_planets  = rand($type['min_planets'],$type['max_planets']);

    $s->set('original_name',$s_name);
    $s->set('name',$s_name);
    $s->set('num_planets',$num_planets);
    $s->set('sun_id_type',$type['id']);

    $s->salvar();

    for ($i=1;$i<=$num_planets;$i++){
      $p = new G_Planet();

      $p_name = $s_name.'-'.$i;

      $p->set('id_system',$s->get('id'));
      $p->set('id_owner',null);
      $p->set('original_name',$p_name);
      $p->set('name',$p_name);

      $p->salvar();
    }
  }
}