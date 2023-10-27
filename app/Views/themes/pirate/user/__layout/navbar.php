<nav class="navbar">

    <div class="container">

        <!-- navbar-brand-->
        <a href="<?=site_url() ?>" class="navbar-brand">
            <?php if (!has_site_logo()): ?>
                <h1 class="ve-logo-text"> <?=esc(site_name()) ?> </h1>
            <?php
            else: ?>
                <img src="<?=site_logo() ?>" class="h-20 h-sm-30" alt="">
            <?php
            endif; ?>
        </a>
        <!-- /. navbar-brand-->

        <?php $uri = http_uri(); ?>
        <!-- Top Navbar menus -->
        <ul class="navbar-nav d-none d-md-flex ml-0">

            <!-- nav-item-->
            <li class="nav-item <?php if ($uri->getTotalSegments() >= 2 && $uri->getSegment(2) === 'dashboard') echo 'active' ?>   ">
                <a href="<?=site_url('/user/Dashboard') ?>" class="nav-link font-weight-semi-bold"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;
                    <?=lang('CENTRAL') ?>
                </a>
            </li>
            <!-- /. nav-item-->

            <!-- nav-item-->
            <li class="nav-item <?php if ($uri->getTotalSegments() >= 2 && ($uri->getSegment(2) === 'my-movies' || $uri->getSegment(2) === 'my-shows')) echo 'active' ?>">
                <a href="<?=site_url('/user/my-movies') ?>" class="nav-link font-weight-semi-bold "  ><i class="fa fa-film" aria-hidden="true"></i>&nbsp;
                <?=lang('MEUS FILMES') ?>
                    <!--?=lang('User/Navbar.my_movies') ?-->
                </a>
            </li>
            <!-- /. nav-item-->

            <!-- nav-item-->
            <li class="nav-item <?php if ($uri->getTotalSegments() >= 2 && $uri->getSegment(2) === 'my-links') echo 'active' ?>">
                <a href="<?=site_url('/user/my-links') ?>" class="nav-link font-weight-semi-bold "><i class="fa fa-link" aria-hidden="true"></i>&nbsp;
                    <?=lang('MEUS LINKS') ?>
                </a>
            </li>
            <!-- /. nav-item-->

            <!-- nav-item-->
            <li class="nav-item dropdown with-arrow">
                <a href="javascript:void(0)" class="nav-link font-weight-semi-bold" data-toggle="dropdown" >
                    <i class="fa fa-area-chart"></i>&nbsp;
                    <?=lang('ESTATÍSTICAS') ?> <i class="fa fa-angle-down ml-5" aria-hidden="true"></i> <!-- ml-5 = margin-left: 0.5rem (5px) -->
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="...">
                    <a href="<?=site_url('/user/statistics/earnings') ?>" class="dropdown-item">
                        <i class="fa fa-star-half-o"></i>&nbsp;
                        <?=lang('ESTATÍSTICAS DE GANHOS') ?>
                    </a>

                    <a href="<?=site_url('/user/statistics/referrals') ?>" class="dropdown-item">
                        <i class="fa fa-users"></i>&nbsp;
                        <?=lang('ESTATÍSTICAS DE REFERÊNCIA') ?>
                    </a>
                </div>
            </li>
            <!-- /. nav-item-->

        </ul>
        <!-- /. Top Navbar menus-->

        <!-- Navbar nav -->
        <ul class="navbar-nav ml-auto">

            <!-- nav-item-->
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" data-toggle="modal" data-target="add-links-by-imdb-id-modal">
                   <span class="badge">
                        <i class="fa fa-plus"></i>
                   </span>
                </a>
            </li>
            <!-- /. nav-item-->

            <!-- nav-item-->
            <li class="nav-item dropdown with-arrow">
                <a class="nav-link" data-toggle="dropdown" id="nav-link-dropdown-toggle">
                    <img src="<?= site_url('/admin-assets/images/avatar.jpg') ?>" class="img-fluid rounded-circle w-30" alt="rounded circle image">
                    &nbsp;&nbsp;<?=esc(current_user()
                        ->username) ?>
                    <i class="fa fa-angle-down ml-5" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-link-dropdown-toggle">
                    <a href="<?=site_url('/user/profile') ?>" class="dropdown-item">
                        <?=lang('MEU PERFIL') ?>
                    </a>
                    <a href="<?=site_url('/user/payouts') ?>" class="dropdown-item">
                        <?=lang('PAGAMENTOS') ?>
                    </a>
                    <a href="<?=site_url('/user/earnings') ?>" class="dropdown-item">
                        <?=lang('GANHOS') ?>
                    </a>
                    <a href="<?=site_url('/user/stars-log') ?>" class="dropdown-item">
                        <?=lang('REGISTRO DE ESTRELAS') ?>
                    </a>

                    <div class="dropdown-divider"></div>
                    <div class="dropdown-content">
                        <a href="<?=site_url('/user/logout') ?>" class="btn btn-block" role="button">
                            <?=lang('SAIR') ?>
                            <i class="fa fa-sign-out ml-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </li>
            <!-- /. nav-item-->

        </ul>

    </div>



</nav>
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