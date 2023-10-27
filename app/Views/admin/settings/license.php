<?php $this->extend( 'admin/__layout/default' ) ?>

<?php $this->section('content') ?>

    <?php if($status == 'not_confirmed'): ?>
    <div class="alert alert-info font-weight-bold">
        LICENÇA JÁ ATIVADA POR AOSEUGOSTO! |QUE DEUS TE ABENÇÕE
    </div>
    <?php endif; ?>

    <?php if($status == 'active'): ?>
        <div class="alert alert-success font-weight-bold">
            FIQUE EM PAZ LICENÇA JÁ ATIVA!
        </div>
    <?php endif; ?>

    <?php if(_pq()): ?>
        <div class="alert alert-danger font-weight-bold">
            A CONFIRMAÇÃO DE LICENÇA NÃO E NECESSÁRIA!
        </div>
    <?php endif; ?>

<div class="row">
    <div class="col-lg-9">


        <div class="x_panel">
            <div class="x_content">
                <p>
                           <!--div class="text-center"-->
                    
                <li class="mb-3 text-center">OLÁ ESTE SCRIPT FOI MODIFICADO E MELHORADO SEM ERROS FUNCIONANDO NORMALMENTE:<a href="#"><span style="color: #ff0000;"><strong>VISITE AQUI</strong></span></a>
                </p>
                <ul class="">
                
                    <li class="mb-3 ">FIQUE SABENDO DE NOVAS ATUALIZAÇÃO DO SCRIPT ACESSE:NULLEBR:<a href="#"><span style="color: #ff0000;"><strong>VISITE AQUI</strong></span></a>
                    </li>
                    <li class="mb-3">
                        ESTA LICENÇA E VITALICIA FAÇA BOM USO!
                    </li>
                    <li class="mb-3 ">USE APENAS DE FORMA PESSOAL POIS ESTÉ CONTEÚDO É PAGO É NÃO PODER SER ENVIADO PRA OUTROS USUÁRIOS QUE NÃO COMPRO NÁ LOJÁ NULLEBR!.</li>
                    <li >NÃO REVENDA ESTE SCRIPT POIS ELE E MODIFFICADO É TEM ATUALIZAÇÃO EM CASO DE REVENDER OU COMPARTILHA COM OUTRAS PESSOAS PERDE ATUALIZAÇÃO E PODE SER PROCESSADO!</li>
                </ul>

                <p>ESPERO QUE VOCÊ LEIA Ó AVISO ACIMA POIS ESTE TIPO DE MODIFICAÇÃO DA TRABALHO PRA FAZER!</p>
                <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">EMBREVE!</h4>
  <p>AGUARDE A PROXIMA ATUALIZAÇÃO DE MODIFICAÇÃO.</p>
  <hr>
  <p class="mb-0">OBRIGADO POR TER ADQUERIDO NOSSO PRODUTO MODIFICADO É FUNCIONANDO ABRAÇO QUE DEUS TE ABENÇÕE.</p>
</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="x_panel">
            <div class="x_content font-weight-bold">
                LICENÇA ATIVADA POR: AOSEUGOSTO
                <span class=" float-right">
                    <?php if($status == 'confirmed'){
                        echo '<span class="text-success ">SUA LICENÇA FOI CONFIRMADA POR AOSEUGOSTO!</span>';
                    }elseif($status == 'active'){
                        if(get_config('license_type') == 'extended'){
                            echo '<span class="text-info"> Extended </span>';
                        }else{
                            echo '<span class="text-success"> Regular </span>';
                        }
                    }elseif($status){
                        echo '<span class="text-success"> SUA LICENÇA FOI CONFIRMADA POR: AOSEUGOSTO! </span>';
                    } ?>
                </span>

            </div>

        </div>
<?php if($status != 'active') : ?>
        <div class="x_panel">
            <div class="x_content">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#confirm-license-modal" class="btn btn-sm btn-block btn-warning font-weight-bold text-dark,red">CONFIRME A LICENÇA</a>
            </div>
        </div>
<?php endif; ?>
    </div>
</div>

<?php if($status != 'active') : ?>
    <div class="modal fade" id="confirm-license-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <?= form_open() ?>

                <div class="modal-header">
                    <h4 class="modal-title" >CONFIRMAÇÃO DE LICENÇA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>A LICENÇA JÁ ESTA ATIVADA PELA LOJÁ SCRIPT NULLEBR!</label>
                        <input type="text" disabled value="LICENÇA JÁ ATIVADA POR MEGADRIVE! BOM APROVEITO" id="license" class="form-control title-suggest" data-type="movie">
                        <span class="form-text">ACESSE A LOJÁ PARA SABER SOBRE ATUALIZAÇÃO! <a href="#" target="_blank">ACESSAR LOJÁ AQUI</a> </span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="confirm-license" onclick="confirmLicense()">CONFIRMA ATIVAÇÃO</button>
                </div>

                <?= form_close() ?>

            </div>
        </div>
    </div>

<?php endif; ?>

<?php $this->endSection() ?>
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