<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="John Antonio">
    <meta name="keywords" content="<?= isset($metaKeywords) ? esc( $metaKeywords ) : '' ?>">
    <meta name="description" content="<?= isset($metaDescription) ? esc( $metaDescription ) : '' ?>">

    <?= $this->renderSection('head') ?>

    <?php if( has_site_favicon() ): ?>
    <link rel="shortcut icon" href="<?= site_favicon() ?>" type="image/x-icon">
    <link rel="icon" href="<?= site_favicon() ?>" type="image/x-icon">
    <?php endif; ?>

    <link href="<?= theme_assets('/vendors/datatables/jquery.dataTables.css') ?>" rel="stylesheet" />
    <link href="<?= theme_assets('/css/template.min.css?v=1.3') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= theme_assets('/css/custom.min.css?v=1.3') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">

    <?php if( service('auth')->isLogged() ){ ?>
        <link href="<?= admin_assets('/css/admin-bar.css?v=1.2') ?>" rel="stylesheet">
    <?php } ?>

    <title> <?php echo isset( $title ) ? esc( get_page_title( $title ) ) : ''  ?> </title>

    <!-- header custom codes-->
    <?= header_custom_codes() ?>

</head>


<body  class="dark-mode with-custom-webkit-scrollbars with-custom-css-scrollbars overflow-x-hidden

<?= service('auth')->isLogged() ? 'with-admin-bar1' : '' ?> " data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" data-new-gr-c-s-check-loaded="14.1008.0" data-gr-ext-installed="">
<!-- admin bar-->

<!-- Page wrapper -->
<div id="page-wrapper" class="page-wrapper with-navbar  with-transitions" data-sidebar-type="default">

    <!-- Sticky alerts -->
    <div class="sticky-alerts"></div>

    <!-- Navbar start -->
    <?= $this->include( theme_path('user/__layout/navbar') ) ?>
    <!-- Navbar end -->
<br>
<script>
</div>
<!--bloqueio inspecionar-->
<script src="https://cdn.jsdelivr.net/gh/brunoalbim/devtools-detect/index.js"></script>
<script>
if (window.devtools.isOpen === true) {
      window.location = "https://aoseugosto.eu.org/";
    }
  	window.addEventListener('devtoolschange', event => {
      if (event.detail.isOpen === true) {
        window.location = "https://t.me/aoseugostobr";
      }
  	});
</script>
<!-- fim inspecionar-->
<!--bloquear control+u do teclado-->
<script>
var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false")


//  F12
//==========

  document.onkeypress = function (event) {
    if (e.ctrlKey &&
        (e.keyCode === 123)) {
            // alert('not allowed');
            return false;
          }
  };


//    CTRL + u
//==============

  document.onkeydown = function(e) {
    if (e.ctrlKey &&
      (e.keyCode === 85)) {
          // alert('not allowed');
          return false;
        }
      };  
</script>
<!-- fim bloqueio control+u do teclado-->