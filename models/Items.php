<?php
abstract class Item
{
    protected $id;
    protected $sku;
    protected $Name;
    protected $Price;

    public function getID()
    {
        return $this->id;
    }

    protected function setIntoDbItem($db){
        $query1 = mysqli_query($db->connection, "INSERT INTO `Items` VALUES (0,'$this->sku','$this->Name','$this->Price')");
        $query2 = mysqli_query($db->connection,"SELECT `id` FROM `Items` WHERE `id` = @@Identity");
        $this->id = mysqli_fetch_array($query2)['id'];
    }
 
    abstract function getParametrs();
    abstract function addItem($db);

}

class DVD extends Item
{
    protected $size;

    public static function create() {
        return new self();
    }

    public function setData($id, $sku, $Name, $Price, $size){
        $this->id = $id;
        $this->sku = $sku;
        $this->Name = $Name;
        $this->Price = $Price;
        $this->size = $size;
        return $this;
    }

    public function addItem($db){
        $this->setData(0, 
        mysqli_real_escape_string($db->connection,$_POST['sku']),
        mysqli_real_escape_string($db->connection,$_POST['name']),
        mysqli_real_escape_string($db->connection,$_POST['price']),
        mysqli_real_escape_string($db->connection,$_POST['size']));

        $this->setIntoDbItem($db);
        $query3 = mysqli_query($db->connection, "INSERT INTO `dvds` VALUES (0,'$this->id','$this->size')"); 
    }

    function getParametrs()
    {
        return ['SKU' => $this->sku, 'Name' => $this->Name, 'Price' => $this->Price." $", 'Size' => "Size: ".$this->size." MB", 'Weight' => "", 'HxWxL' => ""];
    }

}

class Furniture extends Item
{
    protected $Height;
    protected $Width;
    protected $Length;

    public static function create() {
        return new self();
    }

    public function setData($id, $sku, $Name, $Price, $Height, $Width, $Length){
        $this->id = $id;
        $this->sku = $sku;
        $this->Name = $Name;
        $this->Price = $Price;
        $this->Height = $Height;
        $this->Width = $Width;
        $this->Length = $Length;
        return $this;
    }

    public function addItem($db){
        $this->setData(0, 
        mysqli_real_escape_string($db->connection,$_POST['sku']),
        mysqli_real_escape_string($db->connection,$_POST['name']),
        mysqli_real_escape_string($db->connection,$_POST['price']),
        mysqli_real_escape_string($db->connection, $_POST['height']),
        mysqli_real_escape_string($db->connection,$_POST['width']),
        mysqli_real_escape_string($db->connection,$_POST['length']));

        $this->setIntoDbItem($db);
        $query3 = mysqli_query($db->connection, "INSERT INTO `furnitures` VALUES (0,'$this->id','$this->Height','$this->Width','$this->Length')"); 
    }

    function getParametrs()
    {
        return ['SKU' => $this->sku, 'Name' => $this->Name, 'Price' => $this->Price." $", 'Size' => " ", 'Weight' => " ", 'HxWxL' => "Dimensions: ".$this->Height."x".$this->Width."x".$this->Length];
    }

}

class Book extends Item
{
    protected $Weight;
    
    public static function create() {
        return new self();
    }

    public function setData($id, $sku, $Name, $Price, $Weight){
        $this->id = $id;
        $this->sku = $sku;
        $this->Name = $Name;
        $this->Price = $Price;
        $this->Weight = $Weight;
        return $this;
    }

    public function addItem($db){
        $this->setData(0, 
        mysqli_real_escape_string($db->connection,$_POST['sku']),
        mysqli_real_escape_string($db->connection, $_POST['name']),
        mysqli_real_escape_string($db->connection, $_POST['price']),
        mysqli_real_escape_string($db->connection, $_POST['weight']));

        $this->setIntoDbItem($db);
        $query3 = mysqli_query($db->connection, "INSERT INTO `books` VALUES (0,'$this->id','$this->Weight')"); 
    }


    function getParametrs()
    {
        return ['SKU' => $this->sku, 'Name' => $this->Name, 'Price' => $this->Price." $", 'Size' => "", 'Weight' => "Weight: ".$this->Weight."KG", 'HxWxL' => ""];
    }
}

class Storage
{
    private function GetBooks($db)
    {
        $query = mysqli_query($db->connection, "SELECT `Items`.`id` AS `id`,`SKU`,`Name`,`Price`,`Weight` FROM `Items` INNER JOIN `books` ON `Items`.`id` = `books`.`item_id`");
        $Books = [];
        while ($result = mysqli_fetch_array($query)) {
            $Books[$result['id']] = Book::create()->setData($result['id'], $result['SKU'], $result['Name'], $result['Price'], $result['Weight']);
        }
        return $Books;
    }

    private function GetDvds($db)
    {
        $query = mysqli_query($db->connection, "SELECT `Items`.`id` AS `id`,`SKU`,`Name`,`Price`,`Size` FROM `Items` INNER JOIN `dvds` ON `Items`.`id` = `dvds`.`item_id`");
        $DVDs = [];
        while ($result = mysqli_fetch_array($query)) {
            $DVDs[$result['id']] = DVD::create()->setData($result['id'], $result['SKU'], $result['Name'], $result['Price'], $result['Size']);
        }

        return $DVDs;
    }

    private function GetFurnitures($db)
    {
        $query = mysqli_query($db->connection, "SELECT `Items`.`id` AS `id`,`SKU`,`Name`,`Price`,`Height`,`Width`,`Length` FROM `Items` INNER JOIN `furnitures` ON `Items`.`id` = `furnitures`.`item_id`");
        $Furnitures = [];
        while ($result = mysqli_fetch_array($query)) {
            $Furnitures[$result['id']] = Furniture::create()->setData($result['id'], $result['SKU'], $result['Name'], $result['Price'], $result['Height'], $result['Width'], $result['Length']);
        }

        return $Furnitures;
    }

    public function GetItems($db)
    {
        $Items = array_replace($this->getFurnitures($db), $this->getDvds($db), $this->getBooks($db));
        ksort($Items);

        return $Items;
    }

    public function deleteFromDbItem($db,$sku){
        $query = mysqli_query($db->connection,"DELETE FROM `Items` WHERE `SKU` = '$sku'");
    }

    public function SetItem($db)
    {
        $newItem = new $_POST['productType']();
        $newItem->addItem($db);
    }

}

?>