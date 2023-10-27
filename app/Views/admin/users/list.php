<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>



<div class="x_content">
    <div class="x_panel">

        <div class="x_content">

            <table id="datatable" class="table text-center table-striped table-bordered data-list-table" style="width:100%">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Username</th>
                    <th>Admin Appro.</th>
                    <th>Email Verify</th>
                    <th>Last Logged</th>
                    <th>Registered At</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>


                <tbody>

                <?php foreach ($users as $k => $user) :  ?>

                    <tr>
                        <td> <?= $user->id ?> </td>
                        <td>
                            <a href="#" class="font-weight-bold">
                                <?= esc( $user->username ) ?>
                            </a>
                        </td>
                        <td> <?= get_formatted_admin_approval_icon( $user->isAdminApproved(), $user->status ) ?> </td>
                        <td> <?= get_formatted_email_approval_icon( $user->isAdminApproved() ) ?> </td>
                        <td>
                            <?= ! empty($user->last_logged_at) ? \CodeIgniter\I18n\Time::parse( $user->last_logged_at )->humanize() : '--' ?>
                        </td>
                        <td> <?= format_date_time( $user->created_at ) ?> </td>
                        <td> <?= get_formatted_user_status_badges( $user->status ) ?> </td>
                        <td>
                            <a href="<?= admin_url("/users/edit/{$user->id}") ?>" class="text-info ml-3">Edit</a>
                            <a href="javascript:void(0)" data-url="<?= admin_url("/users/delete/{$user->id}") ?>" class="text-danger del-item ml-3">Del</a>

                        </td>
                    </tr>


                <?php endforeach; ?>

                </tbody>
            </table>





        </div>
    </div>
</div>

<?php $this->endSection() ?>
