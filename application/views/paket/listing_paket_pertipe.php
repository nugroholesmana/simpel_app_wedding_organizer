<?php foreach($paket as $t){ ?> 
        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
           <div class="panel panel-default">
               <div class="panel-body">
                   <img src="<?php echo base_url('files/konten/'.$t['foto']) ?>" class="img img-responsive"/>
               </div>
               <div class="panel-footer info-link">
                   <b><a href="<?php echo site_url('paket/menu_paket/'.$t['id_vendor']) ?>"><?php echo $t['nama_vendor'] ?> - <?php echo $t['nama_konten'] ?></a></b>
               </div>
            </div>
        </div>
<?php } ?>
<div class="clearfix">
    <?php echo $this->pagination->create_links(); ?>  
</div>