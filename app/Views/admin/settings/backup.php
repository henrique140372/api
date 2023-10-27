<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col-lg-9">

        <?= form_open('/admin/settings/backup/get', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>Database backup</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">Last backup at : </label>
                    <div class="col-md-9">
                        <label for=""> <?= ! empty(get_last_db_backup_date()) ? get_last_db_backup_date() : '--' ?>  </label>
                    </div>
                </div>


                <div class="text-right">
                    <?= form_button([
                        'type' => 'submit',
                        'class' => 'btn btn-sm btn-warning text-dark'
                    ], 'Get Backup of Database') ?>
                </div>



            </div>
        </div>

        <?= form_close() ?>

    </div>
</div>

<?php $this->endSection() ?>
