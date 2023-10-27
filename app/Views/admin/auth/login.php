<!DOCTYPE html>
<html lang="PT">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> <?= esc( $title ?? '' ) ?> - <?= esc( site_name() ) ?> </title>
    <!-- Bootstrap -->
    <link href="<?= site_url('/admin-assets/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= site_url('/admin-assets/css/custom.css') ?>" rel="stylesheet">
</head>

<body class="login">

<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">



                <?= form_open('/admin_login', ['method'=>'post']) ?>

                    <h1>AOSEUGOSTO ADM</h1>

                    <!--LOGO ABAIXO-->
<div class="text-center mb-4">              <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgCCmr1ntsErF162op3tfyVGD_dFDhOCbRtGbBZnd_DLhJwhyxB3enYLT16CYpOd7tE9VmCxaqz2bIX2EofXWxjdzjbmHNmaUz1pt60046PcY0NMyGYim11saKo50ACnfz0dY4ImJ1wvUospnZfZxSRUR-5b2gPFZ0yB2KAO5kN7LndzXM4AH51tRTS/s170/AOSEUGOSTO3.gif" height="36" alt="">
            </div>
            <!--LOGO FIM-->
                <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <span> <?= esc( session()->get('error') ) ?> </span>
                </div>
                <?php endif; ?>

                    <div>
                        <?= form_input([
                                'name' => 'username',
                                'class' => 'form-control',
                                'placeholder' => 'Username',
                                'required' => 'required'
                        ]) ?>
                    </div>
                    <div>
                        <?= form_password([
                            'name' => 'password',
                            'class' => 'form-control',
                            'placeholder' => 'Password',
                            'required' => 'required'
                        ]) ?>
                    </div>
                    <div>
                        <?= form_button([
                                'class' => 'btn btn-secondary btn-block',
                                'type' => 'submit'
                        ], 'Login') ?>
                    </div>
<div class="text-center text-muted">
               COPYRIGHT@2023 TODOS DIREITOS RESERVADOS<BR><a href="#" tabindex="-1">AOSEUGOSTO</a>CRIADO POR: HENRIQUE
               <BR> AQUI SÓ ADM PODE ACESSAR O SITE<BR> SÉ NÃO FOR POR FAVOR SAIA OBRIGADO
            </div>
         </div>
      </div>
      <script>
         document.body.style.display = "block"
      </script>
                <?= form_close() ?>
            </section>
        </div>
            <!--LOGO ABAIXO-->
<!--div class="text-center mb-4">              <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgVs5imkbVykF9OP6TsJsp-hqmSl_E_wmC30NlV0t7TwcU9ZARoJwffhMx9Kw9Nzf8q2IXKVc_R41pGdkAfKFIVk8kcnNGv7aubYLJHetBlUEPluupTNhuNPO83gi-n0b9Ou6epM2tqOLGLOURUuCYFB85LxfWvIBcQs4fijzgdHK6ks2pNNG17mmyk/s725/logo.png" height="36" alt="">
            </div>
                <!--LOGO FIM-->
</div>
   </body>
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
</html>