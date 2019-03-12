<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Tambah Paket</h3>
            </div>
            <?php echo form_open_multipart('paket/paket_admin_add'); ?>
          	<div class="box-body">
				 <?php echo $this->session->flashdata('notif_input'); ?>
          		<div class="row clearfix">
                  <div class="col-md-6">
						<label for="nama_konten" class="control-label"><span class="text-danger">*</span>Nama Konten</label>
						<div class="form-group">
							<input type="text" name="nama_konten" value="<?php echo $this->input->post('nama_konten'); ?>" class="form-control" id="nama_konten" />
							<span class="text-danger"><?php echo form_error('nama_konten');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="harga" class="control-label"><span class="text-danger">*</span>Harga (Rp)</label>
						<div class="form-group">
							<input type="text" name="harga" value="<?php echo $this->input->post('harga'); ?>" class="form-control" id="harga" />
							<span class="text-danger"><?php echo form_error('harga');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="tipe" class="control-label"><span class="text-danger">*</span>Tipe</label>
						<div class="form-group">
							<select name="tipe" class="form-control">
								<option value="">Pilih Tipe Paket</option>
								<?php 
								$tipe_values = array(
									'1'=>'Paket Utama',
									'2'=>'Catering',
									'3'=>'Ekstra'
								);

								foreach($tipe_values as $value => $display_text)
								{
									$selected = ($value == $this->input->post('tipe')) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('tipe');?></span>
						</div>
					</div>					
					<div class="col-md-6">
						<label for="foto" class="control-label"><span class="text-danger">*</span>Foto</label>
						<div class="form-group">
							<input type="file" name="foto" id="foto" required />
							<span class="text-danger"><?php echo form_error('foto');?></span>
						</div>
					</div>
					<div class="col-md-12">
						<label for="keterangan" class="control-label">Keterangan</label>
						<div class="form-group">
							<textarea name="keterangan" class="form-control" id="keterangan"><?php echo $this->input->post('keterangan'); ?></textarea>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Save
            	</button>
				<a href="<?php echo site_url('paket/paket_admin') ?>" class="btn btn-primary">Back</a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('resources/plugins/tinymce/jquery.tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resources/plugins/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript">
		tinymce.init({
			selector:"textarea",
			height:300
		});
</script>