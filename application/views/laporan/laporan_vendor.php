<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">

<h3>LAPORAN SISTEM PORTAL PEKANBARU</h3>
<h4>Laporan Data Vendor</h4>
<hr/>
<p>Total Vendor : <?php echo number_format($total_vendor) ?> Orang</p>
<table class="table table-bordered table-striped">
    <tr>
        <th>No</th>
		<th>ID Vendor</th>
		<th>Nama Vendor</th>
		<th>Nama Pemilik Vendor</th>
		<th>No Telp Vendor</th>
        <th>Email</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach($vendor as $t){ ?>
        <tr>
            <td><?php echo $no ?></td>
			<td><?php echo $t['id_vendor']; ?></td>
			<td><?php echo $t['nama_vendor']; ?></td>
			<td><?php echo $t['nama_pemilik_vendor']; ?></td>
			<td><?php echo $t['no_telp_vendor']; ?></td>
            <td><?php echo $t['email']; ?></td>
        </tr>
    <?php $no++; ?>
    <?php } ?>
</table>