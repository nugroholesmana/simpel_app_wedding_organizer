<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Vendor Edit</h3>
            </div>
			<?php echo form_open('vendor/edit/'.$vendor['id_vendor']); ?>
			<div class="box-body">
				<table width="25%">
					<tr>
						<th>ID Vendor</th>
						<td width="10%">:</td>
						<td><?php echo $vendor['id_vendor'] ?></td>
					</tr>
					<tr>
						<th>ID User</th>
						<td width="10%">:</td>
						<td><a href="<?php echo site_url('user/edit/?q='.urlencode($this->encrypt_aspireone->encode($vendor['id_user']))) ?>" target="_blank"><?php echo $vendor['id_user'] ?></a></td>
					</tr>
				</table>
				<br>
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="nama_vendor" class="control-label"><span class="text-danger">*</span>Nama Vendor</label>
						<div class="form-group">
							<input type="text" name="nama_vendor" value="<?php echo ($this->input->post('nama_vendor') ? $this->input->post('nama_vendor') : $vendor['nama_vendor']); ?>" class="form-control" id="nama_vendor" />
							<span class="text-danger"><?php echo form_error('nama_vendor');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="nama_pemilik_vendor" class="control-label"><span class="text-danger">*</span>Nama Pemilik Vendor</label>
						<div class="form-group">
							<input type="text" name="nama_pemilik_vendor" value="<?php echo ($this->input->post('nama_pemilik_vendor') ? $this->input->post('nama_pemilik_vendor') : $vendor['nama_pemilik_vendor']); ?>" class="form-control" id="nama_pemilik_vendor" />
							<span class="text-danger"><?php echo form_error('nama_pemilik_vendor');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="no_telpon" class="control-label"><span class="text-danger">*</span>No Telpon</label>
						<div class="form-group">
							<input type="text" name="no_telpon" value="<?php echo ($this->input->post('no_telpon') ? $this->input->post('no_telpon') : $vendor['no_telpon']); ?>" class="form-control" id="no_telpon" />
							<span class="text-danger"><?php echo form_error('no_telpon');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="no_telp_vendor" class="control-label"><span class="text-danger">*</span>No Telp Vendor</label>
						<div class="form-group">
							<input type="text" name="no_telp_vendor" value="<?php echo ($this->input->post('no_telp_vendor') ? $this->input->post('no_telp_vendor') : $vendor['no_telp_vendor']); ?>" class="form-control" id="no_telp_vendor" />
							<span class="text-danger"><?php echo form_error('no_telp_vendor');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="alamat" class="control-label">Alamat</label>
						<div class="form-group">
							<textarea name="alamat" class="form-control" id="alamat"><?php echo ($this->input->post('alamat') ? $this->input->post('alamat') : $vendor['alamat']); ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> Save
				</button>
				<a href="<?php echo site_url('vendor/index') ?>" class="btn btn-primary">Back</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>