<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Paket Listing</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('paket/paket_admin_add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
                <br/><br/>
                <?php echo form_open('paket/paket_admin') ?>
                <div class="col-md-2">
                    <select name="berdasarkan" class="form-control" required>
                        <option value="">Cari Berdasarkan</option>
                        <?php 
							$berdasarkan_value = array(
								'id_konten'=>'ID Paket'
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
                    <a href="<?php echo site_url('paket/paket_admin') ?>" class="btn btn-info">Tampilkan Semua</a>
                </div>
                <?php echo form_close() ?>
                <br/><br/>
            <?php echo $this->session->flashdata('notif_input') ?>
                <table class="table table-striped">
                    <tr>
                        <th>No</th>
						<th>ID Konten</th>
						<th>Tipe</th>
						<th>ID Vendor</th>
						<th>Nama Konten</th>
						<th>Harga</th>
						<th>Actions</th>
                    </tr>
                    <?php
                        if(!$paket){
                            echo '<tr><td>Paket tidak ditemukan.</td></tr>';
                        }
                    ?>
                    <?php $no = 1 + $offset; ?>
                    <?php foreach($paket as $t){ ?>
                    <tr>
                        <td><?php echo $no ?></td>
						<td><?php echo htmlentities($t['id_konten']); ?></td>
						<td><?php echo $this->ekstra->tipe_paket($t['tipe']); ?></td>
						<td><a href="<?php echo site_url('vendor/edit/?q='.urlencode($this->encrypt_aspireone->encode($t['id_user']))) ?>" target="_blank" ><?php echo $t['id_vendor']; ?> - <?php echo $t['nama_vendor']; ?></a></td>
						<td><?php echo $t['nama_konten']; ?></td>
						<td>Rp <?php echo number_format($t['harga']); ?></td>
						<td>
                            <a href="<?php echo site_url('paket/paket_admin_edit/?q='.urlencode($this->encrypt_aspireone->encode($t['id_konten']))); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                            <a href="#" id="modal-remove" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".remove<?php echo $t['id_konten'] ?>" ><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>
                    <!-- Modal Remove -->
                    <div class="modal fade remove<?php echo $t['id_konten'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Anda Yakin Hapus ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                        <button type="button" id="remove<?php echo $t['id_konten'] ?>" class="btn btn-primary" data-id="<?php echo $this->encrypt_aspireone->encode($t['id_konten']) ?>" >Yakin</button>
                                    </div>
                                </div>
                            </div>
                     </div>

                    <script type="text/javascript">
                        $("#remove<?php echo $t['id_konten'] ?>").click(function() {
                            var id_konten = $("#remove<?php echo $t['id_konten'] ?>").attr("data-id");
                            $.ajax({
                                type: 'POST',
                                data: "id_konten="+id_konten,
                                url: "<?php echo site_url('paket/remove') ?>",
                                success:function(msg){
                                    if(msg == "true"){
                                        window.location.href = '<?php echo site_url("paket/paket_admin") ?>';
                                    }    
                                },
                                error:function(){
                                    window.location.href = "<?php echo site_url('paket/paket_admin') ?>";
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
