<?= $this->extend( theme_path('__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="container-fluid mb-20">

    <!-- row -->
    <div class="row">

        <!-- col-md-7 col-xl-6 -->
        <div class="col-md-7 col-xl-6 mx-auto">



            <!-- Server dest card -->
            <div class="card text-center mb-5 p-0">

                <?= display_alerts('mb-0 mt-15') ?>

                <div class="content">
                    <h3 class="font-weight-semi-bold content-title mt-0">
                        <?= esc( $title ) ?>
                    </h3>

                    <span class="email-icon-wrap">
                     <img src="<?= theme_assets('/images/icons/svg/email_blue.svg') ?>" width="60" alt="play-btn">
                </span>


                    <p class="font-size-16">
                        Enviamos um e-mail de verificação para <br>
                        <b> <?= esc( $user->email ) ?> </b> . Clique no link <br> dentro para começar!
                    </p>
                </div>

                <?php if(! $isMaxSendMails): ?>
                <div class="px-card py-15 bg-light-lm bg-very-dark-dm rounded-bottom"> <!-- py-10 = padding-top: 1rem (10px) and padding-bottom: 1rem (10px), bg-light-lm = background-color: var(--gray-color-light) only in light mode, bg-very-dark-dm = background-color: var(--dark-color-dark) only in dark mode, rounded-bottom = rounded corners on the bottom -->
                    <a href="<?= $_SERVER['REQUEST_URI'] ?>&resent_mail=1" class="font-weight-semi-bold">O e-mail não chegou?</a>
                </div>
                <?php endif; ?>

            </div>


            <div class="content mt-0">
                <p class="text-muted font-size-12">
                    O link de ativação é válido por 2 horas a partir de agora. Verifique a pasta de spam se
                    não é entregue em sua caixa de entrada.
                </p>
            </div>






        </div>
        <!-- /. col-md-7 col-xl-6 -->
    </div>
    <!-- /. row -->
</div>
<!-- /. container-fluid -->

<?= $this->endSection() ?>
