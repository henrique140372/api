<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?= form_open('/admin/users/update/'  . $user->id, [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>

<div class="row">
    <div class="col-lg-8">

        <?= $this->include('admin/users/form_x_panels/general.php') ?>
        <?= $this->include('admin/users/form_x_panels/change_passwd.php') ?>

        <div class="text-right">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn px-5 btn-primary'
            ], 'save') ?>
        </div>

    </div>

    <div class="col-lg-4">

        <?= $this->include('admin/users/form_x_panels/status.php') ?>
        <?= $this->include('admin/users/form_x_panels/role.php') ?>
        <?= $this->include('admin/users/form_x_panels/logs.php') ?>
        <?= $this->include('admin/users/form_x_panels/meta_info.php') ?>

    </div>

</div>

<?= form_close() ?>

<?php $this->endSection() ?>
