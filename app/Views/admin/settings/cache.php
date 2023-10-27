<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col-lg-9">

        <?= form_open('/admin/settings/cache/update', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>Web pages <small>( Speed up your site 2x )</small> </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3">Web pages cache</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('web_page_cache','', get_config('web_page_cache')) ?>
                                Enable/ Disable
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Cache duration</label>
                    <div class="col-md-9">

                        <div class="input-group mb-0">
                            <?= form_input([
                                'type' => 'number',
                                'name' => 'web_page_cache_duration',
                                'class' => 'form-control',
                                'value' => get_config('web_page_cache_duration'),
                                'min' => 300
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text" >seconds</span>
                            </div>
                        </div>
                        <small>Min: 60, &nbsp;&nbsp;default: 86400 (1 day)</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">Select pages:</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[home]','1', is_page_cached_enabled('home')) ?>
                                Home page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[embed]','1', is_page_cached_enabled('embed')) ?>
                                Embed page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[view]','1', is_page_cached_enabled('view')) ?>
                                View page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[download]','1', is_page_cached_enabled('download')) ?>
                                Download page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[library]','1', is_page_cached_enabled('library')) ?>
                                Library page
                            </label>
                        </div>

                        <hr>

                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[earn_money]','1', is_page_cached_enabled('earn_money')) ?>
                                Earn money page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[api]','1', is_page_cached_enabled('api')) ?>
                                API  page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[contact_us]','1', is_page_cached_enabled('contact_us')) ?>
                                Contact us page
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[trending_list]','1', is_page_cached_enabled('trending_list')) ?>
                                Trending list pages
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[recommend_list]','1', is_page_cached_enabled('recommend_list')) ?>
                                Recommended list pages
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[recent_list]','1', is_page_cached_enabled('recent_list')) ?>
                                Recent released list pages
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('cached_pages[imdb_top_list]','1', is_page_cached_enabled('imdb_top_list')) ?>
                                Imdb top list pages
                            </label>
                        </div>

                    </div>
                </div>

                <p class="font-weight-bold">
                    <span class="text-danger">NOTE: </span>
                    If you are using users reward system, disable cache in all pages except
                    <i>"embed"</i>, <i>"earn-money"</i>, <i>"api"</i> <br> and <i>"contact us"</i>
                    pages
                </p>


                <div class="text-right">
                    <?= form_button([
                        'type' => 'submit',
                        'class' => 'btn btn-primary'
                    ], 'update') ?>
                </div>



            </div>
        </div>


        <?= form_close() ?>

    </div>
</div>

<?php $this->endSection() ?>
