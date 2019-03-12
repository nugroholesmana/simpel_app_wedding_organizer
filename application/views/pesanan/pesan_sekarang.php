<style>
.page-header, label, p{
    color:#3a3a3a;
}
</style>
<?php echo form_open('pesanan/act_pesan_sekarang') ?>
<input type="hidden" name="id_vendor" value="<?php echo $vendor['id_vendor'] ?>"/>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <div class="page-header">
        <h3>Fomulir Pemesanan</h3>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="nama_vendor" class="control-label">Nama Vendor</label>
            <input type="text" name="nama_vendor" value="<?php echo $vendor['nama_vendor'] ?>" class="form-control" id="nama_vendor" disabled />
            <span class="text-danger"><?php echo form_error('nama_vendor');?></span>
        </div>
        <div class="form-group">
            <label for="tgl_resepsi" class="control-label"><span class="text-danger">*</span>Tanggal Resepsi</label>
            <div class="form-group">
                <input type="date" min="<?php echo date('Y-m-d') ?>" name="tgl_resepsi" value="<?php echo $this->input->post('tgl_resepsi'); ?>" class="has-datepicker form-control" id="tgl_resepsi" />
                <span class="text-danger"><?php echo form_error('tgl_resepsi');?></span>
            </div>
        </div>
        <div class="form-group">
        <label>List Paket</label>
        </div>
        <div class="form-group" id="paket_utama">
        </div>
        <div class="form-group" id="paket_catering">
        </div>        
        <div class="form-group" id="paket_ekstra">
        </div>
        <div class="form-group" id="jumlah_tamu_display" style="display:none">
            <label for="jumlah_tamu" class="control-label">Jumlah Tamu</label>
            <input type="number" name="jumlah_tamu" value="<?php echo $this->input->post('jumlah_tamu') ?>" class="form-control" id="jumlah_tamu" />
            <span class="text-danger"><?php echo form_error('jumlah_tamu');?></span>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th>Jenis Paket</th>
                <th>Paket Diambil</th>
                <th>Subtotal</th>
            </tr>
            <tr>
                <td>Paket Utama</td>
                <td><span id="val_paket_utama"></span></td>
                <td>Rp <span id="val_harga_paket_utama"></span></td>
            </tr>
            <tr>
                <td>Catering</td>
                <td> <span id="val_catering"></span> Rp <span id="val_harga_catering"></span> x <span id="val_jumlah_tamu"></span></td>
                <td>Rp <span id="val_total_harga_catering"></span></td>
            </tr>
            <tr>
                <td>Paket Ekstra</td>
                <td><span id="val_ekstra"></span></td>
                <td><span id="val_harga_ekstra"></span></td>
            </tr>
            <tr>
                <th colspan="2">Total</th>
                <td>Rp <span id="val_total_harga"></span></td> 
            </tr>
        </table>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <button type="submit" class="btn btn-default" onclick="return confirm('Apakah fomulir sudah benar?')">Selesai</button>
        <a href="<?php echo site_url('paket/menu_paket/'.$vendor['id_vendor']) ?>" class="btn btn-info">Kembali</a>
    </div>
</div>
<input type="hidden" id="pkt_utama" value="0"/>
<input type="hidden" id="pkt_catering" value="0"/>
<!-- jQuery 2.2.3 -->
<script src="<?php echo site_url('resources/js/jquery-2.2.3.min.js');?>"></script>
<script>
$(document).ready(function(){
	var harga_paket = 0 ;
    var harga_catering = 0;
    var total_harga = 0;
    var jumlah_tamu = 0;

    id_vendor = <?php echo $vendor['id_vendor'] ?>;
    //memanggil paket
	$.ajax({
		type: 'POST',
		data: "id_vendor="+id_vendor,
		url: "<?php echo site_url('paket/get_paket_utama') ?>",
		success:function(msg){ 
			$("#paket_utama").html(msg); 
            $("#id_paket").change(function(){
                $.ajax({
                    type: 'POST',
                    data: "id_konten="+$("#id_paket").val(),
                    url: "<?php echo site_url('paket/tampilkan_nama_paket') ?>",
                    success:function(msgl){ 
                       $("#val_paket_utama").html(msgl);    
                    }
                });
                $.ajax({
                    type: 'POST',
                    data: "id_konten="+$("#id_paket").val(),
                    url: "<?php echo site_url('paket/tampilkan_harga_paket') ?>",
                    success:function(msgl){ 
                        if(msgl != ""){
                            $("#val_harga_paket_utama").html(msgl);       
                            harga_paket = parseInt(msgl);  
                            $("#pkt_utama").val(harga_paket);
                            total_harga = parseInt(harga_paket) + parseInt($("#pkt_catering").val()) + parseInt(total_ekstra);   
                            $("#val_total_harga").html(total_harga);  

                        }else{
                            $("#val_harga_paket_utama").html(0);       
                            harga_paket = parseInt(0);  
                            $("#pkt_utama").val(harga_paket);
                            total_harga = parseInt($("#pkt_catering").val()) + parseInt(total_ekstra);   
                            $("#val_total_harga").html(total_harga);
                        }  
                    }
                });
            }); 
		}
	});
    //memanggil catering
		$.ajax({
			type: 'POST',
			data: "id_vendor="+id_vendor,
			url: "<?php echo site_url('paket/get_paket_catering') ?>",
			success:function(msg){ 
				$("#paket_catering").html(msg);  
				$("#id_catering").change(function() {
					if(msg != ""){
						$("#jumlah_tamu_display").css('display','block');
                        $.ajax({
                            type: 'POST',
                            data: "id_konten="+$("#id_catering").val(),
                            url: "<?php echo site_url('paket/tampilkan_harga_paket') ?>",
                            success:function(msgl){ 
                                $("#val_harga_catering").html(msgl);     
                                $("#jumlah_tamu").keyup(function(){
                                    $("#val_jumlah_tamu").html($("#jumlah_tamu").val());
                                    var total_harga_catering = msgl * $("#jumlah_tamu").val();
                                    $("#val_total_harga_catering").html(total_harga_catering);
                                    harga_catering = parseInt(total_harga_catering);
                                    $("#pkt_catering").val(harga_catering);
                                    total_harga = parseInt($("#pkt_utama").val()) + parseInt(harga_catering) + parseInt(total_ekstra);
                                    $("#val_total_harga").html(total_harga);  
                                }); 
                                $("#val_jumlah_tamu").html(0);
                                $("#jumlah_tamu").val(0);
                                $("#val_total_harga_catering").html(0);   
                                $("#pkt_catering").val(0);
                                total_harga = parseInt($("#pkt_utama").val()) + parseInt(total_ekstra);
                                $("#val_total_harga").html(total_harga);      
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            data: "id_konten="+$("#id_catering").val(),
                            url: "<?php echo site_url('paket/tampilkan_nama_paket') ?>",
                            success:function(msgl){ 
                                $("#val_catering").html(msgl);                                               
                            }
                        });
                        
					}else if (msg == ""){
						$("#jumlah_tamu_display").css('display','none');
                        total_harga = parseInt(harga_paket) + parseInt(total_ekstra);
                        $("#val_total_harga").html(total_harga);
					}
				});
			}
		});
        //memanggil ekstra
		$.ajax({
			type: 'POST',
			data: "id_vendor="+id_vendor,
			url: "<?php echo site_url('paket/get_paket_ekstra2') ?>",
			success:function(msg){ 
				$("#paket_ekstra").html(msg);  
			}
		});
});
</script>
<?php echo form_close() ?>