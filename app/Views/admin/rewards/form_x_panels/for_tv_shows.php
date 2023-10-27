<div class="x_panel">
    <div class="x_title">
        <h2>For TV Shows</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for new series: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_new_series',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_new_series')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for new episode: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_new_episode',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_new_episode')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for episode streaming link: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_episode_stream_link',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_episode_stream_link')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for episode direct link: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_episode_direct_link',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_episode_direct_link')
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-7">Stars for episode torrent link: </label>
            <div class="col-md-5">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'stars_for_episode_torrent_link',
                    'class' => 'form-control',
                    'value' => get_config('stars_for_episode_torrent_link')
                ]) ?>
            </div>
        </div>

    </div>
</div>