<div class="x_panel">
    <div class="x_title">
        <h2>SEO</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group row">
            <label class="control-label pt-0">Default Keywords : </label>
            <?= form_textarea([
                'name' => 'default_keywords',
                'class' => 'form-control',
                'placeholder' => 'keyword 1, keyword 2',
                'rows' => 4
            ], get_config('default_keywords')) ?>
            <small class="form-text"> separate each keyword by comma </small>
        </div>

        <div class="form-group row">
            <label class="control-label pt-0">Blacklisted Keywords : </label>
            <?= form_textarea([
                'name' => 'blacklisted_keywords',
                'class' => 'form-control',
                'placeholder' => 'keyword 1, keyword 2',
                'rows' => 4
            ], get_config('blacklisted_keywords')) ?>
            <small class="form-text"> separate each keyword by comma </small>
        </div>

        <div class="form-group row mt-4">
            <label class="control-label col-md-3 pt-0">Keywords from title</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label>
                        <?= form_checkbox('keywords_from_title','1', get_config('keywords_from_title')) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small>If you enabled this option, we will dynamically generate keywords from the movie title</small>
            </div>
        </div>

        <div class="form-group row mt-4">
            <label class="control-label col-md-3 pt-0">Movies description as meta desc.</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label>
                        <?= form_checkbox('movie_desc_as_meta','1', get_config('movie_desc_as_meta')) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small>If meta description is empty, use movie short description as that</small>
            </div>
        </div>



    </div>
</div>