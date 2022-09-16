<?php 
  include "db_connection.php";
  $sql="select Service_ID,Service_Name from dental_services where CHAS_color='{$_POST["id"]}'";
  $res=$con->query($sql);
  echo "<option value=''>Select Services</option>";
  if($res->num_rows>0){
    while($row=$res->fetch_assoc()){
      echo "<option value='{$row["Service_Name"]}'>{$row["Service_Name"]}</option>";
    }
  }
?>