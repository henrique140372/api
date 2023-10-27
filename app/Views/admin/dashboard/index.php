<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>


<div class="row" style="display: inline-block;width: 100%;">
    <div class="top_tiles">
        <?= $this->include('admin/dashboard/x_panel/top_tiles') ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6">
        <?= $this->include('admin/dashboard/x_panel/charts/series_completion') ?>
    </div>
    <div class="col-lg-4 col-md-6">
        <?= $this->include('admin/dashboard/x_panel/charts/episodes_completion') ?>
    </div>
    <div class="col-lg-4 col-md-6">
        <?= $this->include('admin/dashboard/x_panel/charts/links_completion') ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <?= $this->include('admin/dashboard/x_panel/most_viewed_movies') ?>
    </div>
    <div class="col-lg-6">
        <?= $this->include('admin/dashboard/x_panel/most_viewed_episodes') ?>
    </div>
</div>


<?php $this->endSection() ?>



<?php $this->section('scripts'); ?>

<!-- ChartJs -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?= $this->include('admin/dashboard/charts_js') ?>

<?php $this->endSection() ?>
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