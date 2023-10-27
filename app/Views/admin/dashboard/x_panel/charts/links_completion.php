<div class="x_panel">
    <div class="x_title">
        <h2>Conclusao de Links</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div id="links_completion_chart"></div>
        <ul class="list-group list-group-flush font-weight-bold">
            <li class="list-group-item">sem links de transmissso :
                <span class="float-right px-1">
                            <?= number_format( $anytc->links_completion->stream->without ) ?>
                        </span>
            </li>
            <li class="list-group-item">without download links :
                <span class="float-right  px-1">
                            <?= number_format( $anytc->links_completion->download->without ) ?>
                        </span>
            </li>
        </ul>
    </div>
</div>