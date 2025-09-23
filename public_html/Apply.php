<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="assets/img/favicon.ico" type="image/ico">
        <?php
            include __DIR__ . '/../app/partials/head-includes.html';
        ?>
        <!--Form steps css-->
        <link rel="stylesheet" href="assets/vendor/node_modules/css/bs-stepper.min.css">
        <!--Prism css snippets-->
        <link rel="stylesheet" href="assets/vendor/node_modules/css/prism-tomorrow.css">
        <!-- Main CSS -->
        <link href="assets/css/theme.min.css" rel="stylesheet">

        <title>The Red Legion - Apply</title>
    </head>

    <body>
        <?php
	    	include __DIR__ . '/../app/partials/preloader.html';
	    ?>
        <!--Header Start-->
        <header class="z-fixed header-transparent header-absolute-top sticky-reverse">
            <nav class="navbar navbar-expand-lg navbar-light navbar-link-white">
                <div class="container position-relative">
                    <a class="navbar-brand" href="index.html">
                        <img src="assets/img/logo/logo.png" alt="" class="img-fluid navbar-brand-sticky">
                        <img src="assets/img/logo/logo.png" alt="" class="img-fluid navbar-brand-transparent">
                    </a>
                    <div class="d-flex align-items-center navbar-no-collapse-items order-lg-last">
                        <button class="navbar-toggler order-last" type="button" data-bs-toggle="collapse"
                            data-bs-target="#mainNavbarTheme" aria-controls="mainNavbarTheme" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <i></i>
                            </span>
                        </button>
                        <div class="nav-item me-2 d-none d-xl-flex">
                            <a href="/Login" class="btn btn-danger btn-sm rounded-pill">Staff Login</a>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="mainNavbarTheme">
                    <?php
				        //Set the default active link.
				        $page = 'apply';
			        	include __DIR__ . '/../app/partials/headers/default-navbar-items.html';
		        	?>
                    </div>
                </div>
            </nav>
        </header>
        <!--Main content-->
        <main>
           <!--page-hero-->
           <section class="bg-gradient-primary text-white position-relative">
            <div class="container pt-14 pb-9 pb-lg-12 position-relative z-1">
                <div class="row pt-lg-5 align-items-center justify-content-center text-center">
                        <div class="col-lg-10 col-xl-7 z-2">
                            <div class="position-relative">
                                <div>
                                    <h1 class="mb-0 display-4">
                                        Join The Red Legion
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            
            <section class="position-relative overflow-hidden">
                <div class="container py-9 py-lg-11">
                    <h5 class="mb-7">Steps Default</h5>
                    <!--Steps default start-->
                    <div class="bs-stepper" id="stepperDemo">
                        <!--Stepper header start-->
                        <div class="bs-stepper-header pb-3 align-items-start align-items-md-center flex-md-row flex-column p-0"
                            role="tablist">
                            <!--Step-Header-item-->
                            <div class="step active" data-target="#stepper-step-1">
                                <button type="button" class="step-trigger ps-0 py-2 flex-nowrap" role="tab"
                                    id="stepperDemotrigger1" aria-controls="stepper-step-1" aria-selected="true">
                                    <span class="bs-stepper-circle rounded-2">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <span
                                        class="flex-grow-1 flex-wrap d-flex flex-column jusitfy-content-start text-start">
                                        <span class="bs-stepper-label h6 m-0">Account Details</span>
                                        <small class="opacity-75">Setup account details</small>
                                    </span>
                                </button>
                            </div>
                            <!--Divider line-->
                            <div class="step-line d-none d-md-block">
                                <i class='bi bi-chevron-double-right'></i>
                            </div>
                            <!--Step-Header-item-->
                            <div class="step" data-target="#stepper-step-2">
                                <button type="button" class="step-trigger py-2 ps-0 ps-md-2 flex-nowrap" role="tab"
                                    id="stepperDemotrigger2" aria-controls="stepper-step-2" aria-selected="false">
                                    <span class="bs-stepper-circle rounded-2">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <span
                                        class="flex-grow-1 flex-wrap d-flex flex-column jusitfy-content-start text-start">
                                        <span class="bs-stepper-label h6 m-0">Address & Payments</span>
                                        <small class="opacity-75">Add address & payment methods</small>
                                    </span>
                                </button>
                            </div>
                            <!--Divider line-->
                            <div class="step-line d-none d-md-block">
                                <i class='bi bi-chevron-double-right'></i>
                            </div>
                            <!--Step-Header-item-->
                            <div class="step" data-target="#stepper-step-3">
                                <button type="button" class="step-trigger py-2 ps-0 ps-md-2 flex-nowrap" role="tab"
                                    id="stepperDemotrigger3" aria-controls="stepper-step-3" aria-selected="false">
                                    <span class="bs-stepper-circle rounded-2">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>
                                    <span
                                        class="flex-grow-1 flex-wrap d-flex flex-column jusitfy-content-start text-start">
                                        <span class="bs-stepper-label h6 m-0">Social Links</span>
                                        <small class="opacity-75">Add social links</small>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <!--Stepper header end-->

                        <!--Stepper content start-->
                        <div class="bs-stepper-content p-0">
                            <div class="card card-body h-100">
                                <form class="h-100 d-flex flex-column" action="#">

                                    <!--Step-1-->
                                    <div id="stepper-step-1" class="content h-100" aria-labelledby="stepper-step-1">
                                        <div class="d-flex flex-column h-100">
                                            <!--Step Title-->
                                            <div class="flex-shrink-0 pb-3 border-bottom">
                                                <h6 class="mb-1">Account Details</h6>
                                                <p class="text-body-secondary small mb-0">Add Account Details</p>
                                            </div>

                                            <!--Step main content-->
                                            <div class="flex-grow-1 py-4">
                                                Add Account Details
                                            </div>
                                            <!--Step footer-->
                                            <div class="d-flex border-top pt-3 justify-content-end">
                                                <button type="button" class="btn btn-primary" onclick="stepDemo.next()">
                                                    Save & Next <i class="bi bi-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Step-2-->
                                    <div id="stepper-step-2" class="content h-100" aria-labelledby="stepper-step-2">
                                        <div class="d-flex flex-column h-100">
                                            <!--Step Title-->
                                            <div class="flex-shrink-0 pb-3 border-bottom">
                                                <h6 class="mb-1">Address & Paymnets</h6>
                                                <p class="text-body-secondary small mb-0">Add address & paymnet method</p>
                                            </div>
                                            <!--Step main content-->
                                            <div class="flex-grow-1 py-4">
                                                Add address & paymnet method
                                            </div>
                                            <!--Step footer-->
                                            <div class="d-flex border-top pt-3 justify-content-between">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="stepDemo.previous()">
                                                    <i class="bi bi-arrow-left"></i> Back
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="stepDemo.next()">
                                                    Save & Next <i class="bi bi-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Step-3-->
                                    <div id="stepper-step-3" class="content h-100" aria-labelledby="stepper-step-3">
                                        <div class="d-flex h-100 flex-column">

                                            <!--Step Title-->
                                            <div class="flex-shrink-0 pb-3 border-bottom">
                                                <h6 class="mb-1">Social Links
                                                </h6>
                                                <p class="text-body-secondary small mb-0"> Add social links
                                                </p>
                                            </div>
                                            <!--Step main content-->
                                            <div class="flex-grow-1 py-4">
                                                Add social links
                                            </div>

                                            <!--Step footer-->
                                            <div class="d-flex pt-3 border-top justify-content-between">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="stepDemo.previous()">
                                                    <i class="bi bi-arrow-left"></i> Back
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Submit <i class="bi bi-send ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--Stepper content end-->
                    </div>
                </div>
            </section>


            
        </main>

        <?php
		    //Footer.	
	    	include __DIR__ . '/../app/partials/footers/footer-9.php';
        ?>
        <!-- begin Back to Top button -->
        <a href="#" class="toTop"><svg class="progress-circle" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
  <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="0, 251.2"></circle>
