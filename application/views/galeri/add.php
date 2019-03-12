<div class="row">
    <div class="col-md-6">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Tambah Galeri</h3>
            </div>
            <?php echo form_open_multipart('galeri/add'); ?>
          	<div class="box-body">
				 <?php echo $this->session->flashdata('notif_input'); ?>
          		<div class="row clearfix">
					<div class="col-md-6">
						<label for="id_vendor" class="control-label"><span class="text-danger">*</span>Vendor</label>
						<div class="form-group">
							<select name="id_vendor" class="form-control">
							<option value="">Pilih Vendor</option>
								<?php 
								foreach($vendor as $value)
								{
									$selected = ($value['id_vendor'] == $this->input->post('id_vendor')) ? ' selected="selected"' : "";

									echo '<option value="'.$value['id_vendor'].'" '.$selected.'>'.$value['id_vendor'].' - '.$value['nama_vendor'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('id_vendor');?></span>
						</div>
					</div>
					<div class="col-md-12">
						<label for="gambar" class="control-label"><span class="text-danger">*</span>Gambar</label>
						<div class="form-group">
							<input type="file" name="gambar" id="gambar" required />
							<span class="text-danger"><?php echo form_error('gambar');?></span>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Save
            	</button>
				<a href="<?php echo site_url('galeri/index') ?>" class="btn btn-primary">Back</a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>