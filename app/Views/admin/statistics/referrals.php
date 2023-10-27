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
        <?= $this->include('admin/statistics/x_panel/referrals/top_tiles') ?>
    </div>
</div>

<!-- Monthly referrals -->
<?= $this->include('admin/statistics/x_panel/referrals/monthly_referrals.php') ?>
<!-- Referrals countries -->
<?= $this->include('admin/statistics/x_panel/referrals/referrals_countries.php') ?>

<!-- Top referrals by countries -->
<?php if(! empty($topRefByCountries)) {
    echo $this->include('admin/statistics/x_panel/referrals/top_referrals_countries.php');
} ?>

<!-- Top referrals by users -->
<?php if(! empty($topRefUsers)){
    echo $this->include('admin/statistics/x_panel/referrals/top_referrals_by_users.php');
} ?>


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

<script type="text/javascript"  src="<?= theme_assets('/vendors/jqvmap/jquery.vmap.min.js') ?>"></script>
<script type="text/javascript"  src="<?= theme_assets('/vendors/jqvmap/maps/jquery.vmap.world.js') ?>"></script>

<script type="text/javascript"  src="<?= admin_assets('/js/charts.js') ?>"></script>
<script type="text/javascript"  src="<?= admin_assets('/js/map.js') ?>"></script>
<script type="text/javascript"  src="<?= admin_assets('/js/analytics.js') ?>"></script>


<script>

    const USER_ID = '<?= ! empty($user) ? $user->id : 0  ?>';

    jQuery(document).ready(function() {

        Analytics.visitorsByMonthly.init();
        Analytics.visitorsByCountriesMap.init();

    });


</script>

<?php $this->endSection(); ?>
