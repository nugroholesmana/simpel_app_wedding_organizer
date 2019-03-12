<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">

<h3>LAPORAN SISTEM PORTAL PEKANBARU</h3>
<h4>Laporan Data Pelanggan</h4>
<hr/>
<p>Total Pelanggan : <?php echo number_format($total_pelanggan) ?> Orang</p>
<table class="table table-bordered table-striped">
    <tr>
        <th>No</th>
		<th>ID Pelanggan</th>
		<th>Nama Pelanggan</th>
		<th>No Telpon</th>
		<th>Email</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach($pelanggan as $t){ ?>
        <tr>
            <td><?php echo $no ?></td>
			<td><?php echo $t['id_pelanggan']; ?></td>
			<td><?php echo $t['nama_pelanggan']; ?></td>
			<td>0<?php echo $t['no_telpon']; ?></td>
			<td><?php echo $t['email']; ?></td>
        </tr>
    <?php $no++; ?>
    <?php } ?>
</table>