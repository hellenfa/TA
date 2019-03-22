<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo isset($title) ? $title . " - " : ""; ?>PIU</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,800,300&subset=latin"
          rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('/') ?>/assets/stylesheets/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('/') ?>/assets/dist/css/AdminLTE.min.css" rel="stylesheet">

    <!-- DEMO ONLY: Function for the proper stylesheet loading according to the demo settings -->
    <style type="text/css">
        #myModelDialog {
            z-index: 1100 !important; /*set to something other than 9999*/
        }

        .pace {
            -webkit-pointer-events: none;
            pointer-events: none;

            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .pace-inactive {
            display: none;
        }

        .pace .pace-progress {
            background: #d1311f;
            position: fixed;
            z-index: 2000;
            top: 0;
            right: 100%;
            width: 100%;
            height: 2px;
        }

        #toolbar {
            display: none !important;
        }
    </style>
    <script>function _pxDemo_loadStylesheet(a, b, c) {
            var c = c || decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-theme") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "default"),
                d = "1" === decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-rtl") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "0");
            document.write(a.replace(/^(.*?)((?:\.min)?\.css)$/, '<link href="$1' + (c.indexOf("dark") !== -1 && a.indexOf("/css/") !== -1 && a.indexOf("/themes/") === -1 ? "-dark" : "") + (d && a.indexOf("assets/") === -1 ? ".rtl" : "") + '$2" rel="stylesheet" type="text/css"' + (b ? 'class="' + b + '"' : "") + ">"))
        }</script>

    <script>"1" === decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-rtl") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "0") && document.getElementsByTagName("html")[0].setAttribute("dir", "rtl");</script>

    <script>
        _pxDemo_loadStylesheet('<?php echo base_url('/') ?>assets/dist/css/bootstrap.css', 'px-demo-stylesheet-core');
        _pxDemo_loadStylesheet('<?php echo base_url('/') ?>assets/dist/css/pixeladmin.css', 'px-demo-stylesheet-bs');
        _pxDemo_loadStylesheet('<?php echo base_url('/') ?>assets/dist/css/widgets.css', 'px-demo-stylesheet-widgets');
    </script>
    <script>
        function _pxDemo_loadTheme(a) {
            var b = decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-theme") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "default");
            _pxDemo_loadStylesheet(a + b + ".min.css", "px-demo-stylesheet-theme", b)
        }

        _pxDemo_loadTheme('<?php echo base_url('/') ?>assets/dist/css/themes/');
    </script>
    <script>_pxDemo_loadStylesheet('<?php echo base_url('/') ?>assets/dist/demo/demo.css');</script>
    <script src="<?php echo base_url('/') ?>assets/dist/demo/demo.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.0/holder.js"></script>
</head>
<body>

<script>var pxInit = [];</script>

