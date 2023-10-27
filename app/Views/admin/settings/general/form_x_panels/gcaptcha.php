<div class="x_panel">
    <div class="x_title">
        <h2>Google Invisible Captcha </h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">


<p>
    Stops bots and other automated attacks while approving valid users
</p>

        <div class="form-group row">
            <label class="control-label col-md-3">Site key </label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'gcaptcha_site_key',
                    'class' => 'form-control',
                    'value' => get_config('gcaptcha_site_key')
                ]) ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Secret key</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'gcaptcha_secret_key',
                    'class' => 'form-control',
                    'value' => get_config('gcaptcha_secret_key')
                ]) ?>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label class="control-label col-md-3 mb-0 pt-0">In 'embed' page</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label class="mb-0">
                        <?= form_checkbox('is_stream_gcaptcha_enabled','', get_config('is_stream_gcaptcha_enabled')) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small>protect stream links in embed player with gcaptcha</small>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label class="control-label col-md-3 mb-0 pt-0">In 'register' page</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label class="mb-0">
                        <?= form_checkbox('is_register_gcaptcha_enabled','', is_register_gcaptcha_enabled()) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small>protect registration form with gcaptcha</small>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label class="control-label col-md-3 mb-0 pt-0">In 'login' page</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label class="mb-0">
                        <?= form_checkbox('is_login_gcaptcha_enabled','', is_login_gcaptcha_enabled()) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small>protect login form with gcaptcha</small>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label class="control-label col-md-3 mb-0 pt-0">In 'contact' page</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label class="mb-0">
                        <?= form_checkbox('is_contact_form_gcaptcha','', is_contact_gcaptcha_enabled()) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small>protect contact form with gcaptcha</small>
            </div>
        </div>


    </div>
</div>