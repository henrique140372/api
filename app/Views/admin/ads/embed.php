<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?= form_open('/admin/ads/update', ['method'=>'post']) ?>



<div class="x_panel">
    <div class="x_title">
        <h2>Pop Ads</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php if(! empty($popAds)) : ?>

            <div class="form-group row mb-5">
                <?= form_textarea( [
                    'name' => "ads[{$popAds->id}][ad_code]",
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter ad code here',
                    'rows' => 8
                ] , base64_decode( $popAds->ad_code )) ?>

                <div class="text-right">
                    status:
                    <?= form_dropdown([
                        'name' => "ads[{$popAds->id}][status]",
                        'options' => [
                            'active' => 'active',
                            'paused' => 'paused'
                        ],
                        'selected' => $popAds->status
                    ]) ?>
                </div>

                <?= form_hidden("ads[{$popAds->id}][id]", $popAds->id) ?>
            </div>

        <?php endif; ?>




    </div>
</div>

<div class="text-right my-3">
    <?= form_button([
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'id' => 'run-importer'
    ], 'Update') ?>
</div>

<?= form_close() ?>


<?php $this->endSection() ?>
