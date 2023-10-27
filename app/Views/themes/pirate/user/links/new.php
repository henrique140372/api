<?= $this->extend( theme_path('user/__layout/base') ) ?>

<?= $this->section("content") ?>

<div class="content d-flex align-items-center justify-content-between">
   <div>
       <?php if($movie->isEpisode()): ?>
       <a href="<?= site_url("/user/series/view/" . encode_id( $movie->id )) ?>">
           <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;
           🔙voltar para a series
       </a>
       <?php endif; ?>
       <h3 class="content-title ">🔗Adicionar links🔗  ( <small class="text-muted"> <?= esc( $movie->getMovieTitle() ) ?> </small> ) </h3>

   </div>
    <div>
        <a href="<?= $movie->getViewLink(true) ?>" target="_blank" class="btn font-weight-semi-bold">
            <i class="fa fa-external-link  " aria-hidden="true"></i>&nbsp;
            👀Visualizar👀
        </a>
    </div>
</div>



<div class="row row-eq-spacing">
    <div class="col-lg-8">

        <?php  $isActive = false; ?>
        <div class="tabs p-5 bg-dark-light font-weight-semi-bold mb-20 w-auto d-inline-flex">
            <?php if($isStreamRewardsEnabled): $isActive = true; ?>
            <a href="javascript:void(0)" class="btn" data-target="stream-links-content">
                <i class="fa fa-play" aria-hidden="true"></i>
                &nbsp; Links de transmissao
            </a>
            <?php endif; ?>

            <?php if($isDirectDlRewardsEnabled):  ?>
            <a href="javascript:void(0)" class="<?= ! $isActive ? 'btn' : 'nav-link d-inline-block' ?>" data-target="direct-links-content">
                <i class="fa fa-download" aria-hidden="true"></i>
                &nbsp; links direto
            </a>
            <?php if(! $isActive) $isActive = true;
                endif; ?>

            <?php if($isTorrentDlRewardsEnabled): ?>
            <a href="javascript:void(0)" class="<?= ! $isActive ? 'btn' : 'nav-link d-inline-block' ?>" data-target="torrent-links-content">
                <i class="fa fa-download" aria-hidden="true"></i>
                &nbsp; Torrent Links
            </a>
            <?php endif; ?>
        </div>

        <?= form_open("/user/links/create/" . encode_id( $movie->id )) ?>

        <?php  $isActive = false; ?>
        <?php if($isStreamRewardsEnabled): $isActive = true; ?>
        <div class="tab-content active" id="stream-links-content">
            <div class="card mt-0 mx-0">
                <h2 class="card-title font-size-18">
                    Streaming Links -
                    <span class="text-muted">
                        ( <span id="num-of-exist-stream-links"><?= ! empty($streamLinks) ? count($streamLinks) : 1 ?> </span>
                        / <?= get_max_steaming_links_per_user() ?> )</span>
                </h2>

                <div id="st-group-content">

                    <?php if(! empty($streamLinks)) : ?>
                        <?php foreach ($streamLinks as $k =>  $link) : $k += 1; ?>

                        <div class="form-group st-group">

                            <?php include view_path( theme_path('/user/links/exist_content/stream') )?>

                        </div>

                        <?php endforeach; ?>
                    <?php else: ?>

                        <?php include view_path( theme_path('/user/links/default_content/stream') )?>


                    <?php endif; ?>

                </div>

                <?php $existLinks = ! empty($streamLinks) ? count($streamLinks) : 1 ?>
                <?php if($existLinks < get_max_steaming_links_per_user()) : ?>
                <button type="button" class="btn mt-15" id="clone-st-group">
                    <i class="fa fa-plus"></i>
                    Adicionar mais link
                </button>
                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>

        <?php if($isDirectDlRewardsEnabled): ?>
        <div class="tab-content <?= !$isActive ? 'active' : '' ?>" id="direct-links-content">
            <div class="card mt-0 mx-0">
                <h2 class="card-title font-size-18">
                    Links de download direto -
                    <span class="text-muted">
                        ( <span id="num-of-exist-direct-links"><?= ! empty($directDownloadLinks) ? count($directDownloadLinks) : 0 ?> </span>
                        / <?= get_max_download_links_per_user() ?> )</span>
                </h2>
                <div id="direct-dl-group-content">

                    <?php if(! empty($directDownloadLinks)) : ?>
                    <?php foreach ($directDownloadLinks as $k =>  $link) : $k += 1; ?>

                            <div class="direct-dl-group">

                                <?php include view_path( theme_path('/user/links/exist_content/download') )?>

                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>

                        <?php include view_path( theme_path('/user/links/default_content/direct') )?>

                    <?php endif; ?>

                </div>

                <?php $existLinks = ! empty($directDownloadLinks) ? count($directDownloadLinks) : 1 ?>
                <?php if($existLinks < get_max_download_links_per_user()) : ?>
                    <button type="button" class="btn mt-15" id="clone-direct-dl-group">
                        <i class="fa fa-plus"></i>
                       Adicionar mais link
                    </button>
                <?php endif; ?>


            </div>
        </div>
        <?php if(! $isActive) $isActive = true;
            endif; ?>

        <?php if($isTorrentDlRewardsEnabled):  ?>
        <div class="tab-content <?= !$isActive ? 'active' : '' ?>" id="torrent-links-content">
            <div class="card mt-0 mx-0">
                <h2 class="card-title font-size-18">
                    Links para baixar torrents
                    <span class="text-muted">( <span id="num-of-exist-torrent-links"><?= ! empty($torrentDownloadLinks) ? count($torrentDownloadLinks) : 0 ?></span> / <?= get_max_torrent_links_per_user() ?> )</span>
                </h2>
                <div id="torrent-dl-group-content">

                    <?php if(! empty($torrentDownloadLinks)) : ?>
                        <?php foreach ($torrentDownloadLinks as $k =>  $link) : $k += 1; ?>

                            <div class="torrent-dl-group">

                                <?php include view_path( theme_path('/user/links/exist_content/download') )?>

                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>

                        <?php include view_path( theme_path('/user/links/default_content/torrent') )?>

                    <?php endif; ?>

                </div>

                <?php $existLinks = ! empty($torrentDownloadLinks) ? count($torrentDownloadLinks) : 1 ?>
                <?php if($existLinks < get_max_torrent_links_per_user()) : ?>
                    <button type="button" class="btn mt-15" id="clone-torrent-dl-group">
                        <i class="fa fa-plus"></i>
                        Adicionar mais link
                    </button>
                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>

        <?= csrf_field() ?>

            <div class="text-right">
                <button type="submit" class="btn btn-lg btn-primary px-20">
                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;
                    Enviar
                </button>
            </div>


        <?= form_close() ?>


    </div>
    <div class="col-lg-4">
        <div class="poster">
            <div class="w-250 mw-full ">
                <div class="card m-0 mb-10 p-5">
                    <img src="<?= poster_uri( $movie->poster ) ?>" class="img-fluid w-full" alt="">
                    <?php if(! empty($movie->imdb_id)): ?>
                    <div class="p-10">
                     Imdb Id:
                        <span class="badge badge-secondary font-weight-semi-bold float-right">
                            <?= $movie->imdb_id ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>



            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>

    const MAX_STREAM_LINKS      = <?= get_max_steaming_links_per_user() ?>;
    const MAX_DIRECT_DL_LINKS   = <?= get_max_download_links_per_user() ?>;
    const MAX_TORRENT_DL_LINKS  = <?= get_max_torrent_links_per_user() ?>;

</script>

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