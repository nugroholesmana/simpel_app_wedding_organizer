<style>
.login-card{
    max-width:600px;
}
</style>
<div class="row login-body">
    <div class="col-md-12">
        <div>
            <div class="col-md-12">
                <div class="login-card">
                    <h3>Formulir Pendaftaran</h3>
                    <p class="profile-name-card"><?php echo validation_errors(); ?> </p>
                    <?php echo form_open('pelanggan/pendaftaran') ?><span class="reauth-email"> </span>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" required placeholder="Username" name="username" class="form-control" id="username" maxlength="32" value="<?php echo $this->input->post('username') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" required placeholder="Email" name="email" class="form-control" id="email" maxlength="80" value="<?php echo $this->input->post('email') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" required placeholder="Password" class="form-control" name="password" id="password" maxlength="32" />
                    </div>
                    <div class="form-group">
                        <label for="conpassword">Konfirmasi Password</label>
                        <input type="password" required placeholder="Konfirmasi Password" class="form-control" name="conpassword" id="conpassword" maxlength="32" />
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" required placeholder="Nama Lengkap" name="nama_pelanggan" class="form-control" id="nama" maxlength="50" value="<?php echo $this->input->post('nama_pelanggan') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" required placeholder="Tanggal Lahir" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker" value="<?php echo $this->input->post('tgl_lahir') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="jns_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jns_kelamin" name="jenis_kelamin">
                            <?php 
								$jenis_kelamin_values = array(
									'Pria'=>'Pria',
									'Wanita'=>'Wanita'	
								);

								foreach($jenis_kelamin_values as $value => $display_text)
								{
									$selected = ($value == $this->input->post('jenis_kelamin')) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="text" required placeholder="No Telpon" class="form-control" name="no_telpon" id="no_telp" maxlength="15" value="<?php echo $this->input->post('no_telpon') ?>" />
                    </div>  
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control"><?php echo $this->input->post('alamat') ?></textarea>
                    </div>   
                        <button class="btn btn-primary btn-block btn-lg btn-signin" type="submit">Daftar</button>
                    <?php echo form_close() ?><a href="<?php echo site_url('pelanggan/login') ?>" style="color:#000000">Sudah punya akun ?</a></div>
            </div>
        </div>
    </div>
</div>