<?php
include "../config/koneksi.php";


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

$pel2="CART.";
$y2=substr($pel2,0,4);
$query2=mysql_query("SELECT * FROM keranjang WHERE substr(id_keranjang,1,4)='$y2' ORDER BY id_keranjang desc limit 0,1");
$row2=mysql_num_rows($query2);
$data2=mysql_fetch_array($query2);
if ($row2>0){
$no2=substr($data2['id_keranjang'],-6)+1;}
else{
$no2=1;
}
$nourut2=1000000+$no2;
$nopel2=$pel2.substr($nourut2,-6);

$penjual  = mysql_query("SELECT * FROM penjual WHERE email='$_SESSION[email]'");
$p        = mysql_fetch_array($penjual);

$aksi="modul/mod_produk_view/aksi_produk.php";

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
                    ";
                    
                    $tampil = mysql_query("SELECT * FROM produk ORDER BY id_produk DESC");
                    
                    while($r=mysql_fetch_array($tampil)){      
                    
                    echo"
                      <div class='col-sm-3'>
                        <div class='thumbnail'>
                          <div class='image view view-first'>
                            <a href='?module=barang-view&act=infoproduk&id=$r[id_produk]'><img style='width: 100%; display: block;' src='upload/produk/$r[gambar]' alt='image' /></a>
                          </div>
                          <div class='caption'>
                            <p class='el'><b>$r[nama_produk]</b></p> <br>
                            <font><i class='fa fa-money'></i> Rp. $r[harga] &nbsp;&nbsp;&nbsp; <i class='fa fa-database'></i> $r[stok] Stok</font> <br>
                            <a href='$aksi?module=barang-view&act=tambah_keranjang&id_produk=$r[id_produk]&id_pembeli=$p2[id_pembeli]&id_keranjang=$nopel2' class='btn btn-primary btn-xs'><i class='fa fa-plus'></i> Tambah Keranjang</a>
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
  
case "infoproduk":
$edit = mysql_query("SELECT * FROM `produk` INNER JOIN kategori ON produk.id_kategori = kategori.id_kategori INNER JOIN penjual ON produk.id_penjual = penjual.id_penjual
WHERE id_produk='$_GET[id]'");
$r    = mysql_fetch_array($edit);

?>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Detail Produk</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-7 col-sm-7 col-xs-12">
                      <div class="product-image">
                        <img src="upload/produk/<?php echo"$r[gambar]"; ?>" alt="..." />
                      </div>
                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                      <h2 class="prod_title"><?php echo"$r[nama_produk]" ?></h2>

                      <div class="">
                        <h2><b>Nama Toko / Penjual</b></h2>
                        <p><?php echo"$r[nama_lengkap]" ?></p>
                      </div>
                      <div class="">
                        <h2><b>Kategori</b></h2>
                        <p><?php echo"$r[nama_kategori]" ?></p>
                      </div>
                      <div class="">
                        <h2><b>Stok</b></h2>
                        <p><?php echo"$r[stok]" ?></p>
                      </div>
                      <div class="">
                        <h2><b>Harga</b></h2>
                      </div>

                      <div class="">
                        <div class="product_price">
                          <h1 class="price">RP. <?php echo"$r[harga]" ?></h1>
                          <!-- <span class="price-tax">Ex Tax: Ksh80.00</span> -->
                          <br>
                        </div>
                      </div>

                      <div class="">
                        <a <?php $pembeli    = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                            $p2        = mysql_fetch_array($pembeli);
                            echo"href='$aksi?module=barang-view&act=tambah_keranjang&id_produk=$r[id_produk]&id_pembeli=$p2[id_pembeli]&id_keranjang=$nopel2'"; ?> class="btn btn-default btn-lg">Tambah ke Keranjang</a>
                      </div>

                    </div>

                    <div class="col-md-12">

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Keterangan</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            <p><?php echo"$r[keterangan]" ?></p>
                          </div>
                        </div>
                      </div>


                    

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

<?php

break;

}

      
        
?>