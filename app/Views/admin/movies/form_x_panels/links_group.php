<div class="x_panel">
    <div class="x_title">
        <h2>Manage Links</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

            <ul class="nav nav-tabs bar_tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"  data-toggle="tab" href="#stream-links" role="tab" >
                        <i class="fa fa-play"></i>&nbsp;
                        Stream
                        <?php if(! empty($movie->id) && isset($streamLinks)): ?>
                        <span class="badge bg-green "><?= count($streamLinks) ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#direct-dl-links" role="tab" >
                        <i class="fa fa-download"></i>&nbsp;
                        Direct DL
                        <?php if(! empty($movie->id) && isset($directDownloadLinks)): ?>
                            <span class="badge bg-green"><?= count($directDownloadLinks) ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#torrent-dl-links" role="tab" >
                        <i class="fa fa-download"></i>&nbsp;
                        Torrent DL
                        <?php if(! empty($movie->id) && isset($torrentDownloadLinks)): ?>
                            <span class="badge bg-green"><?= count($torrentDownloadLinks) ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="stream-links" role="tabpanel" aria-labelledby="home-tab">

                    <?= $this->include('admin/movies/form_x_panels/stream_links.php') ?>


                </div>
                <div class="tab-pane fade" id="direct-dl-links" role="tabpanel" aria-labelledby="profile-tab">

                    <?= $this->include('admin/movies/form_x_panels/direct_download_links.php') ?>

                </div>
                <div class="tab-pane fade" id="torrent-dl-links" role="tabpanel" aria-labelledby="contact-tab">

                    <?= $this->include('admin/movies/form_x_panels/torrent_download_links.php') ?>


                </div>
            </div>


    </div>

</div>