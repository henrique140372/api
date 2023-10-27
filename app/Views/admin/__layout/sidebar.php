<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="   background: #172d44;">
            <a href="<?= site_url('/admin') ?>" class="site_title text-center"> <span>
                   <b>AOSEUGOSTO</b></span>
            <sup>V4.4.4<?= get_config('VERSÃO') ?></sup>
            </a>
        </div>

        <div class="clearfix"></div>

        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a href="<?= admin_url('/dashboard') ?>"><i class="fa fa-dashboard"></i> PAINEL ADM </a></li>

                    <li><a><i class="fa fa-film"></i> FILMES <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/movies/new') ?>">ADICIONAR FILMES</a></li>
                            <li><a href="<?= admin_url('/movies') ?>">VER TUDO</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-video-camera"></i> EPISODIOS <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/episodes/new') ?>">Adicionar Episodio</a></li>
                            <li><a href="<?= admin_url('/episodes') ?>">Ver todos os episodios</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-desktop"></i> Programas de televisao <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/series/new') ?>">Adicionar programa</a></li>
                            <li><a href="<?= admin_url('/series') ?>">Ver todos os shows</a></li>
                        </ul>
                    </li>
                    <?php if( is_admin() ): ?>
                    <li><a><i class="fa fa-users"></i> Sistema de usuarios <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/users/new') ?>">Adicionar usuario</a></li>
                            <li><a href="<?= admin_url('/users') ?>">Ver tudo</a></li>
                            <li><a href="javascript:void(0)">Links <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu">
                                        <a href="<?= admin_url('/users/links/stream') ?>">Stream</a>
                                    </li>
                                    <li>
                                        <a href="<?= admin_url('/users/links/direct_dl') ?>">Direto DL</a>
                                    </li>
                                    <li>
                                        <a href="<?= admin_url('/users/links/torrent_dl') ?>">Torrent DL</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="<?= admin_url('/statistics/earnings') ?>">Ganhos</a></li>
                            <li><a href="<?= admin_url('/statistics/referrals') ?>">Referencias</a></li>
                            <li><a href="<?= admin_url('/payouts') ?>">Pagamentos</a></li>
                            <li><a href="javascript:void(0)">Recompensas <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu">
                                        <a href="<?= admin_url('/rewards/general') ?>">Em geral</a>
                                    </li>
                                    <li>
                                        <a href="<?= admin_url('/rewards/referrals') ?>">Referencias</a>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="<?= admin_url('/settings/users') ?>">Configuracoes</a></li>

                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if( is_admin() ): ?>
                    <li><a href="<?= admin_url('/genres') ?>"><i class="fa fa-th-large"></i> Generos </a></li>
                    <?php endif; ?>

                    <li><a href="<?= admin_url('/bulk-import') ?>"><i class="fa fa-indent"></i> Importacao em massa </a></li>

                    <?php if( is_admin() ): ?>
                    <li><a><i class="fa fa-line-chart"></i> Estatisticas <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/statistics/views') ?>">Visualizacoes de video</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if( is_admin() ): ?>
                    <li><a><i class="fa fa-dollar"></i> Anuncios <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/ads/home_page') ?>">Pagina inicial</a></li>
                            <li><a href="<?= admin_url('/ads/view_page') ?>">Ver pagina</a></li>
                            <li><a href="<?= admin_url('/ads/download_page') ?>">pagina de download</a></li>
                            <li><a href="<?= admin_url('/ads/link_page') ?>">pagina de link</a></li>
                            <li><a href="<?= admin_url('/ads/embed_page') ?>">Embed pagina</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <li><a href="<?= admin_url('/next-for-you') ?>"><i class="fa fa-hand-o-right"></i> Proximo para voce
                            <span class="label label-success badge badge-info pull-right"><?= \App\Models\FailedMovies::getPendingCount() ?></span>
                        </a>
                    </li>
                    <li><a href="<?= admin_url('/requests') ?>"><i class="fa fa-comments-o"></i> Solicitacoes do usuario
                            <span class="label label-success badge badge-info pull-right"><?= \App\Models\RequestsModel::getPendingCount() ?></span>
                        </a>
                    </li>

                    <li><a><i class="fa fa-rocket"></i> Descobrir <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/discover/movies') ?>">FILMES</a></li>
                            <li><a href="<?= admin_url('/discover/shows') ?>">SERIES TV</a></li>
                        </ul>
                    </li>

                    <li><a><i class="fa fa-unlink"></i> Links <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/links') ?>">Ver tudo</a></li>
                            <li><a href="<?= admin_url('/links/reported') ?>">Reportado</a></li>
                            <?php if(! is_admin()): ?>
                            <li><a href="javascript:void(0)">Links <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu">
                                        <a href="<?= admin_url('/links/users-added/stream') ?>">Stream</a>
                                    </li>
                                    <li>
                                        <a href="<?= admin_url('/links/users-added/direct_dl') ?>">Direct DL</a>
                                    </li>
                                    <li>
                                        <a href="<?= admin_url('/links/users-added/torrent_dl') ?>">Torrent DL</a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <?php if( is_admin() ): ?>
                    <li><a><i class="fa fa-files-o"></i> Paginas <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/pages') ?>">Ver tudo</a></li>
                            <li><a href="<?= admin_url('/pages/new') ?>">Nova pagina</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if( is_admin() ): ?>
                    <li><a><i class="fa fa-magic"></i> APIs de terceiros <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/third-party-apis') ?>">Ver tudo</a></li>
                            <li><a href="<?= admin_url('/third-party-apis/new') ?>">Adicionar novo</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if( is_admin() ): ?>
                    <li><a><i class="fa fa-gear"></i> Configuracoes do site<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= admin_url('/settings/site') ?>">SITE</a></li>
                            <li><a href="<?= admin_url('/settings/profile') ?>">PERFIL</a></li>
                            <li><a href="<?= admin_url('/settings/general') ?>">EM GERAL</a></li>
                            <li><a href="<?= admin_url('/settings/servers') ?>">SERVIDORES</a></li>
                            <li><a href="<?= admin_url('/settings/player') ?>">PLAYER</a></li>
                            <li><a href="<?= admin_url('/settings/firewall') ?>">FIREWALL</a></li>
                            <li><a href="<?= admin_url('/settings/cache') ?>">CACHE</a></li>
                            <li><a href="<?= admin_url('/settings/email') ?>">EMAIL</a></li>
                            <li><a href="<?= admin_url('/settings/api') ?>">API DE DESENVOLVIMENTO</a></li>
                            <li><a href="<?= admin_url('/settings/permalinks') ?>">Permalinks</a></li>
                            <li><a href="<?= admin_url('/settings/translations') ?>">TRADUCOES</a></li>
                            <li><a href="<?= admin_url('/settings/backup') ?>">COPIA DE SEGURANCA</a></li>
                            <li><a href="<?= admin_url('/settings/license') ?>">VERIFICA LICENCA</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>


                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <div class="sidebar-footer hidden-small">
            <a href="<?= admin_url('/settings/general') ?>"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Configuracoes">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a href="<?= admin_url('/movies/new') ?>" data-toggle="tooltip" data-placement="top" title="Adicionar filme" data-original-title="FullScreen">
                <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
            </a>
            <a href="<?= admin_url('/episodes/new') ?>" data-toggle="tooltip" data-placement="top" title="Adicionar Episodio" data-original-title="Lock">
                <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="" href="<?= admin_url('/logout') ?>" data-original-title="SAIR DO PAINEL">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</div>