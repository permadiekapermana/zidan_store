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
if ($module=='pesanan' AND $act=='input'){

$no_invoice    = $_POST['id'];
$no_resi   = $_POST['no_resi'];

  $Q=mysql_query("UPDATE orders SET status_order='Pesanan Dikirim', no_resi='$no_resi' WHERE no_invoice='$no_invoice'");
  
  if($Q) {
    header('location:../../media.php?module='.$module);
  }
  else{
    echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
  }




}

// Update perangkatdesa
elseif ($module=='pembayaran' AND $act=='tolak'){
  
  $id = $_GET[id];

  $Q  = mysql_query("UPDATE orders SET status_order = 'Ditolak' WHERE no_invoice='$id'");
    
    if($Q) {
      header('location:../../media.php?module='.$module);
    }
    else{
      echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
    }
  
  }

  elseif ($module=='pembayaran' AND $act=='terima'){
  
    $id = $_GET[id];
  
    $Q  = mysql_query("UPDATE orders SET status_order = 'Pesanan Diproses' WHERE no_invoice='$id'");
      
      if($Q) {
        header('location:../../media.php?module='.$module);
      }
      else{
        echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
      }
    
    }

    elseif ($module=='data_produk' AND $act=='hapus'){
      $id = $_GET[id];
      $cek  = mysql_fetch_array(mysql_query("SELECT * FROM produk where id_produk='$id'"));
      unlink("../../upload/produk/$cek[gambar]");
    
      $Q  = mysql_query("DELETE FROM produk WHERE id_produk='$id'");
    
      if($Q) {
        header('location:../../media.php?module='.$module);
      }
      else{
        echo "<script>alert('Gagal menghapus data !');history.go(-1)</script>";
      }
 }

elseif($module=='data_produk' AND $act=='tambah_keranjang') {

  $id_produk    = $_GET['id_produk'];
  $id_pembeli   = $_GET['id_pembeli'];
  $id_keranjang = $_GET['id_keranjang'];
  $jumlah       = 1;
  $q1 = mysql_query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
  $r = mysql_fetch_array($q1);
  
  if ($r[stok]==0){
    echo "<script>alert('Maaf, Stok Barang Habis!');history.go(-1)</script>";
  } elseif ($r[stok] < $jumlah) {
  
    echo "<script>alert('Jumlah Pembelian Melebihi Stok!');history.go(-1)</script>";
  
  } else {
  
    $sql = mysql_query("SELECT id_produk FROM keranjang WHERE id_produk = '$id_produk' AND id_pembeli = '$id_pembeli'");
    $ketemu = mysql_num_rows($sql);
    
    if ($ketemu == 0){
      $Q=mysql_query("INSERT INTO keranjang (id_keranjang, id_pembeli, id_produk, jumlah) VALUES ('$id_keranjang', '$id_pembeli', '$id_produk', '$jumlah')");
  
  
      if($Q) {
        header('location:../../media.php?module=cart');
      }
      else{
        echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
      }
    } else {
  
      $cek_keranjang = mysql_query("SELECT id_produk, jumlah FROM keranjang WHERE id_produk = '$id_produk' AND id_pembeli = '$id_pembeli'");
      $ketemu2 = mysql_fetch_array($cek_keranjang);
      $q2 = mysql_query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
      $r2 = mysql_fetch_array($q2);
      $total = $ketemu2[jumlah] + $jumlah;
  
      if ($r[stok] < $total) {
        echo "<script>alert('Barang yang ingin anda tambahkan sudah ada dikeranjang dan jumlah yang anda ingin tambah melebihi stok !');history.go(-1)</script>";
      }
      else{
  
      $Q  = mysql_query("UPDATE keranjang SET jumlah = jumlah + $jumlah WHERE id_produk = '$id_produk' AND id_pembeli = '$id_pembeli'");
  
      if($Q) {
        header('location:../../media.php?module=cart');
      }
      else{
        echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
      }
    }
  
    }
    }	

}



}

?>
