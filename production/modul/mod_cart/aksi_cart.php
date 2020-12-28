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
if ($module=='cart' AND $act=='hapus'){

    mysql_query("DELETE FROM keranjang WHERE id_keranjang = '$_GET[id]'");
    header('location:../../media.php?module='.$module);
    
}

// Update perangkatdesa
elseif ($module=='kategori' AND $act=='update'){

  mysql_query("UPDATE kategori SET nama_kategori = '$_POST[nama_kategori]' 
                             WHERE id_kategori   = '$_POST[id]'");
    header('location:../../media.php?module='.$module);

    }

    elseif ($module=='kategori' AND $act=='hapus'){
  
      mysql_query("DELETE FROM kategori WHERE id_kategori='$_GET[id]'");
   header('location:../../media.php?module='.$module);
 }



}

?>
