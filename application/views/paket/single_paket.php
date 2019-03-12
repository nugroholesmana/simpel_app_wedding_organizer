<?php
foreach($g_paket as $r_paket){
    $foto[] = $r_paket['foto'];
}
?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
           <div class="carousel slide" data-ride="carousel" id="carousel-1">
                <div class="carousel-inner" role="listbox">
                    <div class="item active"><img src="<?php echo base_url('files/konten/'.$foto[0]) ?>" alt="Slide Image" /></div>
                    <?php for($i=1; $i < count($foto); $i++){ ?>
                    <div class="item"><img src="<?php echo base_url('files/konten/'.$foto[$i]) ?>" alt="Slide Image" /></div>
                    <?php } ?>
                </div>
                <ol class="carousel-indicators">
                    <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-1" data-slide-to="1"></li>
                    <li data-target="#carousel-1" data-slide-to="2"></li>
                </ol>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Informasi</a></li>
                <li><a href="#tab-2" role="tab" data-toggle="tab">Vendor</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <table class="table table-bordered">
                        <tr>
                            <td>Tipe Paket</td>
                            <td>Nama Konten</td>
                            <td>Harga Paket</td>
                        </tr>
                        <?php foreach($g_paket as $r_paket){ ?>
                        <tr>
                            <td>
                                <?php
                                    if($r_paket['tipe'] == 1){
                                        echo 'Paket Utama';
                                    }elseif($r_paket['tipe'] == 2){
                                        echo 'Catering';
                                    }elseif($r_paket['tipe'] == 3){
                                        echo 'Ekstra';
                                    }
                                ?>
                            </td>
                            <td><?php echo htmlentities($r_paket['nama_konten']) ?></td>
                            <td>Rp <?php echo number_format($r_paket['harga']) ?></td>
                        </tr>
                        <?php $keterangan[] = $r_paket['keterangan']; ?>
                        <?php } ?>
                    </table>
                    <a href="<?php echo site_url('pesanan/pesan_sekarang/'.$r_paket['id_vendor']) ?>" class="btn btn-default">Pesan Paket</a>
                    <?php echo $this->session->flashdata('notif_input'); ?>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama Vendor</td>
                            <td><?php echo htmlentities($g_vendor['nama_vendor']) ?></td>
                        </tr>
                        <tr>
                            <td>Telpon</td>
                            <td><?php echo htmlentities($g_vendor['no_telp_vendor']) ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><?php echo htmlentities($g_vendor['alamat']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row clearfix"></div>  
        <div class="col-md-12">
            <div class="keterangan-produk">
                <h4>Keterangan</h4>
                <hr/>
                <?php if($keterangan[0] != ""){ ?>
                <div class="col-md-4 col-sm-12">
                    <p><b>Paket Utama</b></p>
                    <?php echo $keterangan[0] ?>
                </div>
                <?php } ?>
                <?php if(count($keterangan) > 1){ ?>
                    <?php if($keterangan[1] != ""){ ?>
                    <div class="col-md-4 col-sm-12">
                        <p><b>Catering</b></p>
                        <?php echo $keterangan[1] ?>
                    </div>
                    <?php } ?>
                <?php }else{ ?>
                <div class="col-md-4 col-sm-12">
                        <p><b>Fotografi</b></p>
                        <p>Tidak Tersedia.</p>
                    </div>
                <?php } ?>
                <?php if(count($keterangan) > 2){ ?>
                    <?php if($keterangan[2] != ""){ ?>
                    <div class="col-md-4 col-sm-12">
                        <p><b>Ekstra</b></p>
                        <?php echo $keterangan[2] ?>
                    </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="col-md-4 col-sm-12">
                        <p><b>Fotografi</b></p>
                        <p>Tidak Tersedia.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
<script>
    $('.carousel').carousel();  
</script>