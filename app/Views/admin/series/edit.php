<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>


    <?php if( $isImportAllEpisodes ): ?>
    <div class="x_panel episode-loading" >
        <div class="x_content">
            <div class="spinner-border spinner-border-sm mr-3" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            Updating episodes...
        </div>
    </div>
    <?php endif; ?>



    <?= form_open_multipart("/admin/series/update/{$series->id}") ?>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->include('admin/series/form_x_panels/general.php') ?>
            <?= $this->include('admin/series/form_x_panels/meta_info.php') ?>
            <?= $this->include('admin/series/form_x_panels/seasons.php') ?>
        </div>
        <div class="col-lg-4">
            <?= $this->include('admin/series/form_x_panels/publish.php') ?>
            <?= $this->include('admin/series/form_x_panels/categories.php') ?>
            <?= $this->include('admin/series/form_x_panels/poster_image.php') ?>
            <?= $this->include('admin/series/form_x_panels/banner_image.php') ?>

        </div>
    </div>



    <?= form_close() ?>

<?php $this->endSection() ?>


<?php $this->section('scripts') ?>

<?php if( $isImportAllEpisodes ): ?>
<script>

    $( document ).ready(function() {

        let uniqId = '<?= ! empty($series->imdb_id) ? $series->imdb_id : $series->tmdb_id ?>';
        uniqId += "[*]";

        $.ajax({
            url : BASE_URL + '/ajax/import/',
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest'},
            dataType: "JSON",
            timeout: 3000,
            data: {
                type: 'series',
                uniq_ids: uniqId,
                is_alive: 1
            },
            complete: function()
            {
                $(".episode-loading").remove();
            }
        });

    });

</script>
<?php endif; ?>

<?php $this->endSection() ?>
