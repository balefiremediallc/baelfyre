<?php

class Nav {

public $name;
public $class;

function __construct() {

}

function Init() {

}

function Build() {

}

function Render() {
    $output = '<nav role="navigation" aria-label="'.$this->name.'" class="'.$this->class.'">';
    $output .= '';
    foreach($this->navarr as $key => $val) {
      $output .= '';
    }

    $output .= '';
    $output .= '';
    $output .= '</nav>';

    return $output;
}

}
?>
