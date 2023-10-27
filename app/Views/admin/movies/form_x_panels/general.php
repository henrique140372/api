<div class="x_panel">
    <div class="x_title">
        <h2>General Information</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
                <a class="collapse-link">
                    <?php if(empty($movie->id)) {
                        echo '<i class="fa fa-chevron-up"></i>';
                    }else{
                        echo '<i class="fa fa-chevron-down"></i>';
                    } ?>

                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" style="<?= ! empty($movie->id) ? 'display:none' : '' ?>" >

        <div class="form-group">
            <?= form_label('Title *:') ?>
            <?= form_input( [
                'name' => 'title',
                'value' => old('title', $movie->title),
                'class' => 'form-control title-suggest',
                'data-type' => 'movie'
            ] ) ?>
            <span class="form-text">Enter movie title here to suggest movies.</span>
        </div>

        <div  id="suggest-results"></div>

        <?php if(is_movies_dynamic_slug_enabled() && ! empty($movie->id)): ?>
        <div class="form-group">
            <?= form_label('Custom Slug:') ?>
            <?= form_input( [
                'value' => create_custom_movie_slug( $movie ),
                'class' => 'form-control',
                'disabled' => 'disabled'
            ] ) ?>
        </div>
        <?php endif; ?>


        <div class="form-group row">
            <div class="col">
                <?= form_label('IMDB Id *:') ?>
                <?=  form_input( [
                    'name' => 'imdb_id',
                    'value' => old('imdb_id', $movie->imdb_id),
                    'class' => 'form-control'
                ] ) ?>
            </div>
            <div class="col">
                <?= form_label('TMDB Id :') ?>
                <?= form_input( [
                    'name' => 'tmdb_id',
                    'value' => old('tmdb_id', $movie->tmdb_id),
                    'class' => 'form-control'
                ] ) ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_label('Short Description *:') ?>
            <?= form_textarea( [
                'name' => 'description',
                'class' => 'form-control',
                'rows' => 8
            ], old('description', $movie->description ?? '' ) ) ?>
        </div>


    </div>
</div>