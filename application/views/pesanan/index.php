<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Pesanan Listing</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('pesanan/add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
                <?php echo form_open('pesanan/index') ?>
                <div class="col-md-2">
                    <select name="berdasarkan" class="form-control" required>
                        <option value="">Cari Berdasarkan</option>
                        <?php 
							$berdasarkan_value = array(
                                'id_pesanan'=>'ID Pesanan',
								'id_pelanggan'=>'ID Pelanggan'
							);
							foreach($berdasarkan_value as $value => $display_text)
							{
								$selected = ($value == $this->input->post('berdasarkan')) ? ' selected="selected"' : "";

								echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
							} 
						?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="string_value" value="<?php echo $this->input->post('string_value'); ?>" class="form-control" placeholder="Pencarian..." required />
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info">Cari</button>
                    <a href="<?php echo site_url('pesanan') ?>" class="btn btn-info">Tampilkan Semua</a>
                </div>
                <?php echo form_close() ?>
                <br/><br/>
                <?php echo $this->session->flashdata('notif_input') ?>
                <table class="table table-striped">
                    <tr>
                        <th>No</th>
						<th>ID Pesanan</th>
						<th>ID Pelanggan</th>
                        <th>Total Pembayaran</th>
						<th>Tanggal Resepsi</th>
                        <th>Status Pembayaran</th>
                        <th>Cetak</th>
						<th>Actions</th>
                    </tr>
                    <?php
                        if(!$pesanan){
                            echo '<tr><td colspan="7">Pesanan tidak ditemukan.</td></tr>';
                        }
                    ?>
                    <?php $no = 1 + $offset; ?>
                    <?php foreach($pesanan as $t){ ?>
                    <tr>
                        <td><?php echo $no ?></td>
						<td><?php echo $t['id_pesanan']; ?></td>
						<td><?php echo $t['id_pelanggan']; ?></td>
                        <td>Rp <?php echo number_format($t['total_pembayaran']); ?></td>
                        <td><?php echo $t['tgl_resepsi']; ?></td>
						<td><?php echo $this->ekstra->status_pembayaran($t['status']); ?></td>
                        <td><a href="<?php echo site_url('laporan/nota_pembayaran/?q='.urlencode($this->encrypt_aspireone->encode($t['id_pesanan']))); ?>" class="btn btn-default btn-xs" target="_blank"><span class="fa fa-print"></span> Print</a></td>
						<td>
                            <a href="<?php echo site_url('pesanan/konfirmasi/?q='.urlencode($this->encrypt_aspireone->encode($t['id_pesanan']))); ?>" class="btn btn-success btn-xs"><span class="fa fa-pencil"></span> Confirmation</a> 
                            <a href="<?php echo site_url('pesanan/edit/?q='.urlencode($this->encrypt_aspireone->encode($t['id_pesanan']))); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                            <a href="#" id="modal-remove" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".remove<?php echo $t['id_pesanan'] ?>" ><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>
                    <!-- Modal Remove -->
                    <div class="modal fade remove<?php echo $t['id_pesanan'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Anda Yakin Hapus ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                        <button type="button" id="remove<?php echo $t['id_pesanan'] ?>" class="btn btn-primary" data-id="<?php echo $this->encrypt_aspireone->encode($t['id_pesanan']) ?>" >Yakin</button>
                                    </div>
                                </div>
                            </div>
                     </div>

                    <script type="text/javascript">
                        $("#remove<?php echo $t['id_pesanan'] ?>").click(function() {
                            var id_pesanan = $("#remove<?php echo $t['id_pesanan'] ?>").attr("data-id");
                            $.ajax({
                                type: 'POST',
                                data: "id_pesanan="+id_pesanan,
                                url: "<?php echo site_url('pesanan/remove') ?>",
                                success:function(msg){
                                    if(msg == "true"){
                                        window.location.href = '<?php echo site_url("pesanan") ?>';
                                    }    
                                },
                                error:function(){
                                    window.location.href = "<?php echo site_url('pesanan') ?>";
                                }
                            });
                        });
                        </script>
                    <?php $no++; ?>
                    <?php } ?>
                </table>
             <?php echo $this->pagination->create_links(); ?>                    
            </div>
        </div>
    </div>
</div>
