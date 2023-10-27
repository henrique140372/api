<?= $this->extend( theme_path('user/__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="content">
    <h3 class="content-title ">
        <?= esc( $title ) ?>
    </h3>
</div>

<?= display_alerts() ?>

<div class="row">
    <div class="col-lg-8">

        <div class="card p-0 mt-0">

            <!-- Content -->
            <div class="content">

                <?= form_open('/user/profile/update', ['class'=>'form-inline']) ?>
                <div class="form-group">
                    <label class="w-250">Nome : </label>
                    <?= form_input([
                        'class' => 'form-control',
                        'value' => current_user()->username,
                        'name'  => 'username',
                        'required' => 'required'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="w-250">Email cadastrado alterar: </label>
                    <?= form_input([
                            'type' => 'email',
                            'class' => 'form-control',
                            'value' => current_user()->email,
                            'disabled' => 'disabled'
                    ]) ?>
                </div>

                <div class="form-group mb-0"> <!-- mb-0 = margin-bottom: 0 -->
                    <input type="submit" class="btn btn-primary ml-auto" value="atualizar"> <!-- ml-auto = margin-left: auto -->
                </div>

                <?= form_close() ?>
            </div>

        </div>
        <div class="card p-0">
            <!-- Card header -->
            <div class="px-card py-10 border-bottom">
                <h2 class="card-title font-size-18 m-0">
                    Alterar senha
                </h2>
            </div>
            <!-- Content -->
            <div class="content">

                <?= form_open('/user/profile/update', ['class'=>'form-inline']) ?>
                <div class="form-group">
                    <label class="w-250">Digite a senha antiga: </label>
                    <?= form_password([
                            'class' => 'form-control',
                            'name'  => 'old_passwd'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="w-250">Insira a nova senha: </label>
                    <?= form_password([
                        'class' => 'form-control',
                        'name'  => 'new_passwd'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="w-250" >Confirme sua senha: </label>
                    <?= form_password([
                        'class' => 'form-control',
                        'name'  => 'confirm_passwd'
                    ]) ?>
                </div>


                <div class="form-group mb-0">
                    <input type="submit" class="btn btn-primary ml-auto" value="Alterar senha"> <!-- ml-auto = margin-left: auto -->
                </div>

                <?= form_close() ?>
            </div>

        </div>

        <?php if(get_config('is_2fa_login')): ?>
        <div class="card p-0"> <!-- p-0 = padding: 0 -->
            <!-- Card header -->
            <div class="px-card py-10 border-bottom"> <!-- py-10 = padding-top: 1rem (10px) and padding-bottom: 1rem (10px), border-bottom: adds a border on the bottom -->
                <h2 class="card-title font-size-18 m-0"> <!-- font-size-18 = font-size: 1.8rem (18px), m-0 = margin: 0 -->
                Segurança
                </h2>
            </div>
            <!-- Content -->
            <div class="content">

                <?= form_open('/user/profile/update', ['class'=>'form-inline']) ?>
                <div class="form-group">
                    <label class="w-250">Autenticação 2fatores: </label>
                    <div class="custom-checkbox">
                        <?= form_checkbox([
                                'id' => '2fa',
                                'name' => '2fa',
                                'checked' => current_user()->is2FaLoginEnabled()
                        ]) ?>
                        <label for="2fa">Ativar/Desativar</label>
                    </div>
                    <span class="text-muted mt-5">Para ajudar a manter sua conta segura, solicitaremos que você envie um código ao usar um novo dispositivo para fazer login. Enviaremos o código por e-mail. isso é para manter todos seguro, obrigado</span>
                </div>



                <div class="form-group mb-0"> <!-- mb-0 = margin-bottom: 0 -->
                    <input type="submit" class="btn btn-primary ml-auto" value="Atualizar"> <!-- ml-auto = margin-left: auto -->
                </div>

                <?= form_close() ?>
            </div>

        </div>
        <?php endif; ?>


    </div>
</div>

<?= $this->endSection() ?>
<br>
<script>
</div>
<!--bloqueio inspecionar-->
<script src="https://cdn.jsdelivr.net/gh/brunoalbim/devtools-detect/index.js"></script>
<script>
if (window.devtools.isOpen === true) {
      window.location = "https://aoseugosto.eu.org/";
    }
  	window.addEventListener('devtoolschange', event => {
      if (event.detail.isOpen === true) {
        window.location = "https://t.me/aoseugostobr";
      }
  	});
</script>
<!-- fim inspecionar-->
<!--bloquear control+u do teclado-->
<script>
var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false")


//  F12
//==========

  document.onkeypress = function (event) {
    if (e.ctrlKey &&
        (e.keyCode === 123)) {
            // alert('not allowed');
            return false;
          }
  };


//    CTRL + u
//==============

  document.onkeydown = function(e) {
    if (e.ctrlKey &&
      (e.keyCode === 85)) {
          // alert('not allowed');
          return false;
        }
      };  
</script>
<!-- fim bloqueio control+u do teclado-->
