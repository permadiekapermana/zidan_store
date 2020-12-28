
<?php
include "../config/koneksi.php";
session_start();
 if (empty($_SESSION['email']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$pel="ADMN.";
$y=substr($pel,0,4);
$query=mysql_query("select * from admin where substr(id_admin,1,4)='$y' order by id_admin desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);
if ($row>0){
$no=substr($data['id_admin'],-6)+1;}
else{
$no=1;
}
$nourut=1000000+$no;
$nopel=$pel.substr($nourut,-6);

$aksi="modul/mod_admin/aksi_admin.php";

switch($_GET[act]){
  // Tampil desa
  default:


echo "<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Admin <small>Daftar Data Admin</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <p class='text-muted font-13 m-b-30'>
                    <a href='?module=admin&act=tambahadmin'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Tambah</button></a>
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
                                   INNER JOIN `admin` ON `admin`.`email` = `users`.`email`
                                   WHERE aktif=1 ORDER BY id_admin DESC");
  
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
					  
        echo" <tr>
              <td width='5%' align='center'>$no.</td>
              <td>$r[nama_lengkap]</td>
              <td>$r[email]</td>
              <td>$r[hak_akses]</td>
              <td width='12%'>
                <a href='?module=admin&act=infoadmin&id=$r[id_admin]' class='btn btn-info btn-xs'><i class='fa fa-info'></i> Info</a>
                <a href='?module=admin&act=editadmin&id=$r[id_admin]' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> Edit</a>
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
  case "tambahadmin":
  echo "
<form method='POST' action='$aksi?module=admin&act=input'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >

<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Admin <small>Tambah Data Admin</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                    
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='username'>Email <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='email' id='email' placeholder='Masukkan Email' required='required' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_admin' value='$nopel' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='password'>Password <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='password' name='password' id='password' placeholder='Masukkan Password' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_lengkap'>Nama Lengkap <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_lengkap' id='nama_lengkap' placeholder='Masukkan Nama Lengkap' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='no_hp'>Nomor HP <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='number' name='no_hp' id='no_hp' placeholder='Masukkan Nomor HP' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
            </div>
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='alamat'>Alamat <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <textarea name='alamat' rows='4' cols='50' id='alamat' placeholder='Masukkan Alamat' required='required' class='form-control col-md-7 col-xs-12'></textarea>
                  </div>
            </div>
                  <div class='ln_solid'></div>
                    <div class='form-group'>
                      <div class='col-md-6 col-sm-6 col-xs-12 col-md-offset-3'>
                        <button class='btn btn-primary' type='button' onclick=self.history.back()>Cancel</button>
                        <button class='btn btn-primary' type='reset'>Reset</button>
                        <button type='submit' class='btn btn-success'>Submit</button>
                      </div>
                    </div>  
              </div>
            </div>
            </div>
              </div>
            </div>
      </div>";
  break;
  
  case "editadmin":

    $edit = mysql_query("SELECT * FROM `users`
                        INNER JOIN `admin` ON `admin`.`email` = `users`.`email`
                        WHERE id_admin='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
  <form method='POST' action='$aksi?module=admin&act=update'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
  <div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Admin<small>Edit Data Admin</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='email'>Email <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='email' id='email' value='$r[email]' placeholder='Masukkan Email' required='required' class='form-control col-md-7 col-xs-12' disabled>
                    <span>E-mail tidak dapat dirubah.</span>
                    <input type='hidden' name='id_admin' id='nama' value='$r[id_admin]' required='required' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='email' id='nama' value='$r[email]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='password'>Password <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='password' name='password' id='password' placeholder='Masukkan Password Baru (Jika Kosong Maka Password Tidak Berubah)' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='password2' value='$r[password]' id='password' placeholder='Masukkan Password Baru (Jika Kosong Maka Password Tidak Berubah)' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_lengkap'>Nama Lengkap <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_lengkap' value='$r[nama_lengkap]' id='nama_lengkap' placeholder='Masukkan Nama Lengkap' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='no_hp'>Nomor HP <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='number' name='no_hp' id='no_hp' value='$r[no_hp]' placeholder='Masukkan Nomor HP' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
            </div>         
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='alamat'>Alamat <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <textarea name='alamat' rows='4' cols='50' id='alamat' placeholder='Masukkan Alamat' required='required' class='form-control col-md-7 col-xs-12'>$r[alamat]</textarea>
                  </div>
            </div>
                  <div class='form-group'>
                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='blokir'>Blokir User <span class='required'>*</span>
                        </label>
                        <div class='col-md-6 col-sm-6 col-xs-12'>
                          <div id='gender' class='btn-group' data-toggle='buttons'> ";
                          if ($r[aktif]=='1')  {                        
                            echo"<p>                            
                              <input type='radio' class='flat' name='blokir' id='blokir1' value='1' checked='' required /> Tidak             
                              <input type='radio' class='flat' name='blokir' id='blokir2' value='0' /> Ya
                            </p>";
                          }
                          else
                            echo"<p>                            
                              <input type='radio' class='flat' name='blokir' id='blokir1' value='1' required /> Tidak               
                              <input type='radio' class='flat' name='blokir' id='blokir2' value='0' checked='' /> Ya
                            </p>";
                          echo"</div>
                        </div>
                      </div>                 
                  <div class='ln_solid'></div>
                    <div class='form-group'>
                      <div class='col-md-6 col-sm-6 col-xs-12 col-md-offset-3'>
                        <button class='btn btn-primary' type='button' onclick=self.history.back()>Cancel</button>
                        <button class='btn btn-primary' type='reset'>Reset</button>
                        <button type='submit' class='btn btn-success' onClick=\"return confirm('Yakin ingin ubah data ?')\">Submit</button>
                      </div>
                    </div>  
              </div>
            </div>
            </div>
              </div>
            </div>
      </div>";
  break;

  case "infoadmin":

    $edit = mysql_query("SELECT * FROM `users`
                        INNER JOIN `admin` ON `admin`.`email` = `users`.`email`
                        WHERE id_admin='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

<div class='row'>
<div class='col-md-12 col-sm-12 col-xs-12'>
  <div class='x_panel'>
    <div class='x_title'>
      <h2>Data Users <small>Detail Data User</small></h2>
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
          <th>Alamat</th>
          <td>:</td>
          <td>$r[alamat]</td>
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


                
               
        
        
        