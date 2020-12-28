<?php

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
if ($module=='data_produk' AND $act=='input'){

$lokasi_file    = $_FILES['fupload']['tmp_name'];
$tipe_file      = $_FILES['fupload']['type'];
$nama_file      = $_FILES['fupload']['name'];
$acak           = rand(1,99);
$nama_file_unik = $acak.$nama_file; 

$id_produk    = $_POST['id_produk'];
$id_penjual   = $_POST['id_penjual'];
$id_kategori  = $_POST['id_kategori'];
$nama_produk  = $_POST['nama_produk'];
$harga        = $_POST['harga'];
$stok         = $_POST['stok'];
$keterangan   = $_POST['keterangan'];

  if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/png"){
  echo "<script>alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau *.PNG !');history.go(-1)</script>";
  }
  else{
  UploadProduk($nama_file_unik);
  $Q=mysql_query("INSERT INTO produk (id_produk, id_kategori, id_penjual, nama_produk, harga, stok, gambar, keterangan) VALUES ('$id_produk', '$id_kategori', '$id_penjual', '$nama_produk', '$harga', '$stok', '$nama_file_unik', '$keterangan')");
  
  if($Q) {
    header('location:../../media.php?module='.$module);
  }
  else{
    echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
  }

}


}

// Update perangkatdesa
elseif ($module=='data_produk' AND $act=='update'){

  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 
  
  $id_produk    = $_POST['id_produk'];
  $id_penjual   = $_POST['id_penjual'];
  $id_kategori  = $_POST['id_kategori'];
  $nama_produk  = $_POST['nama_produk'];
  $harga        = $_POST['harga'];
  $stok         = $_POST['stok'];
  $keterangan   = $_POST['keterangan'];
  
  if (!empty($lokasi_file)){
    if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/png"){
    echo "<script>alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau *.PNG !');history.go(-1)</script>";
    }
    else{
    UploadProduk($nama_file_unik);
    $cek  = mysql_fetch_array(mysql_query("SELECT * FROM produk where id_produk='$id_produk'"));
    unlink("../../upload/produk/$cek[gambar]");
    $Q=mysql_query("UPDATE produk SET id_kategori='$id_kategori', nama_produk='$nama_produk', harga='$harga', stok='$stok', gambar='$nama_file_unik', keterangan='$keterangan' WHERE id_produk='$id_produk'");
    
    if($Q) {
      header('location:../../media.php?module='.$module);
    }
    else{
      echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
    }
  
  }
  }
  else{
    $Q=mysql_query("UPDATE produk SET  id_kategori='$id_kategori', nama_produk='$nama_produk', harga='$harga', stok='$stok', keterangan='$keterangan' WHERE id_produk='$id_produk'");
    if($Q) {
      header('location:../../media.php?module='.$module);
    }
    else{
      echo "<script>alert('Gagal menyimpan data !');history.go(-1)</script>";
    }
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
  
  if ($r['stok']==0){
    echo "<script>alert('Maaf, Stok Barang Habis!');history.go(-1)</script>";
  } elseif ($r['stok'] < $jumlah) {
  
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