</svg>
            <i class="bi bi-chevron-up"></i>
        </a>
        <!-- scripts -->
        <script src="assets/js/theme.bundle.min.js"></script>
        <!--Form steps script-->
        <script src="assets/vendor/node_modules/js/bs-stepper.min.js"></script>
        <script>
            var stepDemo = new Stepper(document.querySelector('#stepperDemo'));
            stepDemo.next();
            stepDemo.previous()

            //Vertical Steps
            var stepDemoVertical = new Stepper(document.querySelector('#stepperDemoVertical'));
            stepDemoVertical.next();
            stepDemoVertical.previous()

        </script>


        <!--Copy to clipboard + prismJs-->
        <script src="assets/vendor/node_modules/js/prism.js"></script>
        <script src="assets/vendor/node_modules/js/clipboard.min.js"></script>
        <script>
            /* Clipboard JS - Copy code button */
            var cl = document.querySelector('.copy-link');
            if (typeof !!cl && (cl) != 'undefined' && cl != null) {
                var cle = document.querySelectorAll('.copy-link');
                cle.forEach(el => {
                    el.addEventListener("click", function () {
                        var theButton = this;
                        var copyId = this.getAttribute('id');
                        var clipboard = new ClipboardJS('#' + copyId);

                        clipboard.on('success', function (e) {
                            e.clearSelection();
                            theButton.innerHTML = 'Copied!';
                            setTimeout(function () {
                                theButton.innerHTML = 'Copy code';
                            }, 5000);
                        });
                    });
                });
            }

        </script>
    </body>

</html>
