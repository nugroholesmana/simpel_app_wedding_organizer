<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Tambah Pelanggan</h3>
            </div>
            <?php echo form_open('pelanggan/add'); ?>
          	<div class="box-body">
				<fieldset>
				<legend><span class="fa fa-user-circle-o"></span> Informasi Diri Pelanggan</legend>
          		<div class="row clearfix">
					<div class="col-md-6">
						<label for="nama_pelanggan" class="control-label"><span class="text-danger">*</span>Nama Pelanggan</label>
						<div class="form-group">
							<input type="text" name="nama_pelanggan" value="<?php echo $this->input->post('nama_pelanggan'); ?>" class="form-control" id="nama_pelanggan" />
							<span class="text-danger"><?php echo form_error('nama_pelanggan');?></span>
						</div>
					</div>					
					<div class="col-md-6">
						<label for="jenis_kelamin" class="control-label">Jenis Kelamin</label>
						<div class="form-group">
							<select name="jenis_kelamin" class="form-control">
								<?php 
								$jenis_kelamin_values = array(
									'Pria'=>'Pria',
									'Wanita'=>'Wanita'	
								);

								foreach($jenis_kelamin_values as $value => $display_text)
								{
									$selected = ($value == $this->input->post('jenis_kelamin')) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<label for="tgl_lahir" class="control-label">Tgl Lahir</label>
						<div class="form-group">
							<input type="text" name="tgl_lahir" value="<?php echo $this->input->post('tgl_lahir'); ?>" class="has-datepicker form-control" id="tgl_lahir" />
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
						<label for="alamat" class="control-label"><span class="text-danger">*</span>Alamat</label>
						<div class="form-group">
							<textarea name="alamat" class="form-control" id="alamat"><?php echo $this->input->post('alamat'); ?></textarea>
							<span class="text-danger"><?php echo form_error('alamat');?></span>
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
				<legend><span class="fa fa-lock"></span> Informasi Akun Pelanggan</legend>
				<div class="row clearfix">
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
					<div class="col-md-12">
						<label for="confpassword" class="control-label"><span class="text-danger">*</span>Confirmation Password</label>
						<div class="form-group">
							<input type="password" name="confpassword" value="<?php echo $this->input->post('confpassword'); ?>" class="form-control" id="confpassword" />
							<span class="text-danger"><?php echo form_error('confpassword');?></span>
						</div>
					</div>
					</fieldset>
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Save
            	</button>
				<a href="<?php echo site_url('pelanggan/index') ?>" class="btn btn-primary">Back</a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>