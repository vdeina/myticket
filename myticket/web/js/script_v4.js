  var id_order_select;
$(document).ready(function() {
    setInterval(getTicketList, 60000);
});
function getTicketList()
{
    if(!$("#view-loader").is(':visible') )
    {
        $('#fast-search-button').click();
    }
    
}
  $('form#login-form').on('beforeSubmit', function() {  
    var form = $(this);
    if (form.find('.has-error').length) {
        return false;
    }
    $.post(
        form.attr("action"),
        form.serialize()
    )
       .done(function(result){
        var obj = $.parseJSON(result);
        alert(obj.msg);
        $( "#loginform-username" ).focus();
       });
       return false;
     });              
  $('form#fast-search-form').on('beforeSubmit', function() {  
    var form = $(this);
    if (form.find('.has-error').length) {
        return false;
    }
    $( "#div-ticket-count" ).hide();
    showLoader();
    $.post(
        form.attr("action"),
        form.serialize()
    )
       .done(function(result){
        var obj = $.parseJSON(result);
        if(obj.status=='success'){
               $("#fast_view_table").html(obj.result);   
               $("#tickets-count").text(obj.count);  
            }
           
            $('#'+id_order_select).addClass("select-tr");
            $('#'+id_order_select).find("a").addClass("select-tr");
       })
    .always(function() {
       showLoader();
       $( "#div-ticket-count" ).show();
     });
       return false;
     });
$('form#fast-edit-form').on('beforeSubmit', function() {  
    var form = $(this);
    if (form.find('.has-error').length || $('#ticket-id-update').val()=="" ) {
        return false;
    }
    showEditLoader();
    $.post(
        form.attr("action"),
        form.serialize()
    )
       .done(function(result){
        var obj = $.parseJSON(result);
        if(obj.status=='success'){
            var tr=$('#'+obj.ticket.id);
            tr.find(".total").text(obj.ticket.total);
            tr.find(".responce").text(obj.ticket.responce);
            tr.find(".sf").text(obj.ticket.sf);
            tr.find(".fm").text(obj.ticket.fm);
            tr.find(".dis").text(obj.ticket.dis);
            tr.find(".cur").text(obj.ticket.cur);
            tr.find(".cur_view").text(obj.ticket.cur);
            tr.find(".agent").text(obj.ticket.agent);
            tr.find(".cur_rate").text(obj.ticket.cur_rate);
            if(id_order_select==obj.ticket.id)
            {
                $('#fasteditform-agent').val(obj.ticket.responce);
                $('#fasteditform-sf').val(obj.ticket.sf);
                $('#fasteditform-fm').val(obj.ticket.fm);
                $('#fasteditform-dis').val(obj.ticket.dis);
                $('#fasteditform-cur_rate').val(obj.ticket.cur_rate);
                $('#fasteditform-cur').val(obj.ticket.cur);
            }
            }
       else{
                
            }
       showEditLoader();
       });
       return false;
     });
   function showLoader()
   {
       if( $("#view-loader").is(':visible') )
           $("#view-loader").hide();
       else
        $( "#view-loader" ).show();   
   }  
   function showEditLoader()
   {
       if( $("#view-edit-loader").is(':visible') )
           $("#view-edit-loader").hide();
       else
        $( "#view-edit-loader" ).show();   
   }  
  $(document).on('click', '.tr-ticket-items', function() {
      var status;
      var doc_num;
      var vc;
      var responce;
      var sf;
      var fm;
      var dis;
      var cur_rate;
      var cur;
      var dataContainer = $('#fast_view_table');
      var dataElements = $('.tr-ticket-items', dataContainer); 
      var linkElements = $('a', dataContainer); 
      dataElements.removeClass("select-tr");
      linkElements.removeClass("select-tr");
      $(this).find("a").addClass("select-tr");
      $(this).addClass("select-tr"); 
      id_order_select=$(this).attr('id');   
      $(this).find('td').each(function(){
           switch($(this).attr('class')){
             case 'status':status=$(this).text(); break;
             case 'doc-num' :doc_num=$(this).text(); break;
             case 'vc'  :vc=$(this).text(); break; 
             case 'responce'  :$('#fasteditform-agent').val($(this).text()); break;
             case 'sf'  : $('#fasteditform-sf').val($(this).text()); break;
             case 'fm'  : $('#fasteditform-fm').val($(this).text()); break;
             case 'dis' : $('#fasteditform-dis').val($(this).text()); break;
             case 'cur_rate':$('#fasteditform-cur_rate').val($(this).text()); break;
             case 'cur'  :$('#fasteditform-cur').val($(this).text()); break;               
           }          
             
          });
      
      $('#ticket-info').val(doc_num+', '+status+', '+vc);         
      $('#ticket-id-update').val($(this).attr('id'));       
    });
