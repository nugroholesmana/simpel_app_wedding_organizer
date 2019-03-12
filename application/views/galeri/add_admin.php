<div class="row">
    <div class="col-md-6">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Tambah Galeri</h3>
            </div>
            <?php echo form_open_multipart('galeri/galeri_admin_add'); ?>
            <input type="hidden" name="id_vendor" value="<?php echo $this->encrypt_aspireone->encode($get_user['id_vendor']) ?>">
          	<div class="box-body">
                <?php echo validation_errors() ?>
				 <?php echo $this->session->flashdata('notif_input'); ?>
          		<div class="row clearfix">					
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
				<a href="<?php echo site_url('galeri/galeri_admin') ?>" class="btn btn-primary">Back</a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>