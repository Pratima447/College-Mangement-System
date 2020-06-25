
console.log('loaded');

$(document).ready(function () {
   
    if (window.location.href.indexOf('time_table/enter_data.php') > 0) {
        //get all subjects
        var cid = $('#cid').val();
        var sem = $('#sems').val();
        var dataArray = {
            "cid":cid,
            "sem":sem,
          };
        $('.get_subjects').html(''); 
        $.ajax({
            type: "POST",
            url: "../../../pages/common/get_subjects.php",
            data: dataArray,
            success: function (sub_data) {
                console.log(sub_data);
                    $(".get_subjects").append(sub_data);
                }
        });

        //get all lecturers
        $('.get_lect').html('');    
        $.ajax({
            type: "POST",
            url: "../../../pages/common/get_all_lecturers.php",
            data: '',
            success: function (lect_data) {
                // console.log(lect_data);
                    $(".get_lect").append(lect_data);
                }
        });
    }


    if (window.location.href.indexOf('attendance') > 0) {
        //get subjects of  lecturers
        $('#subject').html('');   

        
        $.ajax({
            type: "POST",
            url: "../../../pages/common/get_lect_sub.php",
            data: '',
            success: function (lect_sub_data) {
                console.log(lect_sub_data);
                    $("#subject").append(lect_sub_data);
                }
        });
    }
    $('#dataTables-example').DataTable({
        responsive: true
    });
    
    $('.main_menu').on("click", function(e){
      $(this).next('ul').toggle();           
      e.stopPropagation();
      e.preventDefault();
    });


    $( function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    } );
});

function courseAvailability() 
{
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "course_availability.php",
        data:'cshort='+$("#cshort").val(),
        type: "POST",
        success:function(data){
            $("#course-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
    });
}

function coursefullAvail() 
{
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "course_availability.php",
        data:'cfull='+$("#cfull").val(),
        type: "POST",
        success:function(data){
            $("#course-status").html(data);
            $("#loaderIcon").hide();
            },
        error:function (){}
    });
}

function populateSubjects() 
{
    var course_selected = $('#cshort').val();
    var c_id = 'C_' + course_selected;
    var no_of_subject = $('#no_sub').val();

    console.log(no_of_subject);
    $('#form_subjects').html('');

    for (var i = 1; i <= no_of_subject; i++) {
        var sub_name = "S" + i;
        var sub_id = c_id + '_S' + i;

        $('#form_subjects').append('<br><br><div class="form-group"><div class="col-lg-4"><label>Subject '+i+'</label></div><div class="col-lg-6"><input required class="form-control" value="" type="text" name="'+sub_name+'" id="'+sub_name+'"></div></div>')
    }
}

function showSub(val)
{
    $.ajax({
	type: "POST",
    url: "subjects.php",
	data:'cid='+val,
        success: function (result) {
            var data = JSON.parse(result);
            console.log(data);
            $("#subjects").val(data.names);
            $("#sub_ids").val(data.ids);
	    }
	});
	
}

function checkMobValidation() {
    var mobile = $('#mobile').val();

    if ( ! validate_mobile(mobile)) {
        $('#invalid_mob_msg').removeClass('display_n');
    } else {
        $('#invalid_mob_msg').addClass('display_n');
    }
}

function checkEmailValidation() {
    var email = $('#email').val();
    if (!validate_email(email)) {
        $('#invalid_email_msg').removeClass('display_n');
    } else {
        $('#invalid_email_msg').addClass('display_n');
    }
}

function validate_mobile(mobile)
{
    return /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/.test(mobile);
}
function validate_email(email)
{
    return  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}


function showSem(val)
{   
    $("#sems").html('');
    var cname = $.trim($("#cshort option:selected").html());

    $.ajax({
	type: "POST",
    url: "../../../pages/common/get_semesters.php",
	data:'cid='+val,
        success: function (sem_data) {
            $('#time_table').attr('action', 'enter_data.php?course=' + cname);
            $("#sems").append(sem_data);
	    }
    });

}

function showSubjects(val) {
    $("#subject").html('');

    var cid = $('#cshort').val();

    var dataArray = {
        "cid":cid,
        "sem":val,
      };
    $.ajax({
        type: "POST",
        // url: "get_subjects.php",
        url: "../../../pages/common/get_subjects.php",

        data: dataArray,
        success: function (sub_data) {
                $("#subject").append(sub_data);
            }
    });
}