$("#cur-rate-table").on("click", "td", function() {
     var _id=$(this).attr("id");
     $('#span-edit-cur').text(_id);
     $('#input-cur-rate').val($('#span-'+_id).text());
     $("#sweet-overlay_cur").css("display", "block");
     $("#sweet-overlay_cur").css("opacity", "1.04");
     $("#sweet-alert").removeClass('hideSweetAlert');
     $("#sweet-alert").css("display", "block");
      $("#sweet-alert").addClass('showSweetAlert');
   });
$( "#cencel-edit-cur-button" ).click(function() { 
    $("#sweet-overlay_cur").css("opacity", "-0.03");
    $("#sweet-overlay_cur").css("display", "none");    
    $("#sweet-alert").removeClass('showSweetAlert'); 
    $("#sweet-alert").addClass('hideSweetAlert');
    $("#sweet-alert").css("display", "none");
    $('#cur_rate_error').text('');
}); 
$( "#cencel-add-agent-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet-add-agent").removeClass('showSweetAlert'); 
    $("#sweet-add-agent").addClass('hideSweetAlert');
    $("#sweet-add-agent").css("display", "none");
    $('#agent_add_error').text('');
    $('#input_agent_name').val('');
    $('#input_agent_sine').val('');
}); 
$("#cencel-remove-agent-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet-remove-agent").removeClass('showSweetAlert'); 
    $("#sweet-remove-agent").addClass('hideSweetAlert');
    $("#sweet-remove-agent").css("display", "none");
    $('#agent_remove_error').text('');
}); 
$("#cencel-editpay-agent-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet-edit-agent-pay").removeClass('showSweetAlert'); 
    $("#sweet-edit-agent-pay").addClass('hideSweetAlert');
    $("#sweet-edit-agent-pay").css("display", "none");
}); 
$("#cencel-editpay-car-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet-edit-car-pay").removeClass('showSweetAlert'); 
    $("#sweet-edit-car-pay").addClass('hideSweetAlert');
    $("#sweet-edit-car-pay").css("display", "none");
}); 
$("#pay-cancel-car-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet_remove_car_pay").removeClass('showSweetAlert'); 
    $("#sweet_remove_car_pay").addClass('hideSweetAlert');
    $("#sweet_remove_car_pay").css("display", "none");
    $('#pay_car_remove_error').text('');
});
$("#ticket-cancel-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet_remove_ticket").removeClass('showSweetAlert'); 
    $("#sweet_remove_ticket").addClass('hideSweetAlert');
    $("#sweet_remove_ticket").css("display", "none");
});
$("#pay-cancel-agent-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet_remove_agent_pay").removeClass('showSweetAlert'); 
    $("#sweet_remove_agent_pay").addClass('hideSweetAlert');
    $("#sweet_remove_agent_pay").css("display", "none");
    $('#pay_agent_remove_error').text('');
});
$("#add_agent_btn" ).click(function() { 
      
     $('#add-agent-title').text('Добавление кассира');
     $('#agent_add_action').val('add_new_agent');
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-add-agent").removeClass('hideSweetAlert');
     $("#sweet-add-agent").css("display", "block");
     $("#sweet-add-agent").addClass('showSweetAlert');
   });
   
function clickAddRecordBtn()
{
    $('#add_agent_btn').click();
} 
   
