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
if ($module=='checkout' AND $act=='input'){
    
    $tgl_skrg       = date("Ymd");
    $jam_skrg       = date("H:i:s");
    $status_order   = 'Menunggu Pembayaran';
    $total_tagihan  = $_POST['total_tagihan'];
    $nama_penerima  = $_POST['nama_penerima'];
    $no_penerima    = $_POST['no_penerima'];
    $alamat         = $_POST['alamat'];
    $id_kota        = $_POST['id_kota'];
    $pesan          = $_POST['pesan'];
    $id_pembeli     = $_POST['id_pembeli'];
    $id_penjual     = $_POST['id_penjual'];
    $id_produk      = $_POST['id_produk'];
    $jumlah		    	= $_POST['jumlah'];
    $jml=count($_POST[id_penjual]);
    $jml2=count($_POST[id_produk]);

    for ($i=0; $i < $jml; $i++){

      $sql_i = mysql_query("SELECT * FROM orders");
      $num_i = mysql_num_rows($sql_i);
  
      if ($num_i <> 0) {
          $kode_i = $num_i + 1;
      } else {
          $kode_i = 1;
      }
  
      //mulai bikin kode
      $bikin_kode_i = str_pad($kode_i, 9, "0", STR_PAD_LEFT);
      $tahun_i = date('Ymd');
      $kode_jadi_i = "INV$tahun_i$bikin_kode_i";

    mysql_query("INSERT INTO orders (no_invoice, status_order, tgl_order, total_tagihan, jam_order, nama_penerima, no_hp, alamat, id_kota, pesan, id_pembeli, id_penjual) VALUES ('$kode_jadi_i', '$status_order', '$tgl_skrg', '$total_tagihan', '$jam_skrg', '$nama_penerima', '$no_penerima', '$alamat', '$id_kota', '$pesan', '$id_pembeli', '$id_penjual[$i]')");   

    $tampil4 = mysql_query("SELECT * FROM keranjang INNER JOIN produk ON keranjang.id_produk = produk.id_produk where id_pembeli='$id_pembeli' AND id_penjual='$id_penjual[$i]'");
    $r4=mysql_fetch_array($tampil4);    
    $jml3=count($r4['id_produk']);

    for ($j=0; $j < $jml2; $j++){
      mysql_query("INSERT INTO orders_detail (no_invoice, id_produk,  jumlah) VALUES ('$kode_jadi_i', '$id_produk[$j]', '$jumlah[$j]')");
      mysql_query("DELETE FROM keranjang WHERE id_pembeli = '$id_pembeli' AND id_produk = '$id_produk[$j]' AND jumlah = '$jumlah[$j]'");
      
      $rproduk = mysql_query("SELECT * FROM produk where id_produk='$id_produk[$j]'");
      $rp=mysql_fetch_array($rproduk); 

      $sisa_stok = $rp[stok] - $jumlah[$j];

      mysql_query("UPDATE produk SET stok='$sisa_stok' WHERE id_produk='$id_produk[$j]'");
      
    }

    }
    
    echo "<script>alert('Berhasil menyimpan data pembelian, silahkan melakukan pembayaran!');window.location.href='../../media.php?module=pembayaran';</script>";
    
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
