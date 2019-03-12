<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">

<h3>LAPORAN SISTEM PORTAL PEKANBARU</h3>
<h4>Laporan Data User</h4>
<hr/>
<table class="table table-bordered table-striped">
    <tr>
        <td align="center">No</td>
        <td align="center">Username</td>
        <td align="center">Email</td>
        <td align="center">Hak Akses</td>
        <td align="center">Status</td>
    </tr>

    <?php $no = 1; ?>
    <?php foreach($user as $t){ ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo htmlentities($t['username']) ?></td>
            <td><?php echo htmlentities($t['email']) ?></td>
            <td><?php echo $this->ekstra->hak_akses(htmlentities($t['hak_akses'])) ?></td>
            <td><?php echo $this->ekstra->status_user(htmlentities($t['aktif'])) ?></td>
        </tr>
    <?php $no++; ?>
    <?php } ?>
</table>