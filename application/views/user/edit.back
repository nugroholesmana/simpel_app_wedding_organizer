<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Akun User</h3>
            </div>
			<?php echo form_open('user/edit/?q='.urlencode($this->encrypt_aspireone->encode($user['id_user']))); ?>
			<div class="box-body">
                <?php echo $this->session->flashdata('notif_input') ?>
                <?php echo validation_errors('<p class="text-danger">','</p>') ?>
				<div class="row clearfix">                    
					<div class="col-md-6">
						<label for="id_user" class="control-label">ID User</label>
						<div class="form-group">
							<input type="text" name="id_user" value="<?php echo ($this->input->post('id_user') ? $this->input->post('id_user') : $user['id_user']); ?>" class="form-control" id="id_user" disabled />
						</div>
					</div>
					<div class="col-md-6">
						<label for="email" class="control-label"><span class="text-danger">*</span>Email</label>
						<div class="form-group">
							<input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $user['email']); ?>" class="form-control" id="email" />
							<span class="text-danger"><?php echo form_error('email');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="username" class="control-label">Username</label>
						<div class="form-group">
							<input type="text" name="username" value="<?php echo ($this->input->post('username') ? $this->input->post('username') : $user['username']); ?>" class="form-control" id="username" disabled />
							<span class="text-danger"><?php echo form_error('username');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="password" class="control-label">Password</label>
						<div class="form-group">
							<input type="password" name="password" value="<?php echo ($this->input->post('password') ? $this->input->post('password') : null); ?>" class="form-control" id="password" placeholder="Empty if not change password" />
							<span class="text-danger"><?php echo form_error('password');?></span>
						</div>
					</div>
                    <div class="col-md-6">
						<label for="hak_akses" class="control-label">Hak Akses</label>
						<div class="form-group">
							<select name="hak_akses" class="form-control" disabled>
								<option value="">select</option>
								<?php 
								$hak_akses_values = array(
									'admin'=>'Admin',
									'admin_wo'=>'Admin Wedding Organizer',
									'pelanggan'=>'Pelanggan',
								);

								foreach($hak_akses_values as $value => $display_text)
								{
									$selected = ($value == $user['hak_akses']) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
						</div>
					</div>                    
                    <div class="col-md-6">
						<label for="confpassword" class="control-label">Confirm Password</label>
						<div class="form-group">
							<input type="password" name="confpassword" value="<?php echo ($this->input->post('confpassword') ? $this->input->post('confpassword') : null); ?>" class="form-control" id="confpassword" />
							<span class="text-danger"><?php echo form_error('password');?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> Save
				</button>
				<a href="<?php echo site_url('user/index') ?>" class="btn btn-primary">Back</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>