$('#upload_mat_file').on('click', function () {
    var cname = $.trim($("#cshort option:selected").html());
    var sem       = $('#sems').val();
    // var subject = $('#subject').val();
    var subject = $.trim($("#subject option:selected").html());
    var file_data = $('#mat_file').prop('files')[0];  
    
    var form_data = new FormData();  
    if (file_data == undefined)
    {
        setTimeout(function(){
            alert('Document file is missing!!', function(){
                
            });
        }, 100);
        return false;
    }

    form_data.append('mat_file', file_data);
    form_data.append('course', cname);
    form_data.append('sem', sem);
    form_data.append('subject', subject);

    $.ajax({
        type:'POST',
        url: "upload.php",
        data:form_data,
        cache:false,
        contentType: false,
        processData: false,
        success:function(result){
            alert(result);
            console.log(result);
          },
        error: function(result){
            setTimeout(function(){
                alert('Something went wrong, Please Try Again!!', function(){
                  });
            }, 100);
            return false;
        }
    });

})

$('#get_mat_file').on('click', function () {
    $('#mat_files').html('');

    var cname = $.trim($("#cshort option:selected").html());
    var sem = $.trim($("#sems option:selected").html());
    var subject = $.trim($("#subject option:selected").html());

    if (!$('#cshort').val() || !$('#sems').val()  || !$('#subject').val() ) {
        alert('Please select course, semester and suject to view files');
        return false;

    }
    var dataArray = {
        "cname":cname,
        "sem": sem,
        "subject": subject
    };
    
    $.ajax({
        type: "POST",
        url: "get_study_materials.php",
        data: dataArray,
        success: function (files) {
            console.log(files);
                $('#view_files').css('display','block');
                $("#mat_files").append(files);
            }
    });
})


$('#get_student_list').on('click', function () {

    $("#student_data").html('');

    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var day = $('#day').val();
    var sub_id = $('#subject').val();

    var dataArray = {
        "start_time":start_time,
        "end_time": end_time,
        "day": day,
        "sub_id": sub_id
    };
    
    $.ajax({
        type: "POST",
        url: "get_my_students.php",
        data: dataArray,
        success: function (stud_table) {
                $('#view_students').css('display','block');
                $("#student_data").append(stud_table);
            }
    });
})

function mark_me(stud_id) {

    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var day = $('#day').val();
    var sub_id = $('#subject').val();
    var sub_name = $('#subject option:selected').html();

    var dataArray = {
        "stud_id": stud_id,
        "sub_id": sub_id,
        "sub_name": sub_name,
        "day": day,
        "start_time": start_time,
        "end_time": end_time,
        "presence": 1
    };

    $.ajax({
        type: "POST",
        url: "mark_attendance.php",
        data: dataArray,
        success: function (result) {
            console.log(result);
            if (result != 'done') {
                $('#' + stud_id).html('Try Again');
                $('#' + stud_id).css('background', 'red');
                alert('Something went wrong, plz try again!!');
                return false;
            } else {
                $('#' + stud_id).html('Present');
                $('#' + stud_id).css('background', 'green');
            }
        }
    });
}

$('#get_att_report').on('click', function () {
        
    $('#report').html('');

    var cid = $("#cshort").val();
    var sem = $("#sems").val();
    var sub_id = $("#subject").val();

    if (!$('#cshort').val() || !$('#sems').val()  || !$('#subject').val() ) {
        alert('Please select course, semester and subject to view files');
        return false;

    }

    var dataArray = {
        "cid":cid,
        "sem": sem,
        "sub_id": sub_id
    };

    $.ajax({
        type: "POST",
        url: "get_attendance_report.php",
        data: dataArray,
        success: function (data) {
            console.log(data);
                $('#view_attendance').css('display','block');
                $("#report").append(data);
            }
    });
    
})


$('#get_internal_list').on('click', function () {

    $("#internal_data").html('');

    var cname = $.trim($("#cshort option:selected").html());
    var sem_name = $.trim($("#sems option:selected").html());
    var cshort  = $('#cshort').val();
    var sems     = $('#sems').val();
    var sub_id = $('#subject').val();
    var session = $('#session').val();

    if (!$('#cshort').val() || !$('#sems').val()  || !$('#subject').val() || ! $('#session').val()) {
        alert('Please select all the options to get list');
        return false;

    }

    var dataArray = {
        "cname": cname,
        "sem_name" :sem_name,
        "cid":cshort,
        "sem": sems,
        "sub_id": sub_id,
        "session": session
    };
    
    $.ajax({
        type: "POST",
        url: "get_internal_sheet.php",
        data: dataArray,
        success: function (stud_sheet) {
                $('#view_internal_report').css('display','block');
                $("#internal_data").append(stud_sheet);
            }
    });
})


