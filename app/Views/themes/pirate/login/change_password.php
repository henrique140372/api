<?= $this->extend( theme_path('__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="container-fluid mb-20">

    <!-- row -->
    <div class="row">

        <!-- col-md-7 col-xl-6 -->
        <div class="col-md-7  col-xl-6 mx-auto">


            <div class="card">
                <h3 class="font-weight-semi-bold content-title text-center mt-0 ">
                    <?= esc( $title ) ?>
                </h3>

                <?= display_alerts('mx-0') ?>

                <?= form_open() ?>

                <div class="form-group">
                    <?= form_label('Choose a Password', '', ['class'=>'required']) ?>
                    <?= form_password([
                        'name' => 'password',
                        'class' => 'form-control form-control-lg'
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= form_label('Confirm Password', '', ['class'=>'required']) ?>
                    <?= form_password([
                        'name' => 'confirm_password',
                        'class' => 'form-control form-control-lg'
                    ]) ?>
                </div>

                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update password">

                <?= form_close() ?>


            </div>




        </div>
        <!-- /. col-md-7 col-xl-6 -->
    </div>
    <!-- /. row -->
</div>
<!-- /. container-fluid -->

<?= $this->endSection() ?>
