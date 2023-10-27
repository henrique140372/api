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

                <?= form_open('/reset_password') ?>

                    <div class="form-group">
                        <?= form_label('Enter Username or Email', '', ['class'=>'required']) ?>
                        <?= form_input([
                                'name' => 'username',
                                'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>

                    <input class="btn btn-lg btn-secondary btn-block" type="submit" value="Reset password">

                <?= form_close() ?>

                <div class="mt-15">
                    <a href="<?= site_url('/login') ?>">Back to login</a>
                </div>


            </div>




        </div>
        <!-- /. col-md-7 col-xl-6 -->
    </div>
    <!-- /. row -->
</div>
<!-- /. container-fluid -->

<?= $this->endSection() ?>
