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
            $('.formsubmit').prop('disabled', true);
            validationRules();
        }else{
            $('.captchaMessage').html('Please verify reCAPTCHA below');
        }
        e.preventDefault();

    });

    /*  Activate the tooltips      */
    $('[rel="tooltip"]').tooltip();

    // Code for the Validator
    var $validator = validationRules();

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
        if($(this).val() == 3){
            filterConcernChoices('bed',enrolled);
            toggle_StrandSelect(0);
        }
        else if($(this).val() == 2){
            filterConcernChoices('shs',enrolled);
            toggle_StrandSelect(1);
        }
        else if($(this).val() == 1){
            filterConcernChoices('hed',enrolled)
            toggle_StrandSelect(2);
        }
        else{
            filterConcernChoices('none',enrolled);
            toggle_StrandSelect(0);
        }

    });

    $('.additionnal_basicinfo').on('change','#studentdept_select',function(){
        
        getPrograms($(this).val());

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

            /* //Uncomment to make it togglable PS: buggy
            if( $(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('[type="checkbox"]').removeAttr('checked');
            } else {

            }
            */

            $('.choice').removeClass('active');
            $('.choice').find('[type="checkbox"]').prop('checked', false);
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').prop('checked', true);
            subjectPreset($(this).find('[type="checkbox"]').data('name'));
        });

        $('.set-full-height').css('height', 'auto');

    });


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
                <option value="3">Basic Education</option>\
                <option value="2">Senior Highschool</option>\
                <option value="1">Higher Education</option>\
            </select>\
            <div class="strandSelect"></div>\
            </div>\
            <div class="form-group">\
                <label>Student Number / Reference Number <small>(required)</small></label>\
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
                <option value="3">Basic Education</option>\
                <option value="2">Senior Highschool</option>\
                <option value="1">Higher Education</option>\
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
    }
    else if(toggle == 2){

        getDepartments();

    }
    else{
        $('.strandSelect').html('');
    }
};


function filterConcernChoices(choice = 'none', enrolled = 1){

    outputData = getInquirySubjects();
    outputData.done(function(data){
        outputs = JSON.parse(data);

        if(enrolled == 1){
            choices = {
                'bed':['Admission','Finance','Grades','Documents','Library','Others'],
                'shs':['Admission','Finance','Grades','Documents','Library','Others'],
                'hed':['Admission','Finance','Grades','Documents','Library','Others'],
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
                        <input type="checkbox" class="choice" name="concern[]" value="'+outputs[value]['ID']+'" data-name="'+outputs[value]['Name']+'">\
                        <div class="card card-checkboxes card-hover-effect">\
                            <i class="'+outputs[value]['Icon']+'"></i>\
                            <p>'+outputs[value]['Name']+'</p>\
                        </div>\
                    </div>\
                </div>\
            ');
            
        });

        var $validator = validationRules();

    });

}

function subjectPreset(subject = ''){

    $('#SubjectInput').val(subject);
    
}

function getPrograms(school_id = 0){

    $.ajax({
        url: baseurl()+"index.php/Main/getPrograms",
        type: 'POST',
        data: {
            school_id: school_id
        },
        success: function(response){

            data = JSON.parse(response);

            options = '';
            $.each(data, function( index, value ) {
                options += '<option value="'+value['Program_ID']+'">'+value['Program_Name']+'  ('+value['Program_Code']+')</option>';
            });
            $('.strandSelect .programselect').html('\
                <label for="studentprogram_select">Select Program</label>\
                <select class="form-control" name="studentprogram" id="studentprogram_select">\
                    <option selected="selected" disabled>Select Department</option>\
                    '+options+'\
                </select>\
            ');
            console.log(data);
        },
        fail: function(){
            alert('Error Connecting to Server');
        }
    });

}

function getDepartments(){

    $.ajax({
        url: baseurl()+"index.php/Main/getDepartments",
        type: 'GET',
        success: function(response){

            data = JSON.parse(response);

            options = '';
            $.each(data, function( index, value ) {
                options += '<option value="'+value['School_ID']+'">'+value['School_Name']+'  ('+value['School_Code']+')</option>';
            });
            $('.strandSelect').html('\
                <label for="studentdept_select">Select Department</label>\
                <select class="form-control" name="studentdepartment" id="studentdept_select">\
                    <option selected="selected" disabled>Select Department</option>\
                    '+options+'\
                </select>\
                <div class="programselect"></div>\
            ');
            console.log(data);
        },
        fail: function(){
            alert('Error Connecting to Server');
        }
    });

}

function getInquirySubjects(){

    return $.ajax({
        url: baseurl()+"index.php/Main/getConcerns",
        type: 'POST',
        fail:function(){
            alert('Failed to connect to server');
        }
    });

}

function validationRules(){

    return $('.wizard-card form').validate({
            rules: {
            fullname: {
                required: true
            },
            email: {
                required: true
            },
            contactnumber: {
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
            studentdepartment: {
                required: true
            },
            'concern[]': {
                required: true
            },
            subject: {
                required: true
            },
            inquiry: {
                required: true,
                maxlength: 200
            },
            privacypolicy:{
                required: true
            }
        },
        messages: {
            'concern[]': "Please Select an Inquiry Topic",
            privacypolicy: "You need agree to the Privacy Policy before submitting the form",
        },
        errorPlacement: function(error, element) {
            if($(element).parent('div').parent('div').parent('div').attr('id') == 'choiceparent'){

                parent = $('#choiceparent');
                $('#choiceerror').html(error[0]['textContent']);

            }
            else if($(element).attr('id') == 'privacypolicy'){

                $('#privacypolicy_message').html(error[0]['textContent']);

            }
            else{
                error.insertAfter(element);
            }
            $('.formsubmit').prop('disabled', false);
            //console.log($(element).parent('div').parent('div').parent('div').attr('id'));
        },
        success: function(){
            $('#choiceparent').find('h4').html('');
        }
    });

}

