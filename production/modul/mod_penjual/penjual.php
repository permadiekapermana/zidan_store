
<?php
include "../config/koneksi.php";
session_start();
 if (empty($_SESSION['email']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{


switch($_GET[act]){
  // Tampil desa
  default:


echo "<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Penjual <small>Daftar Data Penjual</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <p class='text-muted font-13 m-b-30'>
                    </p>
                    <table id='datatable' class='table table-striped table-bordered'>
                      <thead>
                        <tr>
            <th width='5%'>No.</th>
              <th >Nama</th>
              <th >Email</th>
              <th>Hak Akses</th>
						  <th width='12%'>Aksi</th>
                        </tr>
                      </thead>


                      <tbody>";
            //$tampil = mysql_query("SELECT * FROM perangkatdesa, jabatan, users where perangkatdesa.id_user=users.id_user and perangkatdesa.id_jabatan=jabatan.id_jabatan  ORDER BY perangkatdesa.id_perangkatdesa DESC");
            $tampil = mysql_query("SELECT * FROM `users`
                                  INNER JOIN `penjual` ON `penjual`.`email` = `users`.`email`
                                  WHERE aktif=1 ORDER BY id_penjual DESC");
  
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
					  
        echo" <tr>
              <td width='5%' align='center'>$no.</td>
              <td>$r[nama_lengkap]</td>
              <td>$r[email]</td>
              <td>$r[hak_akses]</td>
              <td width='12%'>
                <a href='?module=penjual&act=infopenjual&id=$r[id_penjual]' class='btn btn-info btn-xs'><i class='fa fa-info'></i> Info</a>
              </td>
										</tr>";
						$no++;
						
	}
                      echo"</tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>";
  
break;

  case "infopenjual":

    $edit = mysql_query("SELECT * FROM `users`
                        INNER JOIN `penjual` ON `penjual`.`email` = `users`.`email`
                        WHERE id_penjual='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

<div class='row'>
<div class='col-md-12 col-sm-12 col-xs-12'>
  <div class='x_panel'>
    <div class='x_title'>
      <h2>Data Penjual <small>Detail Data Penjual</small></h2>
      <div class='clearfix'></div>
    </div>
    <div class='x_content'>
      
      
      <table class='table table-striped'>
        <tr>
          <th width='20%'>Email</th>
          <td width='1%'>:</td>
          <td>$r[email]</td>
        </tr>
        <tr>
          <th>Nama Lengkap</th>
          <td>:</td>
          <td>$r[nama_lengkap]</td>
        </tr>
        <tr>
          <th>Nomor HP</th>
          <td>:</td>
          <td>$r[no_hp]</td>
        </tr>
        <tr>
          <th>Alamat</th>
          <td>:</td>
          <td>$r[alamat]</td>
        </tr>
        <tr>
          <th>Nomor Rekening</th>
          <td>:</td>
          <td>$r[nomor_rekening]</td>
        </tr>
        <tr>
          <th>Nama Toko</th>
          <td>:</td>
          <td>$r[nama_toko]</td>
        </tr>
      </table>
            
  </div>
</div>
</div>
  </div>
</div>

      </div>";
  break;

}

}       
        
?>


                
               
        
        
        