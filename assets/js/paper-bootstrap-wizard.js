/*! =========================================================
 *
 Paper Bootstrap Wizard - V1.0.1
*
* =========================================================
*
* Copyright 2016 Creative Tim (http://www.creative-tim.com/product/paper-bootstrap-wizard)
 *
 *                       _oo0oo_
 *                      o8888888o
 *                      88" . "88
 *                      (| -_- |)
 *                      0\  =  /0
 *                    ___/`---'\___
 *                  .' \|     |// '.
 *                 / \|||  :  |||// \
 *                / _||||| -:- |||||- \
 *               |   | \\  -  /// |   |
 *               | \_|  ''\---/''  |_/ |
 *               \  .-\__  '-'  ___/-. /
 *             ___'. .'  /--.--\  `. .'___
 *          ."" '<  `.___\_<|>_/___.' >' "".
 *         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *         \  \ `_.   \_ __\ /__ _/   .-` /  /
 *     =====`-.____`.___ \_____/___.-`___.-'=====
 *                       `=---='
 *
 *     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *               Buddha Bless:  "No Bugs"
 *
 * ========================================================= */

// Paper Bootstrap Wizard Functions

searchVisible = 0;
transparent = true;
var captchaResponse = [];

        $(document).ready(function(){

            //Initially Checks default choice
            $('.studentoption[value="1"]').prop('checked', true);

            //Recaptcha verify
            $('.formsubmit').click(function(e){
                captchaResponse = grecaptcha.getResponse();
                if(captchaResponse.length){
                    $('.captchaMessage').html('');
                    $('#inquiryform').submit();
                }else{
                    $('.captchaMessage').html('Please verify reCAPTCHA below');
                }
                e.preventDefault();

            });

            /*  Activate the tooltips      */
            $('[rel="tooltip"]').tooltip();

            // Code for the Validator
            var $validator = $('.wizard-card form').validate({
        		  rules: {
        		    fullname: {
        		        required: true
        		    },
        		    email: {
        		        required: true
                    },
                    studentlevel: {
                        required: true
                    },
                    studentnumber: {
                        required: true
                    },
                    studentstrand: {
                        required: true
                    },
                    'concern[]': {
                        required: true
                    },
                    subject: {
                        required: true
                    },
                    inquiry: {
                        required: true
                    },
                },
                messages: {
                    'concern[]': "Please Select an Inquiry Topic"
                },
                errorPlacement: function(error, element) {
                    if($(element).parent('div').parent('div').parent('div').attr('id') == 'choiceparent'){
        
                        parent = $('#choiceparent');
                        $('#choiceerror').html(error[0]['textContent']);

                    }else{
                        error.insertAfter(element);
                    }
                    //console.log($(element).parent('div').parent('div').parent('div').attr('id'));
                },
                success: function(){
                    $('#choiceparent').find('h4').html('');
                }
            });

            //Toggles additional input in form
            if($("input[name='studentoption']:checked").val() == 1){
                toggle_AdditionalFormInfo(1);
            }else{
                toggle_AdditionalFormInfo(0);
            }
            
            $('.studentoption').change(function(){
                if($(this).val() == 1){
                    toggle_AdditionalFormInfo(1);
                }else{
                    toggle_AdditionalFormInfo(0);
                }
            });

            $('.additionnal_basicinfo').on('change','#studentlevel_select',function(){
                
                var enrolled = 0;
                if($("input[name='studentoption']:checked").val() == 1){
                    enrolled = 1;
                }
                if($(this).val() == 'Basic Education'){
                    filterConcernChoices('bed',enrolled);
                    toggle_StrandSelect(0);
                }
                else if($(this).val() == 'Senior Highschool'){
                    filterConcernChoices('shs',enrolled);
                    toggle_StrandSelect(1);
                }
                else if($(this).val() == 'Higher Education'){
                    filterConcernChoices('hed',enrolled)
                    toggle_StrandSelect(0);
                }
                else{
                    filterConcernChoices('none',enrolled);
                    toggle_StrandSelect(0);
                }

            });
        
            // Wizard Initialization
          	$('.wizard-card').bootstrapWizard({
                'tabClass': 'nav nav-pills',
                'nextSelector': '.btn-next',
                'previousSelector': '.btn-previous',

                onNext: function(tab, navigation, index) {
                	var $valid = $('.wizard-card form').valid();
                	if(!$valid) {
                		$validator.focusInvalid();
                		return false;
                	}
                },

                onInit : function(tab, navigation, index){

                  //check number of tabs and fill the entire row
                  var $total = navigation.find('li').length;
                  $width = 100/$total;

                  navigation.find('li').css('width',$width + '%');

                },

                onTabClick : function(tab, navigation, index){

                    var $valid = $('.wizard-card form').valid();

                    if(!$valid){
                        return false;
                    } else{
                        return true;
                    }

                },

                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;

                    var $wizard = navigation.closest('.wizard-card');

                    // If it's the last tab then hide the last button and show the finish instead
                    if($current >= $total) {
                        $($wizard).find('.btn-next').hide();
                        $($wizard).find('.btn-finish').show();
                    } else {
                        $($wizard).find('.btn-next').show();
                        $($wizard).find('.btn-finish').hide();
                    }

                    //update progress
                    var move_distance = 100 / $total;
                    move_distance = move_distance * (index) + move_distance / 2;

                    $wizard.find($('.progress-bar')).css({width: move_distance + '%'});
                    //e.relatedTarget // previous tab

                    $wizard.find($('.wizard-card .nav-pills li.active a .icon-circle')).addClass('checked');

                }
	        });


                // Prepare the preview for profile picture
                $("#wizard-picture").change(function(){
                    readURL(this);
                });

                $('[data-toggle="wizard-radio"]').click(function(){
                    wizard = $(this).closest('.wizard-card');
                    wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
                    $(this).addClass('active');
                    $(wizard).find('[type="radio"]').removeAttr('checked');
                    $(this).find('[type="radio"]').attr('checked','true');
                });

                $('#choiceparent').on('click','[data-toggle="wizard-checkbox"]',function(){
                    if( $(this).hasClass('active')){
                        $(this).removeClass('active');
                        $(this).find('[type="checkbox"]').removeAttr('checked');
                    } else {
                        $('.choice').removeClass('active');
                        $('.choice').find('[type="checkbox"]').prop('checked', false);
                        $(this).addClass('active');
                        $(this).find('[type="checkbox"]').prop('checked', true);
                        subjectPreset($(this).find('[type="checkbox"]').val());
                    }
                });

                $('.set-full-height').css('height', 'auto');

            });



         //Function to show image before upload

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


        function debounce(func, wait, immediate) {
        	var timeout;
        	return function() {
        		var context = this, args = arguments;
        		clearTimeout(timeout);
        		timeout = setTimeout(function() {
        			timeout = null;
        			if (!immediate) func.apply(context, args);
        		}, wait);
        		if (immediate && !timeout) func.apply(context, args);
        	};
        };

        function toggle_AdditionalFormInfo(toggle = 0){
            if(toggle == 1){
                $('.additionnal_basicinfo').html('\
                    <div class="form-group">\
                    <label for="studentlevel_select">Education level</label>\
                    <select class="form-control" name="studentlevel" id="studentlevel_select">\
                        <option selected="selected" disabled>Select Student Education Level</option>\
                        <option>Basic Education</option>\
                        <option>Senior Highschool</option>\
                        <option>Higher Education</option>\
                    </select>\
                    <div class="strandSelect"></div>\
                    </div>\
                    <div class="form-group">\
                        <label>Student Number <small>(required)</small></label>\
                        <input name="studentnumber" type="number" class="form-control">\
                    </div>\
                ');
            }
            else{
                $('.additionnal_basicinfo').html('\
                    <div class="form-group">\
                    <label for="studentlevel_select">Select the student\'s education level</label>\
                    <select class="form-control" name="studentlevel" id="studentlevel_select">\
                        <option selected="selected" disabled>Select Student Education Level</option>\
                        <option>Basic Education</option>\
                        <option>Senior Highschool</option>\
                        <option>Higher Education</option>\
                    </select>\
                    <div class="strandSelect"></div>\
                    </div>\
                ');
            }
        };

        function toggle_StrandSelect(toggle = 0){

            if(toggle == 1){
                $('.strandSelect').html('\
                    <label for="studentstrand_select">Select the student\'s education level</label>\
                    <select class="form-control" name="studentstrand" id="studentstrand_select">\
                        <option selected="selected" disabled>Select Strand</option>\
                        <option>Accountancy & Business Management (ABM)</option>\
                        <option>Humanities & Social Scienece (HUMSS)</option>\
                        <option>Science, Technology, Engineering & Mathematics (STEM)</option>\
                        <option>Technical Vocational Track (TVL)</option>\
                    </select>\
                ');
            }else{
                $('.strandSelect').html('');
            }
        };


        function filterConcernChoices(choice = 'none', enrolled = 1){

            outputs = {
                // Value : icon code
                'Admission':'ti-pencil-alt',
                'Finance':'ti-credit-card',
                'Grades':'ti-ruler-pencil',
                'Others':'ti-info-alt',
                'Documents':'ti-folder'
            }
            if(enrolled == 1){
                choices = {
                    'bed':['Admission','Finance','Grades','Others','Documents'],
                    'shs':['Admission','Finance','Grades','Others','Documents'],
                    'hed':['Admission','Finance','Grades','Documents'],
                    'none':['Admission'],
                };
            }else{
                choices = {
                    'bed':['Admission'],
                    'shs':['Admission'],
                    'hed':['Admission'],
                    'none':['Admission'],
                };
            }

            $('#choiceparent').html('');
            $.each(choices[choice], function( index, value ) {
               
                $('#choiceparent').append('\
                    <div class="col-sm-4 d-flex justify-content-center">\
                        <div class="choice" data-toggle="wizard-checkbox">\
                            <input type="checkbox" class="choice" name="concern[]" value="'+value+'">\
                            <div class="card card-checkboxes card-hover-effect">\
                                <i class="'+outputs[value]+'"></i>\
                                <p>'+value+'</p>\
                            </div>\
                        </div>\
                    </div>\
                ');
                
            });


        }

        function subjectPreset(subject = ''){
            $('#SubjectInput').val(subject);
            
        }


