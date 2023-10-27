<div class="x_panel">
    <div class="x_content">
        <div class="form-group row">
            <label class="control-label col-md-3">Nome de usuario: </label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'username',
                    'class' => 'form-control',
                    'value' => old('username', $user->username)
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3">Email: </label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'email',
                    'name' => 'email',
                    'class' => 'form-control',
                    'value' => old('email', $user->email)
                ]) ?>
            </div>
        </div>



    </div>
</div>

<?php if(! empty($user->id)): ?>
<div class="x_panel">
    <div class="x_content text-center">
        <a href="<?= admin_url('/statistics/referrals?user=' . $user->id) ?>" class="mr-3">
            <i class="fa fa-users"></i>&nbsp;
            Ver referencias
        </a>
        <a href="<?= admin_url('/statistics/earnings?user=' . $user->id) ?>" class="mr-3">
            <i class="fa fa-dollar"></i>&nbsp;
            Ver ganhos
        </a>
        <a href="<?= admin_url('/users/links/stream?user=' . $user->id) ?>" class="mr-3">
            <i class="fa fa-link"></i>&nbsp;
            Ver links
        </a>
        <a href="<?= admin_url('/stars-log?user=' . $user->id) ?>" >
            <i class="fa fa-list"></i>&nbsp;
            Ver registro de estrelas
        </a>
    </div>
</div>


<?php endif; ?>

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
