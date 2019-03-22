<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sign In - PIU</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,800,300&subset=latin"
          rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">

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
        _pxDemo_loadStylesheet('<?php echo base_url( '/' ); ?>assets/dist/css/bootstrap.css', 'px-demo-stylesheet-core');
        _pxDemo_loadStylesheet('<?php echo base_url( '/' ); ?>assets/dist/css/pixeladmin.css', 'px-demo-stylesheet-bs');
    </script>

    <!-- DEMO ONLY: Load theme -->
    <script>
        function _pxDemo_loadTheme(a) {
            var b = decodeURIComponent((new RegExp(";\\s*" + encodeURIComponent("px-demo-theme") + "\\s*=\\s*([^;]+)\\s*;", "g").exec(";" + document.cookie + ";") || [])[1] || "default");
            _pxDemo_loadStylesheet(a + b + ".min.css", "px-demo-stylesheet-theme", b)
        }

        _pxDemo_loadTheme('<?php echo base_url( '/' ); ?>assets/dist/css/themes/');
    </script>

    <!-- Demo assets -->
    <script>_pxDemo_loadStylesheet('<?php echo base_url( '/' ); ?>assets/dist/demo/demo.css');</script>
    <script src="<?php echo base_url( '/' ); ?>assets/dist/demo/demo.js"></script>
    <!-- / Demo assets -->
</head>
<body>
<script>var pxInit = [];</script>

<!-- Custom styling -->
<style>
    .page-signin-modal {
        position: relative;
        top: auto;
        right: auto;
        bottom: auto;
        left: auto;
        z-index: 1;
        display: block;
    }

    .page-signin-form-group {
        position: relative;
    }

    .page-signin-icon {
        position: absolute;
        line-height: 21px;
        width: 36px;
        border-color: rgba(0, 0, 0, .14);
        border-right-width: 1px;
        border-right-style: solid;
        left: 1px;
        top: 9px;
        text-align: center;
        font-size: 15px;
    }

    html[dir="rtl"] .page-signin-icon {
        border-right: 0;
        border-left-width: 1px;
        border-left-style: solid;
        left: auto;
        right: 1px;
    }

    html:not([dir="rtl"]) .page-signin-icon + .page-signin-form-control {
        padding-left: 50px;
    }

    html[dir="rtl"] .page-signin-icon + .page-signin-form-control {
        padding-right: 50px;
    }

    #page-signin-forgot-form {
        display: none;
    }

    /* Margins */

    .page-signin-modal > .modal-dialog {
        margin: 30px 10px;
    }

    @media (min-width: 544px) {
        .page-signin-modal > .modal-dialog {
            margin: 60px auto;
        }
    }
</style>
<!-- / Custom styling -->

<!-- Javascript -->
<script>
    pxInit.push(function () {
        $(function () {
            pxDemo.initializeBgsDemo('body', 1, '#000', function (isBgSet) {
                $('#px-demo-signup-link, #px-demo-signup-link a')
                    .addClass(isBgSet ? 'text-white' : 'text-muted')
                    .removeClass(isBgSet ? 'text-muted' : 'text-white');
            });

            $('#page-signin-forgot-link').on('click', function (e) {
                e.preventDefault();

                $('#page-signin-form, #page-signin-social')
                    .css({opacity: '1'})
                    .animate({opacity: '0'}, 200, function () {
                        $(this).hide();

                        $('#page-signin-forgot-form')
                            .css({opacity: '0', display: 'block'})
                            .animate({opacity: '1'}, 200)
                            .find('.form-control').first().focus();

                        $(window).trigger('resize');
                    });
            });

            $('#page-signin-forgot-back').on('click', function (e) {
                e.preventDefault();

                $('#page-signin-forgot-form')
                    .animate({opacity: '0'}, 200, function () {
                        $(this).css({display: 'none'});

                        $('#page-signin-form, #page-signin-social')
                            .show()
                            .animate({opacity: '1'}, 200)
                            .find('.form-control').first().focus();

                        $(window).trigger('resize');
                    });
            });
        });
    });
</script>
<!-- / Javascript -->