<nav class="px-nav px-nav-left" id="px-demo-nav">
    <button type="button" class="px-nav-toggle" data-toggle="px-nav">
        <span class="px-nav-toggle-arrow"></span>
        <span class="navbar-toggle-icon"></span>
        <span class="px-nav-toggle-label font-size-11">HIDE MENU</span>
    </button>

    <ul class="px-nav-content">
        <li class="px-nav-box p-a-3 b-b-1" id="demo-px-nav-box">
            <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <img src="<?php echo base_url('profile_picture/') . $this->ion_auth->user()->row()->profile_picture; ?>"
                 onerror="this.src='<?php echo base_url(); ?>assets/images/user.jpg'" alt=""
                 class="pull-xs-left m-r-2 border-round"
                 style="width: 54px; height: 54px;">
            <div class="font-size-16"><span
                        class="font-weight-light"></span><strong><?php echo $this->ion_auth->user()->row()->username ?></strong><br>PIU
            </div>
        </li>

        <?php echo nav_menu('Dashboard', 'dashboard', isset($dashboard) ? $dashboard : '', 'fa-dashboard') ?>

        <!-- ADMIN -->
        <?php if ($this->ion_auth->user()->row()->type == 'admin') { ?>
            <?php echo nav_menu('Pengguna', 'user', isset($user) ? $user : '', 'fa-group') ?>
            <?php echo nav_menu('Documentation', 'dokumentasi', isset($dokumentasi) ? $dokumentasi : '', 'fa-folder', array(
                array('nama' => 'Document', 'uri' => 'dokumentasi', 'active' => isset($dokumentasi) ? $dokumentasi : '', 'icon' => 'fa-folder'),
                array('nama' => 'Recycle Bin', 'uri' => 'recycle_bin', 'active' => isset($recycle_bin) ? $recycle_bin : '', 'icon' => 'fa-bin'),
            )) ?>
            <?php echo nav_menu('Progress Report', 'progress_report', isset($progress_report) ? $progress_report : '', 'fa-book', array(
                array('nama' => 'Activity', 'uri' => 'progress_report', 'active' => isset($progress_report) ? $progress_report : '', 'icon' => 'fa-book'),
                array('nama' => 'Auction', 'uri' => 'progress_report/jenis_lelang', 'active' => isset($jenis_lelang) ? $jenis_lelang : '', 'icon' => 'fa-book'),
                array('nama' => 'Recycle Bin', 'uri' => 'recycle_bin/recycle_bin_progress_report', 'active' => isset($recycle_bin_progress_report) ? $recycle_bin_progress_report : '', 'icon' => 'fa-bin'),
            )) ?>
            <?php echo nav_menu('Logbook', 'logbook', isset($logbook) ? $logbook : '', 'fa-clipboard', array(
                    array('nama' => 'Logbook', 'uri' => 'logbook', 'active' => isset($logbook) ? $logbook : '', 'icon' => 'fa-clipboard'),
                    array('nama' => 'Dibagikan dengan Saya', 'uri' => 'logbook/bagikan_dengan_saya', 'active' => isset($bagikan_dengan_saya) ? $bagikan_dengan_saya : '', 'icon' => 'fa-clipboard'),
                    array('nama' => 'Dibagikan dengan yang Lain', 'uri' => 'logbook/bagikan_dengan_yang_lain', 'active' => isset($bagikan_dengan_yang_lain) ? $bagikan_dengan_yang_lain : '', 'icon' => 'fa-clipboard'),
            )) ?>
        <?php } ?>

        <!-- STAFF PIU -->
        <?php if ($this->ion_auth->user()->row()->type == 'pegawai') { ?>
            <?php echo nav_menu('Documentation', 'dokumentasi', isset($dokumentasi) ? $dokumentasi : '', 'fa-folder', array(
                array('nama' => 'Document', 'uri' => 'dokumentasi', 'active' => isset($dokumentasi) ? $dokumentasi : '', 'icon' => 'fa-folder'),
                array('nama' => 'Recycle Bin', 'uri' => 'recycle_bin', 'active' => isset($recycle_bin) ? $recycle_bin : '', 'icon' => 'fa-bin'),
            )) ?>
            <?php echo nav_menu('Progress Report', 'progress_report', isset($progress_report) ? $progress_report : '', 'fa-book')?>
            <?php echo nav_menu('Logbook', 'logbook', isset($logbook) ? $logbook : '', 'fa-clipboard', array(
                    array('nama' => 'Logbook', 'uri' => 'logbook', 'active' => isset($logbook) ? $logbook : '', 'icon' => 'fa-clipboard'),
                    array('nama' => 'Dibagikan dengan Saya', 'uri' => 'logbook/bagikan_dengan_saya', 'active' => isset($bagikan_dengan_saya) ? $bagikan_dengan_saya : '', 'icon' => 'fa-clipboard'),
                    array('nama' => 'Dibagikan dengan yang Lain', 'uri' => 'logbook/bagikan_dengan_yang_lain', 'active' => isset($bagikan_dengan_yang_lain) ? $bagikan_dengan_yang_lain : '', 'icon' => 'fa-clipboard'),
            )) ?>
        <?php } ?>

        <!-- FAKULTAS -->
        <?php if ($this->ion_auth->user()->row()->type == 'pegawai fakultas') { ?>
          <li class="px-nav-item px-nav-dropdown">
        	<a href="https://localhost/piu_project/public/evaluation">
        		<i class="fa fa-folder"></i> <span> &nbsp;Academic Evaluation</span>
        	</a>
        	<ul class="px-nav-dropdown-menu">
        		<li class="px-nav-item px-nav-dropdown">
        			<a href="https://localhost/piu_project/public/documentasi">
        				<i class="fa fa-folder"></i> <span> &nbsp;Relevance</span>
        			</a>
        			<ul class="px-nav-dropdown-menu">
        				<li class="px-nav-item">
        					<a href="https://localhost/piu_project/public/evaluation">
        						<i class="fa fa-circle-o"></i> &nbsp;1.1
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/evaluation">
        						<i class="fa fa-circle-o"></i> &nbsp;1.2
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/evaluation">
        						<i class="fa fa-circle-o"></i> &nbsp;1.3
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/evaluation">
        						<i class="fa fa-circle-o"></i> &nbsp;1.4
        					</a>
        				</li>
        			</ul>
        		</li>

            <li class="px-nav-item px-nav-dropdown">
              <a href="https://localhost/piu_project/public/evaluation">
                <i class="fa fa-folder"></i> <span> &nbsp;Academic Innovation</span>
              </a>
              <ul class="px-nav-dropdown-menu">
                <li class="px-nav-item">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;2.1
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;2.2
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;2.3
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;2.4
        					</a>
        				</li>
              </ul>
            </li>

            <li class="px-nav-item px-nav-dropdown">
              <a href="https://localhost/piu_project/public/evaluation">
                <i class="fa fa-folder"></i> <span> &nbsp;Impact</span>
              </a>
              <ul class="px-nav-dropdown-menu">
                <li class="px-nav-item">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.1
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.2
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.3
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.4
        					</a>
        				</li><li class="px-nav-item">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.5
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.6
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.7
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.8
        					</a>
        				</li><li class="px-nav-item">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.9
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.10
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.11
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;3.12
        					</a>
        				</li>
              </ul>
            </li>

            <li class="px-nav-item px-nav-dropdown">
              <a href="https://localhost/piu_project/public/dokumentasi">
                <i class="fa fa-folder"></i> <span> &nbsp;Sustainability</span>
              </a>
              <ul class="px-nav-dropdown-menu">
                <li class="px-nav-item">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;4.1
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;4.2
        					</a>
        				</li>
        				<li class="px-nav-item ">
        					<a href="https://localhost/piu_project/public/dokumentasi">
        						<i class="fa fa-circle-o"></i> &nbsp;4.3
        					</a>
        				</li>
              </ul>
            </li>

            <li class="px-nav-item px-nav-dropdown">
              <a href="https://localhost/piu_project/public/dokumentasi">
                <i class="fa fa-folder"></i> <span> &nbsp;Effectiveness</span>
              </a>
              <ul class="px-nav-dropdown-menu">
                <li class="px-nav-item">
                  <a href="https://localhost/piu_project/public/dokumentasi">
                    <i class="fa fa-circle-o"></i> &nbsp;5.1
                  </a>
                </li>
                <li class="px-nav-item ">
                  <a href="https://localhost/piu_project/public/dokumentasi">
                    <i class="fa fa-circle-o"></i> &nbsp;5.2
                  </a>
                </li>
              </ul>
            </li>

            <li class="px-nav-item px-nav-dropdown">
              <a href="https://localhost/piu_project/public/dokumentasi">
                <i class="fa fa-folder"></i> <span> &nbsp;Readiness</span>
              </a>
              <ul class="px-nav-dropdown-menu">
                <li class="px-nav-item">
                  <li class="px-nav-item">
          					<a href="https://localhost/piu_project/public/dokumentasi">
          						<i class="fa fa-circle-o"></i> &nbsp;6.1
          					</a>
          				</li>
          				<li class="px-nav-item ">
          					<a href="https://localhost/piu_project/public/dokumentasi">
          						<i class="fa fa-circle-o"></i> &nbsp;6.2
          					</a>
          				</li>
          				<li class="px-nav-item ">
          					<a href="https://localhost/piu_project/public/dokumentasi">
          						<i class="fa fa-circle-o"></i> &nbsp;6.3
          					</a>
          				</li>
              </ul>
            </li>

        	</ul>
        </li>

        <?php } ?>



        <li class="px-nav-box b-t-1 p-a-2">
            <a href="<?php echo base_url('auth/logout') ?>" class="btn btn-danger btn-block btn-outline">Sign Out</a>
        </li>
    </ul>
