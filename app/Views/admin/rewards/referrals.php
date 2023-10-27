<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>


<div class="x_panel">
    <div class="x_content">
        <div class="x_title">
            <h2>Special Rewards</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Stars</th>
                <th>Countries</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($rewards as $reward) : ?>

            <tr>
                <td> <?= $reward->id ?> </td>
                <td> <?= esc( $reward->name ) ?> </td>
                <td> <?= nf( $reward->stars_per_view ) ?> </td>
                <td> <?= implode(', ', $reward->countries) ?> </td>
                <td>
                    <a href="<?= site_url('/admin/rewards/ref_reward/' . $reward->id) ?>" class="text-info mr-3">Edit</a>
                    <a href="<?= site_url('/admin/rewards/del_ref_reward/' . $reward->id) ?>" class="text-danger">Del</a>
                </td>
            </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2>Default Reward</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?= form_open('/admin/rewards/update_gen_rewards') ?>

        <div class="form-group row">
            <label class="control-label col-md-4 col-lg-3">Default reward ( stars ) per view : </label>
            <div class="col-md-4">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'default_ref_reward',
                    'class' => 'form-control',
                    'value' => get_config('default_ref_reward')
                ]) ?>
            </div>
            <div class="col-lg-4">
                <button class="btn btn-primary">Update</button>
            </div>
        </div>

        <?= form_close() ?>

    </div>
</div>




<?php $this->endSection() ?>
