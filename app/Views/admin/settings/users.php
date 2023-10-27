<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col-lg-9">

        <?= form_open('/admin/settings/users/update', [ 'method' => 'post', 'class' => 'form-horizontal form-label-left' ] ) ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>General</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">Sistema de usuarios</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label class="mb-0">
                                <?= form_checkbox('users_system','1', get_config('users_system')) ?>
                                Habilitar/desabilitar
                            </label>
                        </div>
                        <small>Quando voce habilitou o sistema de usuarios, os usuarios podem adicionar login ou se registrar no site e ingressar no programa de recompensas</small>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">Verificacao de email</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label class="mb-0">
                                <?= form_checkbox('user_email_verification','1', get_config('user_email_verification')) ?>
                                Habilitar/desabilitar
                            </label>
                        </div>
                        <small>Os usuarios sao obrigados a verificar seu endereco de email apos o registro</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">Aprovacao do administrador</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label class="mb-0">
                                <?= form_checkbox('user_admin_approval','1', get_config('user_admin_approval')) ?>
                                Habilitar/desabilitar
                            </label>
                        </div>
                        <small>os usuarios nao podem fazer login no sistema ate que o administrador aprove seu registro</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">2FA login</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label class="mb-0">
                                <?= form_checkbox('is_2fa_login','1', get_config('is_2fa_login')) ?>
                                Habilitar/desabilitar
                            </label>
                        </div>
                        <small>A autenticacao de dois fatores (2FA) pode ser usada para ajudar a proteger as contas dos usuarios contra acesso nao autorizado, exigindo que voce digite um codigo adicional</small>
                        <br>
                        <small>
                            <span class="text-danger">Observacao: </span>
                            se voce ativou o login 2fa tambem deve configurar um endereco de email do sistema
                        </small>
                    </div>
                </div>





            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Programa de Recompensas</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">



                <div class="form-group row">
                    <label class="control-label col-md-3 pt-0">Ref. Sistema de recompensas</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label class="mb-0">
                                <?= form_checkbox('ref_rewards_system','1', get_config('ref_rewards_system')) ?>
                                Habilitar/desabilitar
                            </label>
                        </div>
                        <small>Habilitar/desabilitar programa de recompensas por referencias (pay per view)</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Max stream links para um filme por usuario</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'number',
                            'name' => 'max_steaming_links_per_user',
                            'class' => 'form-control',
                            'placeholder' => '1',
                            'min' => 1,
                            'value' => get_config('max_steaming_links_per_user')
                        ]) ?>
                        <small>Numero maximo de links de stream permitidos para adicionar por filme por usuario </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Max direct dl links para um filme por usuario</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'number',
                            'name' => 'max_download_links_per_user',
                            'class' => 'form-control',
                            'placeholder' => '1',
                            'min' => 1,
                            'value' => get_config('max_download_links_per_user')
                        ]) ?>
                        <small>Numero maximo de links de download direto permitidos para adicionar por filme por usuario </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Max torrent dl links para um filme por usuario</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'number',
                            'name' => 'max_torrent_links_per_user',
                            'class' => 'form-control',
                            'placeholder' => '1',
                            'min' => 1,
                            'value' => get_config('max_torrent_links_per_user')
                        ]) ?>
                        <small>Numero maximo de links de download de torrent permitidos para adicionar por filme por usuario </small>
                    </div>
                </div>


            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Pagamentos</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group row">
                    <label class="control-label col-md-3">Valor de uma estrela <br> (em dinheiro real)</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'text',
                            'name' => 'stars_exchange_rate',
                            'class' => 'form-control',
                            'placeholder' => '0.001',
                            'value' => get_config('stars_exchange_rate')
                        ]) ?>
                        <small>Definir taxa de cambio de estrelas por estrela </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Minimo de estrelas para resgatar</label>
                    <div class="col-md-9">
                        <?= form_input([
                            'type' => 'number',
                            'name' => 'min_payout_stars',
                            'class' => 'form-control',
                            'min'   => 0,
                            'value' => get_config('min_payout_stars')
                        ]) ?>
                        <small>Defina o minimo de estrelas para uma solicitacao de pagamento </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Metodos de pagamento</label>
                    <div class="col-md-9">
                        <?= form_textarea([
                            'name' => 'payment_methods_for_payouts',
                            'class' => 'form-control',
                            'rows' => 3,
                            'placeholder' => 'paypal, bitcoin'
                        ], implode(', ', get_payout_payment_methods())) ?>
                        <small>Definir metodos de pagamento suportados para resgatar estrelas (pagamentos)</small> <br>
                        <small> <span class="text-danger">Observacao: </span> separe cada forma de pagamento por virgula </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3">Observacao sobre a data de pagamento</label>
                    <div class="col-md-9">
                        <?= form_textarea([
                            'name' => 'note_about_payout_date',
                            'class' => 'form-control',
                            'rows' => 4,
                            'placeholder' => 'Most payments will be processed in five business day or less'
                        ], get_config('note_about_payout_date')) ?>
                        <small>Adicione uma pequena observacao sobre a data de pagamento para os usuarios</small> <br>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-right">
            <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ], 'update') ?>
        </div>

        <?= form_close() ?>

    </div>
</div>

<?php $this->endSection() ?>
