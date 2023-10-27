<!-- First button group -->
<div class="tabs p-5 bg-dark-light font-weight-semi-bold mb-20 w-auto d-inline-flex">
    <a href="#" class="btn" data-target="direct-links-content">
        <i class="fa fa-link" aria-hidden="true"></i>
        &nbsp; <?= lang('General.direct_links') ?>
    </a>
    <a href="#" class="nav-link d-inline-block" data-target="embed-code-content">
        <i class="fa fa-code" aria-hidden="true"></i>
        &nbsp; <?= lang('General.embed_code') ?>
    </a>
</div>
<div class="tab-content active" id="direct-links-content">

    <div class="form-group">
        <label for="" ><?= lang('General.link') ?> 1 :</label>
        <!-- Another input group with stacked buttons (appended) -->
        <div class="input-group">
            <input type="text" class="form-control embed-link-1" id="link-1" value="<?= ! empty( $activeMovie ) ? esc( $activeMovie->getEmbedLink(true) ) : '' ?>" readonly="readonly">
            <div class="input-group-append">
                <button class="btn" type="button" onclick="copyToClipboard('#link-1')"><i class="fa fa-copy"></i></button>
            </div>
        </div>
    </div>
    <div class="form-group mb-0">
        <label for="" ><?= lang('General.link') ?> 2 :</label>
        <!-- Another input group with stacked buttons (appended) -->
        <div class="input-group">
            <input type="text" class="form-control embed-link-2" id="link-2" value="<?= ! empty($activeMovie) ? esc( $activeMovie->getEmbedLink() ) : '' ?>" readonly="readonly">
            <div class="input-group-append">
                <button class="btn" type="button" onclick="copyToClipboard('#link-2')"><i class="fa fa-copy"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="tab-content" id="embed-code-content">
    <div class="position-relative">
        <textarea name="" id="embed-code" class="form-control embed-code"  rows="8" readonly="readonly"><iframe id="ve-iframe" src="<?= ! empty($activeMovie) ? esc( $activeMovie->getEmbedLink() ) : '' ?>" width="100%" height="100%" allowfullscreen="allowfullscreen" frameborder="0"></iframe></textarea>
        <button class="btn position-absolute bottom-0 right-0 m-5 " type="button" onclick="copyToClipboard('#embed-code')"><i class="fa fa-copy"></i></button>
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