<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon text-warning"><i class="fa fa-star "></i></div>
        <div class="count">
            <?= nf( $earningsSummary['credited'] ) ?>
        </div>
        <h3>Earned Stars</h3>
        <ul class="list-group list-group-flush mt-2 lead">
            <li class="list-group-item text-center">
                <span class="px-1 ">
                    <?= stars_exchange($earningsSummary['credited'], true) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon text-success"><i class="fa fa-star "></i></div>
        <div class="count">
            <?= nf( $earningsSummary['active'] ) ?>
        </div>
        <h3>Active Stars</h3>
        <ul class="list-group list-group-flush mt-2 lead">
            <li class="list-group-item text-center">
                <span class="px-1 ">
                    <?= stars_exchange($earningsSummary['active'], true) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon text-secondary"><i class="fa fa-star "></i></div>
        <div class="count">
            <?= nf( $earningsSummary['redeemed'] ) ?>
        </div>
        <h3>Redeemed Stars</h3>
        <ul class="list-group list-group-flush mt-2 lead">
            <li class="list-group-item text-center">
                <span class="px-1 ">
                    <?= stars_exchange($earningsSummary['redeemed'], true) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon text-danger"><i class="fa fa-star-half-full "></i></div>
        <div class="count">
            <?= nf( $earningsSummary['pending'] ) ?>
        </div>
        <h3>Pending Stars</h3>
        <ul class="list-group list-group-flush mt-2 lead">
            <li class="list-group-item text-center">
                <span class="px-1 ">
                    <?= stars_exchange($earningsSummary['pending'], true) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
