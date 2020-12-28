<div role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Dashboard</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <?php
                    
          $admin       = mysql_num_rows(mysql_query("SELECT * FROM users WHERE hak_akses='Admin' AND aktif=1"));
          $pembayaran        = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order = 'Menunggu Verifikasi Admin'"));
          $pengiriman     = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE  status_order = 'Sedang Dikirim'"));
          $j_tot       = mysql_num_rows(mysql_query("SELECT * FROM orders WHERE status_order='Selesai'"));

          

          echo"
            <div class='row tile_count'>
              <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                <span class='count_top'><i class='fa fa-user'></i> Jumlah Admin</span>
                <div class='count'>$admin</div>
              </div>
              <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                <span class='count_top'><i class='fa fa-user'></i>Menunggu Pembayaran</span>
                <div class='count'>$pembayaran</div>
              </div>
              <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                <span class='count_top'><i class='fa fa-user'></i> Jumlah Pengiriman</span>
                <div class='count'>$pengiriman</div>
              </div>
              <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                <span class='count_top'><i class='fa fa-users'></i> Total Pesanan</span>
                <div class='count'>$j_tot</div>
              </div>
            </div>
            ";
            ?>           
            <!-- <div class="bs-example" data-example-id="simple-jumbotron">
                    <div class="jumbotron">
                      <div class="text-center">
                        <img style="width: 60%; display: block;" class="img-responsive center-block" src="images/kc-banner-big.jpg" alt="image" />
                      </div>
                    </div>
                  </div>           -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>