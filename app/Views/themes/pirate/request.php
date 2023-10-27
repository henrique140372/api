<?= $this->extend( theme_path('__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="container-fluid">

    <div class="row align-items-center">
        <div class="col-auto ">
            <div class="content mt-20 mb-0">
                <h1 class="content-title mb-0 ">
                    <?= esc( $title ) ?>
                </h1>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">

        <!-- col-lg-8 -->
        <div class="col-lg-8">

            <!-- Tab button content -->
            <div class="content text-right my-0">

                <div class="tabs p-5 bg-dark-light font-weight-semi-bold mb-20 w-auto d-inline-flex ">
                    <a href="javascript:void(0)" class="btn" data-target="find-movies" onclick="Requests.changeType('movie')">
                        <i class="fa fa-link" aria-hidden="true"></i>
                        &nbsp; <?= lang('FILMES') ?>
                    </a>
                    <a href="javascript:void(0)" class="nav-link d-inline-block" onclick="Requests.changeType('tv')" data-target="find-shows">
                        <i class="fa fa-code" aria-hidden="true"></i>
                        &nbsp; <?= lang('SERIES') ?>
                    </a>
                </div>

            </div>
            <!-- /. Tab button content -->

            <?= display_alerts() ?>

            <!-- Card -->
            <div class="card mt-0">

                <!-- Movies Tab Content -->
                <div class="tab-content active" id="find-movies">
                    <!-- Form Group -->
                    <div class="form-group mb-0">
                        <?= form_input([
                                'class' => 'form-control form-control-lg movie-suggest-input',
                                'placeholder' => lang('Request.movie_input_placeholder'),
                                'onkeyup' => 'Requests.find()',
                                'autofocus' => 'true'
                        ]) ?>
                    </div>
                    <!-- /. Form Group -->
                </div>
                <!-- /. Movies Tab Content -->

                <!-- TV Shows Tab Content -->
                <div class="tab-content" id="find-shows">
                    <!-- Form Group -->
                    <div class="form-group mb-0">
                        <?= form_input([
                            'class' => 'form-control form-control-lg tv-suggest-input',
                            'placeholder' => lang('Request.tv_shows_input_placeholder'),
                            'onkeyup' => 'Requests.find()'
                        ]) ?>
                    </div>
                    <!-- /. Form Group -->
                </div>
                <!-- /. TV Shows Tab Content -->

            </div>
            <!-- /. Card -->


            <div class="content mx-10">

                <!-- Suggestion Results -->
                <div class="row row-eq-spacing" id="suggest-results"></div>
                <!-- /. Suggestion Results -->

                <!-- Results Not Found -->
                <div class="results-not-found text-center" style="display: none">
                    <h4 class="ve-text">
                        <?= lang('Request.content_not_found') ?>
                    </h4>
                </div>
                <!-- /. Results Not Found -->

                <!-- Content Loading -->
                <div class="content-loading text-center" style="display:none;">
                    <div class="loader">
                        <div class="loader-inner line-scale">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="ve-text">
                            <?= lang('Request.content_loading_msg') ?>
                        </div>
                    </div>
                </div>
                <!-- /. Content Loading -->

            </div>



        </div>
        <!-- /. col-lg-8 -->

        <!-- col-lg-4 -->
        <div class="col-lg-4">

            <!-- CARD -->
            <div class="card ">

                <!-- Request From -->
                <?= form_open('/request/create') ?>

                    <p class="mt-0"> <?= lang('Solicitar filmes_series selecionados') ?> </p>

                    <!-- Selected Movies List -->
                    <ul class="selected-movies" style="display: none"></ul>
                    <!-- /. Selected Movies List -->

                    <!-- Selected Not Found -->
                    <div class="selected-not-found text-center text-muted py-20">
                       <?= lang('Pedido não selecionado') ?>
                    </div>
                    <!-- /. Selected Not Found -->

                    <!-- selection input -->
                    <div class="selection-input d-none"></div>
                    <!-- /. selection input -->

                    <?php if(get_config('req_email_subscription')) : ?>
                    <!-- Email Form Group -->
                    <div class="form-group">
                        <?= form_label( lang('preencha seu email') ) ?>
                        <?= form_input([
                                'type' => 'email',
                                'class' => 'form-control',
                                'name' => 'email',
                                'placeholder' => lang('Request.email_input_placeholder')
                        ]) ?>
                        <div class="form-text">
                            <?= lang('Request.email_hint') ?>
                        </div>
                    </div>
                    <!-- /. Email Form Group -->
                    <?php endif; ?>


                    <!-- Captcha Form Group -->
                    <?php if(get_config('is_request_captcha_enabled')){
                        the_math_captcha();
                    } ?>
                    <!-- /. Captcha Form Group -->

                    <!-- CSRF -->
                    <?= csrf_field() ?>
                    <!-- /. CSRF -->

                    <input class="btn btn-primary btn-block " id="request-submit" type="submit" value="Request" disabled>

                <?= form_close() ?>
                <!-- /. Request From -->

            </div>
            <!-- /. CARD -->

        </div>
        <!-- /. col-lg-4 -->

    </div>
    <!-- /. row -->



</div>


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