function removeAgent(_id) { 
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     var tr=$('#'+result[1]);
     $('#remove-agent-name').text(tr.find('.agent-name').text());
     $('#remove_agent_id').val(result[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-remove-agent").removeClass('hideSweetAlert');
     $("#sweet-remove-agent").css("display", "block");
     $("#sweet-remove-agent").addClass('showSweetAlert');
   };
   
  
 function removeTicket () { 
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet_remove_ticket").removeClass('hideSweetAlert');
     $("#sweet_remove_ticket").css("display", "block");
     $("#sweet_remove_ticket").addClass('showSweetAlert');
   };    
  
function removeAgentPayment(_id) { 
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     var tr=$('#'+result[1]);
     $('#remove_agent_pay_id').val(result[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet_remove_agent_pay").removeClass('hideSweetAlert');
     $("#sweet_remove_agent_pay").css("display", "block");
     $("#sweet_remove_agent_pay").addClass('showSweetAlert');
   };   
 function removeCarPayment(_id) { 
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     var tr=$('#'+result[1]);
     $('#remove_car_pay_id').val(result[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet_remove_car_pay").removeClass('hideSweetAlert');
     $("#sweet_remove_car_pay").css("display", "block");
     $("#sweet_remove_car_pay").addClass('showSweetAlert');
   };   
function editAgent(_id){ 
    // var _id=$(this).attr("id");
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     $('#agent_id').val(result[1]);
     var tr=$('#'+result[1]);
     $('#input_agent_name').val(tr.find('.agent-name').text());
     $('#input_agent_sine').val(tr.find('.agent-sine').text());
     $('#add-agent-title').text('Редактирование данных кассира');
     $('#agent_add_action').val('update_agent');
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-add-agent").removeClass('hideSweetAlert');
     $("#sweet-add-agent").css("display", "block");
     $("#sweet-add-agent").addClass('showSweetAlert');
   };
function editAgentPay(_id){ 
    // var _id=$(this).attr("id");
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     $('#edit_pay_id').val(result[1]);
     $('#edit_agent_name').text($('#value_name_id'+result[1]).text());
     $('#input_pay_edit').val($('#value_pay_id'+result[1]).text());
     $('#input_expense_edit').val($('#value_exp_id'+result[1]).text());
     var date = /(\d{4}-\d{2}-\d{2})/i.exec($('#date_id'+result[1]).text());
     $('#date_expense_edit').val(date[1]);
     $('#edit_text-note').val($('#value_note_id'+result[1]).val());
     $('#edit_pay_method_id').val($('#edit_method_id'+result[1]).text());
     var time = /(\d{2}:\d{2}:\d{2})/i.exec($('#date_id'+result[1]).text());
     $('#edit_time_pay').text(time[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-edit-agent-pay").removeClass('hideSweetAlert');
     $("#sweet-edit-agent-pay").css("display", "block");
     $("#sweet-edit-agent-pay").addClass('showSweetAlert');
   };



 
jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};   
$('#input-cur-rate').ForceNumericOnly();
$('.input-expense').ForceNumericOnly();
$('.input-pay').ForceNumericOnly();
  
$("#edit-remove-agent-button").click(function() {
   $('#agent_remove_error').text();
   $.post("/agents", {action:$('#agent_remove_action').val(),agent_id:$('#remove_agent_id').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
          $("#table-agents").html(obj.result);
          $( "#cencel-remove-agent-button" ).click();
          if(obj.add_btn_show=='0')
           $("#add_agent_btn").hide();
          else
           $("#add_agent_btn").show();
           
         }  
       else
       {     
         $('#agent_remove_error').text(obj.msg);
       }
       })
     .always(function() {
      
     });
});
$("#ticket-remove-button").click(function() {
  $.post("/ticket-details/"+$('#ticketeditform-record').val(), {action:'remove_ticket',doc_num:$('#ticketeditform-doc_num').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
         $("#ticket-cancel-button" ).click();
         $("#ticket-details").html(obj.result);
         }  
       else
       {     
       }
       })
     .always(function() {      
     });
});
$("#pay-remove-car-button").click(function() {
   $('#pay_car_remove_error').text();
   $.post("/payments-carriers", {action:'remove_car_pay',pay_id:$('#remove_car_pay_id').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
        $("#"+obj.id).remove();
         $("#pay-cancel-car-button" ).click();
         }  
       else
       {     
         $('#pay_car_remove_error').text(obj.msg);
       }
       })
     .always(function() {      
     });
});

$("#pay-remove-agent-button").click(function() {
   $('#pay_agent_remove_error').text();
   $.post("/payments-agents", {action:'remove_agent_pay',pay_id:$('#remove_agent_pay_id').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
        $("#"+obj.id).remove();
         $("#pay-cancel-agent-button" ).click();
         }  
       else
       {     
         $('#pay_agent_remove_error').text(obj.msg);
       }
       })
     .always(function() {      
     });
});
$("#edit-add-agent-button").click(function() {
   $('#agent_add_error').text();
   if($('#input_agent_name').val().trim().length==0)
   {
     $('#agent_add_error').text("Введите имя");
     return false;
   }
   $.post("/agents", {action:$('#agent_add_action').val(),name:$('#input_agent_name').val(),sine:$('#input_agent_sine').val(),agent_id:$('#agent_id').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
          $("#table-agents").html(obj.result);
          $("#cencel-add-agent-button" ).click();
          $('#input_agent_name').val('');
          $('#input_agent_sine').val('');
          if(obj.add_btn_show=='0')
           $("#add_agent_btn").hide();
          else
           $("#add_agent_btn").show();
         }  
       else
       {     
         $('#agent_add_error').text(obj.msg);
       }
       })
     .always(function() {
      
     });
});

$("#add-payment-button").click(function() {
   $.post("/payments", {action:'add_new',name:$('#input-payment').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
        $("#table-payments").html(obj.result);
         }  
       else
       {     
       }
       })
     .always(function() {
       $( "#cencel-add-carrier-button" ).click();
     });
});

$("#edit-cur-button").click(function() {
   $('#cur_rate_error').text();
   $.post("/currency-rate", {action:'update',cur:$('#span-edit-cur').text(),cur_rate:$('#input-cur-rate').val(),agent_agent_id:$('#agent_agent_id').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
          $('#span-'+obj.cur).text(obj.rate);
          $( "#cencel-edit-cur-button" ).click();
         }  
       else
       {     
         $('#cur_rate_error').text(obj.msg);
       }
       })
     .always(function() {
      
     });
});
$("#edit-pay-agent-button").click(function() {
    $('#agent_editpay_error').text('');
    var pay_id=$("#edit_pay_id").val();
    var input_pay=$("#input_pay_edit").val();
    var input_expense=$("#input_expense_edit").val();
    var expense_date =$("#date_expense_edit").val();
    var note =$("#edit_text-note").val();
    var pay_met =$("#edit_pay_method_id").val();
    var time =$("#edit_time_pay").text();
    if(input_pay.length == 0)
    {
      $('#agent_editpay_error').text("Укажите сумму оплаты");
      return false;  
    }
    $.post("/payments-agents", {action:'agent_pay_edit_action',pay_id:pay_id,input_pay:input_pay,input_expense:input_expense,expense_date:expense_date,note:note,pay_met:pay_met,time:time})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
          $("#value_pay_id"+obj.id).text(obj.input_pay);
          $("#value_exp_id"+obj.id).text(obj.input_expense);
          $("#date_id"+obj.id).text(obj.expense_date);
          $("#value_note_id"+obj.id).text(obj.note);
          $("#value_pay_met_id"+obj.id).text(obj.name_met);
          $("#edit_method_id"+obj.id).text(obj.method_id);
          $("#cencel-editpay-agent-button" ).click();        
         }  
       else
       {
          $('#agent_editpay_error').text("Ошибка");
       }
       })
     .always(function() {
     });  
   });
