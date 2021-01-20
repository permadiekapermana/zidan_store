<?php
error_reporting(0);
include "../config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Zidan Store | Login</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/z-logo.png">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="cek_login.php" method="POST">
              <h1 class="mb-5">Login Form</h1>
              <img src="images/z-logo.png"width="100px" alt="">
              <div>
                <input type="text" class="form-control" name="email" placeholder="Masukkan Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required="" />
              </div>
              <div>
                  <button type="submit" class="btn btn-primary submit">Log  in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Pengguna Baru?
                  Buat Akun <a href="#signup" class="to_register">Disini</a>
                </p>

                <div class="clearfix"></div>

                <div>
                  <p>&copy;2020 All Rights Reserved. Dibuat oleh : Nikma Yanti.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="register_action.php" method="POST">
              <h1>Buat Akun</h1>
              <img src="images/z-logo.png"width="100px" alt="">
              <div>
                <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required="" />
              </div>
              <div>
                <input type="text" class="form-control" name="no_hp" maxlength="16" placeholder="Masukkan Nomor HP" required="" />
              </div>
              <div class="form-group">                    
                  <select id="id_kota" name="id_kota" class="form-control" required>
                    <option value="">-- Pilih Kota / Kabupaten --</option>
                    <?php
                    $tampil=mysql_query("SELECT * FROM kota ORDER BY id_kota");
                    while($r=mysql_fetch_array($tampil)){
                    echo"<option value=$r[id_kota]>$r[nama_kota]</option>";
                    }
                    ?>
                  </select>
              </div>
              <div>
                <textarea type="text" class="form-control mb-3" name="alamat" placeholder="Masukkan Alamat Lengkap" required=""></textarea>
              </div> <br>
              <div>
                <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password2" placeholder="Masukkan Ulang Password" required="" />
              </div>
              <div class="form-group">                    
                    <select class="form-control placeholder-no-fix" name="as" id="as" required="">
                        <option value="">-- Pilih Hak Akses --</option>
                        <option value="Pembeli">Pembeli</option>
                        <option value="Penjual">Penjual</option>
                    </select>
                </div>
                <div class="form-group" id="fnorek" style="display: none;">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Nama Toko" name="nama_toko" id="nama_toko" />
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Nomor Rekening" name="nomor_rekening" id="nomor_rekening" />
                </div>
              <div>
                <button type="submit" class="btn btn-primary submit">Submit</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Sudah Memiliki Akun?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>

                <div>
                    <p>&copy;2020 All Rights Reserved. Dibuat oleh : Nikma Yanti.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>

  <script src="global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="global/scripts/app.min.js" type="text/javascript"></script>
        <script src="login.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            function isNumberKey(evt){
                var charCode = (evt.which) ? evt.which : event.keyCode
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;
                return true;
            };

            var bt = document.getElementById('register-submit-btn');
            $("input[type='text'], textarea").on("keyup", function(){
                if($(this).val() != "" && $("textarea").val() != "" && $("input[name='username']").val() != "" && $("input[name='fullname']").val() != "" && $("input[name='no_ktp']").val() != "" && $("input[name='no_telephone']").val() != "" && $("input[name='email']").val() != "" && $("input[name='password']").val() != "" && $("input[name='repassword']").val() != "" && $("input[name='tnc']").is(":checked") == true){
                    bt.disabled = false;
                } else {
                    bt.disabled = true;
                }
            });

            $("input[name='tnc']").on("change", function(){
                if($(this).val() != "" && $("textarea").val() != "" && $("input[name='username']").val() != "" && $("input[name='fullname']").val() != "" && $("input[name='no_ktp']").val() != "" && $("input[name='no_telephone']").val() != "" && $("input[name='email']").val() != "" && $("input[name='password']").val() != "" && $("input[name='repassword']").val() != "" && $("input[name='tnc']").is(":checked") == true){
                    bt.disabled = false;
                } else {
                    bt.disabled = true;
                }
            });

            jQuery('#as').change(function(){
                var val = jQuery(this).val();

                if(val == 'Penjual'){
                    jQuery('#fnorek').show().addClass('required');
                } else {
                    jQuery('#fnorek').hide().removeClass('required');
                }
            });
        </script>

  </body>
</html>
