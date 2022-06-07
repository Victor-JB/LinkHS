(function ($) {
    "use strict";
    $('.my-color-field').wpColorPicker();
    if ($('#indeed_import_form').length > 0) {     
       $('#indeed_import_form').on('submit', function (e) {
             e.preventDefault();      
             
             var btn_txt   =   $('#import_job_submit').html();
            $('#import_job_submit').html('importing...');
            $("#import_job_submit").attr("disabled", true); 
        
            $.post(ajaxurl, {
                action: 'sb_import_indeed_job',
                sb_indeed_param: $("#indeed_import_form").serialize(),
            }).done(function (response) {
                
                  $('#import_job_submit').html(btn_txt);
                  $("#import_job_submit").attr("disabled", false);                      
                var res = response.split("|");     
            if(res[0] ==  "0"){    
                alert(res[1]);
            }
           else if(res[0] ==  "1"){    
                alert(res[1]);
            }
             else if(res[0] ==  "2"){    
                alert(res[1]);
            }
             else if(res[0] ==  "3"){    
                alert(res[1]);
            }
             else if(res[0] ==  "4"){    
                alert(res[1]);            
            }
            else if(res[0] ==  "5"){    
                alert(res[1]);
                location.reload();
            }
          
         
         console.log(response);
            });

        });
    }
})(jQuery);