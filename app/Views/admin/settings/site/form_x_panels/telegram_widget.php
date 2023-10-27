<div class="x_panel">
    <div class="x_title">
        <h2>Telegram Widget</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group row mt-4">
            <label class="control-label col-md-3 pt-0">Telegram widget in 'view' page</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label>
                        <?= form_checkbox('is_telegram_card_enabled','1', get_config('is_telegram_card_enabled')) ?>
                        Enable/ Disable
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Telegram username</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'telegram_username',
                    'class' => 'form-control',
                    'value' => get_config('telegram_username')
                ]) ?>
            </div>
        </div>
        </div>
        </div>