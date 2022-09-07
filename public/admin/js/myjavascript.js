var csrf = $('meta[name=csrf-token]').attr("content");
var base_url = $('meta[name=base_url]').attr("content");
var primary_color = $('meta[name=primary_color]').attr("content");
var curr_url = window.location.origin+window.location.pathname;
var $document = $(document);

$(function() {
    $(".preload").fadeOut(1000, function() {
        $(".for-loader").fadeIn(400);
    });
});

$document.ready(function() {
    $(document).on('mouseover','.main-sidebar', function () {
        $(this).getNiceScroll().resize();
    });

    $("#sortable-card-language").sortable({
        start: function(event, ui) {
            ui.item.startPos = ui.item.index();
        },
        stop: function(event, ui) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type:"POST",
                url:'changeOrderLanguage',
                data:{
                    start_position:ui.item.startPos+1,
                    end_position: ui.item.index()+1
                },
                success: function(result){
                },
                error: function(err){
                    console.log('err ',err)
                }
            });
        }
    });
    
    $("#sortable-card-song-section").sortable({
        start: function(event, ui) {
            ui.item.startPos = ui.item.index();
        },
        stop: function(event, ui) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type:"POST",
                url:'changeOrderSongSection',
                data:{
                    start_position:ui.item.startPos+1,
                    end_position: ui.item.index()+1
                },
                success: function(result){
                },
                error: function(err){
                    console.log('err ',err)
                }
            });
        }
    });

    $("[name='filter_textbox_year']").keypress(function (evt) {
        evt.preventDefault();
    });
    
    $(".filter_day").flatpickr({

        dateFormat: "Y-m-d",
    }); 
    $(".filter_week").flatpickr({

        dateFormat: "Y-m-d",
        weekNumbers: true,
    });
    $(".filter_period").flatpickr({

        mode: "range",
        dateFormat: "Y-m-d",
        showMonths:2,
    });

    $(".colorpickerinput").colorpicker({
        format: 'hex',
        component: '.input-group-append',
    });

    $(".box-video").click(function(){
        $('iframe',this)[0].src += "?autoplay=1";
        $(this).addClass('open');
    });

    $('.textarea_editor').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ],
        height: 250
    });

    // Select2 for permission
    $('.select2_multi_permissions').select2({
        placeholder: "Select Permissions",
    });
     
    // Select2 for Roles
    $('.select2_multi_roles').select2({
        placeholder: "Select Roles",
    });
     
    // Select2 for song -> section 
    $('.select2_multi_section').select2({
        placeholder: "Select Song Sections",
    });

    // Select2 for Reason type 
    $('.select2_multi_reason_type').select2({
        placeholder: "Select Reason for",
    });

    // Select2 for Reason type 
    $('.select2_filter_type').select2({
        placeholder: "Select Duration",
    });

    //  lightbox
    $('.lightBox-banner a').simpleLightbox();
    
    // image upload new
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });
    
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview2').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview2').hide();
                $('#imagePreview2').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image2").change(function() {
        readURL2(this);
    });

     
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview3').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview3').hide();
                $('#imagePreview3').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image3").change(function() {
        readURL3(this);
    });

     
    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview4').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview4').hide();
                $('#imagePreview4').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image4").change(function() {
        readURL4(this);
    });


    // datatable
    
    var usersTable = $('#datatable').DataTable({
        dom: 'Bfrtip',
        dom: `<'row'<'col-sm-12 text-left'f>>
        <'row'<'col-sm-12'tr>>
        <'row mt-3'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4 'l><'col-sm-12 col-md-4 'p>>`,
        language: {
            paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>",
            first: "<i class='fa fa-angle-double-left'>",
            last: "<i class='fa fa-angle-double-right'>",
            }
        },
        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
       
        pagingType: "full_numbers",
    });

    $('#export_print').on('click', function(e) {
        e.preventDefault();
        usersTable.button(0).trigger();
    });
    
    $('#export_copy').on('click', function(e) {
        e.preventDefault();
        usersTable.button(1).trigger();
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        usersTable.button(2).trigger();
    });

    $('#export_csv').on('click', function(e) {
        e.preventDefault();
        usersTable.button(3).trigger();
    });

    $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        usersTable.button(4).trigger();
    });

    // Users chart
    
    if(curr_url == base_url+'/admin/dashboard')
    {
        $.ajax({
            url: 'user_registerd_chart',
            method: 'get',
            success: function(data){
              user_registerd_chart(data);
            },
            error: function(err) {}
        })
    }

    function user_registerd_chart(data) {
      var statistics_chart = document.getElementById("myChart").getContext('2d');
      var myChart = new Chart(statistics_chart, {
        type: 'line',
        data: {
          labels: data[1],
          datasets: [{
            label: 'Users',
            data: data[0],
            borderWidth: 3,
            borderColor: primary_color,
            backgroundColor: 'transparent',
            pointBackgroundColor: '#fff',
            pointBorderColor: primary_color,
            pointRadius: 4
          }]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                display: false,
                drawBorder: false,
              },
              ticks: {
                stepSize: 150
              }
            }],
            xAxes: [{
              gridLines: {
                color: '#fbfbfb',
                lineWidth: 2
              }
            }]
          },
        }
      });
    }
    
    // platform  Charts
    if(curr_url == base_url+'/admin/dashboard')
    {
        $.ajax({
            url: 'platform',
            method: 'get',
            success: function(data){
                platform_chart(data);
            },
            error: function(err) {}
        })
    }

    function platform_chart(data) {
        var ctx = document.getElementById("myChart3").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                  data: [
                    data['android'],
                    data['ios']
                  ],
                  backgroundColor: [
                    '#3ddc84',
                    '#000000',
                  ],
                  label: 'Dataset 1'
                }],
                labels: [
                  'Android',
                  'iOS',
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
    }

    // Guest vs Login chart
    
    if(curr_url == base_url+'/admin/dashboard')
    {
        $.ajax({
            url: 'guest_user',
            method: 'get',
            success: function(data){
                guest_chart(data);
            },
            error: function(err) {}
        })
    }

    function guest_chart(data) {
        var ctx = document.getElementById("myChart_guest").getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
            data: [
                data['login'],
                data['guest']
            ],
            backgroundColor: [
                '#ffa426',
                '#000000',
            ],
            label: 'Dataset 1'
            }],
            labels: [
            'Login',
            'Guest',
            ],
        },
        options: {
            responsive: true,
            legend: {
            position: 'bottom',
            },
        }
        });
    }
   
    
    $("#challenges-carousel").owlCarousel({
        items: 4,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 2500,
        loop: true,
        responsive: {
            0: {
                items: 2
            },
            768: {
                items: 2
            },
            1200: {
                items: 4
            }
        }
    });

    // Advertisement 
    $document.on('change', '#network-dd', function () {
        if($(this).val() == 'facebook') {
            $("#type-dd option[value='Interstitial']").remove();
            $("#type-dd option[value='Native']").remove();
        } else {
            $("#type-dd").append('<option value="Interstitial">Interstitial</option>');
            $("#type-dd").append('<option value="Native">Native</option>');
        }
    });
    
});

