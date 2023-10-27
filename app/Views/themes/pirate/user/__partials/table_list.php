<table class="table" id="<?= $datatable ?  'datatable' : '' ?>" >
    <thead>
    <tr>
        <th>#</th>
        <th><?= lang('User/Dashboard.tbl_title') ?></th>
        <th>Imdb ID</th>
        <th>Tmdb ID</th>
        <th class="text-right"><?= lang('User/Dashboard.tbl_action') ?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($movies as $k => $movie) : ?>
        <tr>
            <th> <?= $k+1 ?> </th>
            <td>
                <a href="<?= $movie->getViewLink(true) ?>" class="text-light">
                    <?=  esc( $movie->getMovieTitle() )   ?>
                </a>
            </td>
            <td>  <?= $movie->imdb_id ?? '--' ?>
            </td>
            <td>  <?= $movie->tmdb_id ?? '--' ?>
            </td>
            <td class="text-right font-weight-semi-bold">
                <?php $url = $isMovies ? "/user/links/add/" . encode_id( $movie->id ) : "user/series/view/" . encode_id( $movie->id ) ;  ?>
                <a href="<?= site_url( $url ) ?>">pegue</a>            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
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