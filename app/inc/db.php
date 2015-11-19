<?php
namespace App\Inc;

class Db extends PDO {
  protected $tbl;
  protected $qrytype;
  protected $page_id;
  protected $stm;

  function __construct() {
    $pdo = new PDO(DBTYPE.':host='.DBHOST.';port='.DBPORT.';dbname='.DBNAME.'', DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  function ClosePDO() {
    sleep(8);
    $pdo = self::__construct();
    $this->pdo = null;
    sleep(5);
  }

  function PreparedStatement($arr) {
    $pdo = self::__construct();
    //'FetchAll','plugin',array('page_id'=>$this->page_id,'status'=>1));
    foreach($arr as $key => $val){
      $this->qrytype = $key[0];
      $this->tbl = $key[1];
      $qry_arr = $key[2];
    }


    $this->stm = $pdo->prepare();

  }

  function FetchSingle($arr) {

  }

  function FetchAll($arr) {



  }

}
?>
