<?php 
abstract class HtmlPage{

  protected $title;
  protected $header;
  protected $content;

  abstract function setContent($storage);
  abstract function setHeader();

  

  function __construct($title){
    $this->$title = $title;
    $this->setHeader();
    $this->setContent(NULL);
  }

  protected function renderTemplate($template_path, $data) {
    extract($data);
    ob_start();
    require($template_path);
        $html = ob_get_clean();
    
    return $html;
  }

  function getPage(){
    $page = $this->renderTemplate('views/layout.php',['pageName' => "Product List",'header' => $this->header,'content' =>$this->content]);

    return $page;
  }
}
?>