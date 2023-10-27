<?= $this->extend( theme_path('__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row ">
        <div class="col-lg-8 mx-auto">

            <!-- Main Content Title  -->
            <div class="content my-15 ">
                <h1 class="content-title mt-5">
                    🔥 <?= lang('API.stream_api_title') ?>
                </h1>
            </div>
            <!-- /. Main Content Title -->

            <!-- Get Movie Card -->
            <div class="card text-break mt-0">

                <!-- Card Title -->
                <div class="bg-dark-light px-10 py-5 mb-15 rounded">
                    <h2 class="card-title font-size-18 mb-0">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;
                        <?= sprintf( lang('API.get_movie_title') , '<span class="text-primary">', '</span>') ?> :
                    </h2>
                </div>
                <!-- /. Card Title -->

                <!-- h4 - Sub title : get with ids -->
                <h4 class="font-size-16">
                    <i class="fa fa-imdb badge" aria-hidden="true"></i>&nbsp;
                    <?= sprintf( lang('API.with_ids_label') ,
                        '<span class="text-muted">', '</span>',
                        '<span class="text-muted">', '</span>') ?>
                </h4>
                <!-- /. h4 - Sub title : get with ids -->

                <!-- ul - API Usage examples -->
                <ul class="mb-20">

                    <!--  li - method 1 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 1:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">IMDB_ID</small></code>
                            </li>
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">TMDB_ID</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 1 -->

                    <!--  li - method 2 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 2:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/movie?imdb=<small class="text-muted">IMDB_ID</small></code>
                            </li>
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/movie?tmdb=<small class="text-muted">TMDB_ID</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 2 -->

                </ul>
                <!-- /. ul - API Usage examples -->

                <!-- h4 - Sub title : get with title & year -->
                <h4 class="font-size-16">
                    <i class="fa fa-text-width badge" aria-hidden="true"></i>&nbsp;
                    <?= sprintf( lang('API.with_title_label') ,
                        '<span class="text-muted">', '</span>',
                        '<span class="text-muted">', '</span>') ?>
                </h4>
                <!-- /. h4 - Sub title : get with title & year -->

                <!-- ul - API Usage examples -->
                <ul>
                    <li>
                        <code><?= site_url( embed_slug() ) ?>/movie?title=<small class="text-muted">MOVIE_TITLE</small>&year=<small class="text-muted">YEAR</small></code>
                    </li>
                </ul>
                <!-- /. ul - API Usage examples -->

            </div>
            <!-- /. Get Movie Card -->

            <!-- Get TV Show Card -->
            <div class="card text-break mt-0">

                <!-- Card Title -->
                <div class="bg-dark-light px-10 py-5 mb-15 rounded">
                    <h2 class="card-title font-size-18 mb-0">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;
                        <?= sprintf( lang('API.get_tv_show_title') , '<span class="text-primary">', '</span>') ?> :
                    </h2>
                </div>
                <!-- /. Card Title -->

                <!-- h4 - Sub title : get with ids -->
                <h4 class="font-size-16">
                    <i class="fa fa-imdb badge" aria-hidden="true"></i>&nbsp;
                    <?= sprintf( lang('API.with_ids_label') ,
                        '<span class="text-muted">', '</span>',
                        '<span class="text-muted">', '</span>') ?>
                </h4>
                <!-- /. h4 - Sub title : get with ids -->

                <!-- ul - API Usage examples -->
                <ul class="mb-20">

                    <!--  li - method 1 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 1:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">IMDB_ID</small></code>
                            </li>
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">TMDB_ID</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 1 -->

                    <!--  li - method 2 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 2:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/series?imdb=<small class="text-muted">IMDB_ID</small></code>
                            </li>
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/series?tmdb=<small class="text-muted">TMDB_ID</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 2 -->

                </ul>
                <!-- /. ul - API Usage examples -->

                <!-- h4 - Sub title : get with title & year -->
                <h4 class="font-size-16">
                    <i class="fa fa-text-width badge" aria-hidden="true"></i>&nbsp;
                    <?= sprintf( lang('API.with_title_label') ,
                        '<span class="text-muted">', '</span>',
                        '<span class="text-muted">', '</span>') ?>
                </h4>
                <!-- /. h4 - Sub title : get with title & year -->

                <!-- ul - API Usage examples -->
                <ul>
                    <li>
                        <code><?= site_url( embed_slug() ) ?>/series?title=<small class="text-muted">SERIES_TITLE</small>&year=<small class="text-muted">YEAR</small></code>
                    </li>
                </ul>
                <!-- /. ul - API Usage examples -->

            </div>
            <!-- /. Get TV Show Card -->

            <!-- Get Specific Episode Card -->
            <div class="card text-break mt-0">

                <!-- Card Title -->
                <div class="bg-dark-light px-10 py-5 mb-15 rounded">
                    <h2 class="card-title font-size-18 mb-0">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;
                        <?= sprintf( lang('API.get_episode_title') , '<span class="text-primary">', '</span>') ?> :
                    </h2>
                </div>
                <!-- /. Card Title -->

                <!-- h4 - Sub title : get with ids -->
                <h4 class="font-size-16">
                    <i class="fa fa-imdb badge" aria-hidden="true"></i>&nbsp;
                    <?= sprintf( lang('API.with_ids_label') ,
                        '<span class="text-muted">', '</span>',
                        '<span class="text-muted">', '</span>') ?>
                </h4>
                <!-- /. h4 - Sub title : get with ids -->

                <!-- ul - API Usage examples -->
                <ul class="mb-20">

                    <!--  li - method 1 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 1:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">EPISODE_IMDB_ID</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 1 -->

                    <!--  li - method 2 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 2:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">TV_SHOW_IMDB_ID</small>/<small class="text-muted">SEASON</small>/<small class="text-muted">EPISODE</small></code>
                            </li>
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/<small class="text-muted">TV_SHOW_TMDB_ID</small>/<small class="text-muted ">SEASON</small>/<small class="text-muted">EPISODE</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 2 -->

                    <!--  li - method 3 -->
                    <li> <span class="text-muted"><?= lang('API.method_txt') ?> 3:</span>
                        <ul style="list-style: none">
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-secondary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/series?imdb=<small class="text-muted">TV_SHOW_IMDB_ID</small>&sea=<small class="text-muted">SEASON</small>&epi=<small class="text-muted">EPISODE</small></code>
                            </li>
                            <li class="mb-5">
                                <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>&nbsp;
                                <code><?= site_url( embed_slug() ) ?>/series?tmdb=<small class="text-muted">TV_SHOW_TMDB_ID</small>&sea=<small class="text-muted">SEASON</small>&epi=<small class="text-muted">EPISODE</small></code>
                            </li>
                        </ul>
                    </li>
                    <!--  /. li - method 3 -->
                </ul>
                <!-- /. ul - API Usage examples -->

                <!-- h4 - Sub title : get with title & year -->
                <h4 class="font-size-16">
                    <i class="fa fa-text-width badge" aria-hidden="true"></i>&nbsp;
                    <?= sprintf( lang('API.with_title_label') ,
                        '<span class="text-muted">', '</span>',
                        '<span class="text-muted">', '</span>') ?>
                </h4>
                <!-- /. h4 - Sub title : get with title & year -->

                <!-- ul - API Usage examples -->
                <ul>
                    <li>
                        <code><?= site_url( embed_slug() ) ?>/series?title=<small class="text-muted">SERIES_TITLE</small>&year=<small class="text-muted">YEAR</small>&season=<small class="text-muted">SEASON</small>&episode=<small class="text-muted">EPISODE</small></code>
                    </li>
                </ul>
                <!-- /. ul - API Usage examples -->

            </div>
            <!-- /. Get Specific Episode Card -->

            <!-- Main Content Title  -->
            <div class="content my-15 ">
                <h2 class="content-title mt-5">
                    ⚡ <?= lang('API.download_api_title') ?>
                </h2>
            </div>
            <!-- /. Main Content Title  -->

            <div class="card text-break mt-0">
                <p class="mt-0">
                    <?php
                        $txt = sprintf( lang('API.download_api_hint') ,
                            '<span class="badge">', '</span>',
                            '<span class="badge">', '</span>');

                        $txt = str_replace('&embed_slug', embed_slug(), $txt);
                        $txt = str_replace('&download_slug', download_slug(), $txt);
                    ?>

                    <?= $txt ?> :
                </p>
                <p class="font-weight-semi-bold"><?= lang('API.example_txt') ?> :</p>
                <ul>
                    <li>
                        <b><?= lang('API.streaming_api_txt') ?>: </b>&nbsp;
                        <i><?= site_url( embed_slug() ) ?>/xxxx</i>
                    </li>
                    <li>
                        <b><?= lang('API.download_api_txt') ?>: </b>&nbsp;
                        <i><?= site_url( download_slug() ) ?>/xxxx</i>
                    </li>
                </ul>
            </div>
            <div class="content my-15 ">
                <hr>
                <h2 class="content-title mt-15">
                    😋 <?= lang('API.more_info_title') ?>
                </h2>

            </div>
            <div class="card text-break mt-0">
                <div>
                    <h6 class="text-muted font-weight-semi-bold mb-10 mt-0">
                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>&nbsp;
                        <?= lang('API.with_specific_server_label') ?>
                    </h6>
                    <div class="pl-15">
                        <p class="m-0">
                            <?php
                                $txt = sprintf(lang('API.with_specific_server_hint'),
                                '<span class="badge">', '</span>');
                                $txt = str_replace('&server', 'server', $txt);
                            ?>
                            <?= $txt ?>
                        </p>
                        <p class="font-weight-semi-bold"><?= lang('API.example_txt') ?>: </p>
                        <ul>
                            <li><?= site_url( embed_slug() ) ?>/xxxxx?<b>server=</b><small class="text-muted">dood.so</small> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card text-break mt-0">
                <div>
                    <h6 class="text-muted font-weight-semi-bold mb-10 mt-0">
                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>&nbsp;
                        <?= lang('API.status_check_label') ?>
                    </h6>
                    <div class="pl-15">
                        <p class="mt-0"> <?= lang('API.status_check_hint') ?> </p>
                        <ul>
                            <li>
                                <b>Movie</b> -
                                <?= site_url('/api/status') ?><b>?imdb=</b><small class="text-muted">IMDB_ID</small><b>&type=</b><small class="text-muted">movie</small>
                            </li>
                            <li>
                                <b>TV Shows</b>
                                <ul style="list-style: none" class="mt-0">
                                    <li ><?= site_url('/api/status') ?><b>?imdb=</b><small class="text-muted">TV_SHOW_IMDB_ID</small>&sea=<small class="text-muted">SEASON</small>&epi=<small class="text-muted">EPISODE</small><b>&type=</b><small class="text-muted">movie</small></li>
                                </ul>
                            </li>
                        </ul>

                        <?php if(! empty( get_config('api_status_check_rate_limit') )): ?>
                        <small>
                            <span class="text-danger">*</span>
                            <?= lang('API.rate_limit_hint') ?>: <?= get_config('api_status_check_rate_limit') ?>
                        </small> <br>
                            <small>
                                <span class="text-danger">*</span>
                                <?= lang('API.required_params_hint') ?>
                            </small>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>


    </div>



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