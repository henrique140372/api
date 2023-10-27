<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>


<div class="row">
    <div class="col-lg-7">

        <?= form_open('/admin/rewards/save_ref_reward/' . $reward->id ) ?>

        <div class="x_panel">
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3">Name : </label>
                    <div class="col-md-9">
                        <?= form_input([
                            'name' => 'name',
                            'class' => 'form-control',
                            'value' => old('name', $reward->name)
                        ]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3">Stars per view: </label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'number',
                            'name' => 'stars_per_view',
                            'class' => 'form-control',
                            'value' => old('stars_per_view', $reward->stars_per_view)
                        ]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3">Countries : </label>
                    <div class="col-md-9">
                        <?= form_multiselect([
                            'name' => 'countries[]',
                            'options' => get_countries_list(),
                            'class' => 'form-control select2_multiple',
                            'selected' => old('countries', $reward->countries)
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-right">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn px-5 btn-primary'
            ], 'save') ?>
        </div>

        <?= form_close() ?>

    </div>
</div>




<?php $this->endSection() ?>
