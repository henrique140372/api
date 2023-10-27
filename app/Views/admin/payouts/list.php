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
                    <th>Account Details</th>
                    <th>Method</th>
                    <th>Amount ( USD )</th>
                    <th>Requested At</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>


                <tbody>

                <?php foreach ($payouts as $k => $payout) :  ?>


                <tr data-id="<?= $payout->id ?>">

                    <td> #<?= $payout->id ?> </td>
                    <td>
                        <a href="#" class="font-weight-bold">
                            <?= esc( $payout->username ) ?>
                        </a>
                    </td>
                    <td> <?= esc( $payout->account_details ) ?> </td>
                    <td> <?= esc( $payout->payment_method ) ?> </td>
                    <td> <?= $payout->money_balance ?> </td>
                    <td> <?= format_date_time( $payout->created_at ) ?> </td>

                    <td>
                        <?= form_dropdown([
                            'name' => 'status',
                            'options' => array_combine_val_to_keys([
                                \App\Models\PayoutsModel::STATUS_COMPLETED,
                                \App\Models\PayoutsModel::STATUS_PENDING,
                                \App\Models\PayoutsModel::STATUS_REJECTED
                            ]),
                            'selected' => $payout->status,
                            'class' => 'form-control form-control-sm payout-status'
                        ]) ?>
                    </td>


                    <td class="text-center">
                        <a href="javascript:void(0)" data-url="#" class="text-danger del-item ">
                            del
                        </a>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>
            </table>





        </div>
    </div>
</div>

<?php $this->endSection() ?>
