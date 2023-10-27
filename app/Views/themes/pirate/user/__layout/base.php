<?= $this->include( theme_path('user/__layout/header') ) ?>

    <!-- Content wrapper start -->
    <div class="content-wrapper overflow-x-hidden">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
        <?= $this->include( theme_path('user/__layout/footer_inner') ) ?>
    </div>

<?= $this->renderSection('end-of-content') ?>

<?= $this->include( theme_path('user/__layout/footer') ) ?>
