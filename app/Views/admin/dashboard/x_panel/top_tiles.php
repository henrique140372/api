

<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-users"></i></div>
        <div class="count">
            <?= number_format( $anytc->users->total ) ?>
        </div>
        <h3>Users</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Today :
                <span class="float-right px-1">
                            <?= number_format( $anytc->users->today ) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-film "></i></div>
        <div class="count">
            <?= number_format( $anytc->movies->total ) ?>
        </div>
        <h3>Movies</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Today :
                <span class="float-right px-1">
                            <?= number_format( $anytc->movies->today ) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-desktop"></i></div>
        <div class="count">
            <?= number_format( $anytc->series->total ) ?>
        </div>
        <h3>TV Shows</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Today :
                <span class="float-right px-1">
                            <?= number_format( $anytc->series->today ) ?>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-video-camera"></i></div>
        <div class="count">
            <?= number_format( $anytc->episodes->completed ) ?>
        </div>
        <h3>Episodes</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Today :
                <span class="float-right px-1">
                            <?= number_format( $anytc->episodes->today ) ?>
                </span>
            </li>
        </ul>
    </div>
</div>


<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-comments-o"></i></div>
        <div class="count">
            <?= number_format( $anytc->movies_requests->pending ) ?>
        </div>
        <h3>Movies Requests</h3>
    </div>
</div>

<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-money"></i></div>
        <div class="count">
            <?= $anytc->users_balance ?>
            <span style="font-size: 18px;"><?= get_currency_code() ?></span>
        </div>
        <h3>Users Acc. Balance</h3>
    </div>
</div>

<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-sign-out"></i></div>
        <div class="count">
            <?= number_format( $anytc->payouts->pending ) ?>
        </div>
        <h3>Payout Requests</h3>
    </div>
</div>

<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-trophy"></i></div>
        <div class="count"><span class="<?= $anytc->coverage->color_class ?>">
                        <?= number_format( $anytc->coverage->value ) ?>
                    </span>%</div>
        <h3>Coverage</h3>
    </div>
</div>




<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">

        <div class="count">
            <?= number_format( $anytc->views->movies->total + $anytc->views->episodes->total ) ?>
        </div>
        <h3>Total Views</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Movies :
                <span class="float-right px-1">
                            <?= number_format( $anytc->views->movies->total ) ?>
                        </span>
            </li>
            <li class="list-group-item">TV Shows :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->views->episodes->total ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="count">
            <?= number_format( $anytc->views->movies->unique + $anytc->views->episodes->unique ) ?>
        </div>
        <h3>Unique Views</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Movies :
                <span class="float-right px-1">
                            <?= number_format( $anytc->views->movies->unique ) ?>
                        </span>
            </li>
            <li class="list-group-item">TV Shows :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->views->episodes->unique ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="count">
            <?= number_format( $anytc->views->movies->ref_total + $anytc->views->episodes->ref_total ) ?>
        </div>
        <h3>Total Referrals <small>for Views</small> </h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Movies :
                <span class="float-right px-1">
                            <?= number_format( $anytc->views->movies->ref_total ) ?>
                        </span>
            </li>
            <li class="list-group-item">TV Shows :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->views->episodes->ref_total ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="count">
            <?= number_format( $anytc->views->movies->ref_unique + $anytc->views->episodes->ref_unique ) ?>
        </div>
        <h3>Unique Referrals <small>for Views</small> </h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Movies :
                <span class="float-right px-1">
                            <?= number_format( $anytc->views->movies->ref_unique ) ?>
                        </span>
            </li>
            <li class="list-group-item">TV Shows :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->views->episodes->ref_unique ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>

<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-link"></i></div>
        <div class="count">
            <?= number_format( $anytc->users_links->total ) ?>
        </div>
        <h3>Links from Users</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Approved  :
                <span class="float-right px-1">
                            <?= number_format( $anytc->users_links->approved ) ?>
                        </span>
            </li>
            <li class="list-group-item">Pending  :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->users_links->pending ) ?>
                        </span>
            </li>
            <li class="list-group-item">Rejected :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->users_links->rejected ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-link"></i></div>
        <div class="count">
            <?= number_format( $anytc->links->total ) ?>
        </div>
        <h3>Links</h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Streaming  :
                <span class="float-right px-1">
                            <?= number_format( $anytc->links->stream ) ?>
                        </span>
            </li>
            <li class="list-group-item">Direct Download :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->links->direct_dl ) ?>
                        </span>
            </li>
            <li class="list-group-item">Torrent Download :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->links->torrent_dl ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-exchange"></i></div>
        <div class="count">
            <?= number_format( $anytc->links_requests->total ) ?>
        </div>
        <h3>Requests <small>to links</small> </h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Streaming  :
                <span class="float-right px-1">
                            <?= number_format( $anytc->links_requests->stream ) ?>
                        </span>
            </li>
            <li class="list-group-item">Direct Download :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->links_requests->direct_dl ) ?>
                        </span>
            </li>
            <li class="list-group-item">Torrent Download :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->links_requests->torrent_dl ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-unlink"></i></div>
        <div class="count red">
            <?= number_format( $anytc->reported_links->total ) ?>
        </div>
        <h3>Reported <small>links</small></h3>
        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">Streaming  :
                <span class="float-right px-1">
                            <?= number_format( $anytc->reported_links->stream ) ?>
                        </span>
            </li>
            <li class="list-group-item">Direct Download :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->reported_links->direct_dl ) ?>
                        </span>
            </li>
            <li class="list-group-item">Torrent Download :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->reported_links->torrent_dl ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>

