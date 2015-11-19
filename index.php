<?php
session_start();
include_once dirname(__FILE__).'/app/conf.php';
include_once INC.'request.php';

// get the requested client site figured out
$sitedir = $_SERVER['HTTP_HOST'].'/';
if(strpos('www.',$_SERVER['HTTP_HOST'])){
  $sitedir = str_replace('www','',$_SERVER['HTTP_HOST']).'/';
}

if(!isset($_SESSION['site'])) {
  $_SESSION['site'] = dirname(__FILE__).'/sites/'.$sitedir;
}

// ok, let's start working out that request
switch($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    $request = array('site'=>$sitedir,'template'=>'home','page'=>'home');
    if(isset($_GET['c'])) {
      $cat  = $_GET['c'];
      $page = $_GET['p'];
      $request = array('site'=>$sitedir,'template'=>$cat,'page'=>$page);
    }
  break;

  case 'POST':
    $request = 'post';
  break;
}

// alright, load up what we need here
$build = new Request;
$render = build::Init($request);
 ?>
