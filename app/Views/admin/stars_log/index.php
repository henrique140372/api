<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?php if(! empty($user)): ?>
    <div class="x_panel">
        <div class="x_content d-flex align-items-center justify-content-between">
            <h2>User : <b><?= esc( $user->username ) ?></b> </h2>

            <div>
                Filter by:
                <?= form_dropdown([
                    'class' => 'form-control d-inline w-auto',
                    'options' => [
                        'all' => 'all',
                        'credited' => 'credited',
                        'pending' => 'pending',
                        'rejected' => 'rejected',
                    ],
                    'onchange' => 'stars_log_status_changed(this, '. $user->id .')',
                    'selected' => $status
                ]) ?>
                <a href="<?= admin_url('/users/edit/' . $user->id) ?>" class="btn ml-3 btn-sm btn-secondary">Back to user</a>
            </div>

        </div>
    </div>
<?php endif; ?>

<div class="x_content">
    <div class="x_panel">

        <div class="x_content">

            <table id="datatable" class="table text-center table-striped table-bordered data-list-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-left">Type</th>
                        <th>Stars</th>
                        <th>Created At</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($earnings as $k => $earn) :  ?>

                    <tr>
                        <td> #<?=  $k+1 ?> </td>
                        <td class="text-left"> <?= clean_undscr_txt( $earn->type ) ?>  </td>
                        <td> <?= nf( $earn->stars ) ?>  </td>
                        <td> <?= format_date_time( $earn->created_at, true ) ?>  </td>
                        <td> <?= get_formatted_stars_status( $earn->status ) ?>  </td>

                    </tr>


                <?php endforeach; ?>

                </tbody>
            </table>





        </div>
    </div>
</div>


<?php $this->endSection() ?>
