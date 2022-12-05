<?php

class BlockHello extends Block {
  private $text;
  function __construct($id,$params,$class=null) {
    parent::__construct($id,$params,$class);
    $this->text = $params;
  }

  function __toString() {
    return $this->tag('p',$this->text);
  }
}