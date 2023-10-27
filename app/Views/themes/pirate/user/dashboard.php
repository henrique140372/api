<?= $this->extend(theme_path("user/__layout/base")) ?>

<?= $this->section("content") ?>

<!-- Page title content-->
<div class="content d-flex align-items-center justify-content-between">
    <h3 class="content-title ">
        <?= esc( $title ) ?>
    </h3>
    <div>
        <button type="button" class="btn btn-primary font-weight-semi-bold" data-toggle="modal" data-target="add-links-by-imdb-id-modal">
            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
            <?= lang("User/Dashboard.add_links") ?>
        </button>
    </div>
</div>
<!-- /. Page title content-->

<?= display_alerts() ?>

<!-- row -->
<div class="row row-eq-spacing">

    <!-- col-6 col-lg-6-->
    <div class="col-6 col-lg-3">
        <div class="card p-15">
            <h2 class="card-title text-muted font-size-18 mb-5">
                <?= lang("User/Dashboard.earned_stars") ?>
            </h2>
            <h4 class="font-weight-semi-bold text-secondary my-0">
                <?= nf($analytics["earnings"]["credited"] ?? 0) ?>
            </h4>
        </div>
    </div>
    <!-- /. col-6 col-lg-6-->

    <!-- col-6 col-lg-6-->
    <div class="col-6 col-lg-3">
        <div class="card p-15">
            <h2 class="card-title text-muted font-size-18 mb-5">
                <?= lang("User/Dashboard.active_stars") ?>
            </h2>
            <h4 class="font-weight-semi-bold text-primary my-0">
                <?= nf(current_user()->getActiveStars()) ?>
            </h4>


        </div>
    </div>
    <!-- /. col-6 col-lg-6-->

    <!-- col-6 col-lg-6-->
    <div class="col-6 col-lg-3">
        <div class="card p-15">
            <h2 class="card-title text-muted font-size-18 mb-5">
                <?= lang("User/Dashboard.pending_stars") ?>
            </h2>
            <h4 class="font-weight-semi-bold text-danger my-0">
                <?= nf($analytics["earnings"]["pending"] ?? 0) ?>
            </h4>
        </div>
    </div>
    <!-- /. col-6 col-lg-6-->

    <!-- col-6 col-lg-6-->
    <div class="col-6 col-lg-3">
        <div class="card p-15">
            <h2 class="card-title text-muted font-size-18 mb-5">
                <?= lang("User/Dashboard.reliability") ?>
            </h2>
            <h4 class="font-weight-semi-bold  my-0">
                <?= display_reliability_val($analytics["reliability"] ?? 0) ?>
                <small class="text-muted">% </small> </h4>
        </div>
    </div>
    <!-- /. col-6 col-lg-6-->

</div>
<!-- /. row -->

<?php if (!empty($recommendMovies)): ?>

    <div class="content">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="content-title font-size-18">
                <?= lang("User/Dashboard.recommended_movies") ?>
                <span class="text-muted">
                <?= lang("User/Dashboard.to_add_links") ?>
            </span>
            </h2>
            <a href="<?= site_url("/user/recommend/movies") ?>" class="btn">
                <?= lang("User/Dashboard.view_all_btn") ?>
            </a>
        </div>

        <?php the_theme_table_list($recommendMovies, true, false); ?>

    </div>

<?php endif; ?>

<?php if (!empty($recommendSeries)): ?>

    <div class="content">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="content-title font-size-18">
                <?= lang("User/Dashboard.complete_these_tv_shows") ?>
            </h2>
            <a href="<?= site_url("/user/recommend/series") ?>" class="btn">
                <?= lang("User/Dashboard.view_all_btn") ?>
            </a>
        </div>

        <?php the_theme_table_list($recommendSeries, false, false); ?>

    </div>

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