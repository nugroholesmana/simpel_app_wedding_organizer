<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Pesanan Edit</h3>
            </div>
			<?php echo form_open('pesanan/edit/'.$pesanan['id_pesanan']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="photography" value="1" <?php echo ($pesanan['photography']==1 ? 'checked="checked"' : ''); ?> id='photography' />
							<label for="photography" class="control-label">Photography</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="orgen_tunggal" value="1" <?php echo ($pesanan['orgen_tunggal']==1 ? 'checked="checked"' : ''); ?> id='orgen_tunggal' />
							<label for="orgen_tunggal" class="control-label">Orgen Tunggal</label>
						</div>
					</div>
					<div class="col-md-6">
						<label for="id_pelanggan" class="control-label">Id Pelanggan</label>
						<div class="form-group">
							<input type="text" name="id_pelanggan" value="<?php echo ($this->input->post('id_pelanggan') ? $this->input->post('id_pelanggan') : $pesanan['id_pelanggan']); ?>" class="form-control" id="id_pelanggan" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="id_paket" class="control-label">Id Paket</label>
						<div class="form-group">
							<input type="text" name="id_paket" value="<?php echo ($this->input->post('id_paket') ? $this->input->post('id_paket') : $pesanan['id_paket']); ?>" class="form-control" id="id_paket" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="id_catering" class="control-label">Id Catering</label>
						<div class="form-group">
							<input type="text" name="id_catering" value="<?php echo ($this->input->post('id_catering') ? $this->input->post('id_catering') : $pesanan['id_catering']); ?>" class="form-control" id="id_catering" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="jumlah_tamu" class="control-label"><span class="text-danger">*</span>Jumlah Tamu</label>
						<div class="form-group">
							<input type="text" name="jumlah_tamu" value="<?php echo ($this->input->post('jumlah_tamu') ? $this->input->post('jumlah_tamu') : $pesanan['jumlah_tamu']); ?>" class="form-control" id="jumlah_tamu" />
							<span class="text-danger"><?php echo form_error('jumlah_tamu');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="tgl_resepsi" class="control-label">Tgl Resepsi</label>
						<div class="form-group">
							<input type="text" name="tgl_resepsi" value="<?php echo ($this->input->post('tgl_resepsi') ? $this->input->post('tgl_resepsi') : $pesanan['tgl_resepsi']); ?>" class="has-datepicker form-control" id="tgl_resepsi" />
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