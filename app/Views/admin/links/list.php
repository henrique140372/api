<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>



<div class="x_panel">
    <div>
        <div class="group-selection  d-none ve-results--filter" >
            <label class="control-label" for="first-name">Filter:
            </label>
            <?= form_dropdown([
                'name' => 'filter_links_results_by_type',
                'class' => 'form-control',
                'onchange' => 'filter_movie_results(this.value)',
                'options' => [
                    'all' => 'All',
                    'stream' => 'Stream',
                    'direct_dl' => 'Direct',
                    'torrent_dl' => 'Torrent'
                ],
                'selected' => $filter ?? ''
            ]) ?>
        </div>

    </div>
    <div class="card-box table-responsive">

        <table id="links-list-datatable" class="table text-center table-striped table-bordered data-list-table " style="width:100%">
            <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Link</th>
                <th>Requests</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
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