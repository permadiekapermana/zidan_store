<?php
  include "../config/koneksi.php";
  error_reporting(0);
  session_start(0); 
  if (empty($_SESSION['email']) AND empty($_SESSION['password'])){
    echo "<script>alert('Untuk mengakses sistem, Anda harus login'); window.location = '../'</script>";
  }
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Zidan Store | Aplikasi Jual Beli Barang Bekas</title>

<!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/z-logo.png">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;" align="center">
              <!-- <a href="?module=dashboard" class="site_title"><i class="fa fa-institution"></i> <span>SIPDAPAP</span></a> -->
              <a href="?module=dashboard" class="site_title">Zidan Store</a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <?php
                if (!empty($_SESSION[foto])) {
                echo"
                <img src='upload/foto/$_SESSION[foto]' alt='...' class='img-circle profile_img'>";
                }
                else {
                echo"
                <img src='images/z-logo.png' alt='...' class='img-circle profile_img'>";
                }
                ?>                
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <?php

                if($_SESSION['hak_akses']=='Admin'){
                $user = mysql_query("SELECT * FROM admin WHERE email='$_SESSION[email]'");
                $row  = mysql_fetch_array($user);
                }
                elseif($_SESSION['hak_akses']=='Pembeli'){
                $user = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                $row  = mysql_fetch_array($user);
                }
                elseif($_SESSION['hak_akses']=='Penjual'){
                $user = mysql_query("SELECT * FROM penjual WHERE email='$_SESSION[email]'");
                $row  = mysql_fetch_array($user);
                }

                ?>
                <h2><?php echo"$row[nama_lengkap]"; ?> </h2>
                <h2><?php echo"$_SESSION[hak_akses]"; ?> </h2>
              </div>
            </div>
            <!-- /menu profile quick info -->
            

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <?php  if ($_SESSION['hak_akses']=='Admin' ){ ?> 
                <ul class="nav side-menu">
                  <li><a href="?module=dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
                  <li><a><i class="fa fa-database"></i> Master Data <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=kategori">Kategori</a></li>
                      <li><a href="?module=kota">Kota (Ongkos Kirim)</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Data Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=admin">Admin</a></li>
                      <li><a href="?module=pembeli">Pembeli</a></li>
                      <li><a href="?module=penjual">Penjual</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-arrow-right"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      $total_1 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order = 'Menunggu Verifikasi Admin' OR status_order = 'Pesanan Diproses'"));
                      $total_2 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order = 'Pesanan Dikirim' OR status_order='Pesanan Diterima'"));
                      $total_3 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order = 'Selesai'"));
                      $total_4 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order = 'Komplain'"));
                      $total_5 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order = 'Komplain Selesai'"));
                      ?>
                      <li><a href="?module=pembayaran">Menunggu Verifikasi Pembayaran (<?php echo"$total_1"; ?>)</a></li>
                      <li><a href="?module=pengiriman">Pengiriman (<?php echo"$total_1"; ?>)</a></li>
                      <li><a href="?module=komplain">Komplain (<?php echo"$total_4"; ?>)</a></li> 
                    </ul>
                  </li>
                  <li><a><i class="fa fa-arrow-right"></i> Riwayat Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=history">Riwayat Transaksi (<?php echo"$total_3"; ?>)</a></li>
                      <li><a href="?module=history_komplain">Riwayat Komplain (<?php echo"$total_5"; ?>)</a></li>
                    </ul>
                  </li>
                  <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out"></i> Log Out</a></li>
                </ul>
                <?php } elseif ($_SESSION['hak_akses']=='Penjual' ){ ?> 
                  <ul class="nav side-menu">
                  <li><a href="?module=data_produk"><i class="fa fa-database"></i> Data Produk</a></li>
                  <li><a href="?module=data_produk"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a></li>
                  <li><a><i class="fa fa-arrow-right"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      $penjual  = mysql_query("SELECT * FROM penjual WHERE email='$_SESSION[email]'");
                      $p        = mysql_fetch_array($penjual);
                      $total_1 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_penjual='$p[id_penjual]' AND status_order = 'Pesanan Diproses'"));
                      $total_2 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_penjual='$p[id_penjual]' AND status_order = 'Pesanan Dikirim' OR status_order='Pesanan Diterima'"));
                      $total_3 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_penjual='$p[id_penjual]' AND status_order = 'Selesai'"));
                      $total_4 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_penjual='$p[id_penjual]' AND status_order = 'Komplain'"));
                      $total_5 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_penjual='$p[id_penjual]' AND status_order = 'Komplain Selesai'"));
                      ?>
                      <li><a href="?module=pesanan">Pesanan Masuk (<?php echo"$total_1"; ?>)</a></li>
                      <li><a href="?module=pengiriman">Pengiriman (<?php echo"$total_2"; ?>)</a></li>
                      <li><a href="?module=komplain">Komplain (<?php echo"$total_4"; ?>)</a></li> 
                    </ul>
                  </li>
                  <li><a><i class="fa fa-arrow-right"></i> Riwayat Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=history">Riwayat Transaksi (<?php echo"$total_3"; ?>)</a></li>
                      <li><a href="?module=history_komplain">Riwayat Komplain (<?php echo"$total_5"; ?>)</a></li>
                    </ul>
                  </li>
                  <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out"></i> Log Out</a></li>
                </ul>
                <?php } elseif ($_SESSION['hak_akses']=='Pembeli'){ ?> 
                  <ul class="nav side-menu">
                  <li><a href="?module=data_produk"><i class="fa fa-database"></i> Katalog Produk</a></li>
                  <li><a href="?module=data_produk"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a></li>
                  <li><a><i class="fa fa-arrow-right"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$_SESSION[email]'");
                      $p        = mysql_fetch_array($pembeli);
                      $total_1 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND  (status_order = 'Menunggu Pembayaran' OR status_order = 'Pesanan Diproses')"));
                      $total_2 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND status_order = 'Pesanan Dikirim' OR status_order='Pesanan Diterima'"));
                      $total_3 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND status_order = 'Selesai'"));
                      $total_4 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND status_order = 'Komplain'"));
                      $total_5 = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE id_pembeli='$p[id_pembeli]' AND status_order = 'Komplain Selesai'"));
                      ?>
                      <li><a href="?module=pembayaran">Menunggu Pembayaran (<?php echo"$total_1"; ?>)</a></li>
                      <li><a href="?module=pengiriman">Pengiriman (<?php echo"$total_2"; ?>)</a></li>                    
                      <li><a href="?module=komplain">Komplain (<?php echo"$total_4"; ?>)</a></li> 
                    </ul>
                  </li>
                  <li><a><i class="fa fa-arrow-right"></i> Riwayat Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=history">Riwayat Transaksi (<?php echo"$total_3"; ?>)</a></li>
                      <li><a href="?module=history_komplain">Riwayat Komplain (<?php echo"$total_5"; ?>)</a></li>
                    </ul>
                  </li>
                  <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out"></i> Log Out</a></li>
                </ul>
                <?php }?> 
              </div>
			  <!-- 
              <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>-->

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>  -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <?php
              if ($_SESSION['hak_akses']=='Admin' OR $_SESSION['hak_akses']=='Penjual'){
              ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?php
                if (!empty($_SESSION[foto])) {
                echo"
                <img src='upload/foto/$_SESSION[foto]' alt='...'>";
                }
                else {
                echo"
                <img src='images/picture.jpg' alt='...'>";
                }
                ?>  <?php echo"$_SESSION[email]"; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <!-- <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="?module=profile"> Lihat Profil</a></li>
                    <li>
                      <a href="?module=password">
                        <span>Ubah Password</span>
                      </a>
                    </li>
                    
                    <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul> -->
                </li>
                
              </ul>
              <?php
              }elseif ($_SESSION['hak_akses']=='Pembeli'){
              ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="?module=cart">
                  <?php
                  $id = $_SESSION[email];
                  $pembeli  = mysql_query("SELECT * FROM pembeli WHERE email='$id'");
                  $pem      = mysql_fetch_array($pembeli);
                  $hitung_produk = mysql_query("SELECT COUNT(keranjang.id_produk) AS jumlah_produk FROM keranjang, produk WHERE id_pembeli = '$pem[id_pembeli]' AND keranjang.id_produk = produk.id_produk");
                  $r2=mysql_fetch_array($hitung_produk);
                  ?>
                  <span class=" fa fa-shopping-bag"></span>&nbsp; &nbsp;Keranjang Belanja&nbsp;<b>(<?php echo"$r2[jumlah_produk]"; ?> Items)</b>
                  </a>
                  <!-- <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="?module=profile"> Lihat Profil</a></li>
                    <li>
                      <a href="?module=password">
                        <span>Ubah Password</span>
                      </a>
                    </li>
                    
                    <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul> -->
                </li>
                
              </ul>
              <?php
              }
              ?>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Log Out</h5>
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Apakah anda yakin ingin Log Out ?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="logout.php"><button type="button" class="btn btn-primary">Log Out</button></a>
              </div>
            </div>
          </div>
        </div>
        <!-- /Modal Logout -->

        <!-- page content -->        
        <?php include "content.php"; ?> 
        <!-- /page content -->

        <!-- footer content
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
         /footer content -->
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <p>&copy;2020 Zidan Store | All Right Reserved | Dibuat Oleh : <a href="">Nikma Yanti</a></p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

<!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">


    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
	<!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>    
    
<!-- bootstrap-daterangepicker -->
<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

  </body>
</html>