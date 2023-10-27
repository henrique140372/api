<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col-lg-9">

        <?= form_open('/admin/settings/permalinks/update', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>


        <div class="x_panel">
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3">Default permalink type of embed page</label>
                    <div class="col-md-9">
                        <div class="checkbox d-inline-block mt-2 mr-3">
                            <label>
                                <?= form_radio('default_embed_slug_type','general_id', empty(get_config('default_embed_slug_type')) || get_config('default_embed_slug_type') == 'general_id') ?>
                                General Id
                            </label>
                        </div>
                        <div class="checkbox d-inline-block mt-2 mr-3">
                            <label>
                                <?= form_radio('default_embed_slug_type','imdb', get_config('default_embed_slug_type') == 'imdb') ?>
                             Imdb Id
                            </label>
                        </div>
                        <div class="checkbox d-inline-block  mt-2 mr-3">
                            <label>
                                <?= form_radio('default_embed_slug_type','tmdb', get_config('default_embed_slug_type') == 'tmdb') ?>
                               Tmdb Id
                            </label>
                        </div>
                        <br>
                        <small> Ex: <i> https://mysite.com/embed?imdb=tt000001 </i> </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Default permalink type of view page</label>
                    <div class="col-md-9">
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','general_id_short',   get_config('default_movies_permalink_type') == 'general_id_short') ?>
                                <b>General Id short</b> : <?= site_url('/' . view_slug() . '/00') ?>
                            </label>
                        </div>
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','general_id_long',   empty(get_config('default_movies_permalink_type')) || get_config('default_movies_permalink_type') == 'general_id_long') ?>
                                <b>General Id long</b> : <?= site_url('/' . view_slug() . '?id=00') ?>
                            </label>
                        </div>
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','imdb_short',  get_config('default_movies_permalink_type') == 'imdb_short') ?>
                                <b>Imdb short</b> : <?= site_url('/' . view_slug() . '/tt000000') ?>
                            </label>
                        </div>
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','imdb_long',  get_config('default_movies_permalink_type') == 'imdb_long') ?>
                                <b>Imdb long</b> : <?= site_url('/' . view_slug() . '?imdb=tt000000') ?>
                            </label>
                        </div>
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','tmdb_short',  get_config('default_movies_permalink_type') == 'tmdb_short') ?>
                                <b>Tmdb short</b> : <?= site_url('/' . view_slug() . '/000000') ?>
                            </label>
                        </div>
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','tmdb_long',  get_config('default_movies_permalink_type') == 'tmdb_long') ?>
                                <b>Tmdb long</b> : <?= site_url('/' . view_slug() . '?tmdb=000000') ?>
                            </label>
                        </div>
                        <div class="checkbox d-block mt-2">
                            <label>
                                <?= form_radio('default_movies_permalink_type','custom_dynamic',  get_config('default_movies_permalink_type') == 'custom_dynamic') ?>
                                <b>Custom Dynamic</b> : <?= site_url('/' . view_slug() . '/xxxxxx') ?>
                            </label>

                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Custom dynamic permalink patterns</label>
                    <div class="col-md-9">
                        <div class=" mt-2">
                            <p class="mb-1 text-muted">For movies : </p>
                            <?= form_input([
                                'class' => 'form-control form-control-sm w-100',
                                'placeholder' => 'Watch-{ MV_TITLE }-{ YEAR }',
                                'name' => 'movie_permalink_pattern',
                                'value' => old('movie_permalink_pattern', get_config('movie_permalink_pattern'))
                            ]) ?>
                        </div>
                        <div class=" mt-2">
                            <p class="mb-1 text-muted">For parent TV shows : </p>
                            <?= form_input([
                                'class' => 'form-control form-control-sm w-100',
                                'placeholder' => 'Watch-{ TV_TITLE }-{ YEAR }',
                                'name' => 'series_permalink_pattern',
                                'value' => old('series_permalink_pattern', get_config('series_permalink_pattern'))
                            ]) ?>
                        </div>
                        <div class=" mt-2">
                            <p class="mb-1 text-muted">For episodes : </p>
                            <?= form_input([
                                'class' => 'form-control form-control-sm w-100',
                                'placeholder' => 'Watch-{ TV_TITLE }-season-{ SEASON }-episode-{ EPISODE }',
                                'name' => 'episode_permalink_pattern',
                                'value' => old('episode_permalink_pattern', get_config('episode_permalink_pattern'))
                            ]) ?>
                        </div>


                    </div>



                </div>

                <p> <b> <u>Supported variables</u> </b> </p>
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <span class="badge badge-dark font-weight-bold">MV_TITLE</span>
                            -
                            Title of movie
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">MV_IMDB</span>
                            -
                            IMDB Id of movie
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">MV_TMDB</span>
                            -
                            TMDB Id of movie
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">YEAR</span>
                            -
                            Released year of movie or Tv show
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">TV_TITLE</span>
                            -
                           Title of TV show
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">TV_IMDB</span>
                            -
                            IMDB Id of TV show
                        </p>

                    </div>
                    <div class="col-lg-6">
                        <p>
                            <span class="badge badge-dark font-weight-bold">TV_TMDB</span>
                            -
                            TMDB Id of TV show
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">EP_TITLE</span>
                            -
                            Title of episode
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">EP_IMDB</span>
                            -
                            IMDB Id of episode
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">EP_TMDB</span>
                            -
                            TMDB Id of episode
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">SEASON</span>
                            -
                            Season number of episode
                        </p>
                        <p>
                            <span class="badge badge-dark font-weight-bold">EPISODE</span>
                            -
                            Episode number of episode
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Main pages slugs</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3">View Slug</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'view_slug',
                            'class' => 'form-control',
                            'value' => get_config('view_slug'),
                            'placeholder' => 'view'
                        ]) ?>
                        <small>Default: <i>view</i></small> <br>
                        <small>Page: <i>https://mysite.com/view/xxx</i></small>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Embed Slug</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'embed_slug',
                            'class' => 'form-control',
                            'value' => get_config('embed_slug'),
                            'placeholder' => 'embed'
                        ]) ?>
                        <small>Default: <i>embed</i></small> <br>
                        <small>Page: <i>https://mysite.com/embed/xxx</i></small>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Download Slug</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'download_slug',
                            'class' => 'form-control',
                            'value' => get_config('download_slug'),
                            'placeholder' => 'download'
                        ]) ?>
                        <small>Default: <i>download</i></small> <br>
                        <small>Page: <i>https://mysite.com/download/xxx</i></small>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Link Slug</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'link_slug',
                            'class' => 'form-control',
                            'value' => get_config('link_slug'),
                            'placeholder' => 'link'
                        ]) ?>
                        <small>Default: <i>link</i></small> <br>
                        <small>Page: <i>https://mysite.com/link/xxx</i></small>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Library Slug</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'library_slug',
                            'class' => 'form-control',
                            'value' => get_config('library_slug'),
                            'placeholder' => 'library'
                        ]) ?>
                        <small>Default: <i>library</i></small> <br>
                        <small>Page: <i>https://mysite.com/library/xxx</i></small>

                    </div>
                </div>

            </div>
        </div>


        <div class="text-right">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ], 'update') ?>
        </div>

        <?= form_close() ?>

    </div>
</div>

<?php $this->endSection() ?>
