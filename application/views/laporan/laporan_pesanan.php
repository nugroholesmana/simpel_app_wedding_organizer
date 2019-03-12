<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Laporan Pesanan</h3>
            	<div class="box-tools"> 
                </div>
            </div>
            <div class="box-body">
                <?php $attributes = array('target'=>'_blank'); ?>
                <?php echo form_open('laporan/print_laporan_pesanan',$attributes) ?>
                <div class="col-md-2">
                    <select name="berdasarkan" class="form-control" id="berdasarkan" required>
                        <option value="">Cari Berdasarkan</option>
                        <?php 
							$berdasarkan_value = array(
                                'all'=>'Semua',
								'tgl_resepsi'=>'Tanggal Resepsi',
                                'status'=>'Status Pembayaran',
                                'id_vendor'=>'ID Vendor'
							);
							foreach($berdasarkan_value as $value => $display_text)
							{
								$selected = ($value == $this->input->post('berdasarkan')) ? ' selected="selected"' : "";

								echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
							} 
						?>
                    </select>
                </div>
                <div class="col-md-3" id="single_value" style="display:none">
                    <input type="text" name="string_value" value="<?php echo $this->input->post('string_value'); ?>" class="form-control" placeholder="Pencarian..." />
                </div>
                <div class="col-md-3" id="combo_value" style="display:none">
                    <select name="string_combo" id="combo_value" class="form-control">
							<option value="">Pilih Status Konfirmasi</option>
								<?php 
                                $combo_values = array(
                                    '1'=> 'Menunggu Pembayaran',
                                    '2'=> 'Pembayaran Diterima',
                                    '3'=> 'Pembatalan Pembayaran'
                                );
								foreach($combo_values as $value => $displayText)
								{
									$selected = ($value == $this->input->post('combo_value')) ? ' selected="selected"' : null;

									echo '<option value="'.$value.'" '.$selected.'>'.$displayText.'</option>';
								} 
								?>
							</select>
                </div>
                <div id="multi_value" style="display:none">
                    <div class="col-md-2">
                        <input type="text" name="string_value1" value="<?php echo $this->input->post('string_value1'); ?>" class="has-datepicker form-control" id="string_value1" />
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="string_value2" value="<?php echo $this->input->post('string_value2'); ?>" class="has-datepicker form-control" id="string_value2" />
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info"><span class="fa fa-print"></span> Print</button>
                </div>
                <?php echo form_close() ?>
               <div class="row clearfix"></div>                            
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#berdasarkan").change(function() {
        var tipe_berdasarkan = $("#berdasarkan").val();
        if(tipe_berdasarkan == "tgl_resepsi"){
            $("#multi_value").css('display', 'block');
            $("#single_value").css('display', 'none');
            $("#combo_value").css('display', 'none');
        }else if(tipe_berdasarkan == "all"){
            $("#multi_value").css('display', 'none');
            $("#single_value").css('display', 'none');
            $("#combo_value").css('display', 'none');
        }else if(tipe_berdasarkan == "status"){
            $("#multi_value").css('display', 'none');
            $("#single_value").css('display', 'none');
            $("#combo_value").css('display', 'block');
        }else{
            $("#multi_value").css('display', 'none');
            $("#single_value").css('display', 'block');
            $("#combo_value").css('display', 'none');
        }
    });
</script>
