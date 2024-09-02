

/* ============ TÍTULO TOOLTIP TOOGLE ============== */
	
$(function () 
{
	$('[data-toggle="tooltip"]').tooltip();
});


/*
===========================================

VALIDAR FORMULÁRIO DE LOGIN

===========================================
*/

function validateLogInForm() 
{
	var username_input = document.forms["login-form"]["username"].value;
	var password_input = document.forms["login-form"]["password"].value;

	if (username_input == "" && password_input == "") 
    {
    	document.getElementById('required_username').style.display = 'initial';
    	document.getElementById('required_password').style.display = 'initial';
    	return false;
    }
    
    if (username_input == "") 
   	{
    	document.getElementById('required_username').style.display = 'initial';
    	return false;
    }
    if(password_input == "")
    {
    	document.getElementById('required_password').style.display = 'initial';
        return false;
    }
}


/*
    ======================================
    
    PÁGINA DO PAINEL ====> ALTERNAR AS ABA DE RESERVAS NA PÁGINA DO PAINEL

    =======================================
*/

function openTab(evt, tabName) 
{
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    
    for (i = 0; i < tabcontent.length; i++) 
    {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) 
    {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    document.getElementById(tabName).style.display = "table";
    evt.currentTarget.className += " active";
}

/*
    ======================================
    
    PÁGINA DO PAINEL ==== > CANCELAR COMPROMISSO QUANDO O BOTÃO CANCELAR FOR CLIQUEADO

    =======================================
*/

$('.cancel_appointment_button').click(function()
{

    var appointment_id = $(this).data('id');
    var cancellation_reason = $('#appointment_cancellation_reason_'+appointment_id).val();
    var do_ = 'Cancel Appointment';


    $.ajax({
        url: "ajax_files/appointments_ajax.php",
        type: "POST",
        data:{do:do_,appointment_id:appointment_id,cancellation_reason:cancellation_reason},
        success: function (data) 
        {
            //Hide Modal
            $('#cancel_appointment_'+appointment_id).modal('hide');
            
            //Show Success Message
            swal("Agendamento cancelado","O agendamento foi cancelado com sucesso!", "success").then((value) =>
            {
                window.location.replace("index.php");
            });
            
        },
        error: function(xhr, status, error) 
        {
            alert('OCORREU UM ERRO AO TENTAR PROCESSAR SUA SOLICITAÇÃO!');
        }
      });
});


/*
    ======================================
    
    PÁGINA DE CATEGORIAS DE SERVIÇO ====> O BOTÃO ADICIONAR CATEGORIA DE SERVIÇO ESTÁ CLICADO

    =======================================
*/


$('#add_category_bttn').click(function()
{
    var category_name = $("#category_name_input").val();
    var do_ = "Add";

    if($.trim(category_name) == "")
    {
        $('#required_category_name').css('display','block');
    }
    else
    {
        $.ajax(
        {
            url:"ajax_files/service_categories_ajax.php",
            method:"POST",
            data:{category_name:category_name,do:do_},
            dataType:"JSON",
            success: function (data) 
            {
                if(data['alert'] == "Warning")
                {
                    swal("Aviso",data['message'], "warning").then((value) => {});
                }
                if(data['alert'] == "Success")
                {
                    $('#add_new_category').modal('hide');
                    swal("Nova Categoria",data['message'], "success").then((value) =>
                    {
                        window.location.replace("service-categories.php");
                    });
                }
                
            },
            error: function(xhr, status, error) 
            {
                alert('FOI ENCONTRADO UM ERRO AO TENTAR EXECUTAR SUA PEDIDO');
            }
        });
    }
});


/*
    ======================================
    
    PÁGINA DE CATEGORIAS DE SERVIÇO ====> O BOTÃO DELETAR CATEGORIA DE SERVIÇO ESTÁ CLICADO

    =======================================
*/



$('.delete_category_bttn').click(function()
{
    var category_id = $(this).data('id');
    var action = "Delete";

    $.ajax(
    {
        url:"ajax_files/service_categories_ajax.php",
        method:"POST",
        data:{category_id:category_id,action:action},
        dataType:"JSON",
        success: function (data) 
        {
            if(data['alert'] == "Warning")
                {
                    swal("Aviso",data['message'], "warning").then((value) => {});
                }
                if(data['alert'] == "Success")
                {
                    swal("Excluida com sucesso!",data['message'], "success").then((value) =>
                    {
                        window.location.replace("service-categories.php");
                    });
                }     
        },
        error: function(xhr, status, error) 
        {
            alert('FOI ENCONTRADO UM ERRO AO TENTAR EXECUTAR SUA PEDIDO');
            alert(error);
        }
      });
});


/*
    ======================================

    PÁGINA DE CATEGORIAS DE SERVIÇO ====> O BOTÃO EDITAR CATEGORIA DE SERVIÇO ESTÁ CLICADO

    =======================================
*/

$('.edit_category_bttn').click(function()
{
    var category_id = $(this).data('id');
    var category_name = $("#input_category_name_"+category_id).val();

    var action = "Edit";

    if($.trim(category_name) == "")
    {
        $('#invalid_input_'+category_id).css('display','block');
    }
    else
    {
        $.ajax(
        {
            url:"ajax_files/service_categories_ajax.php",
            method:"POST",
            data:{category_id:category_id,category_name:category_name,action:action},
            dataType:"JSON",
            success: function (data) 
            {
                if(data['alert'] == "Warning")
                {
                    swal("Alerta",data['message'], "warning").then((value) => {});
                }
                if(data['alert'] == "Success")
                {
                    swal("Editado com Sucesso",data['message'], "success").then((value) =>
                    {
                        window.location.replace("service-categories.php");
                    });
                }     
            },
            error: function(xhr, status, error) 
            {
                alert('FOI ENCONTRADO UM ERRO AO TENTAR EXECUTAR SUA PEDIDO');
                alert(error);
            }
        });
    }
});


/*
    ======================================
    
    PÁGINA DE SERVIÇOS ==== > BOTÃO EXCLUIR SERVIÇO ESTÁ CLICADO

    =======================================
*/


$('.delete_service_bttn').click(function()
{
    var service_id = $(this).data('id');
    var do_ = "Delete";

    $.ajax(
    {
        url:"ajax_files/services_ajax.php",
        method:"POST",
        data:{service_id:service_id,do:do_},
        success: function (data) 
        {
            swal("Excluir serviço","O serviço foi excluído com sucesso!", "success").then((value) => {
                window.location.replace("services.php");
            });     
        },
        error: function(xhr, status, error) 
        {
            alert('FOI ENCONTRADO UM ERRO AO TENTAR EXECUTAR SUA PEDIDO');
        }
      });
});


/*
    ======================================
    
    PÁGINA DE AGENDAMENTO DE FUNCIONÁRIOS ====> O BOTÃO MOSTRAR DIA DE ATÉ HORAS ESTÁ CLICADO

    =======================================
*/


$(".sb-worktime-day-switch").click(function()
{
    if(!$(this).prop('checked'))
    {
        $(this).closest('div.worktime-day').children(".time_").css('display','none');
    }
    else
        $(this).closest('div.worktime-day').children(".time_").css('display','flex');
});


/*
    ======================================
    
    PÁGINA DE FUNCIONÁRIOS ====> O BOTÃO EXCLUIR FUNCIONÁRIO ESTÁ CLICADO

    =======================================
*/


 $('.delete_employee_bttn').click(function()
{
    var employee_id = $(this).data('id');
    var do_ = "Delete";

    $.ajax(
    {
        url:"ajax_files/employees_ajax.php",
        method:"POST",
        data:{employee_id:employee_id,do:do_},
        success: function (data) 
        {
            swal("Excluir funcionário","O funcionário foi excluído com sucesso!", "success").then((value) => {
                window.location.replace("employees.php");
            });     
        },
        error: function(xhr, status, error) 
        {
            alert('FOI ENCONTRADO UM ERRO AO TENTAR EXECUTAR SUA PEDIDO');
        }
    });
});