<div class="x_panel">
    <div class="x_title">
        <h2>General</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">


        <div class="form-group row">
            <label class="control-label col-md-3">Site Title</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'site_title',
                    'class' => 'form-control',
                    'value' => get_config('site_title')
                ]) ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Site Keywords</label>
            <div class="col-md-9">
                <?= form_textarea([
                    'name' => 'site_keywords',
                    'class' => 'form-control',
                    'rows' => 3
                ], get_config('site_keywords')) ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Site Description</label>
            <div class="col-md-9">
                <?= form_textarea([
                    'name' => 'site_description',
                    'class' => 'form-control',
                    'rows' => 5
                ], get_config('site_description')) ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Site Name/ Logo</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'file',
                    'name' => 'logo_file',
                    'class' => 'mb-3',
                ]) ?>
                <!--img src="<--?= site_logo() ?>" height="35" alt="site_logo"-->
                <img src="<?= site_logo() ?>" height="35" alt="site_logo">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'site_name',
                    'class' => 'form-control',
                    'value' => get_config('site_name')
                ]) ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Site Favicon</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'file',
                    'name' => 'favicon_file',
                    'class' => 'mb-3',
                ]) ?>
                <img src="<?= site_favicon() ?>" height="35" alt="site_logo">
            </div>
        </div>

        <div class="form-group row mt-3">
            <label class="control-label col-md-3">Left Sidebar</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label>
                        <?= form_checkbox('is_sidebar_disabled','1', get_config('is_sidebar_disabled')) ?>
                        Enable/ Disable
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Footer Content</label>
            <div class="col-md-9">
                <?= form_textarea([
                    'name' => 'footer_content',
                    'class' => 'form-control',
                    'rows' => 8
                ], get_config('footer_content')) ?>
                <small>If you use multi languages, use language file to change this footer content</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Site copyright</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'text',
                    'name' => 'site_copyright',
                    'class' => 'form-control',
                    'value' => get_config('site_copyright')
                ]) ?>
                <small>If you use multi languages, use language file to change this footer copyright</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Items per page in library</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'library_items_per_page',
                    'class' => 'form-control',
                    'value' => get_config('library_items_per_page'),
                    'min' => 1,
                    'max' => 60
                ]) ?>
                <small> Min: 1 , Max: 60 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Latest Movies in home</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'home_latest_movies_per_page',
                    'class' => 'form-control',
                    'value' => get_config('home_latest_movies_per_page'),
                    'min' => 0,
                    'max' => 30
                ]) ?>
                <small> Min: 0 , Max: 30 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Latest TV shows in home</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'home_latest_shows_per_page',
                    'class' => 'form-control',
                    'value' => get_config('home_latest_shows_per_page'),
                    'min' => 0,
                    'max' => 30
                ]) ?>
                <small> Min: 0 , Max: 30 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Trending Movies in home</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'home_trending_movies_per_page',
                    'class' => 'form-control',
                    'value' => get_config('home_trending_movies_per_page'),
                    'min' => 0,
                    'max' => 30
                ]) ?>
                <small> Min: 0 , Max: 30 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Trending TV shows in home</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'home_trending_shows_per_page',
                    'class' => 'form-control',
                    'value' => get_config('home_trending_shows_per_page'),
                    'min' => 0,
                    'max' => 30
                ]) ?>
                <small> Min: 0 , Max: 30 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Items per page in trending</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'items_per_trending_page',
                    'class' => 'form-control',
                    'value' => get_config('items_per_trending_page'),
                    'min' => 0,
                    'max' => 100
                ]) ?>
                <small> Min: 0 , Max: 100 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Items per page in recommend</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'items_per_recommend_page',
                    'class' => 'form-control',
                    'value' => get_config('items_per_recommend_page'),
                    'min' => 0,
                    'max' => 100
                ]) ?>
                <small> Min: 0 , Max: 100 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Items per page in new release</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'items_per_new_release_page',
                    'class' => 'form-control',
                    'value' => get_config('items_per_new_release_page'),
                    'min' => 0,
                    'max' => 100
                ]) ?>
                <small> Min: 0 , Max: 100 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Items per page in Imdb top</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'items_per_imdb_top_page',
                    'class' => 'form-control',
                    'value' => get_config('items_per_imdb_top_page'),
                    'min' => 0,
                    'max' => 100
                ]) ?>
                <small> Min: 0 , Max: 100 </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3">Items per page in watch history</label>
            <div class="col-md-9">
                <?= form_input([
                    'type' => 'number',
                    'name' => 'watch_history_limit',
                    'class' => 'form-control',
                    'value' => get_config('watch_history_limit'),
                    'min' => 0,
                    'max' => 50
                ]) ?>
                <small> Min: 0 , Max: 50 </small>
            </div>
        </div>

        <div class="form-group row mt-4">
            <label class="control-label col-md-3">Ad Block Detector</label>
            <div class="col-md-9">
                <div class="checkbox">
                    <label>
                        <?= form_checkbox('ad_block_detector','1', get_config('ad_block_detector')) ?>
                        Enable/ Disable
                    </label>
                </div>
            </div>
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