$("#edit-pay-car-button").click(function() {
    $('#car_editpay_error').text('');
    var pay_id=$("#edit_pay_id").val();
    var input_pay=$("#input_pay_edit").val();
    var expense_date =$("#date_expense_edit").val();
    var note =$("#edit_text-note").val();
    var pay_met =$("#edit_pay_method_id").val();
    var time =$("#edit_time_pay").text();
    
    
    if(input_pay.length == 0)
    {
      $('#car_editpay_error').text("Укажите сумму оплаты");
      return false;  
    }
    $.post("/payments-carriers", {action:'car_pay_edit_action',pay_id:pay_id,input_pay:input_pay,expense_date:expense_date,note:note,pay_met:pay_met,time:time})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
          $("#value_carpay_id"+obj.id).text(obj.input_pay);
          $("#value_cardate_id"+obj.id).text(obj.expense_date);
          $("#value_note_id"+obj.id).text(obj.note);
          $("#value_pay_met_id"+obj.id).text(obj.name_met);
          $("#edit_method_id"+obj.id).text(obj.method_id);
          
          $("#cencel-editpay-car-button" ).click();        
         }  
       else
       {
          $('#car_editpay_error').text("Ошибка");
       }
       })
     .always(function() {
     });  
   });


$("#expense_btn").click(function() {
    $('#error-agent-pay').text("");
    $('#status-agent-pay').text("");  
    $('#loader-agent-pay').show();
    var name=$("#input_name").val();
    var name_id=$("#input-name-id").val();
    var input_pay=$("#input-pay").val();
    var input_expense=$("#input-expense").val();
    var expense_date =$("#date_expense").val();
    var text_note =$("#text-note").val();
    var pay_method =$("#pay_method_id").val();
    if(input_pay.length == 0)
    {
      $('#error-agent-pay').text("Укажите сумму оплаты");
      $('#loader-agent-pay').hide();
      return false;  
    }

    $.post("/payments-agents", {action:'add_pay',name:name,name_id:name_id,input_pay:input_pay,input_expense:input_expense,expense_date:expense_date,text_note:text_note,pay_method:pay_method})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
         $('#status-agent-pay').text(obj.msg);          
         }  
       else
       {
          $('#error-agent-pay').text(obj.msg);
       }
       })
     .always(function() {
       $('#loader-agent-pay').hide();
     });  
   }); 
 $("#filter_expense_btn").click(function() { 
    var date_start_pay=$("#date_start_pay").val();
    var date_end_pay=$("#date_end_pay").val();
    var agent_id_filter=$("#agent_id_filter").val();
    $('#loader_agent_pay_filter').show();
    $.post("/payments-agents", {action:'search_payments',date_start_pay:date_start_pay,date_end_pay:date_end_pay,agent_id_filter:agent_id_filter})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
         $('#table-agents-payments').html(obj.result);   
         $('#count_record_payagent').val(obj.total); 
           paginatorPayAgent();       
         }  
       else
       {
          
       }
       })
     .always(function() {
        $('#loader_agent_pay_filter').hide();
      
     });  
   });   
 $("#filter_car_btn").click(function() { 
    var date_start_pay=$("#date_start_pay").val();
    var date_end_pay=$("#date_end_pay").val();
    var car_id_filter=$("#filter-carriers-id").val();
    $('#loader_car_pay_filter').show();
    $.post("/payments-carriers", {action:'search_payments',date_start_pay:date_start_pay,date_end_pay:date_end_pay,car_id_filter:car_id_filter})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
         $('#table_history_car_payments').html(obj.result);   
         $('#count_record_payagent').val(obj.total); 
         paginatorPayCar();       
         }  
       else
       {
          
       }
       })
     .always(function() {
        $('#loader_car_pay_filter').hide();
     });  
   });   
   
