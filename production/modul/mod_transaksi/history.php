
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

$aksi="modul/mod_transaksi/aksi_pesanan.php";

switch($_GET[act]){
  // Tampil desa
  default:


echo "<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Riwayat Transaksi <small>Daftar Data Riwayat Transaksi</small></h2>
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
              <th>Nomor Resi</th>
              <th>Pilihan</th>
                        </tr>
                      </thead>


                      <tbody>";
            //$tampil = mysql_query("SELECT * FROM perangkatdesa, jabatan, users where perangkatdesa.id_user=users.id_user and perangkatdesa.id_jabatan=jabatan.id_jabatan  ORDER BY perangkatdesa.id_perangkatdesa DESC");
            if($_SESSION['hak_akses']=='Penjual'){
              $penjual  = mysql_query("SELECT * FROM penjual WHERE email='$_SESSION[email]'");
              $p        = mysql_fetch_array($penjual);
              $tampil = mysql_query("SELECT * FROM orders WHERE id_penjual='$p[id_penjual]' AND status_order = 'Selesai'
               ORDER BY no_invoice ASC");
              }elseif($_SESSION['hak_akses']=='Pembeli'){
                $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                $p        = mysql_fetch_array($pembeli);
                $tampil = mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND (status_order = 'Selesai' OR status_order = 'Ditolak')
                 ORDER BY no_invoice ASC");
                }
              else{
                $tampil = mysql_query("SELECT * FROM orders WHERE (status_order = 'Selesai' OR status_order = 'Ditolak')
                 ORDER BY no_invoice ASC");
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
                                            if($r['no_resi']==''){
                                                echo"<font color='red'><a href='?module=pesanan&act=inputresi&id=$r[no_invoice]' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Upload Resi</a></font>";
                                            }
                                            else{
                                                echo"$r[no_resi]";
                                            }
                                            echo"
                                            </td>
              <td width='10%'>
                <a href='?module=detail&id=$r[no_invoice]' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i> Detail</a>
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
  
  case "inputresi":

    $edit = mysql_query("SELECT * FROM `orders` WHERE no_invoice='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

   echo "
<form method='POST' action='$aksi?module=pesanan&act=input'  enctype='multipart/form-data' id='demo-form2' data-parsley-validate class='form-horizontal form-label-left' >
<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Input Resi Pengiriman<small>Input Data Resi Pengiriman</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>                  
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='no_invoice'>Nomor Invoice <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='id' id='no_invoice' value='$r[no_invoice]' placeholder='Masukkan ID Kategori' disabled class='form-control col-md-7 col-xs-12'>
                    <input type='hidden' name='id' id='no_invoice' value='$r[no_invoice]' required='required' class='form-control col-md-7 col-xs-12'>
                  </div>               
                  </div>
                  <div class='form-group'>
                    <label class='control-label col-md-3 col-sm-3 col-xs-12' for='no_resi'>Nomor Resi <span class='required'>*</span>
                    </label>
                  <div class='col-md-6 col-sm-6 col-xs-12'>
                    <input type='text' name='no_resi' id='no_resi' placeholder='Masukkan Nomor Resi' required='required' class='form-control col-md-7 col-xs-12'>
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