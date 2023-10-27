<?= $this->extend( theme_path('__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="container-fluid mb-20">

    <!-- row -->
    <div class="row">

        <!-- col-md-7 col-xl-6 -->
        <div class="col-md-7  col-xl-6 mx-auto">

            <!-- Server dest card -->
            <div class="card">
                <h3 class="font-weight-semi-bold content-title text-center mt-0 ">
                   <?= esc( $title ) ?>
                </h3>

                <?= display_alerts('mx-0') ?>

                <?= form_open('/login/check') ?>

                    <div class="form-group">
                        <?= form_label( lang("Login.username_or_email"), '', ['class'=>'required']) ?>
                        <?= form_input([
                                'name' => 'username',
                                'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label(lang("Login.password"), '', ['class'=>'required']) ?>
                        <?= form_password([
                            'name' => 'password',
                            'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>

                <div class="g-recaptcha d-none" data-sitekey="<?= esc( get_config('gcaptcha_site_key') ) ?>"
                     data-badge="bottomright" data-size="invisible" data-callback="setCaptchaResponse"></div>

                <?= form_hidden('gcaptcha') ?>

                <!-- CSRF -->
                <?= csrf_field() ?>
                <!-- /. CSRF -->

                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="<?= lang("Login.login_btn") ?>">

                <?= form_close() ?>

                <div class="mt-15">
                    <a href="<?= site_url('/reset_password') ?>">
                        <?= lang("Login.forget_passwd") ?>
                    </a>
                </div>
                <div class="text-center">
                    <p>  <?= lang("Login.create_acc_note") ?></p>
                    <a href="<?= site_url('/register') ?>" class="btn btn-lg btn-block">
                        <?= lang("Login.create_a_account") ?>
                    </a>
                </div>

            </div>
            <!-- /. Server dest card -->




        </div>
        <!-- /. col-md-7 col-xl-6 -->
    </div>
    <!-- /. row -->
</div>
<!-- /. container-fluid -->

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<?php if( is_login_gcaptcha_enabled() ): ?>

<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback' async defer></script>

<script>
    window.onloadCallback = function() {
        grecaptcha.execute();
    };

    function setCaptchaResponse(response) {
        $('input[name="gcaptcha"]').val( response );
    }
</script>

<?php endif; ?>

<?= $this->endSection() ?>