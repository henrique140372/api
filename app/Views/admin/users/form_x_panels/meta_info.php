<div class="x_panel">

    <div class="x_content">

        <?php if(! empty($user->id)): ?>

        <div class="form-group">
            <label class="control-label">Aprovacao do Administrador: </label>
            <?= form_dropdown([
                'name' => 'is_admin_approved',
                'options' => [ 1 => 'approved', 0 => 'not approved' ],
                'class'   => 'form-control form-control-sm',
                'selected' => old('is_admin_approved', $user->is_admin_approved)
            ]) ?>
        </div>
        <div class="form-group">
            <label class="control-label">Verificacao de email: </label>
            <?= form_dropdown([
                'name' => 'is_email_verified',
                'options' =>  [ 1 => 'verified', 0 => 'not verified' ],
                'class'   => 'form-control form-control-sm',
                'selected' => old('is_email_verified', $user->is_email_verified)
            ]) ?>
        </div>

        <?php endif; ?>

        <div class="form-group">
            <label class="control-label">Papel: </label>
            <?= form_dropdown([
                'name' => 'role',
                'options' =>  array_combine_val_to_keys([
                    \App\Models\UserModel::ROLE_USER,
                    \App\Models\UserModel::ROLE_MODERATOR
                ]) ,
                'class'   => 'form-control form-control-sm',
                'selected' => old('role', $user->role)
            ]) ?>
        </div>
        <div class="form-group">
            <label class="control-label">Status: </label>
            <?= form_dropdown([
                'name' => 'status',
                'options' => array_combine_val_to_keys([
                    \App\Models\UserModel::STATUS_ACTIVE,
                    \App\Models\UserModel::STATUS_PENDING,
                    \App\Models\UserModel::STATUS_BLOCKED
                ]),
                'class'   => 'form-control form-control-sm',
                'selected' => old('status', $user->status)
            ]) ?>
        </div>
    </div>
</div>