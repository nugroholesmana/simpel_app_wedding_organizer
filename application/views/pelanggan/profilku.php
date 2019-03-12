<style>
.page-header, label{
    color:#3a3a3a;
}
</style>
<?php echo form_open('pelanggan/update_profil') ?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <div class="page-header">
        <h3>Profil Akun</h3>
    </div>
    <?php echo $this->session->flashdata('notif_input'); ?>
    <div class="form-group">
        <label for="nama_pelanggan" class="control-label">Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" value="<?php echo ($this->input->post('nama_pelanggan') ? $this->input->post('nama_pelanggan') : $pelanggan['nama_pelanggan']); ?>" class="form-control" id="nama_pelanggan" />
        <span class="text-danger"><?php echo form_error('nama_pelanggan');?></span>
    </div>
    <div class="form-group">
        <label for="jenis_kelamin" class="control-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <?php 
								$jenis_kelamin_values = array(
									'Pria'=>'Pria',
									'Wanita'=>'Wanita'	
								);

								foreach($jenis_kelamin_values as $value => $display_text)
								{
									$selected = ($value == $pelanggan['jenis_kelamin']) ? ' selected="selected"' : $this->input->post('jenis_kelamin');

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
                </select>
    </div>
    <div class="form-group">
        <label for="no_telepon" class="control-label">Nomor Telepon</label>
        <input type="text" name="no_telepon" value="<?php echo ($this->input->post('no_telpon') ? $this->input->post('no_telpon') : $pelanggan['no_telpon']); ?>" class="form-control" id="no_telepon" />
        <span class="text-danger"><?php echo form_error('no_telepon');?></span>
    </div>
    <div class="form-group">
        <label for="tgl_lahir" class="control-label">Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" value="<?php echo ($this->input->post('tgl_lahir') ? $this->input->post('tgl_lahir') : $pelanggan['tgl_lahir']); ?>" class="has-datepicker form-control" id="tgl_lahir" />
        <span class="text-danger"><?php echo form_error('tgl_lahir');?></span>
    </div>
    <div class="form-group">
        <label for="alamat" class="control-label">Alamat</label>
        <input type="text" name="alamat" value="<?php echo ($this->input->post('alamat') ? $this->input->post('alamat') : $pelanggan['alamat']); ?>" class="form-control" id="alamat" />
        <span class="text-danger"><?php echo form_error('alamat');?></span>
    </div>
    <div class="page-header">
        <h3>Informasi Akun</h3>
    </div>
    <div class="form-group">
        <label for="username" class="control-label">Username</label>
        <input type="text" name="username" value="<?php echo $pelanggan['username']; ?>" class="form-control" id="username" disabled />
        <span class="text-danger"><?php echo form_error('username');?></span>
    </div>
    <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $pelanggan['email']); ?>" class="form-control" id="email" required />
        <span class="text-danger"><?php echo form_error('email');?></span>
    </div>
    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" name="password" value="<?php echo $this->input->post('password'); ?>" placeholder="Kosongkan jika tidak merubah password" class="form-control" id="password" />
        <span class="text-danger"><?php echo form_error('password');?></span>
    </div>
    <div class="form-group">
        <label for="conpassword" class="control-label">Konfirmasi Password</label>
        <input type="password" name="conpassword" value="<?php echo $this->input->post('conpassword'); ?>" class="form-control" id="conpassword" />
        <span class="text-danger"><?php echo form_error('conpassword');?></span>
    </div>

    <input type="submit" class="btn btn-primary" value="Simpan Perubahan">
</div>
<?php echo form_close() ?> 