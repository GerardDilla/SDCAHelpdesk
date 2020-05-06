<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.png" />
	<title>Material Bootstrap Wizard by Creative Tim | Free Boostrap Wizard</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/paper-bootstrap-wizard"/>

    <meta name="keywords" content="wizard, bootstrap wizard, creative tim, long forms, 3 step wizard, sign up wizard, beautiful wizard, long forms wizard, wizard with validation, paper design, paper wizard bootstrap, bootstrap paper wizard">
    <meta name="description" content="Paper Bootstrap Wizard is a fully responsive wizard that is inspired by our famous Paper Kit  and comes with 3 useful examples and 5 colors.">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Paper Bootstrap Wizard by Creative Tim">
    <meta itemprop="description" content="Paper Bootstrap Wizard is a fully responsive wizard that is inspired by our famous Paper Kit  and comes with 3 useful examples and 5 colors.">
    <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/49/opt_pbw_thumbnail.jpg">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@creativetim">
    <meta name="twitter:title" content="Paper Bootstrap Wizard by Creative Tim">
    <meta name="twitter:description" content="Paper Bootstrap Wizard is a fully responsive wizard that is inspired by our famous Paper Kit  and comes with 3 useful examples and 5 colors.">
    <meta name="twitter:creator" content="@creativetim">
    <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/49/opt_pbw_thumbnail.jpg">

    <!-- Open Graph data -->
    <meta property="og:title" content="Paper Bootstrap Wizard by Creative Tim | Free Boostrap Wizard" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://demos.creative-tim.com/paper-bootstrap-wizard/wizard-list-place.html" />
    <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/49/opt_pbw_thumbnail.jpg" />
    <meta property="og:description" content="Paper Bootstrap Wizard is a fully responsive wizard that is inspired by our famous Paper Kit  and comes with 3 useful examples and 5 colors." />
    <meta property="og:site_name" content="Creative Tim" />

	<!-- CSS Files -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="<?php echo base_url(); ?>assets/css/demo.css" rel="stylesheet" />

	<!-- Fonts and Icons -->
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url(); ?>assets/css/themify-icons.css" rel="stylesheet">

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	</head>

	<body>

	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-12 ">

		            <!--      Wizard container        -->
		            <div class="wizard-container">

		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    <form action="" method="POST" id="inquiryform">
		                <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->

		                    	<div class="wizard-header text-center">
		                        	<h1 class="wizard-title">SUBMIT YOUR INQUIRY</h1>
									<p class="category">Fill out the following fields, submit, and wait for a reply to your email</p>
		                    	</div>

								<div class="wizard-navigation">
									<div class="progress-with-circle">
									     <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
									</div>
									<ul>
			                            <li>
											<a href="#about" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-user"></i>
												</div>
												About
											</a>
										</li>
			                            <li>
											<a href="#account" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-book"></i>
												</div>
												Subject
											</a>
										</li>
			                            <li>
											<a href="#address" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-email"></i>
												</div>
												Inquiry
											</a>
										</li>
			                        </ul>
								</div>
		                        <div class="tab-content">
		                            <div class="tab-pane" id="about">
		                            	<div class="row">
											<h5 class="info-text"> Provide your basic information</h5>
											<div class="col-sm-10 col-sm-offset-1">
												<div class="form-group">
													<label>Name <small>(required)</small></label>
													<input name="fullname" type="text" class="form-control" placeholder="Juan Cruz...">
												</div>
												<div class="form-group">
													<label>Email <small>(required)</small></label>
													<input name="email" type="email" class="form-control" placeholder="JuanCruz@email.com">
												</div>
												<hr>
												<label>Is the inquiry about your enrolled child? <small>(required)</small></label>
												<div class="radio">
													<label>
														<input type="radio" class="childRadio studentoption" name="studentoption" value="1">
														Yes
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" class="childRadio studentoption" name="studentoption" value="0" checked="true">
														No
													</label>
												</div>
												<div class="additionnal_basicinfo">

												</div>
											</div>
										</div>
		                            </div>
		                            <div class="tab-pane" id="account">
		                                <h5 class="info-text"> What's the subject of your concern? (Click one of the boxes below) </h5>
		                                <div class="row">
		                                    <div class="col-sm-8 col-sm-offset-2" id="choiceparent">
												<h4></h4>
		                                        <div class="col-sm-4">
		                                            <div class="choice" data-toggle="wizard-checkbox">
		                                                <input type="checkbox" class="choice" name="concern[]" value="Admission">
		                                                <div class="card card-checkboxes card-hover-effect">
		                                                    <i class="ti-pencil-alt"></i>
															<p>Admission</p>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="col-sm-4">
		                                            <div class="choice" data-toggle="wizard-checkbox">
		                                                <input type="checkbox" class="choice" name="concern[]" value="Finance">
		                                                <div class="card card-checkboxes card-hover-effect">
		                                                    <i class="ti-credit-card"></i>
															<p>Finance</p>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="col-sm-4">
		                                            <div class="choice" data-toggle="wizard-checkbox">
		                                                <input type="checkbox" class="choice" name="concern[]" value="Grades">
		                                                <div class="card card-checkboxes card-hover-effect">
		                                                    <i class="ti-ruler-pencil"></i>
															<p>Grades</p>
		                                                </div>
		                                            </div>
												</div>
												<div class="col-sm-4 col-sm-offset-4">
		                                            <div class="choice" data-toggle="wizard-checkbox">
		                                                <input type="checkbox" class="choice" name="concern[]" value="Others">
		                                                <div class="card card-checkboxes card-hover-effect">
		                                                    <i class="ti-info-alt"></i>
															<p>Others</p>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="tab-pane" id="address">
		                                <div class="row">
		                                    <div class="col-sm-12">
		                                        <h5 class="info-text"> Tell us your inquiry </h5>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label>Subject <small>(required)</small></label>
													<input name="subject" id="SubjectInput" type="text" class="form-control" placeholder="">
												</div>
												<div class="form-group">
													<label for="exampleFormControlTextarea1">Inquiry <small>(required)</small></label>
													<textarea class="form-control" name="inquiry" id="exampleFormControlTextarea1" rows="3"></textarea>
												</div>
												<h5 class="captchaMessage"></h5>
												<div class="g-recaptcha" data-sitekey="6LeWcSQUAAAAAN0dGTGNeBZkICUKTIrPUDfTA1Gt"></div>
												<br/>
		                                    </div>

		                                </div>
		                            </div>
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Next' />
		                                <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd formsubmit' name='finish' value='Finish' />
		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div><!-- end row -->
		</div> <!--  big container -->

	</body>

	<!--   Core JS Files   -->
	<script src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="<?php echo base_url(); ?>assets/js/demo.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

	<!--  More information about jquery.validate here: https://jqueryvalidation.org/	 -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>

</html>
