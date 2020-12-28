
<?php
include "../config/koneksi.php";

$pel="CRPN.";
$y=substr($pel,0,4);
$query=mysql_query("SELECT * FROM cerpen WHERE substr(id_cerpen,1,4)='$y' ORDER BY id_cerpen desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);
if ($row>0){
$no=substr($data['id_cerpen'],-6)+1;}
else{
$no=1;
}
$nourut=1000000+$no;
$nopel=$pel.substr($nourut,-6);

$aksi="modul/mod_cerpen2/aksi_cerpen.php";

switch($_GET[act]){
  // Tampil desa
  default:


echo "<div class='row'>
<div class='col-md-12 col-sm-12 col-xs-12'>
  <div class='x_panel'>
    <div class='x_title'>
      <h2>Data Produk <small>Daftar Data Produk</small></h2>
      <div class='clearfix'></div>
    </div>
    <div class='x_content'>
      <p class='text-muted font-13 m-b-30'>
      ";
      if($_SESSION['hak_akses']=='Penjual'){
      echo"
      <a href='?module=data_produk&act=tambahproduk'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Upload Produk</button></a>";
      }
      echo"
      </p>
      <br>
      ";
      ?>

      <?php
      if($_SESSION['hak_akses']=='Penjual'){
      $tampil = mysql_query("SELECT * FROM produk WHERE id_penjual='$p[id_penjual]' ORDER BY id_produk DESC");  
      }elseif($_SESSION['hak_akses']=='Pembeli'){
      $tampil = mysql_query("SELECT * FROM produk ORDER BY id_produk DESC");
      }
      while($r=mysql_fetch_array($tampil)){      
      
      echo"
        <div class='col-sm-3'>
          <div class='thumbnail'>
            <div class='image view view-first'>";
            if($_SESSION['hak_akses']=='Pembeli'){
            echo"
              <a href='?module=data_produk&act=infoproduk&id=$r[id_produk]'><img style='width: 100%; display: block;' src='upload/produk/$r[gambar]' alt='image' /></a>";
            } elseif($_SESSION['hak_akses']=='Penjual'){
            echo"
              <a href='#'><img style='width: 100%; display: block;' src='upload/produk/$r[gambar]' alt='image' /></a>";
            }
            echo"
            </div>
            <div class='caption'>
              <p class='el'><b>$r[nama_produk]</b></p> <br>
              <font><i class='fa fa-money'></i> Rp. $r[harga] &nbsp;&nbsp;&nbsp; <i class='fa fa-database'></i> $r[stok] Stok</font> <br>";
              if($_SESSION['hak_akses']=='Penjual'){
              echo"
              <a href='?module=data_produk&act=editproduk&id=$r[id_produk]' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit</a> <a href='$aksi?module=data_produk&act=hapus&id=$r[id_produk]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash'></i> Delete</a>";
              } elseif($_SESSION['hak_akses']=='Pembeli'){
              $pembeli    = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
              $p2        = mysql_fetch_array($pembeli);
              echo"
              <a href='$aksi?module=data_produk&act=tambah_keranjang&id_produk=$r[id_produk]&id_pembeli=$p2[id_pembeli]&id_keranjang=$nopel2' class='btn btn-primary btn-xs'><i class='fa fa-plus'></i> Tambah Keranjang</a>";
              }
              echo"
            </div>
          </div>
        </div>";

        }
          
  echo"

    </div>
  </div>
</div>
</div>";

			  
  break;
  case "tambahcerpen":
  echo "
<form method='POST' action='$aksi?module=cerpen&act=input'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Cerpen <small>Tambah Data Cerpen</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                    
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='idcerpen'>ID Cerpen <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='idcerpen' id='idcerpen' value='$nopel' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_cerpen' id='nama' value='$nopel' required='required' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='create' id='create' value='$_SESSION[id_user]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='judul'>Judul Cerpen <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='judul' id='judul' placeholder='Masukkan Judul Cerpen' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_tema'>Nama Tema <span class='required'>*</span>
                    </label>
                    <div class='col-md-6 col-sm-6 col-xs-12'>
                    <select name='tema' id='tema' class='form-control col-md-7 col-xs-12'>
                      <option value='' selected>-- Pilih Tema --</option>";
                      $tampil=mysql_query("SELECT * FROM tema WHERE tampil='Y' ORDER BY id_tema");
                      while($r=mysql_fetch_array($tampil)){
                      echo "<option value=$r[id_tema]>$r[tema]</option>";
                      }
                      echo
                    "</select> 
                  </div>
                </div>
                <div class='form-group'>
                <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_genre'>Nama Genre <span class='required'>*</span>
                </label>
                <div class='col-md-6 col-sm-6 col-xs-12'>
                <select name='genre' id='genre' class='form-control col-md-7 col-xs-12'>
                  <option value='' selected>-- Pilih Genre --</option>";
                  $tampil=mysql_query("SELECT * FROM genre WHERE tampil='Y' ORDER BY id_genre");
                  while($r=mysql_fetch_array($tampil)){
                  echo "<option value=$r[id_genre]>$r[genre]</option>";
                  }
                  echo
                "
                </select> 
              </div>
            </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='fileupload'>File Cerpen <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='file' name='fileupload' id='fileupload' accept='application/pdf' required='required' class='form-control col-md-7 col-xs-12'>
                    <br>
                    <h5>File Cerpen harus dalam format .pdf</h5>
                  </div>
                  </div>
                  
                  <div class='ln_solid'></div>
                    <div class='form-group'>
                      <div class='col-md-6 col-sm-6 col-xs-12 col-md-offset-3'>
                        <button class='btn btn-primary' type='button' onclick=self.history.back()>Cancel</button>
                        <button class='btn btn-primary' type='reset'>Reset</button>
                        <button type='submit' onchange='validate(this);' class='btn btn-success'>Submit</button>
                      </div>
                    </div>  
              </div>
            </div>
            </div>
              </div>
            </div>
      </div>";
  break;
  
  case "editcerpen":

    $edit = mysql_query("SELECT * FROM `cerpen`
            WHERE id_cerpen='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form method='POST' action='$aksi?module=cerpen&act=update'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Cerpen<small>Edit Data Cerpen</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_cerpen'>ID Cerpen <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id_cerpen' id='id_cerpen' value='$r[id_cerpen]' placeholder='Masukkan ID cerpen' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_cerpen' id='id_cerpen' value='$r[id_cerpen]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='judul'>Judul Cerpen <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='judul' id='judul' value='$r[judul]' placeholder='Masukkan Judul Cerpen' required='required' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='file_upload' id='file_upload' value='$r[file_upload]' placeholder='Masukkan Judul Cerpen' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_genre'>Nama Genre <span class='required'>*</span>
                    </label>
                      <div class='col-md-6 col-sm-6 col-xs-12'>
                      <select name='id_genre' class='form-control col-md-7 col-xs-12'>";
                            
                      $tampil=mysql_query("SELECT * FROM genre WHERE tampil='Y' ORDER BY id_genre");
                      if ($r[id_genre]==0){
                      echo "<option value='' selected>-- Pilih Genre --</option>";
                      }   

                      while($w=mysql_fetch_array($tampil)){
                      if ($r[id_genre]==$w[id_genre]){
                        echo "<option value=$w[id_genre] selected>$w[genre]</option>";
                      }
                      else{
                        echo "<option value=$w[id_genre]>$w[genre]</option>";
                      }
                      }
                        echo "</select>
                    </div>
                  </div> 
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='fileupload'>File Cerpen <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='file' name='fileupload' id='fileupload' accept='application/pdf' class='form-control col-md-7 col-xs-12'>
                    <br>
                    <h5>File Cerpen harus dalam format .pdf. Apabila tidak ada perubahan pada file cerpen, kosongkan saja.</h5>
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

}

       
        
?>