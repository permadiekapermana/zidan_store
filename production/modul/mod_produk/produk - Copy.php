<?php
include "../config/koneksi.php";
session_start();
 if (empty($_SESSION['email']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$pel="PROD.";
$y=substr($pel,0,4);
$query=mysql_query("SELECT * FROM produk WHERE substr(id_produk,1,4)='$y' ORDER BY id_produk desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);
if ($row>0){
$no=substr($data['id_produk'],-6)+1;}
else{
$no=1;
}
$nourut=1000000+$no;
$nopel=$pel.substr($nourut,-6);

$penjual  = mysql_query("SELECT * FROM penjual WHERE email='$_SESSION[email]'");
$p        = mysql_fetch_array($penjual);

$aksi="modul/mod_produk/aksi_produk.php";

switch($_GET[act]){
  // Tampil desa
  default:


echo "

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Produk <small>Daftar Data Produk</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <p class='text-muted font-13 m-b-30'>
                    <a href='?module=data_produk&act=tambahproduk'><button type='button' class='btn btn-round btn-primary'><i class='fa fa-plus'></i> Upload Produk</button></a>
                    </p>
                    <br>
                    ";
                    ?>

                    <?php
                    $tampil = mysql_query("SELECT * FROM produk WHERE id_penjual='$p[id_penjual]' ORDER BY id_produk DESC");  
                    while($r=mysql_fetch_array($tampil)){      
                    
                    ?>
                      <div class="col-sm-3">
                        <div class="thumbnail">
                          <div class="image view view-first">
                            <a href="#"><img style="width: 100%; display: block;" src="upload/produk/<?php echo"$r[gambar]"; ?>" alt="image" /></a>
                            <!-- <div class="mask">
                              <p>Detail Produk</p>
                              <div class="tools tools-bottom">
                                <a href="#"><i class="fa fa-link"></i></a>
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a href="#"><i class="fa fa-times"></i></a>
                              </div>
                            </div> -->
                          </div>
                          <div class="caption">
                            <p class="el"><b><?php echo"$r[nama_produk]"; ?></b></p> <br>
                            <font><i class="fa fa-money"></i> Rp. <?php echo"$r[harga]"; ?> &nbsp;&nbsp;&nbsp; <i class="fa fa-database"></i> <?php echo"$r[stok]"; ?> Stok</font> <br>
                            <?php
                              if ($_SESSION['hak_akses']=='Penjual'){
                            echo"
                            <a href='?module=data_produk&act=editproduk&id=$r[id_produk]' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit</a> <a href='$aksi?module=data_produk&act=hapus&id=$r[id_produk]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin hapus data ? Data yang dihapus tidak dapat dipulihkan !')\"><i class='fa fa-trash'></i> Delete</a>";                            
                            }elseif($_SESSION['hak_akses']=='Pembeli'){
                            echo"
                            <button class='btn btn-primary btn-xs'><i class='fa fa-plus'></i> Tambah Keranjang</button>";                            
                              }
                            ?>
                          </div>
                        </div>
                      </div>

                      <?php
                      }
                              
                      
                      ?>

                <?php
                echo"

                  </div>
                </div>
              </div>
			  </div>";

			  
  break;
  case "tambahproduk":
  echo "
<form method='POST' action='$aksi?module=data_produk&act=input'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Produk <small>Tambah Data Produk</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                    
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_produk'>ID Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id_produk' id='id_produk' value='$nopel' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_produk' id='id_produk' value='$nopel' required='required' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_penjual' id='id_penjual' value='$p[id_penjual]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_produk'>Nama Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_produk' id='nama_produk' placeholder='Masukkan Nama Produk' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                <div class='form-group'>
                <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_kategori'>Nama Kategori <span class='required'>*</span>
                </label>
                <div class='col-md-6 col-sm-6 col-xs-12'>
                <select name='id_kategori' id='id_kategori' class='form-control col-md-7 col-xs-12'>
                  <option value='' selected>-- Pilih Kategori --</option>";
                  $tampil=mysql_query("SELECT * FROM kategori ORDER BY id_kategori");
                  while($r=mysql_fetch_array($tampil)){
                  echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
                  }
                  echo
                "
                </select> 
              </div>
            </div>
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='harga'>Harga Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='harga' id='harga' placeholder='Masukkan Harga Produk' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='stok'>Stok Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='stok' id='stok' placeholder='Masukkan Stok Produk' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='keterangan'>Keterangan Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <textarea type='text' name='keterangan' id='keterangan' placeholder='Masukkan Keterangan Produk' class='form-control col-md-7 col-xs-12'></textarea>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='fupload'>Gambar Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='file' name='fupload' id='fupload' class='form-control col-md-7 col-xs-12' required>
                    <br>
                    <h5>File Gambar harus dalam format .jpg atau .png dan ukuran maksimum 500kb</h5>
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
  
  case "editproduk":

    $edit = mysql_query("SELECT * FROM `produk`
            WHERE id_produk='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form method='POST' action='$aksi?module=data_produk&act=update'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Produk<small>Edit Data Produk</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                    
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_produk'>ID Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id_produk' id='id_produk' value='$r[id_produk]' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_produk' id='id_produk' value='$r[id_produk]' required='required' class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_penjual' id='id_penjual' value='$r[id_penjual]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_produk'>Nama Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_produk' id='nama_produk' value='$r[nama_produk]' placeholder='Masukkan Nama Produk' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_kategori'>Nama Kategori <span class='required'>*</span>
                    </label>
                      <div class='col-md-6 col-sm-6 col-xs-12'>
                      <select name='id_kategori' class='form-control col-md-7 col-xs-12'>";
                            
                      $tampil=mysql_query("SELECT * FROM kategori ORDER BY id_kategori");
                      if ($r[id_kategori]==0){
                      echo "<option value='' selected>-- Pilih Kategori --</option>";
                      }   

                      while($w=mysql_fetch_array($tampil)){
                      if ($r[id_kategori]==$w[id_kategori]){
                        echo "<option value=$w[id_kategori] selected>$w[nama_kategori]</option>";
                      }
                      else{
                        echo "<option value=$w[id_kategori]>$w[nama_kategori]</option>";
                      }
                      }
                        echo "</select>
                    </div>
                  </div> 
            <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='harga'>Harga Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='harga' id='harga' value='$r[harga]' placeholder='Masukkan Harga Produk' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='stok'>Stok Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='stok' id='stok' value='$r[stok]' placeholder='Masukkan Stok Produk' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='keterangan'>Keterangan Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <textarea type='text' name='keterangan' id='keterangan' placeholder='Masukkan Keterangan Produk' class='form-control col-md-7 col-xs-12'>$r[keterangan]</textarea>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='fupload'>Gambar Produk <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='file' name='fupload' id='fupload' class='form-control col-md-7 col-xs-12' >
                    <br>
                    <h5>File Gambar harus dalam format .jpg atau .png dan ukuran maksimum 500kb. Apabila tidak ada perubahan pada file produk, kosongkan saja.</h5>
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

}       
        
?>