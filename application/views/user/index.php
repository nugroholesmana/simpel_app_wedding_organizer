<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List User</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('user/add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
                <a href="<?php echo site_url('laporan/laporan_user') ?>" class="btn btn-default" target="_blank"><span class="fa fa-print"></span> Print PDF</a>
                <br/><br/>
                <?php echo form_open('user/index') ?>
                <div class="col-md-2">
                    <select name="berdasarkan" class="form-control" required>
                        <option value="">Cari Berdasarkan</option>
                        <?php 
							$berdasarkan_value = array(
								'id_user'=>'ID User',
                                'email'=>'Email',
                                'username'=>'Username'
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
                    <a href="<?php echo site_url('user') ?>" class="btn btn-info">Tampilkan Semua</a>
                </div>
                <?php echo form_close() ?>
                <br/><br/>
                <?php echo $this->session->flashdata('notif_input') ?>
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
						<th>ID User</th>
						<th>Username</th>
						<th>Email</th>
						<th>Hak Akses</th>
                        <th>Status Akun</th>
						<th>Actions</th>
                    </tr>
                </thead>
                    <?php 
                        if(!$user){
                            echo '<td colspan="6">Pelanggan tidak ditemukan.</td>';
                        }else
                    ?>
                <tbody>
                    <?php $no = 1 + $offset; ?>
                    <?php foreach($user as $t){ ?>
                    <tr>
                        <td><?php echo $no ?></td>
						<td><?php echo $t['id_user']; ?></td>
						<td><?php echo $t['username']; ?></td>
						<td><?php echo $t['email']; ?></td>
						<td>
                            <?php 
                                if($t['hak_akses'] == 'admin'){
                                    echo 'Admin';
                                }elseif($t['hak_akses'] == 'admin_wo'){
                                    echo 'Admin WO';
                                }elseif($t['hak_akses'] == 'pelanggan'){
                                    echo 'Pelanggan';
                                }                                
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($t['aktif'] == '1'){
                                    echo '<span class="text-success">Aktif</span>';
                                }elseif($t['aktif'] == '0'){
                                    echo '<span class="text-danger">Tidak Aktif</span>';
                                }                                
                            ?>
                        </td>
						<td>    
                            <a href="<?php echo site_url('user/edit/?q='.urlencode($this->encrypt_aspireone->encode($t['id_user']))); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                            <a href="#" id="modal-remove" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".remove<?php echo $t['id_user'] ?>" ><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>
                   </tbody> 
                    <!-- Modal Remove -->
                    <div class="modal fade remove<?php echo $t['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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
                                url: "<?php echo site_url('user/remove') ?>",
                                success:function(msg){
                                    if(msg == "true"){
                                        window.location.href = '<?php echo site_url("user") ?>';
                                    }     
                                },
                                error:function(){
                                    window.location.href = "<?php echo site_url('user') ?>";
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