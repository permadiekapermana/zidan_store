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
if ($module=='admin' AND $act=='input'){

$id_admin      = $_POST['id_admin'];
$email       = $_POST['email'];
$password     = md5($_POST['password']);
$nama_lengkap = $_POST['nama_lengkap'];
$no_hp      = $_POST['no_hp'];
$alamat       = $_POST['alamat'];

  mysql_query("INSERT INTO users (email, password, hak_akses, aktif) VALUES ('$email', '$password', 'Admin', 1)");
  mysql_query("INSERT INTO admin (id_admin, email, nama_lengkap, no_hp, alamat) VALUES ('$id_admin', '$email', '$nama_lengkap', '$no_hp', '$alamat')");
  header('location:../../media.php?module='.$module);

}

// Update perangkatdesa
elseif ($module=='admin' AND $act=='update'){


      


  if (empty($_POST[password]) ){
    $id_admin      = $_POST['id_admin'];
    $email       = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_hp      = $_POST['no_hp'];
    $alamat       = $_POST['alamat'];
    $blokir       = $_POST['blokir'];
 
      $query=mysql_query("UPDATE admin SET nama_lengkap='$nama_lengkap', no_hp='$no_hp', alamat='$alamat' WHERE id_admin='$id_admin'");
      mysql_query("UPDATE users SET aktif='$blokir' WHERE email='$email'");
    header('location:../../media.php?module='.$module);
    
    }
    else{
      $id_admin      = $_POST['id_admin'];
      $email       = $_POST['email'];
      $password     = md5($_POST['password']);
      $nama_lengkap = $_POST['nama_lengkap'];
      $no_hp      = $_POST['no_hp'];
      $alamat       = $_POST['alamat'];
      $blokir       = $_POST['blokir'];

      $query=mysql_query("UPDATE admin SET nama_lengkap='$nama_lengkap', no_hp='$no_hp', alamat='$alamat' WHERE id_admin='$id_admin'");
      mysql_query("UPDATE users SET password='$password', aktif='$blokir' WHERE email='$email'");
    header('location:../../media.php?module='.$module);
    }    
    
  }

}

?>
