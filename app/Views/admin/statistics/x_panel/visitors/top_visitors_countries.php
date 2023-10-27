<div class="x_panel">
    <div class="x_title">
        <h2>  Top Views Countries  </h2>

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
                <th>Country</th>
                <th class="text-center">Unique Visits</th>
                <th class="text-center">Total Visits</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($topVisitsByCountries as  $k => $val) : ?>

                <tr>
                    <td  > <?= esc( $val['country_name'] ) ?> </td>
                    <td class="text-center"> <?= nf( $val['uniqVisits'] ) ?> </td>
                    <td class="text-center"> <?= nf( $val['totalVisits'] ) ?> </td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>