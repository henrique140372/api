<div class="x_panel">

    <div class="x_content">

        <div class="form-group">
            <span>ultimo acesso em:&nbsp; </span>
            <?php if(! $user->isFirstLogin()): ?>
            <b> <?= \CodeIgniter\I18n\Time::parse($user->last_logged_at)->humanize() ?></b>
            <?php else: ?>
            <i> usuario ainda nao logado </i>
            <?php endif; ?>
        </div>

        <div class="form-group mb-0">
            <span class="">registrado em:&nbsp; </span>
            <b><?= format_date_time($user->created_at, true) ?></b>
        </div>

    </div>
</div>