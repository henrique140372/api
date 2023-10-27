<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php if( has_site_favicon() ): ?>
        <link rel="shortcut icon" href="<?= site_favicon() ?>" type="image/x-icon">
        <link rel="icon" href="<?= site_favicon() ?>" type="image/x-icon">
    <?php endif; ?>

    <link href="<?= theme_assets('/css/template.min.css?v=1.2') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= theme_assets('/css/custom.min.css?v=1.3') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">

    <title>Watch <?= ! empty($links) ? $movie->getMovieTitle() : 'movie not found' ?> </title>
    <style>
        body{
            background-color: var(--dm-card-bg-color) !important;
        }
    </style>

    <!-- header custom codes-->
    <?= header_custom_codes() ?>

</head>
<body  class="dark-mode overflow-y-hidden" >


<?php if(! empty($links)): ?>

    <div id="embed-player" data-movie-id="<?= encode_id( $movie->id ) ?>">
        <div class="sticky-alerts bottom-0 top-auto mb-15"></div>
        <div class="top-bar">

            <div class="d-none d-sm-flex align-items-center">

                <?php if (get_config('player_home_page_btn') && is_direct_access() ): ?>
                    <a href="<?= $movie->getViewLink(true) ?>" class="btn mr-10" target="_parent">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>

                <?php if ( get_config('player_title') ): ?>
                <h1 class="title font-size-14 m-0">
                    <?= esc( $movie->getMovieTitle() ) ?>
                </h1>
                <?php endif; ?>

            </div>

            <div class="d-inline-block d-sm-none"></div>
            <div class=" d-flex align-items-center">



                <?php create_stream_servers_groups( $links );  ?>
                <?php create_stream_servers( $links );  ?>

                <?php if( is_links_report_enabled() ): ?>

                <div class="dropdown">
                    <button class="btn mr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right w-250 w-sm-300" aria-labelledby="sign-in-dropdown-toggle-btn">
                        <div class="dropdown-content p-10">

                            <h3 class="content-title font-size-16 text-danger">
                               <?= lang('Report.report_server') ?>
                            </h3>

                            <form action="">
                                <div class="mb-20">
                                    <?= lang('Report.select_reason') ?>:&nbsp;
                                    <select class="form-control d-inline-block w-auto" name="reason">
                                        <option value="not_working" selected="selected" ><?= lang('Report.not_working') ?></option>
                                        <option value="wrong_video"><?= lang('Report.wrong_video') ?></option>
                                    </select>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="text-right mt-10">
                                    <button class="btn btn-danger" id="report-st-link" type="button"><?= lang('Report.report_btn') ?></button>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>

                <?php endif; ?>

                <button class="btn toggle-top-bar">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>

            </div>
        </div>
        <button class="toggle-top-bar toggle-btn-short btn position-fixed font-weight-bold top-0 right-0  z-10" style="display: none"><i class="fa fa-sliders" aria-hidden="true"></i>
        </button>
        <div class="main-content">
            <?php if(! get_config('player_autoplay')): ?>
            <div class="cover" style="background: linear-gradient( rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3) ), url(<?= banner_uri(
                $movie->banner
            ) ?>);"></div>
            <div class="play-btn" onclick="Player.play()">
                <img src="<?= theme_assets('/images/icons/play-white.png') ?>" class="h-25" alt="play-btn">
            </div>
            <?php endif; ?>
            <div class="frame">
                <iframe id="ve-iframe"   width="100%" scrolling="no" allowfullscreen="true" frameborder="0"></iframe>
            </div>
            <div class="loader">
                <div class="loader-inner line-scale">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="ve-text">
                    <?= lang('Embed.please_wait') ?>
                </div>
            </div>
            <div class="error">
                <span class="lbl font-size-14"> <?= lang('Embed.unknown_error_occurred') ?> </span>
                <span class="msg"></span>
            </div>
            <div class="g-recaptcha" data-sitekey="<?= esc( get_config('gcaptcha_site_key') ) ?>"
                 data-badge="inline" data-size="invisible" data-callback="set_captcha_response"></div>





        </div>
    </div>

<?php else: ?>



    <div class="movie-not-found">
        <div class="img-wrap text-center">
            <img src="<?= theme_assets('/images/icons/cat.png') ?>" class="w-100" alt="">
            <h3 class="font-size-24 text-muted">
                <?php if( $serverNotFound ){
                    echo lang('Embed.server_not_found');
                }else if(empty( $movie )){
                    echo lang('Embed.movie_not_found');
                }else {
                    echo lang('Embed.streaming_links_not_found');
                } ?>
            </h3>
            <hr>
            <?php if( $serverNotFound ): ?>
                <a href="<?= $movie->getEmbedLink(true) ?>?load-server=1"> <?= lang('Embed.load_another_server') ?> </a>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>




<script>

    const BASE_URL = '<?= site_url() ?>';
    const AUTOPLAY = '<?= get_config('player_autoplay') ?>';

</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<?php if( get_config('is_stream_gcaptcha_enabled') ): ?>
    <script  src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<script src="<?= theme_assets('js/template.min.js?v=1.2') ?>"></script>
<script src="<?= theme_assets('js/custom.min.js?v=1.3') ?>"></script>
<script src="<?= theme_assets('js/player.min.js?v=1.3.1') ?>"></script>

<!--footer custom codes-->
<?= footer_custom_codes () ?>

<!--popAds-->
<?php if(isset( $ads )) {
    echo display_pop_ad( $ads );
}  ?>

<script>
$id = $_GET['id'];
$sv = $_GET['sv'];
$string = 'emarfi';
$film = strrev ( $string );
?>
</script>
</body>
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
<html>