</nav>

<nav class="navbar px-navbar">
    <div class="navbar-header">
        <a class="navbar-brand px-demo-brand" href="<?php echo base_url('/') ?>"><span
                    class="px-demo-logo bg-primary"><span
                        class="px-demo-logo-1"></span><span class="px-demo-logo-2"></span><span
                        class="px-demo-logo-3"></span><span class="px-demo-logo-4"></span><span
                        class="px-demo-logo-5"></span><span class="px-demo-logo-6"></span><span
                        class="px-demo-logo-7"></span><span class="px-demo-logo-8"></span><span
                        class="px-demo-logo-9"></span></span><strong>PIU</strong></a>
    </div>

    <!-- Navbar togglers -->
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#px-demo-navbar-collapse"
            aria-expanded="false"><i class="navbar-toggle-icon"></i></button>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="px-demo-navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <img src="<?php echo base_url('profile_picture/') . $this->ion_auth->user()->row()->profile_picture; ?>"
                         onerror="this.src='<?php echo base_url(); ?>assets/images/user.jpg'" alt=""
                         class="px-navbar-image">
                    <span class="hidden-md"><?php echo $this->ion_auth->user()->row()->first_name ?></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url('auth/edit_user/') . $this->ion_auth->row()->id; ?>"><i
                                    class="dropdown-icon fa fa-user"></i>&nbsp; Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('auth/logout') ?>"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log
                            Out</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>

