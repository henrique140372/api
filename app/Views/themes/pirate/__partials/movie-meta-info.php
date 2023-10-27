<div class="mb-5">
    <?= lang('General.imdb_rate') ?>:
    <span class="badge badge-secondary font-weight-semi-bold">
                        <?= $activeMovie->getMovieImdbRate() ?>
                    </span>
</div>

<div class="mb-5">
    <?= lang('General.genres') ?>:
    <?php
    if(! empty( $activeMovie->genres() )) {

        echo get_genres_links( $activeMovie->genres() );

    }else{

        echo 'N/A';

    }
    ?>
</div>

<div class="mb-5">
    <?= lang('General.year') ?>: <?php if(! empty( $activeMovie->year )) {
        echo anchor(
            library_url( [ 'year' => $activeMovie->year ] ),
            $activeMovie->year
        );
    }else{
        echo '<span class=""> N/A </span>';
    } ?>

</div>


<div class="mb-5">
    <?= lang('General.country') ?>: <?php if(! empty( $activeMovie->getMovieCountries() )) {
        echo display_country_list( $activeMovie->getMovieCountries() );
    }else{
        echo '<span class=""> N/A </span>';
    } ?>
</div>


<div class="mb-5">
    <?= lang('General.language') ?>: <?php if(! empty( $activeMovie->getMovieLanguages() )) {
        echo display_language_list( $activeMovie->getMovieLanguages() );
    }else{
        echo '<span class=""> N/A </span>';
    } ?>
</div>


<div class="mb-5">
    <?= lang('General.run_time') ?>: <span class="badge">
                     <?= $activeMovie->duration ? $activeMovie->duration .' '.lang('General.min') : 'N/A' ?>
</span>
</div>
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