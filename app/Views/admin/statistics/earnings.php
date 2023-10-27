<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?php if(! empty($user)): ?>
    <div class="x_panel">
        <div class="x_content d-flex align-items-center justify-content-between">
            <h2>User : <b><?= esc( $user->username ) ?></b> </h2>
            <a href="<?= admin_url('/users/edit/' . $user->id) ?>" class="btn btn-sm btn-secondary">Back to user</a>
        </div>
    </div>
<?php endif; ?>

<div class="row" style="display: inline-block;width: 100%;">
    <div class="top_tiles">
        <?= $this->include('admin/statistics/x_panel/earnings/top_tiles') ?>
    </div>
</div>

<?= $this->include('admin/statistics/x_panel/earnings/monthly_earnings.php') ?>
<?= $this->include('admin/statistics/x_panel/earnings/earnings_summary.php') ?>
<?= $this->include('admin/statistics/x_panel/earnings/most_earned_users.php') ?>


<?php $this->endSection() ?>



<?= $this->section("head") ?>

    <link href="<?= admin_assets('/vendors/apexcharts/apexcharts.css') ?>" rel="stylesheet" />
    <link href="<?= admin_assets('/vendors/jqvmap/jqvmap.min.css') ?>" rel="stylesheet" />
    <link href="<?= admin_assets('/vendors/daterangepicker/daterangepicker.css') ?>" rel="stylesheet" />

<?= $this->endSection() ?>

<?php $this->section('scripts');  ?>

<script type="text/javascript"  src="<?= admin_assets('/vendors/apexcharts/apexcharts.min.js') ?>"></script>
<script type="text/javascript"  src="<?= admin_assets('/vendors/daterangepicker/moment.min.js') ?>"></script>
<script type="text/javascript"  src="<?= admin_assets('/vendors/daterangepicker/daterangepicker.js') ?>"></script>


<script type="text/javascript"  src="<?= admin_assets('/js/charts.js') ?>"></script>
<script type="text/javascript"  src="<?= admin_assets('/js/analytics.js') ?>"></script>


<script>

    const USER_ID = '<?= ! empty($user) ? $user->id : 0  ?>';

    jQuery(document).ready(function() {

        Analytics.earnByMonthly.init();

    });


</script>

<?php $this->endSection(); ?>
