<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ignoreAuth = true;
require_once "globals.php";

$csvFilePath = "/home/azureuser/list.csv";

if (file($csvFilePath)) {
  echo "found file";
}

//$sql = "insert into patient_data_previous set id = '', first_name = ?, last_name = ?, phone = ?, email = ?, notes = ?";

$file = fopen($csvFilePath, "r");
$i = 0;
echo "<pre>";
while (($row = fgetcsv($file)) !== FALSE) {
    if (empty($row[0])) {
       continue;
    }
    if (empty($row[1])) {
       continue;
    }
    if (is_int($row[1])) {
       continue;
    }
    if (empty($row[4])) {
       continue;
    }
    $hasextraname = explode(")", $row[1]);
   //var_dump($hasextraname);  
   if (!empty($hasextraname[1])) {
      //$middlename = str_replace('(', '', $hasextraname[0]); 
      //echo "has middle name " . $middlename . "<br>";
      $id = null;
      $fname = $row[0]; 
      $lname = $hasextraname[1]; 
      $phone = $row[2]; 
      $email = $row[3];
      $notes = $row[4];
      insertPreviousPatient($fname, $lname, $phone, $email, $notes);
      //var_dump($row);
   } else {
      $id = null;
      $fname = $row[0]; 
      $lname = $row[1]; 
      $phone = $row[2]; 
      $email = $row[3];
      $notes = $row[4];
      insertPreviousPatient($fname, $lname, $phone, $email, $notes);
      //var_dump($row);
   }
   
   ++$i;
   if ($i == 20) {
     //break;
   }
   echo "<br>import complete " . $i;
}


function insertPreviousPatient($fname, $lname, $phone, $email, $notes) {
   $ssql = "INSERT INTO `patient_data_previous` (`id`, `first_name`, `last_name`, `phone`, `email`, `notes`) VALUES (NULL, ?, ?, ?, ?, ?)";
   sqlStatement($ssql, [$fname, $lname, $phone, $email, $notes]);
}