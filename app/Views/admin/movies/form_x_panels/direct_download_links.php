<div class="x_title">
    <h2>Links de download direto</h2>
    <div class="clearfix"></div>
</div>

<div class="x_content">

    <div class="x_content" id="direct-dl-group-content">

        <?php if(! empty($directDownloadLinks)): ?>
            <?php foreach ($directDownloadLinks as $key => $link):
                $key += 1; ?>

                <div class="main-form-group direct-dl-group">
                    <div class="form-group mb-0">
                        <?= form_label("Link {$key}:", "", ['class'=>'font-weight-bold']) ?>

                        <div class="link-meta-info mb-1">
                            <span class="requests-count">Requests :  <?= $link->requests ?></span>
                            <span class="status float-right">Status : <?= format_links_status( $link->status ) ?> </span>
                        </div>

                        <div class="input-group mb-2">
                            <?= form_input([
                                'type' => 'url',
                                'name' => "direct_dl_links[{$key}][url]",
                                'class' => 'form-control link',
                                'value' => old("direct_dl_links.{$key}.url", $link->link)
                            ]) ?>

                            <span class="input-group-btn ml-2 ">
                                <button type="button" class="btn btn-light link-approved mb-0"  <?= is_link_btn_disabled($link, true) ?> >
                                    <i class="fa fa-check"></i>
                                    <span class="spinner-border spinner-border-sm loader" style="display: none" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>
                                </button>
                                <button type="button" class="btn btn-light text-danger link-rejected mb-0" <?= is_link_btn_disabled($link) ?>>
                                    <i class="fa fa-close"></i>
                                    <span class="spinner-border spinner-border-sm loader" style="display: none" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col">
                            <div class="form-group form-row">
                                <?= form_label('Res. :', '', ['class'=>'control-label col-md-3']) ?>
                                <div class="col-md-9">

                                    <?= form_dropdown([
                                        'name' => "direct_dl_links[{$key}][resolution]",
                                        'options' => getResolutionFormatOptions(),
                                        'selected' => $link->resolution,
                                        'class' => 'form-control form-control-sm resolution'
                                    ]) ?>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">

                                <?= form_label('Quality :', '', ['class'=>'control-label col-md-4']) ?>

                                <div class="col-md-8">

                                    <?= form_dropdown([
                                        'name' => "direct_dl_links[{$key}][quality]",
                                        'options' => getQualityFormatOptions(),
                                        'selected' => $link->quality,
                                        'class' => 'form-control form-control-sm quality'
                                    ]) ?>

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">

                                <?= form_label('Size:', '', ['class'=>'control-label col-md-3']) ?>

                                <div class="col-md-9">

                                    <div class="input-group">
                                        <?= form_input([
                                                'name' => "direct_dl_links[{$key}][size_val]",
                                                'type' => 'number',
                                                'min' => 'number',
                                                'step' => 'any',
                                                'class' => 'form-control form-control-sm size-val',
                                                'value' => old("direct_dl_links.{$key}.size_val", $link->size_val)
                                        ]) ?>
                                        <?= form_dropdown([
                                                'name' => "direct_dl_links[{$key}][size_lbl]",
                                                'options' => [
                                                        'MB' => 'MB',
                                                        'GB' => 'GB'
                                                ],
                                                'selected' => old("direct_dl_links.{$key}.size_lbl", $link->size_lbl),
                                                'class' => 'form-control form-control-sm size-label'
                                        ]) ?>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                    <input type="hidden" name="direct_dl_links[<?= $key ?>][id]" class="link-id" value="<?= $link->id ?>" >

                </div>

                <div class="text-right meta-bottom-right">
                    <a href="<?= esc( $link->link ) ?>" target="_blank"><i class="fa fa-external-link"></i>&nbsp; Open Link</a>
                    <p class="mb-0 d-inline-block ml-3">by&nbsp;
                        <a href="<?= admin_url('/users/edit/' . $link->user()->id) ?>" class="text-info"> <?= esc( $link->user()->username ) ?> </a></p>
                </div>







            <?php endforeach; ?>
        <?php else: ?>
            <?php for($i = 1; $i <= 2; $i++) : ?>

                <div class="direct-dl-group">
                    <div class="form-group mb-0">
                        <?= form_label("Link {$i}:") ?>
                        <div class="input-group mb-2">
                            <?= form_input([
                                'type' => 'url',
                                'name' => "direct_dl_links[{$i}][url]",
                                'class' => 'form-control link',
                                'value' => old("direct_dl_links.{$i}.url")
                            ]) ?>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <?= form_label('Res.:', '', ['class'=>'control-label col-md-3']) ?>
                                <div class="col-md-9">

                                    <?php

                                    echo form_dropdown([
                                            'name' => "direct_dl_links[{$i}][resolution]",
                                            'options' => getResolutionFormatOptions(),
                                            'selected' => old("direct_dl_links.{$i}.resolution"),
                                            'class' => 'form-control form-control-sm resolution'
                                    ]) ?>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">

                                <?= form_label('Quality :', '', ['class'=>'control-label col-md-4']) ?>

                                <div class="col-md-8">

                                    <?php

                                    echo form_dropdown([
                                            'name' => "direct_dl_links[{$i}][quality]",
                                            'options' => getQualityFormatOptions(),
                                            'selected' => old("direct_dl_links.{$i}.quality"),
                                            'class' => 'form-control form-control-sm quality'
                                    ]) ?>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">

                                <?= form_label('Size:', '', ['class'=>'control-label col-md-3']) ?>

                                <div class="col-md-9">

                                    <div class="input-group">
                                        <?= form_input([
                                            'name' => "direct_dl_links[{$i}][size_val]",
                                            'type' => 'number',
                                            'min' => '1',
                                            'step' => 'any',
                                            'class' => 'form-control form-control-sm size-val',
                                            'value' => old("direct_dl_links.{$i}.size_val")
                                        ]) ?>
                                        <?= form_dropdown([
                                            'name' => "direct_dl_links[{$i}][size_lbl]",
                                            'options' => [
                                                'MB' => 'MB',
                                                'GB' => 'GB'
                                            ],
                                            'selected' => old("direct_dl_links.{$i}.size_lbl"),
                                            'class' => 'form-control form-control-sm size-label'
                                        ]) ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            <?php endfor; ?>
        <?php endif; ?>

    </div>


    <div class="text-right">
        <button type="button" class="btn btn-light font-weight-bold" id="clone-direct-dl-group">
            <i class="fa fa-plus"></i>&nbsp;
            Add more
        </button>
    </div>

</div>