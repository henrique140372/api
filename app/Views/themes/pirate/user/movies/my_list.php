<?= $this->extend( theme_path('user/__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="content d-flex align-items-center justify-content-between">
    <h3 class="content-title "> <?= esc( $title ) ?> - (<span class="text-muted"> <?= count( $movies ) ?> </span>) </h3>

    <div class="tabs p-5 bg-dark-light font-weight-semi-bold mr-0">
        <a href="<?= site_url('/user/my-movies') ?>" class="d-inline-block <?= $isMovie  ? 'btn' : 'nav-link' ?>" >
            <i class="fa fa-film" aria-hidden="true"></i>&nbsp;
            <?= lang('General.movies') ?>
        </a>
        <a href="<?= site_url('/user/my-shows') ?>" class="d-inline-block <?= ! $isMovie ? 'btn' : 'nav-link' ?>" >
            <i class="fa fa-television" aria-hidden="true"></i>&nbsp;
            <?= lang('General.tv_shows') ?>
        </a>
    </div>


</div>

<div class="content">

    <?php the_theme_table_list($movies, $isMovie) ?>

</div>

<?= $this->endSection() ?>
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



