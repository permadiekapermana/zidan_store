<?php
error_reporting(0);
include "../config/koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$email = anti_injection($_POST['email']);
$pass     = anti_injection(md5($_POST['password']));

$login=mysql_query("SELECT * FROM users WHERE email='$email' AND password='$pass' AND aktif=1");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);
$login2=mysql_query("SELECT * FROM users WHERE email='$email' AND password='$pass' AND aktif=0");
$ketemu2=mysql_num_rows($login2);
$r2=mysql_fetch_array($login2);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  include "timeout.php";

    $_SESSION[email]      = $r[email];
    $_SESSION[password]   = $r[password];
    $_SESSION[hak_akses]  = $r[hak_akses];

  if ($r['hak_akses']=='Admin') {
  header('location:media.php?module=dashboard');
  }
  elseif ($r['hak_akses']=='Penjual') {
    header('location:media.php?module=data_produk');
  }
  elseif ($r['hak_akses']=='Pembeli') {
    header('location:media.php?module=data_produk');
  }

}
elseif ($ketemu2 > 0){
  echo "<script>alert('Anda tidak lagi memiliki akses ke dalam Sistem!');history.go(-1)</script>";
}
else{
  echo "<script>alert('Username atau Password yang anda masukkan salah!');history.go(-1)</script>";
}

?>
