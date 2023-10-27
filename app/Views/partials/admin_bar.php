<div class="ve-admin--bar">
        <ul class="ve-left">
            <li><a href="<?= admin_url('/dashboard') ?>" class="ve-link">
                    <img src="<?= admin_assets('/images/svg-icons/dashboard.svg') ?>" height="15" alt="">&nbsp;
                   PAINEL ADM </a> </li>

            <li class="ve-dropdown">
                <a href="javascript:void(0)" class="ve-link ">
                    <img src="<?= admin_assets('/images/svg-icons/plus.svg') ?>" height="13" alt="">&nbsp;
                    NOVO</a>
                <ul>
                    <li><a href="<?= admin_url('/movies/new') ?>" class="ve-sub--link"> FILMES </a> </li>
                    <li><a href="<?= admin_url('/episodes/new') ?>" class="ve-sub--link"> EPISODIOS </a></li>
                    <li><a href="<?= admin_url('/series/new') ?>" class="ve-sub--link"> SERIES </a></li>
                </ul>
            </li>

            <?php $cPage = current_url(true)->getSegment(1); ?>
            <?php if($cPage == view_slug() || $cPage == download_slug()):
                if(! empty( $activeMovie )):  ?>
                    <li>
                        <a href="<?= admin_url("/movies/edit/{$activeMovie->id}") ?>" class="ve-link">
                            <img src="<?= admin_assets('/images/svg-icons/edit.svg') ?>" height="15" alt="">&nbsp;
                            EDITAR
                        </a>
                    </li>
                <?php   endif;
            endif; ?>

            <li class="ve-dropdown">
                <a href="javascript:void(0)" class="ve-link ">
                    <img src="<?= admin_assets('/images/svg-icons/list.svg') ?>" height="15" alt="">&nbsp;
                    LISTA</a>
                <ul>
                    <li><a href="<?= admin_url('/movies') ?>" class="ve-sub--link"> FILMES </a> </li>
                    <li><a href="<?= admin_url('/episodes') ?>" class="ve-sub--link"> EPISODIOS </a></li>
                    <li><a href="<?= admin_url('/series') ?>" class="ve-sub--link"> SERIES </a></li>
                </ul>
            </li>
            <li>
                <a href="<?= admin_url('/settings/cache/clean') ?>" class="ve-link d-none d-lg-inline-block ">
                    <img src="<?= admin_assets('/images/svg-icons/clear.svg') ?>" height="18" alt="">&nbsp;
                    LIMPAR CACHE </a> </li>

        </ul>
        <ul class="ve-right">
            <li><a href="<?= admin_url('/logout?rd_back=1') ?>" class="ve-link">
                    <img src="<?= admin_assets('/images/svg-icons/logout.svg') ?>" height="13" alt="">&nbsp;
                    SAIR PARA LOGIN</a> </li>
        </ul>

    </div>
</html>

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