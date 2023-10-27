<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col-lg-3">
        <div class="nav nav-tabs flex-column  bar_tabs" >
            <a class="nav-link active" data-toggle="pill" href="#settings-data-api" >Data APIs</a>
            <a class="nav-link" data-toggle="pill" href="#settings-media-files" >Media Files</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-gcaptcha" >Google Invisible Captcha</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-st-links" >Stream Links</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-dl-links" >Download Links</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-movie-request" >Movies Request </a>
            <a class="nav-link"  data-toggle="pill" href="#settings-others" >Others </a>
        </div>
    </div>
    <div class="col-lg-9">

        <?= form_open_multipart('/admin/settings/general/update', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>

        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="settings-data-api">
                <?= $this->include('/admin/settings/general/form_x_panels/data_api') ?>
            </div>
            <div class="tab-pane fade" id="settings-media-files">
                <?= $this->include('/admin/settings/general/form_x_panels/media_files') ?>
            </div>
            <div class="tab-pane fade" id="settings-gcaptcha" >
                <?= $this->include('/admin/settings/general/form_x_panels/gcaptcha') ?>
            </div>
            <div class="tab-pane fade" id="settings-st-links">
                <?= $this->include('/admin/settings/general/form_x_panels/stream') ?>
            </div>
            <div class="tab-pane fade" id="settings-dl-links">
                <?= $this->include('/admin/settings/general/form_x_panels/download') ?>
            </div>
            <div class="tab-pane fade" id="settings-movie-request">
                <?= $this->include('/admin/settings/general/form_x_panels/request') ?>
            </div>
            <div class="tab-pane fade" id="settings-others">
                <?= $this->include('/admin/settings/general/form_x_panels/others') ?>
            </div>
        </div>

        <div class="text-right mb-3">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ], 'update') ?>
        </div>

        <?= form_close() ?>

    </div>
</div>

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