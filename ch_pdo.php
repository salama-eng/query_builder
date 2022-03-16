<?php

class DatabaseClass{

    private $pdo;
    function __construct($dsn,$username,$password)
    {
        $this->pdo=new PDO($dsn,$username,$password);
        
    }
   public function query($table,$sl_list=null,$where=null){
        if($sl_list!=null){
                 
            $query_list=implode(",",$sl_list);
        }
        if($sl_list==null && $where==null){


            $stmt=$this->pdo->prepare("select*from $table");
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
       else if($sl_list==null && $where!= null){
        $stmt=$this->pdo->prepare("select * from $table where $where");
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_OBJ);
       }
       else if($where==null){
        $stmt=$this->pdo->prepare("select $query_list from $table ");
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_OBJ);
       }
       else{
      
            $stmt=$this->pdo->prepare("select $query_list from $table where $where");
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_OBJ);
       
       }
       
    }
  public function update($table_name,$list,$where_condition){
    $query = '';  
    $condition = ''; 
      foreach($list as $key => $value)  
      {  
           $query .= $key . "='".$value."', ";  
      }  
     $query = substr($query, 0, -2);  

     foreach($where_condition as $key => $value)  
      {  
           $condition .= $key . "='".$value."' AND ";  
      }  
       $condition = substr($condition, 0, -5);  
        $query = "UPDATE ".$table_name." SET ".$query." WHERE ".$condition."";  
        $stmt=$this->pdo->prepare( $query);
        $count=$stmt->execute();
            return $count;
  

    }
    public function delete($table,$where=null){
        // $count=$this->pdo->exec("delete from $table set $col='$col_val' where $condit_col='$condit_val'");
        if($where==null){
            $stmt=$this->pdo->prepare("delete from $table");
            $count=$stmt->execute();
           return $count;
        }
        else{
            $stmt=$this->pdo->prepare("delete from $table where $where");
            $count=$stmt->execute();
           return $count;
        }
        

    }
    public function insert($table_name, $data){
       
        $string = "INSERT INTO ".$table_name." (";            
        $string .= implode(",", array_keys($data)) . ') VALUES (';            
        $string .= "'" . implode("','", array_values($data)) . "')";
        $stmt=$this->pdo->prepare($string);
        $count=$stmt->execute();
        return $count;

    }

}
$database="php_test";
$dsn="mysql:host=localhost;dbname=$database;charset=utf8mb4";
$username="root";
$password="";
$db_obj=new DatabaseClass($dsn,$username,$password);

// $result=$db_obj->query("category",);
// $count=$db_obj->add("category","radioes");
// echo $count."<br>";
// $count=$db_obj->delete("category","name","radioes");
// echo $count."<br>";
// $count=$db_obj->update("category","active","1","name='phones' and id='3'");
// echo $count."<br>";
// $result=$db_obj->query("category",array("id","name","active"));
// foreach($result as $row)
// {
//     echo "id  ".$row->id." name  ".$row->name." active  ".$row->active."<br>";
// }

// $sl_list= array("id","name","active");
// $query_list=implode(",",$sl_list);
// $table="cate";
// echo "select $query_list from $table";
// $result=$db_obj->query("category",array("id","name")array("id","name"),"name='phones' and id='3'");


$update_data = array(  
    'name'     =>  "afaf"  ,  
    'age'   =>   14
);  
$where_condition = array(  
    'id'     =>    1 ,
    'name'=>"amat"
);  
// $count=$db_obj->update("users", $update_data, $where_condition);
// echo $count."<br>";
// $result=$db_obj->query("users",null,"name='phones' and id='3'");
// $test=array("id","name");
$result=$db_obj->query("users");
// where("coddintion","=","value")

   $insert_data = array(  
          
           'name'          => "lapppms" ,
           'age'           =>  17 ,
           'major'         => "lapppms" 
          
      );
$count=$db_obj->insert("users",$insert_data);
foreach($result as $row)
 {
    //  echo "id  ".$row->id." name  ".$row->name."<br>";
     echo "id  ".$row->id." name  ".$row->name." major  <br>";

}


?>