/*$("#expense_btn").click(function() {
   var arr_expense =[]; 
   $('#status-agent-pay').text(''); 
   $('#error-agent-pay').text('');
   $('#loader-agent-pay').show();
  $("#table-agents-expense > tbody  > tr").each(function() {
       var id=$(this).attr('id');
       var expense_input =$(this).find(".input-expense").val();
       var pay_input =$(this).find(".input-pay").val();
       var expense_date =$(this).find(".date-expense").val();
       var myExpense = {id_agent:id , expense_input:expense_input,pay_input:pay_input,expense_date:expense_date};     
       arr_expense.push(myExpense);
        });
         
  var json_str = JSON.stringify(arr_expense);
     $.post("/payments-agents", {json_str:json_str})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
         $('#status-agent-pay').text(obj.msg);          
         }  
       else
       {
          $('#error-agent-pay').text(obj.msg);
       }
       })
     .always(function() {
       $('#loader-agent-pay').hide();
     });   
});*/
$("#payments_btn").click(function() {
   var arr_expense =[]; 
   $('#status-carrier-pay').text(''); 
   $('#error-carrier-pay').text('');
   $('#loader-carriers-pay').show();
  var id_car=$('#input-carriername-id').val();
  var input_pay=$('#input-pay').val();
  var input_date=$('#date_pay').val();
   var text_note =$("#text-note").val();
   var pay_method =$("#pay_method_id").val();
   if(input_pay.length == 0)
    {
      $('#error-carrier-pay').text("Укажите сумму оплаты");
      $('#loader-carriers-pay').hide();
      return false;  
    }
   $.post("/payments-carriers", {action:"add_pay",id_car:id_car,input_pay:input_pay,input_date:input_date,text_note:text_note,pay_method:pay_method})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
         $('#status-carrier-pay').text(obj.msg);          
         }  
       else
       {
          $('#error-carrier-pay').text(obj.msg);
       }
       })
     .always(function() {
       $('#loader-carriers-pay').hide();
     });   
});
$("#add-carrier-button").click(function() {
   $.post("/carriers", {action:'add_new',name:$('#input-carrier').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){
        $("#table-carriers").html(obj.result);
         }  
       else
       {     
       }
       })
     .always(function() {
       $( "#cencel-add-carrier-button" ).click();
     });
});
$("#add_carrier_btn" ).click(function() { 
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-alert_car").removeClass('hideSweetAlert');
     $("#sweet-alert_car").css("display", "block");
     $("#sweet-alert_car").addClass('showSweetAlert');
   });
   $( "#cencel-add-carrier-button" ).click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet-alert_car").removeClass('showSweetAlert'); 
    $("#sweet-alert_car").addClass('hideSweetAlert');
    $("#sweet-alert_car").css("display", "none");
    $('#input-carrier').val('');
}); 
function paginatorPayAgent()
{
     $('#navigator').smartpaginator({
        totalrecords: $('#count_record_payagent').val(),
        refund: 0,
        voided: 0,
        recordsperpage: 10,
        datacontainer: 'table-agents-payments',
        dataelement: 'tr.agent-items',
        theme: 'green'});
}
function paginatorPayCar()
{
     $('#navigator').smartpaginator({
        totalrecords: $('#count_record_payagent').val(),
        refund: 0,
        voided: 0,
        recordsperpage: 10,
        datacontainer: 'table_history_car_payments',
        dataelement: 'tr.agent-items',
        theme: 'green'});
}
function editForPayment(_id){ 
    // var _id=$(this).attr("id");
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     $('#edit_form_pay_id').val(result[1]);
     $('#input-payment-name').val( $('#method_nameid'+result[1]).text());
     $('#edit_pay_id').val(result[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-alert_form-pay").removeClass('hideSweetAlert');
     $("#sweet-alert_form-pay").css("display", "block");
     $("#sweet-alert_form-pay").addClass('showSweetAlert');
   };
$("#cencel-edit-payment-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet-alert_form-pay").removeClass('showSweetAlert'); 
    $("#sweet-alert_form-pay").addClass('hideSweetAlert');
    $("#sweet-alert_form-pay").css("display", "none");
    $('#cur_rate_error').text('');   
});

