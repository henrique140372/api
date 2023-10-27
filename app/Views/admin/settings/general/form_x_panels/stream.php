<div class="x_panel">
    <div class="x_title">
        <h2>Stream Links</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group row">
            <label class="control-label col-md-3">Links groups</label>
            <div class="col-md-9">
                <?= form_textarea([
                    'name' => 'stream_types',
                    'class' => 'form-control',
                    'rows' => 2
                ], implode(', ', get_config('stream_types'))) ?>
                <small>Separate each stream type by comma. <br> Ex: Dubbed , Subtitled  , Audio 1, Audio 2 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Stream Quality Formats</label>
            <div class="col-md-9">
                <?= form_textarea([
                    'name' => 'stream_quality_formats',
                    'class' => 'form-control',
                    'rows' => 2
                ], implode(', ', get_config('stream_quality_formats'))) ?>
                <small>Separate each resolution format by comma. <br> Ex: HD , SD , CAM </small>
            </div>
        </div>




    </div>
</div>