$('#get_marks_list').on('click', function () {

    $("#marks_data").html('');

    if (!$('#cshort').val() || !$('#sems').val()  || !$('#subject').val() || ! $('#session').val()) {
        alert('Please select all the options to get list');
        return false;

    }

    var cname = $.trim($("#cshort option:selected").html());
    var sem_name = $.trim($("#sems option:selected").html());
    var cshort  = $('#cshort').val();
    var sems     = $('#sems').val();
    var sub_id = $('#subject').val();
    var session = $('#session').val();

   
    var dataArray = {
        "cname": cname,
        "sem_name" :sem_name,
        "cid":cshort,
        "sem": sems,
        "sub_id": sub_id,
        "session": session
    };
    
    $.ajax({
        type: "POST",
        url: "view_marks_sheet.php",
        data: dataArray,
        success: function (mark_sheet) {
            console.log(mark_sheet)
                $('#view_internal_report').css('display','block');
                $("#marks_data").append(mark_sheet);
            }
    });
})

$('#admin_marks_list').on('click', function () {

    $("#marks_data").html('');

    if (!$('#cshort').val() || !$('#sems').val()  || !$('#subject').val()) {
        alert('Please select the options to get list');
        return false;

    }
    var cname = $.trim($("#cshort option:selected").html());
    var sem_name = $.trim($("#sems option:selected").html());
    var cshort  = $('#cshort').val();
    var sems     = $('#sems').val();
    var sub_id = $('#subject').val();
    var session = $('#session').val();
  
    var dataArray = {
        "cname": cname,
        "sem_name" :sem_name,
        "cid":cshort,
        "sem": sems,
        "sub_id": sub_id,
        "session": session
    };
    
    $.ajax({
        type: "POST",
        url: "view_marks_sheet.php",
        data: dataArray,
        success: function (mark_sheet) {
            console.log(mark_sheet)
                $('#view_internal_report').css('display','block');
                $("#marks_data").append(mark_sheet);
            }
    });
})

$('#view_att_report').on('click', function () {
    $('#att_data').html('');

    var sub_id = $('#subs_ids').val();
    var day = $('#stud_day').val();

    if ($('#subject_option').is(':checked')) {
        var dataArray = {
            'sub_id': sub_id
        }
        $.ajax({
            type: "POST",
            url: "view_subject_att.php",
            data: dataArray,
            success: function (att_sheet) {
                console.log(att_sheet)
                $('#view_att_sheet').css('display', 'block');
                $("#att_data").append(att_sheet);
            }
        });
    } else if($('#day_option').is(':checked')) {
        var dataArray = {
            'day': day
        }
        $.ajax({
            type: "POST",
            url: "view_day_att.php",
            data: dataArray,
            success: function (att_sheet) {
                console.log(att_sheet)
                $('#view_att_sheet').css('display', 'block');
                $("#att_data").append(att_sheet);
            }
        });
    } else {
        alert('Please select the option to get report');
        return false;
    }
})

function show_sub_sec() {
    $('#subject_sec').removeClass('display_n');
    $("#day_option").prop( "checked", false );
    $('#day_sec').addClass('display_n');
}

function show_day_sec()
{
    $('#day_sec').removeClass('display_n');
    $("#subject_option").prop( "checked", false );

    $('#subject_sec').addClass('display_n');
}


$('#stud_marks_list').on('click', function () {

    $("#marks_data").html('');

    if (!$('#subject').val() || !$('#session').val()) {
        alert('Please select the options to get list');
        return false;

    }

    var sub_id  = $('#subject').val();
    var session = $('#session').val();
  
    var dataArray = {
        "sub_id": sub_id,
        "session": session
    };
    
    $.ajax({
        type: "POST",
        url: "view_stud_marks.php",
        data: dataArray,
        success: function (mark_sheet) {
            console.log(mark_sheet)
                $('#view_internal_report').css('display','block');
                $("#marks_data").append(mark_sheet);
            }
    });
})


$('#check_query_status').on('click', function () {
    $("#my_questions").html('');

    if (!$('#subject').val()) {
        alert('Please select the options to get list');
        return false;

    }

    var sub_id  = $('#subject').val();
  
    var dataArray = {
        "sub_id": sub_id,
    };
    
    $.ajax({
        type: "POST",
        url: "view_queries.php",
        data: dataArray,
        success: function (query_sheet) {
            console.log(query_sheet)
                $('#view_question').css('display','block');
                $("#my_questions").append(query_sheet);
            }
    });
})

function del_query(qid)
{
    alert('deleteing now');

    var dataArray = {
        "qid": qid
    };

    $.ajax({
        type: "POST",
        url: "delete_question.php",
        data: dataArray,
        success: function (result) {
            console.log(result);
            if (!result) {
                alert('Something went wrong, plz try again!!');
                return false;
            } else {
                alert('Deleted query successfully!!');
            }
        }
    });
}
