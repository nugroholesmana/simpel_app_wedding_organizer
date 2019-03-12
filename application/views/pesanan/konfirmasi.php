<div class="row">
    <div class="col-md-6">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Konfirmasi Pesanan</h3>
            </div>
			<?php echo form_open('pesanan/konfirmasi/?q='.urlencode($this->encrypt_aspireone->encode($pesanan['id_pesanan']))); ?>
			<div class="box-body">
				<div class="row clearfix">
                    <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <td>Tanggal Resepsi</td>
                            <td><?php echo htmlentities($pesanan['tgl_resepsi']) ?></td>
                            <td>ID Pesanan</td>
                            <td><?php echo htmlentities($pesanan['id_pesanan']) ?></td>
                        </tr>
                        <tr>
                            <td>Vendor</td>
                            <td><?php echo htmlentities($pesanan['nama_vendor']) ?></td>
                            <td>Pelanggan</td>
                            <td><?php echo htmlentities($pesanan['nama_pelanggan']) ?></td>
                        </tr>
                        <tr>
                            <td>Paket</td>
                            <td><?php echo htmlentities($pesanan_detail) ?></td>
                            <td>Total</td>
                            <td>Rp <?php echo number_format($pesanan['total_pembayaran']) ?></td>
                        </tr>
                    </table>
                    </div>
                    <div class="col-md-12">
						<label for="status" class="control-label"><span class="text-danger">*</span>Status</label>
						<div class="form-group">
							<select name="status" id="status" class="form-control">
							<option value="">Pilih Status Konfirmasi</option>
								<?php 
                                $status_values = array(
                                    '2'=> 'Pembayaran Diterima',
                                    '3'=> 'Pembatalan Pembayaran'
                                );
								foreach($status_values as $value => $displayText)
								{
									$selected = ($value == $pesanan['status']) ? ' selected="selected"' : $this->input->post('status');

									echo '<option value="'.$value.'" '.$selected.'>'.$displayText.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('status');?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> Save
				</button>
                <a href="<?php echo site_url('pesanan/index') ?>" class="btn btn-primary">Back</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>