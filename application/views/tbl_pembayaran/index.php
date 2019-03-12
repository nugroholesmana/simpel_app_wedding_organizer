<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Tbl Pembayaran Listing</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('tbl_pembayaran/add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
						<th>Id Pembayaran</th>
						<th>Status</th>
						<th>Id Pesanan</th>
						<th>Total Pembayaran</th>
						<th>Jumlah Pembayaran</th>
						<th>Actions</th>
                    </tr>
                    <?php foreach($tbl_pembayaran as $t){ ?>
                    <tr>
						<td><?php echo $t['id_pembayaran']; ?></td>
						<td><?php echo $t['status']; ?></td>
						<td><?php echo $t['id_pesanan']; ?></td>
						<td><?php echo $t['total_pembayaran']; ?></td>
						<td><?php echo $t['jumlah_pembayaran']; ?></td>
						<td>
                            <a href="<?php echo site_url('tbl_pembayaran/edit/'.$t['id_pembayaran']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                            <a href="<?php echo site_url('tbl_pembayaran/remove/'.$t['id_pembayaran']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                                
            </div>
        </div>
    </div>
</div>
