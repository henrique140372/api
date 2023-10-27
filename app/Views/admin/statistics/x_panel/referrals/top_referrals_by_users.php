<div class="x_panel">
    <div class="x_title">
        <h2>  Top Referrals by Users  </h2>

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
                <th  class="text-center">#Rank</th>
                <th >User</th>
                <th class="text-center">Referrals</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($topRefUsers as  $k => $user) : ?>

                <tr>
                    <td  class="text-center"> #<?= $k + 1 ?> </td>
                    <td>
                        <a href="<?= admin_url('/users/edit/' . $user['user_id']) ?>" class="font-weight-bold"> <?= esc( $user['username'] ) ?> </a>
                    </td>
                    <td class="text-center"> <?= nf($user['referrals']) ?> </td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>