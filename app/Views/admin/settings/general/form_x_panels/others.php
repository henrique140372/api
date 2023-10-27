<div class="x_panel">
    <div class="x_title">
        <h2>Others</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group row">
            <label class="control-label col-md-3">Timezone</label>
            <div class="col-md-9">
                <?= form_dropdown([
                        'options' => array_combine_val_to_keys(get_all_timezones()),
                        'name' => 'timezone',
                        'class' => 'form-control',
                        'selected' => date_default_timezone_get()
                ]) ?>
                <small class="form-text">Select your current timezone</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Currency code</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'currency_code',
                    'class' => 'form-control',
                    'placeholder' => 'USD',
                    'value' => get_currency_code()
                ]) ?>
            </div>
        </div>









        <div class="form-group row">
            <label class="control-label col-md-3">Links Report</label>
            <div class="col-md-9">
                <div class="checkbox  mt-2">
                    <label>
                        <?= form_checkbox('is_links_report','', get_config('is_links_report')) ?>
                        Enable/ Disable
                    </label>
                </div>
            </div>
        </div>



        <div class="form-group row">
            <label class="control-label col-md-3">Views Analytics System</label>
            <div class="col-md-9">
                <div class="checkbox  mt-2">
                    <label>
                        <?= form_checkbox('views_anlytc_system','', get_config('views_anlytc_system')) ?>
                        Enable/ Disable
                    </label>
                </div>
                <small class="form-text">If you disable this option, we do not store visitors' information</small>
            </div>
        </div>

        <div class="text-right">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ], 'update') ?>
        </div>



    </div>
</div>