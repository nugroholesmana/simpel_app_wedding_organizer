<div class="row login-body">
    <div class="col-md-12">
        <div>
            <div class="col-lg-7 col-md-7 hidden-xs hidden-sm">                
                <h1 style="text-indent:50px">Selamat Datang</h1>
                <ul>
                    <li><h3>Terdiri dari beberapa vendor</h3></li>
                    <li><h3>Memilih paket dan melakukan pemesanan lebih mudah</h3></li>
                </ul>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="login-card">
                    <h3>Silahkan Login</h3>
                    <?php echo $this->session->flashdata('notif_input') ?>
                    <p class="profile-name-card"> </p>
                    <?php
                        $paramater = array('class'=>'form-signin');
                        echo form_open('pelanggan/login', $paramater);
                    ?>
                        <span class="reauth-email"> </span>
                        <input type="text" required placeholder="Username" name="username" autofocus class="form-control" id="inputEmail" />
                        <input type="password" required placeholder="Password" name="password" class="form-control" id="inputPassword" />
                        
                        <button class="btn btn-primary btn-block btn-lg btn-signin" type="submit">Sign in</button>
                    <?php echo form_close() ?>
                    <a href="<?php echo site_url('pelanggan/pendaftaran') ?>" style="color:#000000">Belum punya akun ?</a></div>
            </div>
        </div>
    </div>
</div>