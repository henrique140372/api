


<div class="x_panel">

    <div class="x_content">
        <div class="form-group" style="margin-bottom:2rem;">
            <label class="control-label ">NOME API: </label>&nbsp;
            <?= form_input([
                'name' => 'name',
                'class' => 'form-control w-auto',
                'value' => old('name', $tpAPI->name),
                'required' => 'required'
            ]) ?>
        </div>

        <div class="form-group">
            <label class="control-label ">FILMES API: </label>
            <?= form_input([
                'type' => 'url',
                'name' => 'movie_api',
                'class' => 'form-control',
                'value' => old('movie_api', $tpAPI->movie_api),
            ]) ?>
        </div>
        <div class="form-group">
            <label class="control-label ">SERIES API: </label>
            <?= form_input([
                'type' => 'url',
                'name' => 'series_api',
                'class' => 'form-control',
                'value' => old('series_api', $tpAPI->series_api),
            ]) ?>
        </div>

        <?php if(! empty($tpAPI->id)): ?>
        <div class="form-group text-right mt-3">
            <?= form_label('Status:', '',['class' => 'control-label' ]) ?>
            <?= form_dropdown([
                'name' => 'status',
                'options' => [
                    'active' => 'Active',
                    'paused' => 'Paused'
                ],
                'selected' => [ old('status', $tpAPI->status) ],
                'class' => 'form-control w-auto d-inline-block'
            ]); ?>
        </div>

        <?php endif; ?>

    </div>
</div>


<div class="text-right">
    <button type="submit" class="btn btn-primary d-inline-block px-5">SALVAR AGORA</button>
</div>
