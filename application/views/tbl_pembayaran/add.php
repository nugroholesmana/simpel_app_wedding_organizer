<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Tbl Pembayaran Add</h3>
            </div>
            <?php echo form_open('tbl_pembayaran/add'); ?>
          	<div class="box-body">
          		<div class="row clearfix">
					<div class="col-md-6">
						<label for="status" class="control-label">Status</label>
						<div class="form-group">
							<select name="status" class="form-control">
								<option value="">select</option>
								<?php 
								$status_values = array(
									'1'=>'Menunggu Pembayaran',
									'2'=>'Pembayaran Diterima',
									'3'=>'Pembatalan Pembayaran',
								);

								foreach($status_values as $value => $display_text)
								{
									$selected = ($value == $this->input->post('status')) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<label for="id_pesanan" class="control-label">Id Pesanan</label>
						<div class="form-group">
							<input type="text" name="id_pesanan" value="<?php echo $this->input->post('id_pesanan'); ?>" class="form-control" id="id_pesanan" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="total_pembayaran" class="control-label">Total Pembayaran</label>
						<div class="form-group">
							<input type="text" name="total_pembayaran" value="<?php echo $this->input->post('total_pembayaran'); ?>" class="form-control" id="total_pembayaran" />
							<span class="text-danger"><?php echo form_error('total_pembayaran');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="jumlah_pembayaran" class="control-label">Jumlah Pembayaran</label>
						<div class="form-group">
							<input type="text" name="jumlah_pembayaran" value="<?php echo $this->input->post('jumlah_pembayaran'); ?>" class="form-control" id="jumlah_pembayaran" />
							<span class="text-danger"><?php echo form_error('jumlah_pembayaran');?></span>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Save
            	</button>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>