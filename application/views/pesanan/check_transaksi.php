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
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Informasi Pemesanan</th>
                    </tr>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>:</td>
                        <td><?php echo $nama_pelanggan ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Tamu</td>
                        <td>:</td>
                        <td><?php echo $jumlah_tamu ?></td>
                    </tr>
                    <tr>
                        <td>Vendor</td>
                        <td>:</td>
                        <td><?php echo $nama_vendor ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Resepsi</td>
                        <td>:</td>
                        <td><?php echo $tgl_resepsi ?></td>
                    </tr>
                </table>

                <a href="<?php echo site_url('pesanan/add') ?>" class="btn btn-large btn-info">Back</a>
                                
            </div>
        </div>
    </div>
</div>
