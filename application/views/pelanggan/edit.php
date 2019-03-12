<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Pelanggan Edit</h3>
            </div>
			<?php echo form_open('pelanggan/edit/?q='.urlencode($this->encrypt_aspireone->encode($pelanggan['id_user']))); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
					<table width="25%">
						<tr>
							<th>ID Pelanggan</th>
							<td width="10%">:</td>
							<td><?php echo $pelanggan['id_pelanggan'] ?></td>
						</tr>
						<tr>
							<th>ID User</th>
							<td width="10%">:</td>
							<td><a href="<?php echo site_url('user/edit/?q='.urlencode($this->encrypt_aspireone->encode($pelanggan['id_user']))) ?>" target="_blank"><?php echo $pelanggan['id_user'] ?></a></td>
						</tr>
					</table>
					<br>
					</div>
					<div class="col-md-12">
						<label for="nama_pelanggan" class="control-label"><span class="text-danger">*</span>Nama Pelanggan</label>
						<div class="form-group">
							<input type="text" name="nama_pelanggan" value="<?php echo ($this->input->post('nama_pelanggan') ? $this->input->post('nama_pelanggan') : $pelanggan['nama_pelanggan']); ?>" class="form-control" id="nama_pelanggan" />
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
									$selected = ($value == $pelanggan['jenis_kelamin']) ? ' selected="selected"' : $this->input->post('jenis_kelamin');

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
						</div>
					</div>					
					<div class="col-md-6">
						<label for="tgl_lahir" class="control-label">Tanggal Lahir</label>
						<div class="form-group">
							<?php
								$explode_tgl_lahir = explode('-',$pelanggan['tgl_lahir']);
								$tgl_lahir = $explode_tgl_lahir[2].'/'.$explode_tgl_lahir[1].'/'.$explode_tgl_lahir[0];
							?>
							<input type="text" name="tgl_lahir" value="<?php echo ($this->input->post('tgl_lahir') ? $this->input->post('tgl_lahir') : $tgl_lahir); ?>" class="has-datepicker form-control" id="tgl_lahir" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="no_telpon" class="control-label"><span class="text-danger">*</span>No Telpon</label>
						<div class="form-group">
							<input type="text" name="no_telpon" value="<?php echo ($this->input->post('no_telpon') ? $this->input->post('no_telpon') : $pelanggan['no_telpon']); ?>" class="form-control" id="no_telpon" />
							<span class="text-danger"><?php echo form_error('no_telpon');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="alamat" class="control-label"><span class="text-danger">*</span>Alamat</label>
						<div class="form-group">
							<textarea name="alamat" class="form-control" id="alamat"><?php echo ($this->input->post('alamat') ? $this->input->post('alamat') : $pelanggan['alamat']); ?></textarea>
							<span class="text-danger"><?php echo form_error('alamat');?></span>
						</div>
					</div>
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