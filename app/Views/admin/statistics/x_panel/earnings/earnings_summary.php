<div class="x_panel">
    <div class="x_title">
        <h2>  Earnings Summary  </h2>

        <ul class="nav navbar-right panel_toolbox">

            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Stars Type</th>
                <th class="text-center text-success">Earned Stars</th>
                <th class="text-center text-danger">Lost Stars</th>
                <th class="text-center text-warning">Pending Stars</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($earningsByType as $type => $earn) : ?>

                <tr>
                    <td> <?= clean_undscr_txt( $type ) ?> </td>
                    <td class="text-center"> <?= nf($earn['credited']) ?> </td>
                    <td class="text-center"> <?= nf($earn['rejected']) ?> </td>
                    <td class="text-center"> <?= nf($earn['pending']) ?> </td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>