function report_filter() {
    var type = $('.select2_filter_type').val();
    
    $('.filter .form-control').addClass('display-none');
    
    if (type == 'all') {
        $('.filter .filter_all').removeClass('display-none');
    }
    if (type == 'day') {
        $('.filter .filter_day').removeClass('display-none');
    }
    if (type == 'week') {
        $('.filter .filter_week').removeClass('display-none');
    }
    if (type == 'month') {
        $('.filter .filter_month').removeClass('display-none');
        $('.filter .filter_year').removeClass('display-none');
    }
    if (type == 'year') {
        $('.filter .filter_year').removeClass('display-none');
    }
    if (type == 'period') {
        $('.filter .filter_period').removeClass('display-none');
    }
}

// dashboard
function user_dashboard(time) {
    $.ajax({
        url: 'user_statistics',
        method: 'post',
        data: {time: time, _token: csrf},
        success: function(res) {
            document.getElementById("user_count_curr").innerHTML = res.user_count_curr;
            document.getElementById("user_text_curr").innerHTML = res.user_text_curr;
            document.getElementById("user_count_past").innerHTML = res.user_count_past;
            document.getElementById("user_text_past").innerHTML = res.user_text_past;
            $('.user_statistics .btn').removeClass('bg-primary text-white');
            $('.user_statistics #btn-'+time).addClass('bg-primary text-white');
        },
        error: function(error) {}
    });
}

function video_dashboard(time) {
    $.ajax({
        url: 'video_statistics',
        method: 'post',
        data: {time: time, _token: csrf},
        success: function(res) {
            document.getElementById("video_count_curr").innerHTML = res.video_count_curr;
            document.getElementById("video_text_curr").innerHTML = res.video_text_curr;
            document.getElementById("video_count_past").innerHTML = res.video_count_past;
            document.getElementById("video_text_past").innerHTML = res.video_text_past;
            $('.video_statistics .btn').removeClass('bg-primary text-white');
            $('.video_statistics #btn-'+time).addClass('bg-primary text-white');
        },
        error: function(error) {}
    });
}

function all_delete(url,id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't to delete this record!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                url: base_url+'/'+url+'/'+id,
                success: function (result) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                    Swal.fire({
                        type: 'success',
                        title: 'Deleted!',
                        text: 'Record is deleted successfully.',
                        showConfirmButton: false,
                    })
                },
                error: function (err) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'This record is conntect with another data!'
                    })
                }
            });
        }
    })       
}

function approve_video(id) {
    $.ajax({
        url:  base_url+'/admin/video/approve/'+id,
        method: 'post',
        data: {video_id: id, _token: csrf},
        success: function(res) {},
        error: function(error) {}
    });
}

function change_status(id,url) {
    $.ajax({
        url:  base_url+'/admin/'+url+'/'+id,
        method: 'post',
        data: {id: id, _token: csrf},
        success: function(res) {},
        error: function(error) {}
    });
}

function template_edit(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        type:"get",
        url:base_url+'/admin/notification/'+id,
        success: function(result){
            $('.nav-nots .nav-link').removeClass('active');
            $('#nav-title'+id).addClass('active');

            document.getElementById('temp_title').innerHTML = result.data.title;
            $(".form-group input[name='subject']").val(result.data.subject);
            $(".form-group input[name='message_content']").val(result.data.msg_content);
            
            $('.textarea_editor').summernote('code',result.data.mail_content);
            $('#template_form').get(0).setAttribute('action', base_url+'/admin/notification/'+result.data.id);
        },
        error: function(err){
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}