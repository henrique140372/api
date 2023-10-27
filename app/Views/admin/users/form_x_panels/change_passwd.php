<div class="x_panel">
    <div class="x_title">
        <h2>Alterar a senha</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group row">
            <label class="control-label col-md-3">Nova Senha: </label>
            <div class="col-md-9">
                <?= form_password([
                    'name' => 'new_password',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3">Confirme a nova senha: </label>
            <div class="col-md-9">
                <?= form_password([
                    'name' => 'confirm_password',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
    </div>
</div>