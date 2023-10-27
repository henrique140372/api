<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="x_panel">

    <div class="x_content">

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome da API</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
                <th>Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($apis as $api) : ?>
            <tr>
                <th scope="row"><?= $api->id ?></th>
                <td> <b> <?= esc( $api->name ) ?> </b> </td>
                <td> <?= format_date_time($api->created_at) ?> </td>
                <td> <?= format_date_time($api->updated_at) ?> </td>
                <td>
                    <span class="badge <?= $api->status == 'active' ? 'badge-success' : 'badge-danger' ?> ">
                        <?= $api->status ?>
                    </span>
                </td>
                <td class="text-center">
                    <a href="<?= admin_url("/third-party-apis/edit?id={$api->id}") ?>">Edit</a>
                    <a href="javascript:void(0)" data-url="<?= admin_url("/third-party-apis/delete?id={$api->id}") ?>" class="text-danger del-item ml-2">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?php $this->endSection() ?>
