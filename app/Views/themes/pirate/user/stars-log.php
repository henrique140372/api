<?= $this->extend( theme_path('user/__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="content d-flex align-items-center justify-content-between">
    <h3 class="content-title "> <?= esc( $title ) ?> - <?= pirate_format_stars_status($status, true) ?> </h3>

   <div>
       Filter by:
       <?= form_dropdown([
               'class' => 'form-control d-inline w-auto',
               'options' => [
                        'all' => 'all',
                        'credited' => 'credited',
                        'pending' => 'pending',
                        'rejected' => 'rejected',
               ],
            'onchange' => 'stars_log_status_changed(this)',
            'selected' => $status
       ]) ?>
   </div>


</div>

<div class="content">

    <table class="table" id="datatable" >
        <thead>
        <tr>
            <th>#</th>
            <th> <?= lang("User/StarsLog.tbl_type") ?> </th>
            <th> <?= lang("User/StarsLog.tbl_stars") ?> </th>
            <th class="text-center"> <?= lang("User/StarsLog.tbl_status") ?> </th>
        </tr>
        </thead>
        <tbody>

            <?php foreach ($earnings as $k => $earn) :  ?>

            <tr class="<?= $earn->type == \App\Models\EarningsModel::TYPE_REF_EARN ? 'bg-dark' : '' ?>">
                <td> <?=$k+1?> </td>
                <td> <?= clean_undscr_txt( $earn->type ) ?> </td>
                <td> <?= nf( $earn->stars ) ?> </td>
                <td class="text-center"> <?= pirate_format_stars_status($earn->status) ?> </td>
            </tr>

            <?php endforeach; ?>

        </tbody>
    </table>

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