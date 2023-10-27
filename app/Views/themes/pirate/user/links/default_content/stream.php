<div class="form-group st-group">
    <?= form_label('Link 1:') ?>
    <?= form_input([
        'type' => 'url',
        'name' => 'st_links[1][url]',
        'placeholder' => 'https://aoseugosto.eu.org/watch/xxxxx',
        'class' => 'form-control link'
    ]) ?>

    <?php if(! empty(get_stream_types())): ?>
    <div class="row row-eq-spacing px-0  mt-5 mb-0">
        <div class="col-4 px-0">
            <div class="form-group mb-0 row">
                <label class="control-label col-md-4">Qualidade:</label>
                <div class="col-md-8">
                    <?= form_dropdown([
                        'name' => "st_links[1][quality]",
                        'options' => get_stream_types(),
                        'selected' => '',
                        'class' => 'form-control form-control-sm quality'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>



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