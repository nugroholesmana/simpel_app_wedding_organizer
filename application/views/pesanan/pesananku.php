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
        <h3>List Pesanan</h3>
    </div>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>ID Pesanan</th>
            <th>Vendor</th>
            <th>Tanggal Resepsi</th>
            <th>Total Tagihan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $nourut = 1; ?>
        <?php foreach($get_mypesanan as $r){ ?>
        <tr>
            <td><?php echo $nourut; ?></td>
            <td><?php echo htmlentities($r['id_pesanan']) ?></td>
            <td><?php echo htmlentities($r['nama_vendor']) ?></td>
            <td><?php echo htmlentities($r['tgl_resepsi']) ?></td>
            <td>Rp <?php echo number_format($r['total_pembayaran']) ?></td>
            <td><?php echo $this->ekstra->status_pembayaran($r['status']) ?></td>
            <td><a href="<?php echo site_url('pesanan/detail_mypesanan/'.$r['id_pesanan']) ?>" id="tombol_detail">Detail</a></td>
        </tr>
        <?php $nourut++; ?>
        <?php } ?>
    </table>
</div>