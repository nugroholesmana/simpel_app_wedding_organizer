<style>
    table tr td{
        color:#545456;
    }
    table tr td a:hover, a:active{
        color:#545456;

    }
</style>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <div class="page-header">
        <h3>Rincian Pesanan</h3>
    </div>
    <table class="table table-striped">
        <tr>
            <th width="10%">ID Pesanan</th>
            <td width="30%">: <?php echo htmlentities($get_mypesanan['id_pesanan']) ?></td>
            <th width="10%">Nama Vendor</th>
            <td width="30%">: <?php echo htmlentities($get_mypesanan['nama_vendor']) ?></td>
        </tr>
        <tr>
            <th width="10%">Tanggal Resepsi</th>
            <td width="30%">: <?php echo htmlentities($get_mypesanan['tgl_resepsi']) ?></td>
            <th width="15%">No Telepon Vendor</th>
            <td width="30%">: <?php echo htmlentities($get_mypesanan['no_telp_vendor']) ?></td>
        </tr>
        <tr>
            <th width="10%">Jumlah Tamu</th>
            <td width="30%">: <?php echo htmlentities($get_mypesanan['jumlah_tamu']) ?> Orang</td>
            <th width="10%">Alamat Vendor</th>
            <td width="30%">: <?php echo htmlentities($get_mypesanan['alamat']) ?></td>
        </tr>
        <tr>
            <th width="10%">Status Pesanan</th>
            <td width="30%">: <?php echo $this->ekstra->status_pembayaran($get_mypesanan['status']) ?></td>
            <th width="10%"></th>
            <td width="30%"></td>
        </tr>
    </table>
    <br/>
    <div class="clearfix"></div>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Paket</th>
            <th>Harga</th>
        </tr>
        <?php $nourut = 1; ?>
        <?php $total_harga = 0; ?>
        <?php foreach($get_mypesanandetail as $r){ ?>
        <?php
            if($r['tipe'] == 2){
                $subtotal_harga = $r['harga'] * $r['jumlah_tamu'];
                $harga = "Rp ".number_format($r['harga'])." x ".$r['jumlah_tamu']." = Rp ".number_format($subtotal_harga);
            }else{
                $harga = "Rp ".number_format($r['harga']);
            }
        ?>
        <tr>
            <td><?php echo $nourut; ?></td>
            <td><?php echo htmlentities($r['nama_konten']) ?></td>
            <td><?php echo $harga ?></td>
        </tr>
        <?php $nourut++; ?>
        <?php } ?>
        <tr>
            <th colspan="2">Total</th>
            <td>Rp <?php echo number_format($get_mypesanan['total_pembayaran']) ?></td>
        </tr>
    </table>
    <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Pembayaran</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cara Pembayaran</h4>
      </div>
      <div class="modal-body">
        <p>Cara Pembayaran dengan Transfer Bank</p>
        <ol>
            <li>Transfer sejumlah Rp <?php echo number_format($get_mypesanan['total_pembayaran']) ?> ke salah satu nomor rekening dibawah</li>
            <li>Admin akan mengecek dan konfirmasi pembayaran anda secepatnya</li>
        </ol>
      </div>
      <div class="col-sm-12">
      <table class="table table-striped" width="100%" height="10%">
        <tr>
            <td width="30%">Bank Mandiri</td>
            <td width="30%">Bank BCA</td>
            <td width="30%">Bank BRI</td>
        </tr>
        <tr>
            <td>108.0000.203.222</td>
            <td>2348533882</td>
            <td>129384736477485885</td>
        </tr>
        <tr>
            <td><img src="<?php echo base_url('resources/icon/bank_mandiri-logo.jpg') ?>" width="100%"/></td>
            <td><img src="<?php echo base_url('resources/icon/bank-bca.png') ?>" width="100%"/></td>
            <td><img src="<?php echo base_url('resources/icon/icon-bri.png') ?>" width="100%"/></td>
        </tr>
      </table>
      <p>Cara Pembayaran ditempat</p>
        <ol>
            <li>Melakukan pembayaran secara cash dengan mengunjugi di jam kantor dengan menunjukan ID Pesanan.</li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</div>