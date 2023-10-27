<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<?= form_open('/admin/ads/update', ['method'=>'post']) ?>

<div class="x_panel">
    <div class="x_title">
        <h2>Banner Ads</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php if(! empty($topAd)) : ?>

        <div class="form-group row mb-5">
            <label class="control-label col-md-3">Top of embed player:</label>
            <div class="col-md-9">
                <?= form_textarea( [
                    'name' => "ads[{$topAd->id}][ad_code]",
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter ad code here',
                    'rows' => 8
                ] , base64_decode( $topAd->ad_code )) ?>

                <div class="text-right">
                    status:
                    <?= form_dropdown([
                        'name' => "ads[{$topAd->id}][status]",
                        'options' => [
                                'active' => 'active',
                                'paused' => 'paused'
                        ],
                        'selected' => $topAd->status
                    ]) ?>
                </div>

                <?= form_hidden("ads[{$topAd->id}][id]", $topAd->id) ?>

            </div>
        </div>

        <?php endif; ?>

        <?php if(! empty($playerRightAd)) : ?>

            <div class="form-group row mb-5">
                <label class="control-label col-md-3">Right of embed player:</label>
                <div class="col-md-9">
                    <?= form_textarea( [
                        'name' => "ads[{$playerRightAd->id}][ad_code]",
                        'class' => 'form-control mb-3',
                        'placeholder' => 'Enter ad code here',
                        'rows' => 8
                    ] , base64_decode( $playerRightAd->ad_code )) ?>

                    <div class="text-right">
                        status:
                        <?= form_dropdown([
                            'name' => "ads[{$playerRightAd->id}][status]",
                            'options' => [
                                'active' => 'active',
                                'paused' => 'paused'
                            ],
                            'selected' => $playerRightAd->status
                        ]) ?>
                    </div>

                    <?= form_hidden("ads[{$playerRightAd->id}][id]", $playerRightAd->id) ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if(! empty($playerBottomAd)) : ?>

            <div class="form-group row">
                <label class="control-label col-md-3">Bottom of embed player:</label>
                <div class="col-md-9">
                    <?= form_textarea( [
                        'name' => "ads[{$playerBottomAd->id}][ad_code]",
                        'class' => 'form-control mb-3',
                        'placeholder' => 'Enter ad code here',
                        'rows' => 8
                    ] , base64_decode( $playerBottomAd->ad_code )) ?>

                    <div class="text-right">
                        status:
                        <?= form_dropdown([
                            'name' => "ads[{$playerBottomAd->id}][status]",
                            'options' => [
                                'active' => 'active',
                                'paused' => 'paused'
                            ],
                            'selected' => $playerBottomAd->status
                        ]) ?>
                    </div>

                    <?= form_hidden("ads[{$playerBottomAd->id}][id]", $playerBottomAd->id) ?>

                </div>
            </div>

        <?php endif; ?>



    </div>
</div>

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
