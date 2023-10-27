<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?= form_open('/admin/users/create', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>


<div class="row">
    <div class="col-lg-8">

        <?= $this->include('admin/users/form_x_panels/general.php') ?>
        <?= $this->include('admin/users/form_x_panels/create_passwd.php') ?>



    </div>

    <div class="col-lg-4">

        <?= $this->include('admin/users/form_x_panels/meta_info.php') ?>

        <div class="text-right">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-block btn-primary'
            ], 'save') ?>
        </div>

    </div>

</div>

<?= form_close() ?>

<?php $this->endSection() ?>
