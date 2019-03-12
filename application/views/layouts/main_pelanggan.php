<?php 
$this->load->library('Encrypt_aspireone');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal WO</title>
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/fonts/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/css/styles.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/css/Bootstrap-Payment-Form.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/css/Google-Style-Login.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/css/style-login.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/css/Pretty-Header.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resources/pelanggan/assets/css/Pretty-Footer.css') ?>">

</head>

<body>
    <nav class="navbar navbar-default custom-header">
    <div class="container-fluid">
        <div class="navbar-header"><a href="#" class="navbar-brand navbar-link">Portal Wedding <span>Pekanbaru </span> </a>
            <button data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <?php 
        if($this->session->userdata("logged_id")){ 
        ?>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav links hidden-xs hidden-sm" style="float:right">
                <li role="presentation"><a style="background-color:#000;">Welcome</a></li>
                <li role="presentation"><a href="<?php echo site_url('pelanggan/profilku') ?>">Profil </a></li>
                <li role="presentation"><a href="<?php echo site_url('pelanggan/act_logout_pelanggan') ?>">Logout </a></li>
                <!--<li role="presentation"><a href="#" class="custom-navbar"> Roles<span class="badge">new</span></a></li>-->
            </ul>
        </div>
        <?php }else{ 
        ?>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav links hidden-xs hidden-sm" style="float:right">
                <li role="presentation"><a style="background-color:#000;">Login Sebagai</a></li>
                <li role="presentation"><a href="<?php echo site_url('pelanggan/login') ?>">Pelanggan </a></li>
                <li role="presentation"><a href="<?php echo site_url('login/wo_admin') ?>">Vendor </a></li>
                <!--<li role="presentation"><a href="#" class="custom-navbar"> Roles<span class="badge">new</span></a></li>-->
            </ul>
            <ul class="nav navbar-nav links hidden-md hidden-lg" style="float:right">
                <li role="presentation"><a href="<?php echo site_url('beranda/index/1') ?>">Paket Utama </a></li>
                <li role="presentation"><a href="<?php echo site_url('beranda/index/2') ?>">Catering </a></li>
                <li role="presentation"><a href="<?php echo site_url('beranda/index/3') ?>">Ekstra </a></li>
                <li role="presentation"><a href="<?php echo site_url('galeri/') ?>">Gakeri Foto </a></li>
                <li role="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Login
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url('login/wo_admin') ?>">Vendor</a></li>
                    <li><a href="<?php echo site_url('pelanggan/login') ?>">Pelanggan</a></li>
                </ul>
                </li>
                <!--<li role="presentation"><a href="#" class="custom-navbar"> Roles<span class="badge">new</span></a></li>-->
            </ul>
            <!--
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a data-toggle="dropdown" aria-expanded="false" href="#" class="dropdown-toggle"> <span class="caret"></span><img src="assets/img/avatar.jpg" class="dropdown-image" /></a>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li role="presentation"><a href="#">Settings </a></li>
                        <li role="presentation"><a href="#">Payments </a></li>
                        <li role="presentation" class="active"><a href="#">Logout </a></li>
                    </ul>
                </li>
            </ul>
-->
        </div>
        <?php } ?>
    </div>
</nav>
    <div class="row">
    <div class="col-lg-3 col-md-3 hidden-xs hidden-sm">
        
        <?php 
        $hakakses = $this->session->userdata('hak_akses');
        if($hakakses){ 
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pesanan</h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?php echo site_url('pesanan/pesananku') ?>">List Pesanan</a></li>
                </ul>
            </div>
        </div>
        <?php } ?>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">DAFTAR PAKET</h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?php echo site_url('beranda/index/1') ?>">Paket Utama</a></li>
                    <li><a href="<?php echo site_url('beranda/index/2') ?>">Catering</a></li>
                    <li><a href="<?php echo site_url('beranda/index/3') ?>">Ekstra</a></li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Informasi</h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?php echo site_url('galeri/lihat_galeri') ?>">Galeri Fotografi</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
        <!-- content wrapper -->
        <?php                    
            if(isset($_view) && $_view)
            $this->load->view($_view);
        ?>

    </div>
</div>
    <footer>
    <div class="row">
        <div class="col-md-4 col-sm-6 footer-navigation">
            <h3>Portal Wedding Pekanbaru</h3>
            <p class="links"><a href="<?php echo site_url('beranda') ?>">Home</a><strong> · </strong><a href="#">About</a><strong> · </strong><a href="#">Faq</a><strong> · </strong><a href="#">Contact</a></p>
            <p class="company-name">Portal Wedding Pekanbaru © 2015 </p>
        </div>
        <div class="col-md-4 col-sm-6 footer-contacts">
            <div><span class="fa fa-map-marker footer-contacts-icon"> </span>
                <p><span class="new-line-span">21 Revolution Street</span> Paris, France</p>
            </div>
            <div><i class="fa fa-phone footer-contacts-icon"></i>
                <p class="footer-center-info email text-left"> +1 555 123456</p>
            </div>
            <div><i class="fa fa-envelope footer-contacts-icon"></i>
                <p> <a href="#" target="_blank">support@company.com</a></p>
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 footer-about">
            <h4>About the company</h4>
            <p> Lorem ipsum dolor sit amet, consectateur adispicing elit. Fusce euismod convallis velit, eu auctor lacus vehicula sit amet.
            </p>
            <div class="social-links social-icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-github"></i></a></div>
        </div>
    </div>
</footer>
    <script src="<?php echo base_url('resources/pelanggan/assets/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('resources/pelanggan/assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>

</html>