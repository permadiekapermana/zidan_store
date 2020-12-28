
<?php
include "../config/koneksi.php";
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

  include "../../../config/fungsi_indotgl.php";

$pel="NILL.";
$y=substr($pel,0,4);
$query=mysql_query("SELECT * FROM nilai WHERE substr(id_nilai,1,4)='$y' ORDER BY id_nilai desc limit 0,1");
$row=mysql_num_rows($query);
$data=mysql_fetch_array($query);
if ($row>0){
$no=substr($data['id_nilai'],-6)+1;}
else{
$no=1;
}
$nourut=1000000+$no;
$nopel=$pel.substr($nourut,-6);

$aksi="modul/mod_penilaian/aksi_penilaian.php";

switch($_GET[act]){
  // Tampil desa
  default:

echo "<div class='clearfix'></div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>Riwayat Lomba Cerpen <small>Daftar Data Riwayat Lomba Cerpen</small></h2>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>



            <p class='text-muted font-13 m-b-30'>
            Riwayat Cerpen</p>
            <table id='datatable' class='table table-hover'>
              <thead>
                <tr>
    <th width='5%'>No.</th>
      <th>ID Cerpen</th>
      <th>Judul Cerpen</th>
      <th>Tanggal Selesai</th>
      <th>Nilai</th>  
                </tr>
              </thead>


              <tbody>";
    //$tampil = mysql_query("SELECT * FROM perangkatdesa, jabatan, users where perangkatdesa.id_user=users.id_user and perangkatdesa.id_jabatan=jabatan.id_jabatan  ORDER BY perangkatdesa.id_perangkatdesa DESC");
    $tampil = mysql_query("SELECT
    DISTINCT cerpen.id_cerpen, cerpen.judul
  FROM
    `cerpen`
    INNER JOIN `riwayat_nilai` ON `riwayat_nilai`.`id_cerpen` = `cerpen`.`id_cerpen`");

$no = 1;
while($r=mysql_fetch_array($tampil)){

      $nilai_sum = mysql_query("SELECT SUM(nilai) as sumnilai, tgl_selesai FROM riwayat_nilai WHERE id_cerpen='$r[id_cerpen]' GROUP BY id_cerpen");
      $nilai = mysql_fetch_array($nilai_sum);
   
echo" <tr>
      <td width='5%' align='center'>$no.</td>
      <td>$r[id_cerpen]</td>
      <td>$r[judul]</td>";
      $tglramal=tgl_indo($nilai['tgl_selesai']);
      echo"
      <td>$tglramal</td>
      <td>";echo round($nilai['sumnilai'],4); "</td>
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
  
}

}       
        
?>