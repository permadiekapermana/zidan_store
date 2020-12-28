
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

$aksi="modul/mod_transaksi/aksi_pembayaran.php";

switch($_GET[act]){
  // Tampil desa
  default:


echo "<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Data Pembayaran <small>Daftar Data Pembayaran</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <p class='text-muted font-13 m-b-30'>
                    
                    </p>
                    <table id='datatable' class='table table-striped table-bordered'>
                      <thead>
                        <tr>
						<th width='5%'>No.</th>
              <th>Nomor Invoice</th>
              <th>Status Order</th>
              <th>Tgl Order</th>
              <th>Tgl Bayar</th>
              <th>Bukti Bayar</th>
              <th>Pilihan</th>
                        </tr>
                      </thead>


                      <tbody>";
            //$tampil = mysql_query("SELECT * FROM perangkatdesa, jabatan, users where perangkatdesa.id_user=users.id_user and perangkatdesa.id_jabatan=jabatan.id_jabatan  ORDER BY perangkatdesa.id_perangkatdesa DESC");
            if($_SESSION['hak_akses']=='Pembeli'){
            $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
            $p        = mysql_fetch_array($pembeli);
            $tampil = mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND status_order = 'Menunggu Pembayaran' OR status_order = 'Menunggu Verifikasi Admin' OR status_order = 'Pesanan Diproses' ORDER BY no_invoice ASC");
            }
            else{
              $tampil = mysql_query("SELECT * FROM orders WHERE status_order = 'Menunggu Verifikasi Admin' OR status_order = 'Pesanan Diproses' ORDER BY no_invoice ASC");
            }
  
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
					  
        echo" <tr>
						  <td width='5%' align='center'>$no.</td>
              <td>$r[no_invoice]</td>
              <td>$r[status_order]</td>
              <td>$r[tgl_order]</td>
              <td width='10%'>";
                                            if($r['tgl_bayar']==''){
                                                echo"<font color='Red'>Belum Bayar</font>";
                                            }
                                            else{
                                                echo"$r[tgl_bayar]";
                                            }
                                            echo"
                                            </td>
                                            <td width='105px'>";
                                            $bukti=mysql_query("SELECT bukti_transfer FROM konfirm_bayar WHERE no_invoice='$r[no_invoice]'");
                                            $ketemu=mysql_num_rows($bukti);
                                            $r2=mysql_fetch_array($bukti);
                                            if($ketemu > 0){
                                                echo"<a href='upload/bukti/$r2[bukti_transfer]' target='_blank' class='btn btn-success btn-xs'>Bukti Bayar</a>";
                                            }else{
                                                echo"<font color='red'><a href='?module=pembayaran&act=inputbayar&id=$r[no_invoice]' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Upload Bukti Bayar</a></font>";
                                            }
                                            echo"
                                            </td>
              <td width='10%'>";
                if($_SESSION['hak_akses']=='Pembeli'){
                echo"
                <a href='?module=detail&id=$r[no_invoice]' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i> Detail</a>";
                }elseif($_SESSION['hak_akses']=='Admin' AND $r['status_order']=='Menunggu Verifikasi Admin'){
                echo"
                <a href='?module=detail&id=$r[no_invoice]' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i> Detail</a>
                <a href='$aksi?module=pembayaran&act=terima&id=$r[no_invoice]' class='btn btn-success btn-xs' onClick=\"return confirm('Yakin ingin Verifikasi pembelian ? Pesanan akan diteruskan ke penjual !')\"onClick=\"return confirm('Yakin ingin terima pembelian ? Data yang diterima tidak dapat diubah !')\"><i class='fa fa-check'></i> Verifikasi</a>
                <a href='$aksi?module=pembayaran&act=tolak&id=$r[no_invoice]' class='btn btn-danger btn-xs' onClick=\"return confirm('Yakin ingin tolak pembelian ? Data yang ditolak tidak dapat dipulihkan !')\"><i class='fa fa-trash'></i> Tolak Pesanan</a>
                ";
                
              }elseif($_SESSION['hak_akses']=='Admin' AND $r['status_order']=='Pesanan Diproses'){
                echo"
                <a href='?module=detail&id=$r[no_invoice]' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i> Detail</a>
                ";
                }
                echo"
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
  
  case "inputbayar":

    $edit = mysql_query("SELECT * FROM `orders` WHERE no_invoice='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form method='POST' action='$aksi?module=pembayaran&act=input'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Konfirmasi Pembayaran<small>Konfirmasi Data Pembayaran</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='no_invoice'>Nomor Invoice <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id' id='no_invoice' value='$r[no_invoice]' placeholder='Masukkan ID Kategori' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id' id='no_invoice' value='$r[no_invoice]' required='required' class='form-control col-md-7 col-xs-12'>
                    <span>Silahkan transfer ke Rekening berikut sesuai nominal pesanan :
                    <br>
                    BCA 00981991911 <br>
                    a/n <br>
                    Zidan Store <br> <br>
                    BNI 912891829182 <br>
                    a/n <br>
                    Zidan Store <br> <br>
                    BRI 1729182912 <br>
                    a/n <br>
                    Zidan Store <br> <br>
                    <span>
                  </div>               
                  </div>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='tgl_bayar'>Tanggal Pembayaran <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='date' name='tgl_bayar' id='tgl_bayar' value='$r[nama_kategori]'  required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='bank_asal'>Bank Asal <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='bank_asal' id='bank_asal' placeholder='Masukkan Bank Asal Pembeli' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='nama_pemilik'>Nama Pemilik <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='nama_pemilik' id='nama_pemilik' placeholder='Masukkan Nama Pemilik' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='jumlah'>Jumlah Transfer <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='number' name='jumlah' id='jumlah' placeholder='Masukkan Jumlah Transfer' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='fupload'>Bukti Transfer <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='file' name='fupload' id='fupload' class='form-control col-md-7 col-xs-12' >
                    <br>
                    <h5>File Gambar harus dalam format .jpg atau .png dan ukuran maksimum 500kb. .</h5>
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

}

}       
        
?>