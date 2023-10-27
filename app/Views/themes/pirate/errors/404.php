<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="John Antonio">

    <link href="<?= theme_assets('/css/template.css?v=1.3') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= theme_assets('/css/custom.css?v=1.2' . time()) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">

    <title> 404 Page Not Found </title>
</head>


<body  class="dark-mode with-custom-webkit-scrollbars with-custom-css-scrollbars overflow-x-hidden" >

<!-- Content wrapper start -->
<div class="content-wrapper overflow-x-hidden">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-7 mx-auto">

                <div class="card text-center page-error-card">
                    <h2 class="error-title mb-15" >404</h2>
                    <h4>Page not found</h4>
                    <a href="<?= site_url() ?>" class="font-weight-semi-bold">Go back to home</a>
                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>



