<?php $isExist = $data['is_exist'] ?? false;  ?>

<div class="card movie-card p-5 border-0 mb-10 <?= $isExist ? 'selected' : '' ?> " data-tmdb="<?= $data['tmdb_id'] ?>">
    <div class="front">
        <div class="poster-img lazy"
             data-bg-multi="linear-gradient( rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3) ), url(<?= $data['poster'] ?>)">
        </div>
    </div>
    <div class="back">
        <p class="title mt-0"> <?= esc( $data['title'] ) ?> </p>
        <div class="btn-list">
            <?php if(! $isExist): ?>
            <a href="javascript:void(0)" class="btn select-btn" onclick="Requests.select(this)">
                <?= lang('Request.movie_select') ?>
            </a>
            <?php else: ?>
                <a href="<?= site_url(view_slug() . '/' . $data['tmdb_id'])  ?>" class="btn">
                    <?= lang('Request.movie_view') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
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