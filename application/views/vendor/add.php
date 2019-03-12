<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Tambah Vendor</h3>
            </div>
            <?php echo form_open('vendor/add'); ?>
          	<div class="box-body">
			  <fieldset>
			  <legend><span class="fa fa-user-circle-o"></span> Informasi Vendor</legend>
          		<div class="row clearfix">
					<div class="col-md-6">
						<label for="nama_vendor" class="control-label"><span class="text-danger">*</span>Nama Vendor</label>
						<div class="form-group">
							<input type="text" name="nama_vendor" value="<?php echo $this->input->post('nama_vendor'); ?>" class="form-control" id="nama_vendor" />
							<span class="text-danger"><?php echo form_error('nama_vendor');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="nama_pemilik_vendor" class="control-label"><span class="text-danger">*</span>Nama Pemilik Vendor</label>
						<div class="form-group">
							<input type="text" name="nama_pemilik_vendor" value="<?php echo $this->input->post('nama_pemilik_vendor'); ?>" class="form-control" id="nama_pemilik_vendor" />
							<span class="text-danger"><?php echo form_error('nama_pemilik_vendor');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="no_telpon" class="control-label"><span class="text-danger">*</span>No Telpon</label>
						<div class="form-group">
							<input type="text" name="no_telpon" value="<?php echo $this->input->post('no_telpon'); ?>" class="form-control" id="no_telpon" />
							<span class="text-danger"><?php echo form_error('no_telpon');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="no_telp_vendor" class="control-label"><span class="text-danger">*</span>No Telp Vendor</label>
						<div class="form-group">
							<input type="text" name="no_telp_vendor" value="<?php echo $this->input->post('no_telp_vendor'); ?>" class="form-control" id="no_telp_vendor" />
							<span class="text-danger"><?php echo form_error('no_telp_vendor');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="alamat" class="control-label">Alamat</label>
						<div class="form-group">
							<textarea name="alamat" class="form-control" id="alamat"><?php echo $this->input->post('alamat'); ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<label for="email" class="control-label"><span class="text-danger">*</span>Email</label>
						<div class="form-group">
							<input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control" id="email" />
							<span class="text-danger"><?php echo form_error('email');?></span>
						</div>
					</div>
				</div>
				</fieldset>
				<fieldset>
				<legend><span class="fa fa-lock"></span> Informasi Akun Vendor</legend>
					<div class="col-md-12">
						<label for="username" class="control-label"><span class="text-danger">*</span>Username</label>
						<div class="form-group">
							<input type="text" name="username" value="<?php echo $this->input->post('username'); ?>" class="form-control" id="username" />
							<span class="text-danger"><?php echo form_error('username');?></span>
						</div>
					</div>
					<div class="col-md-12">
						<label for="password" class="control-label"><span class="text-danger">*</span>Password</label>
						<div class="form-group">
							<input type="password" name="password" value="<?php echo $this->input->post('password'); ?>" class="form-control" id="password" />
							<span class="text-danger"><?php echo form_error('password');?></span>
						</div>
					</div>
				</fieldset>
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