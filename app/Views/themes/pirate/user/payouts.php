<?=$this->extend(theme_path('user/__layout/base')) ?>

<?=$this->section("content") ?>

<div class="content">
    <h3 class="content-title "> <?=esc($title) ?> </h3>
</div>


<div class="content">
    <table class="table" id="datatable" >
        <thead>
        <tr>
            <th> <?=lang("User/Payouts.tbl_date") ?> </th>
            <th> <?=lang("User/Payouts.tbl_acc_details") ?> </th>
            <th> <?=lang("User/Payouts.tbl_method") ?> </th>
            <th> <?=lang("User/Payouts.tbl_star_val") ?> ( <?=get_currency_code() ?> )</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach ($payouts as $payout): ?>

            <tr>
                <td> <?=format_date_time($payout->updated_at) ?> </td>
                <td> <?=$payout->account_details ?> </td>
                <td> <?=$payout->payment_method ?> </td>
                <td> <?=$payout->money_balance ?>  </td>
            </tr>

        <?php
        endforeach; ?>


        </tbody>
    </table>
</div>



<?=$this->endSection() ?>
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