function removeForPayment(_id) { 
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     $('#remove_form_pay_id').val(result[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet_remove_form_pay").removeClass('hideSweetAlert');
     $("#sweet_remove_form_pay").css("display", "block");
     $("#sweet_remove_form_pay").addClass('showSweetAlert');
   }; 
   
$("#edit-payment-button").click(function() {
   $('#cur_rate_error').text();
   $.post("/payments", {action:'edit_form_pay',pay_id:$('#edit_form_pay_id').val(),name:$('#input-payment-name').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
         $("#method_nameid"+obj.id).text(obj.name);
         $("#cencel-edit-payment-button" ).click();
         }  
       else
       {     
         $('#cur_rate_error').text(obj.msg);
       }
       })
     .always(function() {      
     });
});    
   
   
$("#pay-form-remove-button").click(function() {
   $('#pay_form_remove_error').text();
   $.post("/payments", {action:'remove_form_pay',pay_id:$('#remove_form_pay_id').val()})
      .done(function(result) {   
      var obj = $.parseJSON(result);
      if(obj.status=='success'){         
        $("#"+obj.id).remove();
         $("#pay-form-cancel-button" ).click();
         }  
       else
       {     
         $('#pay_form_remove_error').text(obj.msg);
       }
       })
     .always(function() {      
     });
});      
$("#pay-form-cancel-button").click(function() { 
    $("#sweet-overlay").css("opacity", "-0.03");
    $("#sweet-overlay").css("display", "none");    
    $("#sweet_remove_form_pay").removeClass('showSweetAlert'); 
    $("#sweet_remove_form_pay").addClass('hideSweetAlert');
    $("#sweet_remove_form_pay").css("display", "none");
    $('#pay_form_remove_error').text('');
});
function editCarPay(_id){ 
    // var _id=$(this).attr("id");
     var regexp = /id(\d+)/ig;
     var result;
     result = regexp.exec(_id);
     $('#edit_pay_id').val(result[1]);
     $('#edit_car_name').text($('#value_carname_id'+result[1]).text());
     $('#input_pay_edit').val($('#value_carpay_id'+result[1]).text());
      var date = /(\d{4}-\d{2}-\d{2})/i.exec($('#value_cardate_id'+result[1]).text());
     $('#date_expense_edit').val(date[1]);
     $('#edit_text-note').val($('#value_note_id'+result[1]).text());
     $('#edit_pay_method_id').val($('#edit_method_id'+result[1]).text())
     var time = /(\d{2}:\d{2}:\d{2})/i.exec($('#value_cardate_id'+result[1]).text());
     $('#edit_time_pay').text(time[1]);
     $("#sweet-overlay").css("display", "block");
     $("#sweet-overlay").css("opacity", "1.04");
     $("#sweet-edit-car-pay").removeClass('hideSweetAlert');
     $("#sweet-edit-car-pay").css("display", "block");
     $("#sweet-edit-car-pay").addClass('showSweetAlert');
   };
