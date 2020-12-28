<?php
error_reporting(0);
session_start();
 if (empty($_SESSION['email']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";

$module=$_GET[module];
$act=$_GET[act];

// Input users
if ($module=='kota' AND $act=='input'){

    $id_kota    = $_POST['id_kota'];
    $nama_kota  = $_POST['nama_kota'];
    $ongkir     = $_POST['ongkir'];

    $query=mysql_query("INSERT INTO kota (id_kota, nama_kota, ongkir) 
			values ('$id_kota','$nama_kota', '$ongkir')");
    header('location:../../media.php?module='.$module);
    
}

// Update perangkatdesa
elseif ($module=='kota' AND $act=='update'){

  mysql_query("UPDATE kota SET nama_kota = '$_POST[nama_kota]', ongkir = '$_POST[ongkir]' 
                             WHERE id_kota   = '$_POST[id]'");
    header('location:../../media.php?module='.$module);

    }

    elseif ($module=='kota' AND $act=='hapus'){
  
      mysql_query("DELETE FROM kota WHERE id_kota='$_GET[id]'");
   header('location:../../media.php?module='.$module);
 }



}

?>
