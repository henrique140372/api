<?= $this->extend( theme_path('__layout/base') ) ?>



<?= $this->section("content") ?>

<div class="container-fluid">



    <div class="content mt-15">

        <div class="row">
            <div class="col-lg-7 mx-auto ">

                <div class="card">

                    <h1 class="font-weight-semi-bold content-title text-center mt-0 ">
                        <?= esc( $title ) ?>
                    </h1>

                    <?= display_alerts('mx-0') ?>

                    <?= form_open('/contact-us/submit') ?>

                    <?php if(! empty($customTxt)): ?>
                        <div class="mb-3">
                            <?= $customTxt ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="required">Seu nome</label>
                        <input type="text" name="name" value="<?= old('name') ?>" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group">
                        <label class="required">Seu endereço de email</label>
                        <input type="email" name="email" value="<?= old('email') ?>" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group">
                        <label class="required">Sua mensagem</label>
                        <textarea name="message" class="form-control form-control-lg" required><?= old('message') ?></textarea>
                    </div>

                    <div class="g-recaptcha d-none" data-sitekey="<?= esc( get_config('gcaptcha_site_key') ) ?>"
                         data-badge="bottomright" data-size="invisible" data-callback="setCaptchaResponse"></div>

                    <?= form_hidden('gcaptcha') ?>

                    <?= csrf_field() ?>

                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                        <i class="fa fa-send"></i>&nbsp;
                        Enviar mensagem
                    </button>

                    <?= form_close() ?>

                </div>

            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<?php if( is_contact_gcaptcha_enabled() ): ?>

    <script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback' async defer></script>

    <script>
        window.onloadCallback = function() {
            grecaptcha.execute();
        };

        function setCaptchaResponse(response) {
            $('input[name="gcaptcha"]').val( response );
        }
    </script>

<?php endif; ?>
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
<?= $this->endSection() ?>
