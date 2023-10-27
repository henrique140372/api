<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?php if(! empty($movie)): ?>
    <div class="x_panel">
        <div class="x_content d-flex align-items-center justify-content-between">
            <h2>Video : <b><?= esc( $movie->getMovieTitle() ) ?></b> </h2>
            <a href="<?= admin_url(! $movie->isEpisode() ? '/movies/edit/'  . $movie->id : '/episodes/edit/'  . $movie->id ) ?>" class="btn btn-sm btn-secondary">Back to video</a>
        </div>
    </div>
<?php endif; ?>

<div class="row" style="display: inline-block;width: 100%;">
    <div class="top_tiles">
        <?= $this->include('admin/statistics/x_panel/visitors/top_tiles') ?>
    </div>
</div>

<!-- Monthly referrals -->
<?= $this->include('admin/statistics/x_panel/visitors/monthly_visitors.php') ?>
<!-- Referrals countries -->
<?= $this->include('admin/statistics/x_panel/visitors/visitors_countries.php') ?>

<!-- Top referrals by countries -->
<?php if(! empty($topVisitsByCountries)) {
    echo $this->include('admin/statistics/x_panel/visitors/top_visitors_countries.php');
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

    const MOVIE_ID = '<?= ! empty($movie) ? $movie->id : 0  ?>';

    jQuery(document).ready(function() {

        Analytics.visitorsByMonthly.init();
        Analytics.visitorsByCountriesMap.init();

    });


</script>

<?php $this->endSection(); ?>
