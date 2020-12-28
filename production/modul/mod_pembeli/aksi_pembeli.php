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
if ($module=='pembeli' AND $act=='input'){

$username     = $_POST['username'];
$id_user      = $_POST['id_user'];
$blokir       = $_POST['blokir'];
$password     = md5($_POST['password']);
$nama_lengkap = $_POST['nama_lengkap'];
$no_telp      = $_POST['no_telp'];
$tmp_lahir    = $_POST['tmp_lahir'];
$tgl_lahir    = $_POST['tgl_lahir'];
$alamat       = $_POST['alamat'];
$level        = $_POST['id_level'];
$jk           = $_POST['id_jk'];
$tampil       = 'Y';
$create       = $_POST['create'];

$query=mysql_query("UPDATE users SET id_user='$id_user' WHERE no='1' AND tampil='N'");
$query=mysql_query("INSERT INTO users (id_user, username, password, nama_lengkap, tmp_lahir, tgl_lahir, alamat, no_telp, id_jk, id_level, blokir, tampil, created_by, timestamp_create) VALUES ('$id_user', '$username', '$password', '$nama_lengkap', '$tmp_lahir', '$tgl_lahir', '$alamat', '$no_telp', '$jk', '$level', '$blokir', '$tampil', '$create', CURRENT_TIMESTAMP)");
      
      
  header('location:../../media.php?module='.$module);

  
}

// Update perangkatdesa
elseif ($module=='users' AND $act=='update'){


      


  if (empty($_POST[password]) ){
    $username     = $_POST['username'];
    $id_user      = $_POST['id_user'];
    $blokir       = $_POST['blokir'];
    $password2    = $_POST['password2'];
    $email        = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telp      = $_POST['no_telp'];
    $tmp_lahir    = $_POST['tmp_lahir'];
    $tgl_lahir    = $_POST['tgl_lahir'];
    $alamat       = $_POST['alamat'];
    $level        = $_POST['id_level'];
    $jk           = $_POST['id_jk'];
    $tampil       = 'Y';
    $no           = $_POST['no'];
    $delete       = $_POST['delete'];
    
    $query=mysql_query("INSERT INTO users (no_reff, id_user, username, password, nama_lengkap, tmp_lahir, tgl_lahir, alamat, no_telp, id_jk, id_level, blokir, tampil, created_by, timestamp_create) VALUES ('$no', '$id_user', '$username', '$password2', '$nama_lengkap', '$tmp_lahir', '$tgl_lahir', '$alamat', '$no_telp', '$jk', '$level', '$blokir', '$tampil', '$delete', CURRENT_TIMESTAMP)");    
    $query=mysql_query("UPDATE users SET password='', blokir = 'Y', tampil = 'N', delete_by ='$delete', timestamp_delete = CURRENT_TIMESTAMP WHERE no='$no'");
  }
  else {
    $username     = $_POST['username'];
    $id_user      = $_POST['id_user'];
    $blokir       = $_POST['blokir'];
    $email        = $_POST['email'];
    $password     = md5($_POST['password']);
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telp      = $_POST['no_telp'];
    $tmp_lahir    = $_POST['tmp_lahir'];
    $tgl_lahir    = $_POST['tgl_lahir'];
    $alamat       = $_POST['alamat'];
    $level        = $_POST['id_level'];
    $jk           = $_POST['id_jk'];
    $tampil       = 'Y';
    $no           = $_POST['no'];
    $delete       = $_POST['delete'];
    
    $query=mysql_query("INSERT INTO users (no_reff, id_user, username, password, nama_lengkap, tmp_lahir, tgl_lahir, email, alamat, no_telp, id_jk, id_level, blokir, tampil, created_by, timestamp_create) VALUES ('$no', '$id_user', '$username', '$password', '$nama_lengkap', '$tmp_lahir', '$tgl_lahir', '$email', '$alamat', '$no_telp', '$jk', '$level', '$blokir', '$tampil', '$delete', CURRENT_TIMESTAMP)");    
    $query=mysql_query("UPDATE users SET password='', blokir = 'Y', tampil = 'N', delete_by ='$delete', timestamp_delete = CURRENT_TIMESTAMP WHERE no='$no'");

  }							 
  header('location:../../media.php?module='.$module);
    }





}

?>
