<?=$this->extend(theme_path('__layout/base')) ?>

<?=$this->section("content") ?>

<div class="container-fluid">

    <!-- leaderboard ad-->
    <?php if (has_display_banner_ad('home.banner.top', $ads)) {
        echo display_banner_ad('home.banner.top', $ads);
    } ?>
    <!-- /. leaderboard ad -->

    <!-- Quick embed form -->
    <div class="card p-0">
        <div class="row row-eq-spacing p-0 my-15">
            <div class="col-lg-7">

                <?php if (!empty($activeMovie)) {
                    the_embed_player($activeMovie);
                }else {
                    echo 'script not ready yet';
                } ?>

                <!-- leaderboard ad-->
                <?php if ( has_display_banner_ad('home.banner.player-bottom', $ads) )
                {
                    echo display_banner_ad('home.banner.player-bottom', $ads);
                } ?>

            </div>
            <div class="col-lg-5">


                <div id="quick-embed" class="mt-15">

                    <div class="content my-0 text-right">
                        <?= lang('EmbedForm.finding_label') ?> :
                        <div class="dropdown selection with-arrow ml-10">
                            <button class="btn " data-toggle="dropdown" type="button">
                                <?= lang('EmbedForm.tab_select_with_ids') ?>
                                <i class="fa fa-angle-down ml-5" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-toggle-btn-2">
                                <a href="javascript:void(0)" data-type="by_uniq_id" onclick="QuickEmbed.toggle(this)" class="dropdown-item">
                                    <?= lang('EmbedForm.tab_select_with_ids') ?>
                                </a>
                                <a href="javascript:void(0)" data-type="by_title"  onclick="QuickEmbed.toggle(this)" class="dropdown-item">
                                    <?= lang('EmbedForm.tab_select_with_title') ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mx-0 mt-5 text-break border-0">

                        <!-- Tabs Button group -->
                        <div class="tabs p-5 bg-dark-light font-weight-semi-bold  mb-15">
                            <a href="javascript:void(0)" class="btn d-inline-block" data-target="ids-movie-content">
                                <i class="fa fa-film" aria-hidden="true"></i>&nbsp;
                                <?= lang('EmbedForm.tabs.movie_label') ?>
                            </a>
                            <a href="javascript:void(0)" class="nav-link d-inline-block" data-target="ids-show-content">
                                <i class="fa fa-television" aria-hidden="true"></i>&nbsp;
                                <?= lang('EmbedForm.tabs.series_label') ?>
                            </a>
                            <a href="javascript:void(0)" class="nav-link d-none d-sm-inline-block" data-target="ids-api-content">
                                <i class="fa fa-magic" aria-hidden="true"></i>&nbsp;
                                <?= lang('EmbedForm.tabs.api_label') ?>
                            </a>
                        </div>

                        <!--  Movies Tab Content -->
                        <div class="tab-content active" id="ids-movie-content">

                            <!--  Tab Content: find by tmdb or imdb ids -->
                            <div class="find-by-uniq-id">
                                <h3 class="card-title ">
                                    <?= sprintf( lang('EmbedForm.ids_tab_content.movie.title') , '<span class="text-primary">', '</span>', '<span class="text-primary">', '</span>') ?> :
                                </h3>
                                <div class="form-group">
                                    <label for="username" class="required">
                                        <?= lang('EmbedForm.ids_tab_content.movie.form.input_imdb.label') ?>
                                    </label>
                                    <input type="text" class="form-control movie-uniq-id" placeholder="<?=lang('EmbedForm.ids_tab_content.movie.form.input_imdb.placeholder') ?>">
                                </div>
                            </div>
                            <!--  /. Tab Content: find by tmdb or imdb ids -->

                            <!--  Tab Content: find by title -->
                            <div class="find-by-title" style="display: none">
                                <h3 class="card-title ">
                                    <?= sprintf( lang('EmbedForm.title_tab_content.movie.title') ,
                                        '<span class="text-primary">', '</span>',
                                        '<span class="text-primary">', '</span>') ?> :
                                </h3>
                                <div class="form-group mb-15">
                                    <label  class="required">
                                        <?= lang('EmbedForm.title_tab_content.movie.form.input_title.label') ?>
                                    </label>
                                    <input type="text" class="form-control movie-title" placeholder="<?=lang('EmbedForm.title_tab_content.movie.form.input_title.placeholder') ?>" >
                                </div>
                                <div class="form-group text-right">
                                    <label class="d-inline-block">
                                        <?= lang('EmbedForm.title_tab_content.movie.form.input_year.label') ?>
                                        : </label>
                                    <input type="number" class="form-control d-inline-block movie-year w-100" placeholder="<?=lang('EmbedForm.title_tab_content.movie.form.input_year.placeholder') ?>">
                                </div>
                            </div>
                            <!--  /. Tab Content: find by title -->

                            <input class="btn btn-primary btn-block" onclick="QuickEmbed.getMovie()" type="button" value="<?=lang('EmbedForm.ids_tab_content.movie.form.submit_btn_txt') ?>">

                        </div>
                        <!--  /. Movies Tab Content -->

                        <!--  TV Shows Tab Content -->
                        <div class="tab-content" id="ids-show-content">

                            <!--  Tab Content: find by tmdb or imdb ids -->
                            <div class="find-by-uniq-id">
                                <h3 class="card-title ">
                                    <?=sprintf( lang('EmbedForm.ids_tab_content.series.title') , '<span class="text-primary">', '</span>', '<span class="text-primary">', '</span>')
                                    ?> :
                                </h3>

                                <div class="form-group">
                                    <label  class="required">
                                        <?=lang('EmbedForm.ids_tab_content.series.form.input_imdb.label') ?>
                                    </label>
                                    <input type="text" class="form-control series-uniq-id" placeholder="<?=lang('EmbedForm.ids_tab_content.series.form.input_imdb.placeholder') ?>">
                                </div>
                            </div>
                            <!--  /. Tab Content: find by tmdb or imdb ids -->

                            <!--  Tab Content: find by title -->
                            <div class="find-by-title" style="display: none">
                                <h3 class="card-title ">
                                    <?=sprintf( lang('EmbedForm.title_tab_content.series.title') , '<span class="text-primary">', '</span>', '<span class="text-primary">', '</span>')
                                    ?> :
                                </h3>
                                <div class="form-group mb-15">
                                    <?=lang('EmbedForm.title_tab_content.series.form.input_title.label') ?>
                                    <input type="text" class="form-control series-title" placeholder="<?=lang('EmbedForm.title_tab_content.series.form.input_title.placeholder') ?>">
                                </div>
                                <div class="form-group text-right">
                                    <label class="d-inline-block">
                                        <?=lang('EmbedForm.title_tab_content.series.form.input_year.label') ?>
                                        : </label>
                                    <input type="number" class="form-control d-inline-block series-year w-100" placeholder="<?= lang('EmbedForm.title_tab_content.series.form.input_year.placeholder') ?>">
                                </div>
                            </div>
                            <!--  /. Tab Content: find by title -->

                            <div class="dropdown-divider mb-15"></div>

                            <!--  Tab Content: season and episode -->
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mr-15">
                                        <label>
                                            <?=lang('EmbedForm.ids_tab_content.series.form.input_season.label') ?>
                                        </label>
                                        <input type="number"  min="1" class="form-control season" placeholder="<?= lang('EmbedForm.ids_tab_content.series.form.input_season.placeholder') ?>" required="required">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>
                                            <?=lang('EmbedForm.ids_tab_content.series.form.input_episode.label') ?>
                                        </label>
                                        <input type="number" min="1" class="form-control episode" placeholder="<?= lang('EmbedForm.ids_tab_content.series.form.input_episode.placeholder') ?>" required="required">
                                    </div>
                                </div>
                            </div>
                            <!--  /. Tab Content: season and episode -->

                            <input class="btn btn-primary btn-block" onclick="QuickEmbed.getEpisode()" type="button" value="<?= lang('EmbedForm.ids_tab_content.series.form.submit_btn_txt') ?>">

                        </div>
                        <!--  /. TV Shows Tab Content -->

                        <!--  APIs Tab Content -->
                        <div class="tab-content " id="ids-api-content">

                            <!--  Tab Content: find by tmdb or imdb ids -->
                            <div class="find-by-uniq-id">
                                <h3 class="card-title mb-0">
                                    <?= sprintf(lang('EmbedForm.api_tab_content.movie_title') , '<span class="text-primary">', '</span>') ?> :
                                </h3>

                                <p class="mt-10"> <?= site_url(embed_slug()) ?>/IMDB_ID_or_TMDB_ID </p>

                                <h3 class="card-title mb-0">
                                    <?= sprintf(lang('EmbedForm.api_tab_content.series_title') , '<span class="text-primary">', '</span>') ?> :
                                </h3>

                                <p class="mt-10"><?= site_url(embed_slug()) ?>/IMDB_ID_or_TMDB_ID</p>

                            </div>
                            <!--  /. Tab Content: find by tmdb or imdb ids -->

                            <!--  Tab Content: find by title -->
                            <div class="find-by-title" style="display: none">
                                <h3 class="card-title mb-0">
                                    <?= sprintf(lang('EmbedForm.api_tab_content.movie_title') , '<span class="text-primary">', '</span>') ?> :
                                </h3>
                                <p class="mt-10"><?= site_url(embed_slug()) ?>/movie?title=TITLE&year=YEAR

                                </p>

                                <h3 class="card-title mb-0">
                                    <?= sprintf(lang('EmbedForm.api_tab_content.series_title') , '<span class="text-primary">', '</span>') ?> :
                                </h3>

                                <p class="mt-10">
                                    <?= site_url(embed_slug()) ?>/series??title=TITLE&year=YEAR
                                </p>
                            </div>
                            <!--  /. Tab Content: find by title -->

                            <a href="<?= site_url('/api') ?>" class="font-weight-semi-bold">
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;
                                <?= lang('EmbedForm.api_tab_content.learn_more_btn_txt') ?>
                            </a>

                        </div>
                        <!--  /. APIs Tab Content -->

                    </div>


                </div>

                <!-- 300x300 ad-->
                <?php if ( has_display_banner_ad('home.banner.player-right', $ads) ) {
                    echo display_banner_ad('home.banner.player-right', $ads, 300);
                } ?>

            </div>
        </div>
        <span class="qe-version text-muted">
            <?= lang('EmbedForm.form_version') ?> v1.1
        </span>
    </div>
    <!-- /. Quick embed form -->

    <!-- Trending movies widget -->
    <?php if (! empty($trendingMovies)): ?>

        <div class="row row-eq-spacing align-items-center my-15 pt-15 pb-5">
            <div class="col-auto">
                <div class="content">
                    <h1 class="content-title mb-0 mr-10">
                        <i class="fa fa-fire text-danger mr-5" aria-hidden="true"></i>
                        <?= lang('Home.trending_widget_title') ?>
                    </h1>
                </div>
            </div>
            <div class="col text-right">
                <div class="content my-0">
                    <div class="tabs  bg-dark-light font-weight-semi-bold m-0 d-inline-block">
                        <a href="javascript:void(0)" class="d-inline-block btn" data-target="trending-movies-content">
                            <i class="fa fa-film" aria-hidden="true"></i>&nbsp;
                            <?= lang('General.movies') ?>
                        </a>
                        <a href="javascript:void(0)" class="d-inline-block nav-link" data-target="trending-shows-content">
                            <i class="fa fa-television" aria-hidden="true"></i>&nbsp;
                            <?= lang('General.tv_shows') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content active" id="trending-movies-content">

            <div class="row row-eq-spacing mx-10 mt-0" >
                <?php foreach ($trendingMovies as $movie): ?>
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 px-5">
                        <?php the_movie_item( $movie ); ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <?php if (! empty($trendingShows)): ?>
        <div class="tab-content" id="trending-shows-content">

            <div class="row row-eq-spacing mx-10 mt-0" >
                <?php foreach ($trendingShows as $show): ?>
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 px-5">
                        <?php the_movie_item( $show ); ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <?php endif; ?>

    <?php endif; ?>
    <!-- /. Trending movies widget -->



    <!-- Latest movies widget -->
    <?php if (! empty($latestMovies)): ?>

        <div class="row row-eq-spacing align-items-center mb-15">
            <div class="col-auto">
                <div class="content mt-15">
                    <h1 class="content-title mb-0">
                        <i class="fa fa-history text-muted" aria-hidden="true"></i>&nbsp;
                        <?= lang('Home.latest_widget_title') ?>
                    </h1>
                </div>
            </div>
            <div class="col text-right">
                <div class="content my-0">
                    <div class="tabs  bg-dark-light font-weight-semi-bold m-0 d-inline-block">
                        <a href="javascript:void(0)" class="d-inline-block btn" data-target="latest-movies-content">
                            <i class="fa fa-film" aria-hidden="true"></i>&nbsp;
                            <?= lang('General.movies') ?>
                        </a>
                        <a href="javascript:void(0)" class="d-inline-block nav-link" data-target="latest-shows-content">
                            <i class="fa fa-television" aria-hidden="true"></i>&nbsp;
                            <?= lang('General.tv_shows') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <div class="tab-content active" id="latest-movies-content">
        <div class="row row-eq-spacing mx-10 mt-0">
            <?php foreach ($latestMovies as $movie): ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 px-5">
                    <?php the_movie_item($movie); ?>
                </div>
            <?php
            endforeach; ?>
        </div>
    </div>
    <?php if (! empty($latestShows)): ?>

        <div class="tab-content" id="latest-shows-content">
            <div class="row row-eq-spacing mx-10 mt-0">

                <?php foreach ($latestShows as $movie): ?>
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 px-5">
                        <?php the_movie_item($movie); ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <?php endif; ?>
    <?php endif; ?>
    <!-- /. Latest movies widget -->

</div>


<?=$this->endSection() ?>
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