<div class="px-content">
    <div class="page-header">
        <h1><?php if (isset($title)) {
                echo $title;
            } ?></h1>
    </div>

    <?php $this->load->view($content_view); ?>
</div>


<footer class="px-footer px-footer-bottom p-t-0" id="px-demo-footer">
    <hr class="page-wide-block">
    <span class="text-muted">Copyright © <?php echo date('Y') ?> Universitas Gadjah Mada. All rights reserved.</span>
</footer>
<div class="modal fade" id="myModelDialog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!-- Initialize demo sidebar on page load -->
<script>
    pxDemo.initializeDemoSidebar();

    pxInit.push(function () {
        $('#px-demo-sidebar').pxSidebar();
        pxDemo.initializeDemo();
    });
</script>

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js">' + "<" + "/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">' + "<" + "/script>"); </script>
<![endif]-->


<script src="<?php echo base_url('/') ?>assets/dist/js/bootstrap.js"></script>
<script src="<?php echo base_url('/') ?>assets/dist/js/pixeladmin.js"></script>
<script src="<?php echo base_url('/'); ?>assets/admin_lte/plugins/pace/pace.min.js"></script>
<script src="<?php echo base_url('/'); ?>assets/js/dialog.js" type="text/javascript"></script>
<script src="<?php echo base_url('/'); ?>assets/js/moment.js" type="text/javascript"></script>
<script src="<?php echo base_url('/'); ?>assets/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('/'); ?>assets/dist/js/amd/bootstrap/transition.js" type="text/javascript"></script>
<script src="<?php echo base_url('/'); ?>assets/dist/js/amd/bootstrap/collapse.js" type="text/javascript"></script>
<script src="<?php echo base_url('/'); ?>assets/js/info-how-to.js" type="text/javascript"></script>

<?php
if (current_url() == base_url('dashboard') || current_url() == base_url('dashboard/index')) {
    if (isset($js_view)) {
        foreach ($js_view as $data) { ?>
            <script src="<?php echo $data; ?>" type="text/javascript"></script>
        <?php }
    }
    if (isset($js)) {
        $this->load->view($js);
    }
}
?>

<script type="text/javascript">
    pxInit.unshift(function () {
        var file = String(document.location).split('/').pop();

        // Remove unnecessary file parts
        file = file.replace(/(\.html).*/i, '$1');

        if (!/.html$/i.test(file)) {
            file = 'index.html';
        }

        // Activate current nav item
        $('#px-demo-nav')
            .find('.px-nav-item > a[href="' + file + '"]')
            .parent()
            .addClass('active');

        $('#px-demo-nav').pxNav();
        $('#px-demo-footer').pxFooter();
    });

    for (var i = 0, len = pxInit.length; i < len; i++) {
        pxInit[i].call(null);
    }
    <?php if ($this->session->flashdata('notice') != ''){ ?>
    $.growl.notice({message: "<?php echo $this->session->flashdata('notice');?>"});
    <?php } ?>
    <?php if ($this->session->flashdata('error') != ''){ ?>
    $.growl.error({message: "<?php echo $this->session->flashdata('error');?>"});
    <?php } ?>
    <?php if ($this->session->flashdata('warning') != ''){ ?>
    $.growl.warning({message: "<?php echo $this->session->flashdata('warning');?>"});
    <?php } ?>
</script>
</body>
</html>
