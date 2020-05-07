
<!--   Big container   -->
<div class="container">
	<div class="row">
		<div class="col-sm-12 ">

			<!--      Wizard container        -->
			<div class="wizard-container">

				<div class="card wizard-card" data-color="orange" id="wizardProfile">
					<div class="row">
						<div class="col-md-12" style="text-align:center;">
							<h2>
								<?php echo $this->session->flashdata('Message')['primary']; ?>
							</h2>
							<h4 style="color:#666">
								<?php echo $this->session->flashdata('Message')['secondary']; ?>
							</h4>
						</div>
						<div class="col-md-12" style="text-align:center; padding-top:10%">
							<a class="btn btn-info btn-md" href="<?php echo base_url(); ?>index.php/Main" >Back to Form</a>
						</div>
					</div>
				</div>
			</div> <!-- wizard container -->
		</div>
	</div><!-- end row -->
</div> 
<!--  big container -->

