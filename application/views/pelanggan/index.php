<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Pelanggan Listing</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('pelanggan/add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
            <a href="<?php echo site_url('laporan/laporan_pelanggan') ?>" class="btn btn-default" target="_blank"><span class="fa fa-print"></span> Print PDF</a>
                <br/><br/>
                <?php echo form_open('pelanggan/index') ?>
                <div class="col-md-2">
                    <select name="berdasarkan" class="form-control" required>
                        <option value="">Cari Berdasarkan</option>
                        <?php 
							$berdasarkan_value = array(
								'id_pelanggan'=>'ID Pelanggan',
                                'email'=>'Email',
                                'nama_pelanggan'=>'Nama Pelanggan'
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
                    <a href="<?php echo site_url('pelanggan') ?>" class="btn btn-info">Tampilkan Semua</a>
                </div>
                <?php echo form_close() ?>
                <br/><br/>
                <?php echo $this->session->flashdata('notif_input') ?>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No</th>
						<th>ID Pelanggan</th>
						<th>Nama Pelanggan</th>
						<th>No Telpon</th>
						<th>Email</th>
						<th>Actions</th>
                    </tr>
                    <?php 
                        if(!$pelanggan){
                            echo '<td colspan="5">Pelanggan tidak ditemukan</td>';
                        }else
                    ?>
                    <?php $no = 1 + $offset; ?>
                    <?php foreach($pelanggan as $t){ ?>
                    <tr>
                        <td><?php echo $no ?></td>
						<td><?php echo $t['id_pelanggan']; ?></td>
						<td><?php echo $t['nama_pelanggan']; ?></td>
						<td>0<?php echo $t['no_telpon']; ?></td>
						<td><?php echo $t['email']; ?></td>
						<td>
                            <a href="<?php echo site_url('pelanggan/edit/?q='.urlencode($this->encrypt_aspireone->encode($t['id_user']))); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                            <a href="#" id="modal-remove" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".remove<?php echo $t['id_pelanggan'] ?>" ><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Remove -->
                    <div class="modal fade remove<?php echo $t['id_pelanggan'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Anda Yakin Hapus ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                        <button type="button" id="remove<?php echo $t['id_user'] ?>" class="btn btn-primary" data-id="<?php echo $this->encrypt_aspireone->encode($t['id_user']) ?>" >Yakin</button>
                                    </div>
                                </div>
                            </div>
                     </div>

                    <script type="text/javascript">
                        $("#remove<?php echo $t['id_user'] ?>").click(function() {
                            var id_user = $("#remove<?php echo $t['id_user'] ?>").attr("data-id");
                            $.ajax({
                                type: 'POST',
                                data: "id_user="+id_user,
                                url: "<?php echo site_url('pelanggan/remove') ?>",
                                success:function(msg){
                                    if(msg == "true"){
                                        window.location.href = '<?php echo site_url("pelanggan") ?>';
                                    }    
                                },
                                error:function(){
                                    window.location.href = "<?php echo site_url('pelanggan') ?>";
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
