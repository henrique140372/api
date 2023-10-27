<div class="torrent-dl-group">
    <div class="form-group mb-0">
        <label>Link 1:</label>
        <div class="input-group mb-0">
            <?= form_input([
                'type'  => 'url',
                'name'  => 'torrent_dl_links[1][url]',
                'class' => 'form-control link'
            ]) ?>
        </div>
    </div>
    <div class="row row-eq-spacing px-0 mt-5 mb-0">

        <div class="col">
            <div class="form-group row">
                <label class="control-label col-md-3">Resolu:</label>                                <div class="col-md-9">
                    <?= form_dropdown([
                        'name' => "torrent_dl_links[1][resolution]",
                        'options' => getResolutionFormatOptions(),
                        'selected' => '',
                        'class' => 'form-control form-control-sm resolution'
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group row">

                <label class="control-label col-md-4">Qualida:</label>
                <div class="col-md-8">
                    <?= form_dropdown([
                        'name' => "torrent_dl_links[1][quality]",
                        'options' => getQualityFormatOptions(),
                        'selected' => '',
                        'class' => 'form-control form-control-sm quality'
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group row">

                <label class="control-label col-md-3">tama:</label>
                <div class="col-md-9">
                    <div class="input-group">

                        <?= form_input([
                            'type'  => 'number',
                            'name'  => 'torrent_dl_links[1][size_val]',
                            'min'   => 1,
                            'step'  => 'any',
                            'class' => 'form-control form-control-sm size-val'
                        ]) ?>

                        <?= form_dropdown([
                            'name' => "torrent_dl_links[1][size_lbl]",
                            'options' => [
                                'MB' => 'MB',
                                'GB' => 'GB'
                            ],
                            'selected' => old("torrent_dl_links.1.size_lbl", ''),
                            'class' => 'form-control form-control-sm dl-size-label'
                        ]) ?>

                    </div>

                </div>
            </div>
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