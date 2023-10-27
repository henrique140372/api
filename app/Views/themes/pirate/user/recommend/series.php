<?= $this->extend( theme_path('user/__layout/base') ) ?>

<?= $this->section("content") ?>

    <div class="content">
        <h3 class="content-title ">Programas de TV recomendados  <span class="text-muted">para adicionar links</span> </h3>
    </div>

<?php if(! empty($series)): ?>

    <div class="content">


        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Imdb ID</th>
                <th>Título</th>
                <th class="text-right">ação</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($series as $k => $show) : ?>
                <tr>
                    <th> <?= $k+1 ?> </th>
                    <td> <a href="https://www.imdb.com/title/<?= $show->imdb_id ?>" class="text-muted" target="_blank">
                            <?= $show->imdb_id ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= $show->getViewLink(true) ?>" class="text-light">
                            <?= esc( $show->title ) ?>
                        </a>
                    </td>
                    <td class="text-right font-weight-semi-bold">
                        <a href="<?= site_url("/user/series/view/" . encode_id($show->id)) ?>">Veja isto</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

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