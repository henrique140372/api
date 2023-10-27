<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="x_panel">
    <div class="card-box table-responsive">

        <table id="series-list-datatable" class="table text-center table-striped table-bordered data-list-table" style="width:100%">
            <thead>
            <tr>
                <th>Selection</th>
                <th>ID</th>
                <th>Poster</th>
                <th>Name</th>
                <th>IMDB Id</th>
                <th>TMDB Id</th>
                <th>Year</th>
                <th>Seasons</th>
                <th>Total Episodes</th>
                <th>Is Done</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<?php $this->endSection(); ?>
