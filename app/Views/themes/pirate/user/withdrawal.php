<?=$this->extend(theme_path('user/__layout/base')) ?>

<?=$this->section("content") ?>

<div class="content d-flex align-items-center justify-content-between">
    <h3 class="content-title "> <?=esc($title) ?> </h3>
    <div>
        <a href="<?=site_url('/user/payouts') ?>" type="button" class="btn font-weight-semi-bold" >
            <i class="fa fa-list" aria-hidden="true"></i>&nbsp;
            <?=lang("User/Earnings.payouts_overview") ?>
        </a>
    </div>
</div>

<?=display_alerts() ?>


<div class="row row-eq-spacing">

    <div class="col-6 col-lg-4">
        <div class="card p-15">
            <h4 class="font-weight-semi-bold  my-0">
                <span class="text-secondary">
                    <i class="fa fa-star"></i>
                </span>
                &nbsp;
                <span class="text-muted">
                    <i class="fa fa-exchange" aria-hidden="true"></i>
                </span>
                &nbsp;
                <span><?=get_stars_exchange_rate(true) ?></span>
            </h4>
            <h2 class="card-title text-muted font-size-14 mt-5 mb-0">
                <?=lang("User/Earnings.stars_exchange_rate") ?>
            </h2>
        </div>
    </div>

    <div class="col-6 col-lg-4">
        <div class="card p-15">
            <h4 class="font-weight-semi-bold  my-0">
                <span class="text-primary">
                   <?=nf($activeStars) ?>
                </span>
                &nbsp;
                <span class="text-muted font-size-14 font-weight-normal">
                    ( <?=stars_exchange($activeStars, true) ?> )
                </span>


            </h4>
            <h2 class="card-title text-muted font-size-14 mt-5 mb-0">
                <?=lang("User/Earnings.active_stars_for_redeem") ?>
            </h2>
        </div>
    </div>

</div>

<div class="row row-eq-spacing">
    <div class="col-lg-8">

        <?php if (empty($pendingPayout)): ?>

            <div class="card p-0">
                <!-- Card header -->
                <div class="px-card py-10 border-bottom">
                    <h2 class="card-title font-size-18 m-0">
                        <?=lang("User/Earnings.redeem_stars") ?>
                    </h2>
                </div>
                <!-- Content -->
                <div class="content">

                    <p>
                        If you have more than <?=nf(get_config('min_payout_stars')) ?>estrelas, você pode resgatar suas estrelas usando os seguintes métodos de pagamento:
                    </p>

                    <?=form_open('/user/earnings/create', ['class' => 'form-inline']) ?>

                    <div class="form-group">
                        <label class="required w-250"> <?=lang("User/Earnings.num_of_stars_for_redeem") ?> : </label>
                        <input type="number" class="form-control" name="stars" min="0" required="required">
                    </div>
                    <div class="form-group">
                        <label class="required w-250" ><?=lang("User/Earnings.payment_destination") ?> : </label>
                        <input type="text" class="form-control" name="account_details"  required="required">
                    </div>
                    <?php if (!empty(get_payment_methods_for_payouts())): ?>
                        <div class="form-group">
                            <label class="required w-250 mb-10" ><?=lang("User/Earnings.payment_method") ?> : </label>

                            <?php foreach (get_payment_methods_for_payouts() as $payMethod): ?>
                                <div class="custom-radio mt-0 mr-15">
                                    <input type="radio" name="payment_method" id="<?=$payMethod
                                    ?>" value="<?=$payMethod
                                    ?>">
                                    <label for="<?=$payMethod
                                    ?>"><?=$payMethod
                                        ?></label>
                                </div>
                            <?php
                            endforeach; ?>

                        </div>
                    <?php
                    endif; ?>

                    <div class="form-group mb-0">
                        <input type="submit" class="btn btn-primary ml-auto" value="<?=lang("User/Earnings.submit_btn") ?>">
                    </div>

                    <?=form_close() ?>
                </div>
                <!-- Card footer -->
                <?php if (!empty(get_config('note_about_payout_date'))): ?>
                    <div class="px-card py-10 bg-light-lm bg-very-dark-dm rounded-bottom">
                        <p class="font-size-12 m-0">
                            <?=esc(get_config('note_about_payout_date')) ?>
                        </p>
                    </div>
                <?php
                endif; ?>
            </div>

        <?php
        else: ?>

            <div class="card p-0">
                <!-- Card header -->
                <div class="px-card py-10 px-15 border-bottom m-0">
                    <h2 class="card-title font-size-18 m-0">
                        Resgate programado de estrelas
                    </h2>
                </div>
                <div class="content m-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Método</th>
                            <th>Detalhes da contas</th>
                            <th>Estrelas</th>
                            <th>Você vai ter</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>

                            <td> <?=$pendingPayout->payment_method ?> </td>
                            <td> <?=$pendingPayout->account_details ?> </td>
                            <td> <?=nf($pendingPayout->stars) ?> </td>
                            <td>
                                <span class="badge font-weight-semi-bold">
                                    <?=stars_exchange($pendingPayout->stars, true) ?>
                                </span>
                            </td>

                        </tr>


                        </tbody>
                    </table>

                    <div class="d-flex align-items-center justify-content-between p-15">
                        <div class="text-muted">
                            <span >Data de pagamento agendada	: </span>
                        </div>
                        <a href="<?=site_url('/user/earnings/cancel') ?>" class="btn ">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

        <?php
        endif; ?>


    </div>
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