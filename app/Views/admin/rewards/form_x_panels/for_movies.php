<div class="x_panel">
    <div class="x_title">
        <h2>For Movies</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for new movie: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_new_movie',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_new_movie')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for movie streaming link: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_movie_stream_link',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_movie_stream_link')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for movie direct link: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_movie_direct_link',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_movie_direct_link')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for movie torrent link: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_movie_torrent_link',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_movie_torrent_link')
                ]) ?>
            </div>
        </div>

    </div>
</div>