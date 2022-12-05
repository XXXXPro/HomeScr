<?php

class HomeScreen {
  private $settings;
  private $dbg = [];

  function __construct() {
    spl_autoload_register([$this,'class_loader']);
  }

  function main()  {
    $filename = __DIR__.'/settings.json';
    if (!is_readable($filename)) die('No settings.json file or wrong permissions! Copy and edit settings.json.sample for your needs.');
    $this->settings = json_decode(file_get_contents($filename));
    if (empty($this->settings)) die('File settings.json is empty or damaged.');

    $blocks = [];
    $item_number = 0;

    foreach ($this->settings->blocks as $item) {
      try {
        $classname = 'Block'.$item->type;
        if (class_exists($classname)) $this->debug("Class $classname for item #$item_number not found!");
        if (empty($item->area)) $this->debug("No area name specified for ".$item->type." item #$item_number.");
        if (empty($item->id)) $item->id ='block'.$item_number;
        $blck_class = new $classname($item->id,$item->params,$item->class ?? null);
        if ($this->is_preloading()) {
          $blck_class->preload();
        }
        else {
          if (empty($blocks[$item->area])) $blocks[$item->area]='';
          $blocks[$item->block].=$blck_class;
        }
      }
      catch (Exception $e) {
        $this->debug("Error in item ".$item->type);
      }
      $item_number++;
    }
    
    if (!$this->is_preloading()) {
      $template = $this->settings->template ?? 'default';
      $template_file = __DIR__."/template/$template/template.php";
      if (!is_readable($template_file)) die("Error loading template file $template_file");
      require $template_file;
    }
  }

  function is_debugging() {
    return (!empty($_REQUEST['debug']));
  }

  function is_preloading() {
    return isset($_SERVER['argv'][1]) && $_SERVER['argv'][1]==='--preload';
  }

  function debug($data) {
    $this->dbg[]=$data;
  }

  function print_deubg($separator) {
    print join($separator,$this->dbg);
  }

  function class_loader($classname) {
    if (strpos($classname,'Block')===0) {
      $classfile = strtolower(preg_replace('/\w([A-Z])/','_$1',substr($classname,strlen('Block'))));
      include __DIR__.'/blocks/'.$classfile.'/'.$classfile.'.php';
    }
  }
}

class Block {
  private $id;
  private $class;

  function __construct($id,$params,$class=null) {
    $this->id = $id;
    $this->class = $class; 
  }

  function preload() { }

  function tag($tagname,$content,$attrs='') {
    $cls = '';
    if ($this->class!=null) $cls = sprintf(' class="%s"',$this->class);
    return sprintf('<%s id="%s"%s%s>%s</%s>',$tagname,$this->id,$cls,$attrs,$content,$tagname);
  }

  function __toString() {
    return $this->tag('div',print_r($this,true)); 
  }
}

$home_scr = new HomeScreen;
$home_scr->main();
