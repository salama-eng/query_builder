
<?php

class Db{
  private $pdo;
  private $final_query;
  
  function __construct($dsn,$username,$password)
  {
      $this->pdo=new PDO($dsn,$username,$password);
      echo "you are connected";
  }

/******** Run Query ******* */
function runQuery()
{
  $stmt=$this->pdo->prepare($this->final_query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);
}


  /******** insert FUNCTION ******* */
  function insert($table_name,$data)
  {
    $query = "INSERT INTO ".$table_name." (";            
    $query .= implode(",", array_keys($data)) . ') VALUES (';            
    $query .= "'" . implode("','", array_values($data)) . "')";
    $this->final_query = $query ;
   return $this;
  }

   /******** QUERY FUNCTION ******* */
   
   function select($table)
   {

    $this->final_query="select * from $table";
     return $this;
   }

   function where($key,$value)
   {
    $this->final_query.=" where $key = '$value'";
    echo  $this->final_query;
    return $this;
   }

}

/********* ******** */
$database="php_test";
$dsn="mysql:host=localhost;dbname=$database;charset=utf8mb4";
$username="root";
$password="";
$db_obj=new Db($dsn,$username,$password);
/**inserted data */
/*
$insert_data = array(  
          
  'name'          => "mmmmm" ,
  'age'           =>  17 ,
  'major'         => "lapppms" 
 
);
$count =$db_obj->insert("users",$insert_data)->runQuery();
print_r($count);
*/
/*  test quere for all users
print_r($db_obj->select("users")->runQuery());
*/
print_r($db_obj->select("users")->where(' name ','lapppms')->runQuery());

?>
