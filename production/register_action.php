<?php

error_reporting(0);
include "../config/koneksi.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$pel="PMBL.";
$y=substr($pel,0,4);
$query=mysql_query("SELECT * FROM pembeli WHERE substr(id_pembeli,1,4)='$y' ORDER BY id_pembeli desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);
if ($row>0){
$no=substr($data['id_pembeli'],-6)+1;}
else{
$no=1;
}
$nourut=1000000+$no;
$nopel=$pel.substr($nourut,-6);

$pel2="PNJL.";
$y2=substr($pel2,0,4);
$query2=mysql_query("SELECT * FROM penjual WHERE substr(id_penjual,1,4)='$y2' ORDER BY id_penjual desc limit 0,1");
$row2=mysql_num_rows($query2);
$data2=mysql_fetch_array($query2);
if ($row2>0){
$no2=substr($data2['id_penjual'],-6)+1;}
else{
$no2=1;
}
$nourut2=1000000+$no2;
$nopel2=$pel2.substr($nourut2,-6);

$nama_lengkap = $_POST['nama_lengkap'];
$no_hp        = $_POST['no_hp'];
$email        = $_POST['email'];
$password     = md5($_POST['password']);
$password2    = md5($_POST['password2']);
$as           = $_POST['as'];
$nomor_rekening = $_POST['nomor_rekening'];
$nama_toko    = $_POST['nama_toko'];
$alamat       = $_POST['alamat'];

// Memastikan inputan pada kolom pada input hanya angka dan huruf saja, bukan simbol
if (!ctype_alnum($username) OR !ctype_alnum($password)){
  echo "<script>alert('Terdapat aktivitas mencurigakan pada Login anda!');history.go(-1);</script>";
}
else{

$login=mysql_query("SELECT * FROM users WHERE email = '$email'");
$ketemu=mysql_num_rows($login);

  if ($ketemu > 0){
    echo"<script>alert('Email anda telah terdaftar di Sistem!');history.go(-1);</script>";
  }
  else{  
  if ($_POST['password']!=$_POST['password2'] ) {
    echo "<script>alert('Password yang Anda Masukan Tidak Sama');history.go(-1)</script>";
  }
  elseif ($as=='Pembeli'){
  $query=mysql_query("INSERT INTO users (email, password, hak_akses, aktif) VALUES ('$email', '$password', 'Pembeli', 1)");
  $query=mysql_query("INSERT INTO pembeli (id_pembeli, email, nama_lengkap, no_hp, alamat) VALUES ('$nopel', '$email', '$nama_lengkap', '$no_hp', '$alamat')");
  echo"<script>alert('Anda berhasil terdaftar di Sistem!');history.go(-1);</script>";
  }  
  elseif ($as=='Penjual'){
    $query=mysql_query("INSERT INTO users (email, password, hak_akses, aktif) VALUES ('$email', '$password', 'Penjual', 1)");
    $query=mysql_query("INSERT INTO penjual (id_penjual, email, nama_lengkap, no_hp, alamat, nomor_rekening, nama_toko) VALUES ('$nopel2', '$email', '$nama_lengkap', '$no_hp', '$alamat', '$nomor_rekening', '$nama_toko')");
    echo"<script>alert('Anda berhasil terdaftar di Sistem!');history.go(-1);</script>";
    }    
}


}

?>