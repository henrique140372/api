<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>


<div class="row">

    <div class="col-lg-3">
        <div class="nav nav-tabs flex-column  bar_tabs" >
            <a class="nav-link active" data-toggle="pill" href="#settings-general" >General</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-seo" >SEO</a>
            <a class="nav-link" data-toggle="pill" href="#settings-footer-links" >Footer links</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-telegram" >Telegram widget</a>
            <a class="nav-link"  data-toggle="pill" href="#settings-custom-codes" >Header & Footer codes</a>
        </div>
    </div>

    <div class="col-lg-9">

        <?= form_open_multipart('/admin/settings/site/update', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>


        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="settings-general">
                <?= $this->include('admin/settings/site/form_x_panels/general.php') ?>
            </div>
            <div class="tab-pane fade" id="settings-seo">
                <?= $this->include('admin/settings/site/form_x_panels/seo.php') ?>
            </div>
            <div class="tab-pane fade" id="settings-footer-links" >
                <?= $this->include('admin/settings/site/form_x_panels/footer_links.php') ?>
            </div>
            <div class="tab-pane fade" id="settings-telegram">
                <?= $this->include('admin/settings/site/form_x_panels/telegram_widget.php') ?>
            </div>
            <div class="tab-pane fade" id="settings-custom-codes">
                <?= $this->include('admin/settings/site/form_x_panels/custom_codes.php') ?>
            </div>
        </div>

        <div class="text-right mb-3">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ], 'update') ?>
        </div>

        <?= form_close() ?>

    </div>
</div>


<?php $this->endSection() ?>
