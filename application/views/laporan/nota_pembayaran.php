<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">
<h4 align="center">Sistem Portal Wedding Pekanbaru</h4>
<h5 align="center">Nota Pembayaran</h5>
<hr/>
<table class="table table-striped">
    <tr>
        <td>ID Pesanan</td>
        <td><?php echo $pesanan['id_pesanan'] ?></td>
        <td>Tanggal Resepsi</td>
        <td><?php echo $pesanan['tgl_resepsi'] ?></td>
    </tr>
    <tr>
        <td>ID Pelanggan</td>
        <td><?php echo $pesanan['id_pelanggan'] ?></td>
        <td>Jumlah Tamu</td>
        <td><?php echo $pesanan['jumlah_tamu'] ?></td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td><?php echo $pesanan['nama_pelanggan'] ?></td>
        <td>Nama Vendor</td>
        <td><?php echo $pesanan['nama_vendor'] ?></td>
    </tr>
</table>
<br/><bbr/>
<table class="table table-bordered">
    <tr>
        <th colspan="3">Daftar Paket</th>
    </tr>
    <tr>
        <td>Tipe Paket</td>
        <td>Nama Paket</td>
        <td>Harga</td>
    </tr>
    <?php foreach($pesanan_paket as $t) { ?>
    <tr>
        <td><?php echo $this->ekstra->tipe_paket(htmlentities($t['tipe'])) ?></td>
        <td><?php echo htmlentities($t['nama_konten']) ?></td>
        <td>Rp <?php echo number_format($t['harga']) ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td><?php echo $this->ekstra->tipe_paket(htmlentities($pesanan_paket_catering['tipe'])) ?></td>
        <td><?php echo htmlentities($pesanan_paket_catering['nama_konten']) ?> - Rp <?php echo number_format($pesanan_paket_catering['harga']) ?> / Orang</td>
        <td>Rp <?php echo number_format($pesanan_paket_catering['harga'] * $pesanan['jumlah_tamu']) ?></td>
    </tr>
    <tr>
        <td colspan="2">Total Harga</td>
        <td>Rp <?php echo number_format($pesanan['total_pembayaran']) ?></td>
    </tr>
</table>

<div class="col-md-3">
    <b>Diterima Oleh</b>
</div>
<div class="row clearfix" style="height:50px"></div>
<div class="col-md-3">
    <?php echo $check_user['username'] ?>
</div>