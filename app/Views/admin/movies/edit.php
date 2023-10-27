<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>


<?= form_open_multipart('/admin/movies/update/' . $movie->id) ?>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->include('admin/movies/form_x_panels/general.php') ?>
            <?= $this->include('admin/movies/form_x_panels/links_group.php') ?>
            <?= $this->include('admin/movies/form_x_panels/seo.php') ?>
            <?= $this->include('admin/movies/form_x_panels/translations.php') ?>
        </div>
        <div class="col-lg-4">
            <?= $this->include('admin/movies/form_x_panels/publish.php') ?>
            <?= $this->include('admin/movies/form_x_panels/next_movie.php') ?>
            <?= $this->include('admin/movies/form_x_panels/quality.php') ?>
            <?= $this->include('admin/movies/form_x_panels/meta-info.php') ?>
            <?= $this->include('admin/movies/form_x_panels/trailer.php') ?>
            <?= $this->include('admin/movies/form_x_panels/categories.php') ?>
            <?= $this->include('admin/movies/form_x_panels/poster_image.php') ?>
            <?= $this->include('admin/movies/form_x_panels/banner_image.php') ?>



        </div>
    </div>
<?= form_close() ?>


<?php $this->endSection() ?>
