<style>
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px;
    text-align: center;
}
</style>

<?php foreach($get_all_galeri as $r){ ?>
<div class="col-lg-2 col-md-2 col-xs-6 col-sm-6">
    <div class="gallery">
        <a target="_blank" href="<?php echo base_url('files/galeri/'.$r['gambar']) ?>">
            <img src="<?php echo base_url('files/galeri/'.$r['gambar']) ?>" alt="Trolltunga Norway" width="300" height="200">
        </a>
        <div class="desc"><?php echo htmlentities($r['nama_vendor']) ?></div>
    </div>
</div>

<?php } ?>
<div class="clearfix">
    <?php echo $this->pagination->create_links(); ?>  
</div>