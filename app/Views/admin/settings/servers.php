<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col-lg-9">

        <?= form_open('/admin/settings/servers/update', ['method'=>'post']) ?>


        <div class="x_panel">
            <div class="x_content">
                <div class="form-group row">
                    <label class="control-label col-md-5">Anonymous stream server names</label>
                    <div class="col-md-7">
                        <div class="checkbox">
                            <label>
                                <?= form_checkbox('is_use_anonymous_stream_server','', get_config('is_use_anonymous_stream_server')) ?>
                                Enable/ Disable
                            </label>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="control-label col-md-5">Base name of anonymous stream servers</label>
                    <div class="col-md-7">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'anonymous_stream_server_name',
                            'class' => 'form-control',
                            'value' => get_config('anonymous_stream_server_name')
                        ]) ?>
                        <small>Default: <i>server</i> </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="x_panel">
            <div class="x_content">


                <?php if(! empty($servers)): ?>



                <div class="form-group row">
                    <label class="control-label col-md-3">Default Server</label>
                    <div class="col-md-9">

                       <?= form_dropdown([
                               'name' => 'default_server',
                                'class' => 'form-control',
                                'options' => $serverOptions,
                                'selected' => get_config('default_server')
                       ]) ?>

                        <small>Default or main server for streaming</small>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Rename Servers</label>
                    <div class="col-md-9">

                        <?php foreach ($servers as $key => $val) : ?>
                        <div class="input-group">
                            <?= form_input([
                                    'class' => 'form-control',
                                    'value' => $key,
                                    'disabled' => 'disabled'
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text">@</span>
                            </div>
                            <?= form_input([
                                'name' => "renamed_servers[$key]",
                                'class' => 'form-control',
                                'value' => $val
                            ]) ?>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="text-right">
                    <?= form_button([
                        'type' => 'submit',
                        'class' => 'btn btn-primary'
                    ], 'update') ?>
                </div>

                <?php else: ?>
                     servers not found yet
                <?php endif; ?>



            </div>
        </div>

        <?= form_close() ?>

    </div>
</div>

<?php $this->endSection() ?>
