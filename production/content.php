<?php
include "../config/koneksi.php";
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_combobox.php";
include "../config/fungsi_rupiah.php";

$id_Operator=$_SESSION[id_Operator];                 
                   
 echo"<div class='right_col' role='main'>
          <div class=''>  ";     
if ($_GET['module']=='dashboard'){
    include "modul/mod_dashboard/dashboard.php";
}
elseif ($_GET[module]=='admin'){
  if ($_SESSION['hak_akses']=='Admin'){
   include "modul/mod_admin/admin.php";
 }
}
elseif ($_GET[module]=='pembeli'){
  if ($_SESSION['hak_akses']=='Admin'){
   include "modul/mod_pembeli/pembeli.php";
 }
}
elseif ($_GET[module]=='penjual'){
  if ($_SESSION['hak_akses']=='Admin'){
   include "modul/mod_penjual/penjual.php";
 }
}
elseif ($_GET[module]=='kategori'){
  if ($_SESSION['hak_akses']=='Admin'){
   include "modul/mod_kategori/kategori.php";
 }
}
elseif ($_GET[module]=='kota'){
  if ($_SESSION['hak_akses']=='Admin'){
   include "modul/mod_kota/kota.php";
 }
}
elseif ($_GET[module]=='data_produk'){
  if ($_SESSION['hak_akses']=='Penjual' OR $_SESSION['hak_akses']=='Pembeli'){
   include "modul/mod_produk/produk.php";
 }
}
elseif ($_GET[module]=='cart'){
  if ($_SESSION['hak_akses']=='Pembeli'){
   include "modul/mod_cart/cart.php";
 }
}
elseif ($_GET[module]=='checkout'){
  if ($_SESSION['hak_akses']=='Pembeli'){
   include "modul/mod_cart/checkout.php";
 }
}
elseif ($_GET[module]=='pembayaran'){
  if ($_SESSION['hak_akses']=='Pembeli' OR $_SESSION['hak_akses']=='Admin'){
   include "modul/mod_transaksi/pembayaran.php";
 }
}
elseif ($_GET[module]=='konfirmasi_pembayaran'){
  if ($_SESSION['hak_akses']=='Pembeli' OR $_SESSION['hak_akses']=='Admin'){
   include "modul/mod_transaksi/konfirmasi_pembayaran.php";
 }
}
elseif ($_GET[module]=='pesanan'){
  if ($_SESSION['hak_akses']=='Penjual'){
   include "modul/mod_transaksi/pesanan.php";
 }
}
elseif ($_GET[module]=='pengiriman'){
  if ($_SESSION['hak_akses']=='Penjual' OR $_SESSION['hak_akses']=='Pembeli' OR $_SESSION['hak_akses']=='Admin'){
   include "modul/mod_transaksi/pengiriman.php";
 }
}
elseif ($_GET[module]=='komplain'){
  if ($_SESSION['hak_akses']=='Pembeli' OR $_SESSION['hak_akses']=='Admin' OR $_SESSION['hak_akses']=='Penjual'){
   include "modul/mod_transaksi/komplain.php";
 }
}
elseif ($_GET[module]=='history'){
  if ($_SESSION['hak_akses']=='Penjual' OR $_SESSION['hak_akses']=='Pembeli' OR $_SESSION['hak_akses']=='Admin'){
   include "modul/mod_transaksi/history.php";
 }
}
elseif ($_GET[module]=='history_komplain'){
  if ($_SESSION['hak_akses']=='Pembeli' OR $_SESSION['hak_akses']=='Admin'  OR $_SESSION['hak_akses']=='Penjual'){
   include "modul/mod_transaksi/history-komplain.php";
 }
}
elseif ($_GET[module]=='barang-view'){
   include "modul/mod_produk_view/barang-view2.php";
 
}
elseif ($_GET[module]=='detail'){
  include "modul/mod_detail/detail.php";

}
elseif ($_GET[module]=='thanks'){
  include "modul/mod_cart/thanks.php";

}



// Modul Profile
elseif ($_GET[module]=='profile'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Juri' OR $_SESSION[leveluser]=='Peserta' OR $_SESSION[leveluser]=='Visitor'){
    include "modul/mod_profile/profile.php";
  }
}
// Modul Password
elseif ($_GET[module]=='password'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Juri' OR $_SESSION[leveluser]=='Peserta' OR $_SESSION[leveluser]=='Visitor'){
    include "modul/mod_password/password.php";
  }
}

else{
  echo "<p><b>MODUL Tidak DITEMUKAN</b></p>";
}		
echo"</div>
</div>";
?>   
