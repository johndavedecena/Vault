<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nothing Found | IT Assets</title>
    @include('Includes.css_tb')
</head>
<body>
    <div class="container">
        <section class="space"></section>
        <div class="error">
            <a class="navbar-brand" href="{{ URL() }}"><img alt="logo" src="{{ URL() }}/images/nwl/nwllogo.png"/></a>
            <section class="tab_space"></section>
            <p class="error-msg">404 error: page out of site</p>
        </div>
        <div class="main_contain page-error">
            <section class="space"></section>
            <div class="well error-innermsg">
                <section class="brand-error">
                    <img src="{{ URL() }}/images/nwl/error-image.png">
                </section>
                <h6>GO HOME YOU'RE DRUNK</h6>
                <section class="space"></section>
                <p>We are not sure how you were able to find this magical and deserted place, <br/>but the page you were looking for is so lost that we are seriously considering placing a "missing" ad. <br/>We've tried everything so far, and sadly, <br/>not even good old <b>&quot;Abracadabra&quot;</b> works anymore, so until we find it you could go:</p>
                <section class="space"></section>
                <div class="col-md-4 col-md-offset-5">
                    <button class="btn btn-sm btn-info" onclick="<?php echo Session::get('page')!=null ? Session::get('page'): URL() ?>">Back to Previous Page</button>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
    @include('Includes.footer')
    <!-- /.footer -->
<!-- Load JS here for greater good =============================-->
@include('Includes.Scripts.scripts')
</body>
</html>