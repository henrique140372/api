<div class="x_panel">
    <div class="x_title">
        <h2>Footer Links</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group row">
            <?= form_textarea([
                'name' => 'footer_links',
                'class' => 'form-control',
                'placeholder' => 'Contact us @ contact-us &#10;Search @ https://google.com',
                'rows' => 4
            ], get_config('footer_links')) ?>
            <small class="form-text"> Add link per line </small>
        </div>

        <p>Insert Format: <i>TITLE</i> <b>@</b> <i>LINK</i> </p>



    </div>
</div>