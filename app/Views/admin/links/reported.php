<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="x_panel">
    <div class="card-box table-responsive">

        <table id="datatable" class="table text-center table-striped table-bordered data-list-table " style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Link</th>
                <th>Req.</th>
                <th>Reason</th>
                <th>Reports</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>


            <tbody>

            <?php foreach ($links as $link) : ?>
                <tr>
                    <td> <?= $link->id ?> </td>
                    <td class="text-left" >
                        <a href="<?= esc( $link->link ) ?>" class="cut-text" target="_blank">
                            <?= esc( $link->link ) ?>
                        </a>
                    </td>
                    <td> <?= number_format( $link->requests ) ?> </td>
                    <td>
                        <span class="">
                            <?php if($link->reports_not_working >= $link->reports_wrong_link) {
                                echo 'not working';
                            }else{
                                echo 'wrong link';
                            }  ?>
                        </span>
                    </td>
                    <td> <span class="text-danger font-weight-bold"> <?= number_format( $link->countReports() ) ?> </span> </td>
                    <td> <?= format_date_time( $link->updated_at ) ?> </td>
                    <td>
                        <a href="<?= admin_url("/links/edit/{$link->id}") ?>" class="text-info">Edit</a>
                        <a href="<?= admin_url("/movies/edit/{$link->movie_id}") ?>" class="text-success ml-2">Movie</a>
                        <a href="<?= admin_url("/links/clear/{$link->id}") ?>" class=" ml-2">Clear</a>
                        <a href="javascript:void(0)" class="text-danger ml-2 del-item" data-url="<?= admin_url("/links/delete/{$link->id}") ?>">Del</a>

                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php $this->endSection() ?>


