<div class="card p-5 pb-0 border-0 " id="embed-player">

    <div class="iframe-wrapper">
        <iframe data-src="<?= $activeMovie->getEmbedLink() ?>" class="ve-iframe lazy" id="ve-iframe" allowfullscreen="allowfullscreen" frameborder="0"></iframe>
    </div>

    <div class="d-flex align-items-center justify-content-between m-10 pb-10">
        <div class="left">
            <?= lang('General.active') ?>:
            <span class="text-primary active-movie-id">
                <?= $activeMovie->imdb_id ?>
            </span>
        </div>
        <div class="right">

            <?php if( http_uri()->getPath() != '/' && http_uri()->getSegment(1) === view_slug()) : ?>

                <?php
                $lType = ! $activeMovie->isEpisode() ? \App\Models\EarningsModel::TYPE_MOVIE_STREAM_LINK : \App\Models\EarningsModel::TYPE_EPISODE_STREAM_LINK;
                if(is_users_system_enabled() && is_earnings_method_enabled( $lType ) && ! is_admin() ): ?>

                    <?php if(! is_logged()): ?>

                        <div class="dropdown">
                            <button class="btn" data-toggle="dropdown" type="button"  aria-expanded="false">
                              <i class="fa fa-plus"></i>&nbsp;
                                Adicionar links
                            </button>
                            <div class="dropdown-menu w-300">
                                <h6 class="dropdown-header text-white">Deseja adicionar links?</h6>
                                <div class="dropdown-content">

                                    <p class="text-muted mt-0">
                                        Faça login para adicionar links para contribuir com este filme 
                                    </p>

                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="<?= site_url('/login') ?>" class="dropdown-item text-center font-weight-semi-bold text-primary">
                                   Conecte-se
                                </a>
                            </div>
                        </div>


                    <?php else: ?>

                        <a href="<?= site_url('/user/links/add/' . encode_id($activeMovie->id)) ?>"  class="btn">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block"> &nbsp; Adicionar links</span>
                        </a>

                    <?php endif; ?>

                <?php endif; ?>
            <?php endif; ?>

            <?php if( is_download_enabled() ) : ?>
            <a href="<?= esc( $activeMovie->getDownloadLink(true) ) ?>" id="ve-download--btn" class="ve-download--btn btn ml-5">
                <i class="fa fa-download" aria-hidden="true"></i>
               <span class="d-none d-sm-inline-block"> &nbsp; <?= lang('General.download') ?></span>
            </a>
            <?php endif; ?>


            <?php if( http_uri()->getPath() == '/' || http_uri()->getSegment(1) === 'home'  ) : ?>
            <a href="<?= esc( $activeMovie->getViewLink(true) ) ?>" class="ve-download--btn btn show-player-embed-codes">
                <i class="fa fa-share" aria-hidden="true"></i>
            </a>
            <?php endif; ?>

        </div>
    </div>
</div>
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