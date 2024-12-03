<?php

class ScandiWebTest
{

  function __construct()
  {
    require_once("models/HtmlPage.php");
    require_once("models/Items.php");
    require_once("models/Database.php");
  }

  function Run()
  {
    $pageURL = explode('/', $_SERVER['REQUEST_URI']);
    $db = new DBase();
    $Storage = new Storage();
    switch ($pageURL[1]) {
      case 'getSKU':
        $skuID = mysqli_real_escape_string($db->connection,$_POST['skuID']);
        $query = mysqli_query($db->connection, "SELECT COUNT(*) AS `SKUCOUNT` FROM `Items` WHERE `SKU` = '$skuID'");
        $skuCount = mysqli_fetch_array($query);
        if ($skuCount['SKUCOUNT'] == 0)
          $isUnique = true;
        else
          $isUnique = false;
        $out = array(
          'skuUnique' => $isUnique,
          'skuID' => $skuID
        );
        echo json_encode($out);
        break;
      case 'massDelete':
        foreach ($_POST as $checkboxes) {
          $Storage->deleteFromDbItem($db, $checkboxes);
        }
        header("Location:/");
        break;
      case 'newItem':
        $Storage->SetItem($db);
        header("Location:/");
        break;
      case 'addproduct':
        $ProductAddPage = new ProductAddPage("Product Add");
        print($ProductAddPage->getPage());
        break;
      default:
        $ProductListPage = new ProductListPage("Product List");
        $ProductListPage->setContent($Storage->GetItems($db));
        print($ProductListPage->getPage());
        break;
    }
  }

}

$Programm = new ScandiWebTest();

class ProductListPage extends HtmlPage
{
  function setHeader()
  {
    $this->header = $this->renderTemplate('views/headerProductList.php', []);
  }
  function setContent($items)
  {
    $result = "";
    if ($items != NULL)
      foreach ($items as $item) {
        $parametrs = $item->getParametrs();
        $result = $result . $this->renderTemplate('views/productListItem.php', $parametrs);
      }
    $this->content = $this->renderTemplate('views/productList.php', ['content' => $result]);
  }
}


class ProductAddPage extends HtmlPage
{
  function setHeader()
  {
    $this->header = $this->renderTemplate('views/headerProductAdd.php', []);
  }
  function setContent($storage)
  {
    $this->content = $this->renderTemplate('views/productAdd.php', []);
  }
}


$Programm->Run();

?>