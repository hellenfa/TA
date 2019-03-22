<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Error 404 - Halaman Tidak Ditemukan</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,800,300&subset=latin"
          rel="stylesheet" type="text/css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">

    <!-- DEMO ONLY: Function for the proper stylesheet loading according to the demo settings -->
    <script>function _pxDemo_loadStylesheet(a, b, c) {
            var c = c || decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-theme") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "default"),
                d = "1" === decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-rtl") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "0");
            document.write(a.replace(/^(.*?)((?:\.min)?\.css)$/, '<link href="$1' + (c.indexOf("dark") !== -1 && a.indexOf("/css/") !== -1 && a.indexOf("/themes/") === -1 ? "-dark" : "") + (d && a.indexOf("assets/") === -1 ? ".rtl" : "") + '$2" rel="stylesheet" type="text/css"' + (b ? 'class="' + b + '"' : "") + ">"))
        }</script>

    <!-- DEMO ONLY: Set RTL direction -->
    <script>"1" === decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-rtl") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "0") && document.getElementsByTagName("html")[0].setAttribute("dir", "rtl");</script>

    <!-- DEMO ONLY: Load PixelAdmin core stylesheets -->
    <script>
        _pxDemo_loadStylesheet('<?php echo base_url('/assets') ?>/dist/css/bootstrap.css', 'px-demo-stylesheet-core');
        _pxDemo_loadStylesheet('<?php echo base_url('/assets') ?>/dist/css/pixeladmin.css', 'px-demo-stylesheet-bs');
    </script>

    <!-- DEMO ONLY: Load theme -->
    <script>
        function _pxDemo_loadTheme(a) {
            var b = decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-theme") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "default");
            _pxDemo_loadStylesheet(a + b + ".min.css", "px-demo-stylesheet-theme", b)
        }

        _pxDemo_loadTheme('<?php echo base_url('/assets') ?>/dist/css/themes/');
    </script>

    <!-- Demo assets -->
    <script>_pxDemo_loadStylesheet('<?php echo base_url('/assets') ?>/dist/demo/demo.css');</script>
    <script src="<?php echo base_url('/assets') ?>/dist/demo/demo.js"></script>
    <!-- / Demo assets -->
</head>
<body>
<script>var pxInit = [];</script>

<!-- Custom styling -->
<style>
    .page-404-bg {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .page-404-header,
    .page-404-error-code,
    .page-404-subheader,
    .page-404-text,
    .page-404-form {
        position: relative;

        padding: 0 30px;

        text-align: center;
    }

    .page-404-header {
        width: 100%;
        padding: 20px 0;

        box-shadow: 0 4px 0 rgba(0, 0, 0, .1);
    }

    .page-404-error-code {
        margin-top: 60px;

        color: #fff;
        text-shadow: 0 4px 0 rgba(0, 0, 0, .1);

        font-size: 120px;
        font-weight: 700;
        line-height: 140px;
    }

    .page-404-subheader,
    .page-404-text {
        margin-bottom: 60px;

        color: rgba(0, 0, 0, .5);

        font-weight: 600;
    }

    .page-404-subheader {
        font-size: 50px;
    }

    .page-404-subheader:after {
        position: absolute;
        bottom: -30px;
        left: 50%;

        display: block;

        width: 40px;
        height: 4px;
        margin-left: -20px;

        content: "";

        background: rgba(0, 0, 0, .2);
    }

    .page-404-text {
        font-size: 20px;
    }

    .page-404-form {
        max-width: 500px;
        margin: 0 auto 60px auto;
    }

    .page-404-form * {
        margin: 0 !important;

        border: none !important;
    }

    .page-404-form .btn {
        background: rgba(0, 0, 0, .3);
    }
</style>
<!-- / Custom styling -->

<div class="page-404-bg bg-warning"></div>
<div class="page-404-header bg-white">
    <a class="px-demo-brand px-demo-brand-lg text-default" href="index.html"><span class="px-demo-logo bg-black"><span
                    class="px-demo-logo-1"></span><span class="px-demo-logo-2"></span><span
                    class="px-demo-logo-3"></span><span class="px-demo-logo-4"></span><span
                    class="px-demo-logo-5"></span><span class="px-demo-logo-6"></span><span
                    class="px-demo-logo-7"></span><span class="px-demo-logo-8"></span><span
                    class="px-demo-logo-9"></span></span><strong>PIU</strong></a>
</div>
<h1 class="page-404-error-code"><strong>404</strong></h1>
<h2 class="page-404-subheader">OOPS!</h2>
<h3 class="page-404-text">
    HALAMAN TIDAK DITEMUKAN
</h3>
<form class="page-404-form" action="">
    <a href="<?php echo base_url(); ?>" class="btn btn-primary btn-xl font-weight-bold font-size-14">Kembali ke Halaman Utama</a>
</form>


<!-- Initialize demo sidebar on page load -->
<script>
    pxDemo.initializeDemoSidebar();
    pxInit.push(function () {
        $(function () {
            $('#px-demo-sidebar').pxSidebar();
        });
    });
</script>

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<script type="text/javascript"> window.jQuery || document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js">' + "<" + "/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
<script type="text/javascript"> window.jQuery || document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">' + "<" + "/script>"); </script>
<![endif]-->

<script src="<?php echo base_url('/assets') ?>/dist/js/bootstrap.js"></script>
<script src="<?php echo base_url('/assets') ?>/dist/js/pixeladmin.js"></script>

<script type="text/javascript">
    pxInit.unshift(function () {
        $(function () {
            pxDemo.initializeDemo();
        });
    });

    for (var i = 0, len = pxInit.length; i < len; i++) {
        pxInit[i].call(null);
    }
</script>
</body>
</html>
