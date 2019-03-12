
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Galeri Fotografi Listing</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('galeri/galeri_admin_add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
            <?php echo $this->session->flashdata('notif_input') ?>    
            <div class="row clearfix">
            </div>     
            <?php
                if(!$galeri){
                    echo 'Galeri Masih Kosong';
                }
            ?> 
            <?php foreach($galeri as $t){ ?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo $t['nama_vendor'] ?>
                    </div>
                    <div class="panel-body" style="height:200px">
                        <center><img src="<?php echo base_url('files/galeri/'.$t['gambar']) ?>" width="100%" height="165px"/></center>
                    </div>
                    <div class="panel-footer">
                        <a href="#" id="modal-remove" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".remove<?php echo $t['id_galeri'] ?>"><span class="fa fa-trash"></span> Delete</a>
                    </div>
                </div>
            </div>
                <!-- Modal Remove -->
                    <div class="modal fade remove<?php echo $t['id_galeri'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Anda Yakin Hapus ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                        <button type="button" id="remove<?php echo $t['id_galeri'] ?>" class="btn btn-primary" data-id="<?php echo $this->encrypt_aspireone->encode($t['id_galeri']) ?>" >Yakin</button>
                                    </div>
                                </div>
                            </div>
                     </div>

                    <script type="text/javascript">
                        $("#remove<?php echo $t['id_galeri'] ?>").click(function() {
                            var id_galeri = $("#remove<?php echo $t['id_galeri'] ?>").attr("data-id");
                            $.ajax({
                                type: 'POST',
                                data: "id_galeri="+id_galeri,
                                url: "<?php echo site_url('galeri/remove') ?>",
                                success:function(msg){
                                    if(msg == "true"){
                                        window.location.href = '<?php echo site_url("galeri/galeri_admin") ?>';
                                    }    
                                },
                                error:function(){
                                    window.location.href = "<?php echo site_url('galeri/galeri_admin') ?>";
                                }
                            });
                        });
                        </script>
               <?php } ?>  
               <div class="row clearfix"></div>  
               <?php echo $this->pagination->create_links(); ?>                           
            </div>
        </div>
    </div>
</div>