<div class="page-signin-modal modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="box m-a-0">
                <div class="box-row">

                    <div class="box-cell col-md-5 bg-primary p-a-4">
                        <div class="text-xs-center text-md-left">
                            <a class="px-demo-brand px-demo-brand-lg" href="<?php base_url( '/' ) ?>"><span
                                        class="px-demo-logo bg-primary m-t-0"><span class="px-demo-logo-1"></span><span
                                            class="px-demo-logo-2"></span><span class="px-demo-logo-3"></span><span
                                            class="px-demo-logo-4"></span><span class="px-demo-logo-5"></span><span
                                            class="px-demo-logo-6"></span><span class="px-demo-logo-7"></span><span
                                            class="px-demo-logo-8"></span><span
                                            class="px-demo-logo-9"></span></span><span
                                        class="font-size-18 line-height-1"><strong>PIU</strong></span></a>
                            <div class="font-size-15 m-t-1 line-height-1">Project Implementation Unit<br><br><b>Universitas Gadjah Mada</b></div>
                        </div>
                        <ul class="list-group m-t-3 m-b-0 visible-md visible-lg visible-xl">
                            <li class="list-group-item p-x-0 p-b-0 b-a-0"><i
                                        class="list-group-icon fa fa-file-text-o text-white"></i> Fitur 1
                            </li>
                            <li class="list-group-item p-x-0 p-b-0 b-a-0"><i
                                        class="list-group-icon fa fa-file-text-o text-white"></i> Fitur 2
                            </li>
                            <li class="list-group-item p-x-0 p-b-0 b-a-0"><i
                                        class="list-group-icon fa fa-outdent text-white"></i> Fitur 3
                            </li>
                        </ul>
                    </div>

                    <div class="box-cell col-md-7">
						<?php echo form_open( '/auth/login', array( 'class' => 'p-a-4', 'id' => 'page-signin-form' ) ) ?>
                        <h4 class="m-t-0 m-b-4 text-xs-center font-weight-semibold">Masuk dengan username dan
                            password</h4>

                        <fieldset class="page-signin-form-group form-group form-group-lg">
                            <div class="page-signin-icon text-muted"><i class="ion-person"></i></div>
                            <input type="text" class="page-signin-form-control form-control" name="identity"
                                   placeholder="Email atau Username">
                        </fieldset>

                        <fieldset class="page-signin-form-group form-group form-group-lg">
                            <div class="page-signin-icon text-muted"><i class="ion-asterisk"></i></div>
                            <input type="password" class="page-signin-form-control form-control" name="password"
                                   placeholder="Password">
                        </fieldset>

                        <div class="clearfix">
                            <label class="custom-control custom-checkbox pull-xs-left">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                Ingat Saya
                            </label>
                            <a href="#" class="font-size-12 text-muted pull-xs-right" id="page-signin-forgot-link">Forgot
                                your password?</a>
                        </div>

                        <button type="submit" class="btn btn-block btn-lg btn-primary m-t-3">Sign In</button>
                        </form>
                        <!-- / Sign In form -->

                        <!-- Reset form -->

                        <form action="#" class="p-a-4" id="page-signin-forgot-form">
                            <h4 class="m-t-0 m-b-4 text-xs-center font-weight-semibold">Password reset</h4>

                            <fieldset class="page-signin-form-group form-group form-group-lg">
                                <div class="page-signin-icon text-muted"><i class="ion-at"></i></div>
                                <input type="email" class="page-signin-form-control form-control"
                                       placeholder="Your Email">
                            </fieldset>

                            <button type="submit" class="btn btn-block btn-lg btn-primary m-t-3">Send password reset
                                link
                            </button>
                            <div class="m-t-2 text-muted">
                                <a href="#" id="page-signin-forgot-back">&larr; Back</a>
                            </div>
							<?php echo form_close() ?>

                            <!-- / Reset form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js">' + "<" + "/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">' + "<" + "/script>"); </script>
<![endif]-->

<script src="<?php echo base_url( '/' ); ?>assets/dist/js/bootstrap.js"></script>
<script src="<?php echo base_url( '/' ); ?>assets/dist/js/pixeladmin.js"></script>

<script type="text/javascript">
    pxInit.unshift(function () {
        $(function () {
            pxDemo.initializeDemo();
        });
    });

    for (var i = 0, len = pxInit.length; i < len; i++) {
        pxInit[i].call(null);
    }
    <?php if ($message != ''){ ?>
    $.growl.error({ message: "<?php echo str_replace(PHP_EOL, '',$message);?>" });
    <?php } ?>
</script>
</body>
</html>
