<div style="background-image: url('<?php echo base_url(); ?>assets/img/background.jpg');
height: 100%;
background-attachment: fixed;
background-repeat: no-repeat;
background-position: center;
background-size: cover;
position: fixed;
width: 100%;
">
</div>

<!--   Big container   -->
<div class="container">
	<div class="row">
		<div class="col-sm-12 ">

			<!--      Wizard container        -->
			<div class="wizard-container">

				<div class="card wizard-card" style="background:#800000; color:white" data-color="orange" id="wizardProfile">

					<div class="helplogo">
						<img src="<?php echo base_url(); ?>assets/img/Logo.jpg">
					</div>

					<form action="<?php echo base_url(); ?>index.php/Main/Inquire" method="POST" id="inquiryform">
						<!--You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"-->

						<div class="wizard-header">

							<h3 class="wizard-title">WE'RE GLAD TO ASSIST YOU!</h3><br>
							<h5 class="wizard-title">
							Please complete the information on the following field and let us know <br> how we may help you. 
							We'll do our best to be as responsive as possible</h5>
							<br>

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
										<div class="form-group">
											<label>Contact Number <small>(required)</small></label>
											<input name="contactnumber" type="number" class="form-control">
										</div>
										<label>Is the inquiry about your enrolled child? <small>(required)</small></label>
										<div class="radio">
											<label>
												<input type="radio" class="childRadio studentoption" name="studentoption" value="1">
												Yes
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" class="childRadio studentoption" name="studentoption" value="0">
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
									<div class="col-sm-12">
										<h4 id="choiceerror"></h4>
									</div>
									<div class="col-sm-8 col-sm-offset-2" id="choiceparent">
										
										<div class="col-sm-4">
											<div class="choice" data-toggle="wizard-checkbox">
												<input type="checkbox" class="choice" name="concern[]" value="1">
												<div class="card card-checkboxes card-hover-effect">
													<i class="ti-pencil-alt"></i>
													<p>Admission</p>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="choice" data-toggle="wizard-checkbox">
												<input type="checkbox" class="choice" name="concern[]" value="2">
												<div class="card card-checkboxes card-hover-effect">
													<i class="ti-credit-card"></i>
													<p>Finance</p>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="choice" data-toggle="wizard-checkbox">
												<input type="checkbox" class="choice" name="concern[]" value="3">
												<div class="card card-checkboxes card-hover-effect">
													<i class="ti-ruler-pencil"></i>
													<p>Grades</p>
												</div>
											</div>
										</div>
										<div class="col-sm-4 col-sm-offset-2">
											<div class="choice" data-toggle="wizard-checkbox">
												<input type="checkbox" class="choice" name="concern[]" value="5">
												<div class="card card-checkboxes card-hover-effect">
													<i class="ti-info-alt"></i>
													<p>Others</p>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="choice" data-toggle="wizard-checkbox">
												<input type="checkbox" class="choice" name="concern[]" value="4">
												<div class="card card-checkboxes card-hover-effect">
													<i class="ti-folder"></i>
													<p>Documents</p>
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
</div> 
<!--  big container -->


