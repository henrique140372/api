<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="x_content">
    <div>
        <div class="group-selection  d-none ve-results--filter" >
            <label class="control-label" for="first-name">Filter:
            </label>
            <?= form_dropdown([
                    'name' => 'filter_movie_results_by_links',
                    'class' => 'form-control',
                    'onchange' => 'filter_movie_results(this.value)',
                    'options' => [
                            'all' => 'All',
                            'with_st_links' => 'Have Stream Links',
                            'without_st_links' => 'Haven\'t Stream Links',
                            'with_dl_links' => 'Have Download Links',
                            'without_dl_links' => 'Haven\'t Download Links'
                    ],
                    'selected' => $filter ?? ''

            ]) ?>
        </div>

    </div>

</div>

<div class="x_panel">
    <div class="card-box table-responsive">

        <table id="movies-list-datatable" data-type="<?= $isMovie ? 'movies' : 'episodes' ?>" class="table text-center table-striped table-bordered data-list-table " style="width:100%">
            <thead>
            <tr>
                <th>Seleção</th>
                <th>ID</th>
                <th>Pôster</th>
                <th>Título</th>
                <th>ID do IMDB</th>
                <th>ID do TMDB</th>
                <th>Ano</th>
                <th>Taxa Imdb</th>
                <th>Visualizações</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
                <th>Ações</th>
            </tr>
            </thead>


            <tbody>



            </tbody>
        </table>
    </div>
</div>

<?php $this->endSection() ?>



<?php $this->section('scripts'); ?>

<!-- Datatables -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<?php $this->endSection(); ?>
