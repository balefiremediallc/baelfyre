<?php
namespace App\Inc;

include_once DB;

class Request extends Db{
  protected $build_arr;
  protected $site;
  protected $template;
  protected $page;
  protected $page_id;
  protected $plugin_arr;

  function Init($arr) {
    $this->site = '';
    $this->template = '';
    $this->page = '';
    $this->page_id = '';
    $this->plugin_arr = array();

    if(is_array($arr)){

      // let's open up this array
      foreach($arr as $key => $value) {
        // does the customer site exist?
        if($key == 'site' && is_file(SITE)) {
          $this->site = SITE;
        }
        //does the template file exist?
        if ($key == 'template' && is_file($this->site.$value.'.tpl')) {
          $this->template = $this->site.$value.'.tpl';
        }
        // if the template file exists, let's check the database for the page name
        if($key == 'page' && $this->template != '') {
          $page_qry = parent::FetchSingle('pages',array('name'=>$value));
          // if our query returned a match, let's make it official for the build array later on
          if($page_qry) {
            $this->page = $value;
            $this->page_id = $page_qry['id'];
          }
        }
      }

      // ok we're out of the verification loop. let's serve up something useful just in case we have a fail
      if($this->template == '' || $this->page == '') {
        $this->template = THEME.'404.tpl';
        $this->page = '404';
        $this->plugin_arr = '';
      } else {
        $template_scan = file_get_contents($this->template);
        if(preg_match_all('/{+(.*?)}/', $template_scan, $matches)) {
            $this->plugin_arr=($matches[1]);
        }
      }

      $this->build_arr = array('template'=>$this->template,'page' => $this->page,'build'=>$this->plugin_arr);

    } else {
      //todo: add form post logic

      $this->build_arr = array();
    }

    self::Build();
  }

  function Build() {

    if(is_array($this->build_arr['build'])) {
      // lets make sure the plugins content are in the db for the page
      $plugin_qry = parent::FetchAll('plugin',array('page_id'=>$this->page_id,'status'=>1));
      // setup a placeholder array
      $plugin = array();
      // get what we're gonna fill the placeholder array with
      foreach($plugin_qry as $key => $val) {
        if(in_array($key,$this->build_arr['build'])) {
          $plugin[$key] = $val;
        }
      }
    }
    self::Render($plugin);
  }

  function Render($arr) {
    $page  = ''; //header here
    foreach($arr as $key => $val) {
      $page .= preg_replace("/\{([^\{]{1,100}?)\}/e","$key[$val]",file_get_contents($this->template));
    }
    $page .= ''; //footer here
    print $page;
  }

}
?>
