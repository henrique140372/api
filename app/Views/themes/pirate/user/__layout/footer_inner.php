<div class="footer text-center">

    <?php if(! empty( footer_txt_content() ) && empty(  lang('Footer.notice') )) : ?>
    <div class="footer-notice  text-muted p-20 pb-0 ">
        <?= esc( footer_txt_content() )  ?>
    </div>
    <?php endif; ?>

    <?php if(! empty( lang('Footer.notice') )) : ?>
        <div class="footer-notice  text-muted p-20 pb-0">
            <?= lang('Footer.notice') ?>
        </div>
    <?php endif; ?>

    <?php $links = get_footer_links();
    if(! empty($links)) : ?>
        <div class="footer-menu mt-20">
            <?php foreach ($links as $link) {
                echo anchor( $link['url'], $link['title'], [
                    'class' => 'text-muted d-inline-block mx-10'
                ]);
            } ?>
        </div>
    <?php endif; ?>

    <div class="copyright py-20">
       <?= ! empty( lang('Footer.copyright') ) ? lang('Footer.copyright') :  esc( site_copyright() ) ?>
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
