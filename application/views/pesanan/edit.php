<?php
$explode_tgl = explode('-', $pesanan['tgl_resepsi']);
$tgl_resepsi = $explode_tgl[2].'/'.$explode_tgl[1].'/'.$explode_tgl[0];
?>
<link href="<?php echo base_url('resources/plugins/select-search/select2.css') ?>" rel="stylesheet" type="text/css">
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Edit Pesanan</h3>
            </div>

			<div id="form_pesanan" style="display:block">
			<?php echo $this->session->flashdata('notif_input') ?>
			<?php $attributes = array('id'=>'formulir') ?>
			<?php echo form_open('pesanan/edit/?q='.urlencode($this->encrypt_aspireone->encode($pesanan['id_pesanan'])), $attributes) ?>
          	<div class="box-body">
			<?php echo validation_errors('<p class="text-danger">','</p>'); ?>
          		<div class="row clearfix">
					<div class="col-md-6">
						<label for="id_pelanggan" class="control-label"><span class="text-danger">*</span>Pelanggan</label>
						<div class="form-group">
							<select name="id_pelanggan" class="form-control select" id="id_pelanggan">
								<option value="">Pilih Pelanggan</option>
								<?php 
								foreach($pelanggan as $value)
								{
									$selected = ($value['id_pelanggan'] == $pesanan['id_pelanggan']) ? ' selected="selected"' : $this->input->post('id_pelanggan');

									echo '<option value="'.$value['id_pelanggan'].'" '.$selected.'>'.$value['id_pelanggan'].' - '.$value['nama_pelanggan'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('id_pelanggan');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="tgl_resepsi" class="control-label"><span class="text-danger">*</span>Tanggal Resepsi</label>
						<div class="form-group">
							<input type="text" name="tgl_resepsi" value="<?php echo ($this->input->post('tgl_resepsi') ? $this->input->post('tgl_resepsi') : $tgl_resepsi); ?>" class="has-datepicker form-control" id="tgl_resepsi" />
							<span class="text-danger"><?php echo form_error('tgl_resepsi');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="id_vendor" class="control-label"><span class="text-danger">*</span>Vendor</label>
						<div class="form-group">
							<select name="id_vendor" id="id_vendor" class="form-control">
							<option value="">Pilih Vendor</option>
								<?php 
								foreach($vendor as $value)
								{
									$selected = ($value['id_vendor'] == $pesanan['id_vendor']) ? ' selected="selected"' : $this->input->post('id_vendor');

									echo '<option value="'.$value['id_vendor'].'" '.$selected.'>'.$value['nama_vendor'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('id_vendor');?></span>
						</div>
					</div>
					<div class="row clearfix"></div>
					<div id="paket_pesanan" style="display:block">
						<div class="col-md-6">
							<h3>Daftar Paket</h3>
							<hr>
						</div>
						<div class="col-md-6">
							<h3>Ekstra</h3>
							<hr>
						</div>
						<div class="col-md-6">
							<label for="id_paket" class="control-label">Paket</label>
							<div class="form-group" id="paket_utama">
								
							</div>
						</div>
						<div class="col-md-6">
							<div id="paket_ekstra"></div>
						</div>
						<div class="row clearfix"></div>
						<div class="col-md-6">
							<label for="id_catering" class="control-label">Catering</label>
							<div class="form-group" id="paket_catering">
							</div>
						</div>
					</div>
			</div>
          	<div class="box-footer">
            	<a class="btn btn-success" id="check">
            		<i class="fa fa-check"></i> Next
            	</a>
				<a href="<?php echo site_url('pesanan/index') ?>" class="btn btn-primary">Back</a>
          	</div>
			</div>
			</div>
			<div id="check_form_pesanan" style="display:none">
			<div class="box-body">
          		<div class="row clearfix">
				  <div class="col-md-12">
				  <div id="result_form"></div>
					<table class="table table-striped table-hover">
						<tr>
							<th colspan="3">Informasi Pemesanan</th>
						</tr>
						<tr>
							<td width="25%">Nama Pelanggan</td>
							<td>:</td>
							<td><span id="nm_pelanggan"></span></td>
						</tr>
						<tr>
							<td>Jumlah Tamu</td>
							<td>:</td>
							<td><span id="jmlh_tamu"></span></td>
						</tr>
						<tr>
							<td>Vendor</td>
							<td>:</td>
							<td><span id="nm_vendor"></span></td>
						</tr>
						<tr>
							<td>Tanggal Resepsi</td>
							<td>:</td>
							<td><span id="tgl"></span></td>
						</tr>
					</table>
					<table class="table table-striped table-hover">
						<tr>
							<td>Tipe Paket</td>
							<td>Nama Paket</td>
							<td>Harga</td>
						</tr>
						<tr>
							<td>Paket Utama</td>
							<td><span id="nm_pkt_utama"></span></td>
							<td><span id="hrg_pkt_utama"></span></td>
						</tr>
						<tr>
							<td>Paket Catering</td>
							<td><span id="nm_pkt_catering"></span></td>
							<td><span id="hrg_pkt_catering"></span></td>
						</tr>
						<tr>
							<td>Paket Ekstra</td>
							<td><span id="nm_pkt_ekstra"></span></td>
							<td><span id="total_pkt_ekstra"></span></td>
						</tr>
						<tr>
							<td colspan="2">Total</td>
							<td><span id="total_harga"></span></td>
						</tr>
					</table>
					
				  </div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success" id="check">
            		<i class="fa fa-check"></i> Save
            	</button>
				<a id="close_check_transaksi" class="btn btn-primary">Edit</a>
          	</div>
			<?php echo form_close() ?>
			</div>
      	</div>
    </div>
</div>
<script type="text/javascript">
id_vendor = $("#id_vendor").val();
id_pesanan = <?php echo $pesanan['id_pesanan'] ?>

//memanggil paket
$.ajax({
	type: 'POST',
	data: "id_vendor="+id_vendor+"&id_pesanan="+id_pesanan,
	url: "<?php echo site_url('pesanan/get_pesanan_paket_utama') ?>",
	success:function(msg){ 
		$("#paket_utama").html(msg);  
	}
});
//memanggil catering
$.ajax({
	type: 'POST',
	data: "id_vendor="+id_vendor+"&id_pesanan="+id_pesanan,
	url: "<?php echo site_url('pesanan/get_pesanan_paket_catering') ?>",
	success:function(msg){ 
		$("#paket_catering").html(msg);  
	}
});
//memanggil ekstra
$.ajax({
	type: 'POST',
	data: "id_vendor="+id_vendor+"&id_pesanan="+id_pesanan,
	url: "<?php echo site_url('pesanan/get_pesanan_paket_ekstra') ?>",
	success:function(msg){ 
		$("#paket_ekstra").html(msg);  
	}
});
	$("#id_vendor").change(function() {
		$("#paket_pesanan").css('display','block');
		id_vendor = $("#id_vendor").val();

		//memanggil paket
		$.ajax({
			type: 'POST',
			data: "id_vendor="+id_vendor,
			url: "<?php echo site_url('paket/get_paket_utama') ?>",
			success:function(msg){ 
				$("#paket_utama").html(msg);  
			}
		});
		//memanggil catering
		$.ajax({
			type: 'POST',
			data: "id_vendor="+id_vendor,
			url: "<?php echo site_url('paket/get_paket_catering') ?>",
			success:function(msg){ 
				$("#paket_catering").html(msg);  
			}
		});
		//memanggil ekstra
		$.ajax({
			type: 'POST',
			data: "id_vendor="+id_vendor,
			url: "<?php echo site_url('paket/get_paket_ekstra') ?>",
			success:function(msg){ 
				$("#paket_ekstra").html(msg);  
			}
		});
	});

	$("#check").click(function() {
		$("#form_pesanan").css('display','none');
		$("#check_form_pesanan").css('display','block');
		formulir = $("#formulir").serializeArray();

		//memanggil ekstra
		$.ajax({
			type: 'POST',
			data: formulir,
			url: "<?php echo site_url('pesanan/check_transaksi') ?>",
			success:function(msg){ 
				var obj = jQuery.parseJSON(msg);
				
				//console.log(obj.paket_ekstra.length);
				//$("#result_form").html(msg); 
				if(obj.nm_pelanggan == null){
					$("#nm_pelanggan").html('<span class="text-danger">Pelanggan tidak boleh kosong</span>');
				}else{
					$("#nm_pelanggan").html(obj.nm_pelanggan);
				} 
				if(obj.jumlah_tamu == ""){
					$("#jmlh_tamu").html('<span class="text-danger">Jumlah tamu undangan tidak boleh kosong</span>');
				}else{
					$("#jmlh_tamu").html(obj.jumlah_tamu+" Orang");
				}
				if(obj.tgl_resepsi == ""){
					$("#tgl").html('<span class="text-danger">Tanggal resepsi tidak boleh kosong</span>');
				}else{
					$("#tgl").html(obj.tgl_resepsi);
				}
				if(obj.nm_vendor == null){
					$("#nm_vendor").html('<span class="text-danger">Vendor tidak boleh kosong</span>');
				}else{
					$("#nm_vendor").html(obj.nm_vendor);
				}
				$("#nm_pkt_utama").html(obj.paket_utama.nama);
				$("#hrg_pkt_utama").html('Rp '+obj.paket_utama.harga);

				$("#nm_pkt_catering").html(obj.paket_catering.nama);
				$("#hrg_pkt_catering").html('Rp '+obj.paket_catering.harga);	

				$("#nm_pkt_ekstra").html(obj.paket_ekstra.nama);
				$("#total_pkt_ekstra").html('Rp '+obj.paket_ekstra.harga);	

				$("#total_harga").html('Rp '+obj.total);
			}
		});
	});

	$("#close_check_transaksi").click(function() {
		$("#form_pesanan").css('display','block');
		$("#check_form_pesanan").css('display','none');
	});
</script>
<!-- Select Search JavaScript -->
<script type="text/javascript" src="<?php echo base_url('resources/plugins/select-search/select2.js') ?>"></script> 
<script type="text/javascript">
	$('.select').select2();
</script>