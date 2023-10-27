<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?= form_open('/admin/rewards/update_gen_rewards', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>

<div class="row">
    <div class="col-lg-6">

        <?= $this->include('admin/rewards/form_x_panels/for_movies.php') ?>


    </div>

    <div class="col-lg-6">

        <?= $this->include('admin/rewards/form_x_panels/for_tv_shows.php') ?>


    </div>

</div>


<div class="text-right">
    <?= form_button([
        'type' => 'submit',
        'class' => 'btn px-5 btn-primary'
    ], 'save') ?>
</div>

<?= form_close() ?>



<?php $this->endSection() ?>
