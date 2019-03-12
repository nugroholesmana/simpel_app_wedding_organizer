<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">

<h3>LAPORAN SISTEM PORTAL PEKANBARU</h3>
<h4>Laporan Pesanan </h4>
<hr/>
<table class="table table-bordered table-striped">
    <tr>
        <td align="center">No</td>
        <td align="center">Tanggal Resepsi</td>
        <td align="center">ID Pesanan</td>
        <td align="center">ID Pelanggan</td>
        <td align="center">Vendor</td>
        <td align="center">Status Pembayaran</td>
        <td align="center">Total Pembayaran</td>
    </tr>
    <?php if(!$pesanan){ ?>
    <tr>
        <td colspan="7">Data pesanan tidak ditemukan.</td>
    </tr>
    <?php } ?>
    <?php $no = 1; ?>
    <?php $total_semua_pembayaran = 0; ?>
    <?php foreach($pesanan as $t){ ?>
    <?php $total_semua_pembayaran += $t['total_pembayaran']; ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo htmlentities($t['tgl_resepsi']) ?></td>
            <td><?php echo htmlentities($t['id_pesanan']) ?></td>
            <td><?php echo htmlentities($t['id_pelanggan']) ?></td>
            <td><?php echo htmlentities($t['nama_vendor']) ?></td>
            <td><?php echo $this->ekstra->status_pembayaran(htmlentities($t['status'])) ?></td>
            <td>Rp <?php echo number_format($t['total_pembayaran']) ?></td>
        </tr>
    <?php $no++; ?>
    <?php } ?>
    <tr>
        <td colspan="6"><b>Total</b></td>
        <td colspan="1">Rp <?php echo number_format($total_semua_pembayaran) ?></td>
    </tr>
    <tr>
        <td colspan="6"><b>Min Pembayaran</b></td>
        <td colspan="1">Rp <?php echo number_format($get_pesanan['min_pembayaran']) ?></td>
    </tr>
    <tr>
        <td colspan="6"><b>Max Pembayaran</b></td>
        <td colspan="1">Rp <?php echo number_format($get_pesanan['max_pembayaran']) ?></td>
    </tr>
</table>