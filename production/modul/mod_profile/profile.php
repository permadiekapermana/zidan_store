<?php

include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";

$edit = mysql_query("SELECT *, users.no AS nomor FROM `users`
            INNER JOIN `jenis_kelamin` ON `users`.`id_jk` = `jenis_kelamin`.`id_jk`
            INNER JOIN `level` ON `users`.`id_level` = `level`.`id_level`
            WHERE `users`.`tampil` = 'Y' and level!='' AND users.id_user='$_SESSION[id_user]'");
    $r    = mysql_fetch_array($edit);

echo "

<div class='row'>
<div class='col-md-12 col-sm-12 col-xs-12'>
  <div class='x_panel'>
    <div class='x_title'>
      <h2>Profile Users <small>Detail Data User</small></h2>
      <div class='clearfix'></div>
    </div>
    <div class='x_content'>
      
      
      <table class='table table-striped'>
        <tr>
          <th width='20%'>Username</th>
          <td width='1%'>:</td>
          <td>$r[username]</td>
        </tr>
        <tr>
          <th>Nama Lengkap</th>
          <td>:</td>
          <td>$r[nama_lengkap]</td>
        </tr>
        <tr>
          <th>Foto Profil</th>
          <td>:</td>
          <td width='105px'><img src='upload/foto/$r[foto]' border='3' height='100' width='100'></img></td>
        </tr>
        <tr>
          <th>Jenis Kelamin</th>
          <td>:</td>
          <td>
            $r[jenis_kelamin]
          </td>
        </tr>
        <tr>
          <th>Nomor Telepon</th>
          <td>:</td>
          <td>$r[no_telp]</td>
        </tr>
        <tr>
          <th>Tempat, Tanggal Lahir</th>
          <td>:</td>
          <td>$r[tmp_lahir], $r[tgl_lahir]</td>
        </tr>
        <tr>
          <th>Alamat</th>
          <td>:</td>
          <td>$r[alamat]</td>
        </tr>
        <tr>
          <th>Hak Akses</th>
          <td>:</td>
          <td>$r[level]</td>
        </tr>
      </table>
            
  </div>
</div>
</div>
  </div>
</div>;"
    
?>