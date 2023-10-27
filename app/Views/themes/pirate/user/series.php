<?= $this->extend( theme_path('user/__layout/base') ) ?>

<?= $this->section("content") ?>


<div class="content">
    <h3 class="content-title "><?= esc( $series->title ) ?>  ( <small class="text-muted">SERIES</small> )    </h3>

</div>

<div class="row row-eq-spacing">
    <div class="col-lg-9">
        <div class="card get-episode-card" >
            <h4 class="card-title font-size-18"> OBTER EPISÓDIOS   </h4>
            <div class="row">
                <div class="col">
                    <div class="form-group mr-15">
                        <label>
                            TEMPORADA                                        </label>
                        <input type="number" name="season" min="1" class="form-control" placeholder="Ex: 1" required="required">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>
                            EPISÓDIO                                        </label>
                        <input type="number" name="episode" min="1" class="form-control" placeholder="Ex: 1" required="required">
                    </div>
                </div>
                <?= form_hidden('series_imdb_id', $series->imdb_id) ?>
                <div class="col">
                    <div class="form-group mx-15">
                        <label style="visibility: hidden">
                            PEGUE                                        </label>
                        <button class="btn btn-primary btn-block w-auto user-get-episode" >
                            <div class="spinner-border mr-5 " role="status" > </div>&nbsp;
                            PEGAR AGORA</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="poster">
            <div class="w-200 mw-full ">
                <div class="card m-0 mb-10 p-5">
                    <img src="<?= poster_uri( $series->poster ) ?>" class="img-fluid w-full" alt="">
                    <div class="p-5">
                        IMDB ID:
                        <span class="badge badge-secondary font-weight-semi-bold float-right">
                            <?= $series->imdb_id ?>
                        </span>
                    </div>
                </div>



            </div>
        </div>

    </div>



</div>





<?php if(! empty($seasons)): ?>

    <div class="content">
        <h3 class="content-title font-size-20"> LISTA DE EPISODIOS    </h3>
    </div>

    <?php foreach ($seasons as $season => $episodes) :
        if(empty($episodes))   continue;  ?>

        <div class="card mt-0 ">
            <h2 class="card-title font-size-18">
                TEMPORADA <?= $season ?>
            </h2>

            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <?php foreach ($episodes as $episode => $data) : ?>

                    <li class="page-item user-get-episode" data-season="<?= $season ?>" data-episode="<?= $episode ?>">
                        <a href="#" class=" page-link font-weight-semi-bold <?= $data['is_ok'] ? 'bg-primary' : '' ?>">
                            <div class="spinner-border mr-5 " role="status" > </div>
                             E<?= sprintf("%02d", $episode) ?>
                        </a>
                    </li>

                    <?php endforeach; ?>

                </ul>
            </nav>

        </div>

    <?php endforeach; ?>
<?php endif; ?>



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
