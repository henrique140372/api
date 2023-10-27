<?= $this->extend( theme_path('__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="container-fluid mb-20">

    <!-- row -->
    <div class="row">

        <!-- col-md-7 col-xl-6 -->
        <div class="col-md-7  col-xl-6 mx-auto">

            <!-- Server dest card -->
            <div class="card">
                <h3 class="font-weight-semi-bold content-title text-center mt-0 ">
                   <?= esc( $title ) ?>
                </h3>

                <?= display_alerts('mx-0') ?>

                <?= form_open('/register/create') ?>

                    <div class="form-group">
                        <?= form_label(lang("Register.username"), '', ['class'=>'required']) ?>
                        <?= form_input([
                                'name' => 'username',
                                'class' => 'form-control form-control-lg',
                                'value' => old('username')
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label(lang("Register.email"), '', ['class'=>'required']) ?>
                        <?= form_input([
                            'type' => 'email',
                            'name' => 'email',
                            'class' => 'form-control form-control-lg',
                            'value' => old('email')
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label(lang("Register.password"), '', ['class'=>'required']) ?>
                        <?= form_password([
                            'name' => 'password',
                            'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label(lang("Register.confirm_password"), '', ['class'=>'required']) ?>
                        <?= form_password([
                            'name' => 'confirm_password',
                            'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>


                <div class="g-recaptcha d-none" data-sitekey="<?= esc( get_config('gcaptcha_site_key') ) ?>"
                     data-badge="bottomright" data-size="invisible" data-callback="setCaptchaResponse"></div>

                <?= form_hidden('gcaptcha') ?>

                <!-- CSRF -->
                <?= csrf_field() ?>
                <!-- /. CSRF -->

                <div>
                    <p>
Ao se inscrever, você confirma que concorda com nossos
                        <a href="#">termos e Condições</a>
                    </p>
                </div>



                 <input class="btn btn-lg btn-primary btn-block" type="submit" value="<?= lang("Register.register_btn") ?>">

                <?= form_close() ?>

                <div class="mt-15 text-center">
                    <a href="<?= site_url('/login') ?>">
                        <?= lang("Register.login") ?>
                    </a>
                </div>

            </div>
            <!-- /. Server dest card -->




        </div>
        <!-- /. col-md-7 col-xl-6 -->
    </div>
    <!-- /. row -->
</div>
<!-- /. container-fluid -->

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<?php if( is_register_gcaptcha_enabled() ): ?>

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