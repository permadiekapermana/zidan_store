
<?php
include "../config/koneksi.php";
session_start();
 if (empty($_SESSION['email']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$pel="KTGR.";
$y=substr($pel,0,4);
$query=mysql_query("SELECT * FROM kategori WHERE substr(id_kategori,1,4)='$y' ORDER BY id_kategori desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);
if ($row>0){
$no=substr($data['id_kategori'],-6)+1;}
else{
$no=1;
}
$nourut=1000000+$no;
$nopel=$pel.substr($nourut,-6);

$aksi="modul/mod_cart/aksi_checkout.php";

switch($_GET[act]){
  // Tampil desa
  default:


echo "<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Checkout</h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>"; ?>
                    <?php
                    $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                    $p        = mysql_fetch_array($pembeli);
                    ?>
                    <!-- start form for validation -->
                    <form action="<?php echo"$aksi?module=checkout&act=input"; ?>" method="POST" id="demo-form" data-parsley-validate>
                      <label for="fullname">Nama Lengkap :</label>
                      <input type="text" id="fullname" value="<?php echo"$p[nama_lengkap]"; ?>" class="form-control" name="fullname" disabled /> <br>

                      <label for="email">Email :</label>
                      <input type="email" id="email" class="form-control" value="<?php echo"$p[email]"; ?>" name="email" data-parsley-trigger="change" disabled /> <br>

                      <label for="nama_penerima">Nama Penerima :</label>
                      <input type="text" id="nama_penerima" class="form-control" value="<?php echo"$p[nama_lengkap]"; ?>" name="nama_penerima" data-parsley-trigger="change" required /> <br>

                      <label for="no_penerima">Nomor HP Penerima :</label>
                      <input type="text" id="no_penerima" class="form-control" value="<?php echo"$p[no_hp]"; ?>" name="no_penerima" data-parsley-trigger="change" required /> <br>

                      <label for="id_kota">Kota/Kabupaten :</label>
                          <select id="id_kota" name="id_kota" class="form-control" required>
                            <option value="">-- Pilih Kota / Kabupaten --</option>
                            <?php
                            $tampil=mysql_query("SELECT * FROM kota ORDER BY id_kota");
                            while($r=mysql_fetch_array($tampil)){
                            echo"<option value=$r[id_kota]>$r[nama_kota]</option>";
                            }
                            ?>
                          </select> <br>

                      <label for="alamat">Alamat :</label>
                          <textarea id="alamat" required="required" class="form-control" name="alamat" required><?php echo"$p[alamat]"; ?></textarea>

                          <br/>

                          <label for="pesan">Pesan (Opsional) :</label>
                          <textarea id="pesan" class="form-control" name="pesan" placeholder="Masukkan pesan untuk penjual"></textarea>

                          <span>* Mohon pastikan kembali order anda dengan benar sebelum checkout. Data yang sudah dicheckout tidak dapat diubah.</span> <br /> <br>
                          <button type="submit" class="btn btn-primary">Lanjut Pembayaran</button>

                    
                    <!-- end form for validations -->
                  <?php
                  echo"
                  </div>
                </div>
              </div>
        </div>
        
        <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Produk</h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>";

                            $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                            $p        = mysql_fetch_array($pembeli);
                            $tampil3 = mysql_query("SELECT DISTINCT(id_penjual) as id_penjual FROM keranjang INNER JOIN produk ON keranjang.id_produk = produk.id_produk where id_pembeli='$p[id_pembeli]' ORDER BY id_penjual");
                            while($r3=mysql_fetch_array($tampil3)){
                            echo"
                            
                            <input type='hidden' name='id_penjual[]' value='$r3[id_penjual]' class='form-control col-md-7 col-xs-12'>";
                            $tampil4 = mysql_query("SELECT * FROM keranjang INNER JOIN produk ON keranjang.id_produk = produk.id_produk where id_pembeli='$p[id_pembeli]' AND id_penjual='$r3[id_penjual]' ORDER BY id_penjual");
                            while($r4=mysql_fetch_array($tampil4)){
                            echo"
                            <input type='hidden' name='id_produk[]' value='$r4[id_produk]' class='form-control col-md-7 col-xs-12'>
                            <input type='hidden' name='jumlah[]' value='$r4[jumlah]' class='form-control col-md-7 col-xs-12'>";
                            }
                                                             
                            }
                    
                    echo"
                    <table class='table table-striped table-bordered'>
                      <thead>
                        <tr>
						<th width='5%'>No.</th>
              <th>Nama Produk</th>
              <th>Nama Kategori</th>
              <th>Gambar</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Total</th>
                        </tr>
                      </thead>


                      <tbody>";
            //$tampil = mysql_query("SELECT * FROM perangkatdesa, jabatan, users where perangkatdesa.id_user=users.id_user and perangkatdesa.id_jabatan=jabatan.id_jabatan  ORDER BY perangkatdesa.id_perangkatdesa DESC");
            $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
            $p        = mysql_fetch_array($pembeli);
            $tampil = mysql_query("SELECT * FROM keranjang INNER JOIN produk ON keranjang.id_produk = produk.id_produk INNER JOIN kategori ON kategori.id_kategori = produk.id_kategori WHERE id_pembeli='$p[id_pembeli]' ORDER BY keranjang.id_keranjang DESC");
  
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
					  
        echo" <tr>
						  <td width='5%' align='center'>$no.</td>
              <td>$r[nama_produk]</td>
              <td>$r[nama_kategori]</td>
              <td><img src='upload/produk/$r[gambar]' alt='' border='3' height='250' width='200'></td>
              <td>Rp. $r[harga]</td>
              <td>$r[jumlah]</td>";
              $total_harga = $r[harga]*$r[jumlah];
              echo"
              <td>Rp. $total_harga</td>
										</tr>";
						$no++;
						
	}           
                      echo"
                      <tr>
                        <td colspan='5'></td>
                        <td>Grand Total</td>";
                        $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                        $p        = mysql_fetch_array($pembeli);
								        $total_harga = mysql_query("SELECT * FROM keranjang INNER JOIN produk ON keranjang.id_produk = produk.id_produk INNER JOIN kategori ON kategori.id_kategori = produk.id_kategori WHERE id_pembeli='$p[id_pembeli]'");
								  	    while($r=mysql_fetch_array($total_harga)){
                        $subtotal    = $r[harga]* $r[jumlah];
                        $total       = $total + $subtotal;
                        }
                        echo"
                        <input type='hidden' value='$total' name='total_tagihan'></input>
                        <input type='hidden' value='$p[id_pembeli]' name='id_pembeli'></input>
                        <td colspan='2'>Rp. $total</td>
                      </tr>
                      </tbody>
                    </table>
                    </form>
                  </div>
                </div>
              </div>
        </div>";
        

			  
  break;
  case "tambahkategori":
  echo "
<form method='POST' action='$aksi?module=kategori&act=input'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Kategori <small>Tambah Data Kategori</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                    
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_kategori'>ID Kategori <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id_kategori' id='id_kategori' value='$nopel' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id_kategori' id='nama' value='$nopel' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_kategori'>Nama Kategori <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_kategori' id='nama_kategori' placeholder='Masukkan Nama Kategori' class='form-control col-md-7 col-xs-12'>
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
  
  case "editkategori":

    $edit = mysql_query("SELECT * FROM `kategori` WHERE id_kategori='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form method='POST' action='$aksi?module=kategori&act=update'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Kategori<small>Edit Data Kategori</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='id_kategori'>ID Kategori <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id' id='id_kategori' value='$r[id_kategori]' placeholder='Masukkan ID Kategori' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id' id='id_kategori' value='$r[id_kategori]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_kategori'>Nama Kategori <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_kategori' id='nama_kategori' value='$r[nama_kategori]' placeholder='Masukkan Nama Kategori' required='required' class='form-control col-md-7 col-xs-12'>
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