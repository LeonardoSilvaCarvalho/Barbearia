/* ============ TOOLTIP TOGGLE DO TÍTULO ============== */
$(function ()
{
    $('[data-toggle="tooltip"]').tooltip();
});

/* ============ VALIDAÇÃO DE E-MAIL ============== */
function ValidateEmail(email)
{
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email))
    {
        return true;
    }
    return false;
}

/* ============ VALIDAÇÃO DE NÚMERO DE TELEFONE ============== */
function phonenumber(inputtxt) {
    var phoneno = /^\d{10,11}$/; // Aceita de 10 a 11 dígitos numéricos
    return phoneno.test(inputtxt);
}

/* ============ ENVIO DO FORMULÁRIO DE CONTATO ============== */
$('#contact_send').click(function()
{
    var contact_name = $('#contact_name').val();
    var contact_email = $('#contact_email').val();
    var contact_subject = $('#contact_subject').val();
    var contact_message = $('#contact_message').val();

    if($.trim(contact_name) === "" || $.trim(contact_email) === "" || $.trim(contact_subject) === "" || $.trim(contact_message) === "")
    {
        $('#contact_status_message').html("<div class = 'alert alert-danger'>Um ou mais campos estão vazios!</div>");
    }
    else
    {
        if(!ValidateEmail(contact_email))
        {
            $('#contact_status_message').html("<div class = 'alert alert-danger'>Por favor, insira um endereço de e-mail válido!</div>");
        }
        else
        {
            $.ajax({
                url: "Includes/php-files-ajax/contact.php",
                type: "POST",
                data:{contact_name:contact_name, contact_email:contact_email, contact_subject:contact_subject, contact_message:contact_message},
                cache: false,
                beforeSend: function(){
                    $('#contact_ajax_loader').show();
                },
                complete: function(){
                    $('#contact_ajax_loader').hide();
                },
                success: function (data)
                {
                    $('#contact_status_message').html(data);
                },
                error: function(xhr, status, error)
                {
                    alert("Ocorreu um ERRO interno, por favor, tente novamente mais tarde.");
                }
            });
        }
    }
});

/* ============ TOGGLE DO MENU MOBILE ============== */
$(".mob-menu-toggle").click(function()
{
    $("#menu_mobile").toggleClass("active");
});

$('.mob-close-toggle').click(function()
{
    $("#menu_mobile").removeClass("active");
});

$('.a-mob-menu').click(function()
{
    $("#menu_mobile").removeClass("active");
});

/* ============ TOGGLE DO CHECKBOX DA PÁGINA DE AGENDAMENTO ============== */
$('.service_label').click(function()
{
    $(this).button('toggle');
});

/* ============ CÓDIGO JS DO FORMULÁRIO DE MÚLTIPLOS PASSOS DA PÁGINA DE AGENDAMENTO ============== */
var currentTab = 0;
showTab(currentTab);

function showTab(n)
{
    var x = document.getElementsByClassName("tab_reservation");

    if(x[0] == null)
    {
        return;
    }
    x[n].style.display = "block";

    if (n == 0)
    {
        document.getElementById("prevBtn").style.display = "none";
    }
    else
    {
        document.getElementById("prevBtn").style.display = "inline";
    }

    if (n == (x.length - 1))
    {
        document.getElementById("nextBtn").innerHTML = "Enviar";
    }
    else
    {
        document.getElementById("nextBtn").innerHTML = "Próximo";
    }

    fixStepIndicator(n);
}


function nextPrev(n)
{
    var x = document.getElementsByClassName("tab_reservation");

    if (n == 1 && !validateForm()) return false;
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;

    if (currentTab >= x.length)
    {
        document.getElementById("appointment_form").submit();
        return false;
    }

    showTab(currentTab);
}




function validateForm()
{
    var x, id_tab, valid = true;
    x = document.getElementsByClassName("tab_reservation");
    id_tab = x[currentTab].id;

    if(id_tab == "services_tab")
    {
        if(x[currentTab].querySelectorAll('input[type="checkbox"]:checked').length == 0)
        {
            x[currentTab].getElementsByClassName("alert")[0].style.display = "block";
            valid = false;
        }
        else
        {
            x[currentTab].getElementsByClassName("alert")[0].style.display = "none";
        }
    }

    if(id_tab == "employees_tab")
    {
        if(x[currentTab].querySelectorAll('input[type="radio"]:checked').length == 0)
        {
            x[currentTab].getElementsByClassName("alert")[0].style.display = "block";
            valid = false;
        }
        else
        {
            x[currentTab].getElementsByClassName("alert")[0].style.display = "none";

            var selected_services = [];

            $("input[name='selected_services[]']:checked").each(function(){
                selected_services.push($(this).val());
            })


            var selected_employee = $("input[name='selected_employee']:checked").val();

            $.ajax(
                {

                    url:"calendar.php",
                    method:"POST",
                    data:{selected_services:selected_services,selected_employee:selected_employee},
                    success: function (data)
                    {
                        $('#calendar_tab_in').html(data);
                    },
                    beforeSend: function()
                    {
                        $('#calendar_loading').show();
                    },
                    complete: function()
                    {
                        $('#calendar_loading').hide();
                    },
                    error: function(xhr, status, error)
                    {
                        alert('UM ERRO OCORREU AO TENTAR EXECUTAR A SUA SOLICITAÇÃO');
                    }
                });

        }
    }

    if(id_tab == "calendar_tab")
    {
        if(x[currentTab].querySelectorAll('input[type="radio"]:checked').length == 0)
        {
            x[currentTab].getElementsByClassName("alert")[0].style.display = "block";
            valid = false;
        }
        else
        {
            x[currentTab].getElementsByClassName("alert")[0].style.display = "none";
        }
    }

    if(id_tab == "client_tab")
    {
        var client_f_name = $('#client_first_name').val();
        var client_l_name = $('#client_last_name').val();
        var client_email = $('#client_email').val();
        var client_phone_number = $('#client_phone_number').val();

        if($.trim(client_f_name) == "")
        {
            $('#client_first_name').css("border", "2px solid #dc3545");
            $("#client_first_name ~ span").css("display", "block");
            valid = false;
        }
        else
        {
            $('#client_first_name').css("border", "0px");
            $("#client_first_name ~ span").css("display", "none");

            if($.trim(client_l_name) == "")
            {
                $('#client_last_name').css("border", "2px solid #dc3545");
                $("#client_last_name ~ span").css("display", "block");
                valid = false;
            }
            else
            {
                $('#client_last_name').css("border", "0px");
                $("#client_last_name ~ span").css("display", "none");

                if(!ValidateEmail(client_email))
                {
                    $('#client_email').css("border", "2px solid #dc3545");
                    $("#client_email ~ span").css("display", "block");
                    valid = false;
                }
                else
                {
                    $('#client_email').css("border", "0px");
                    $("#client_email ~ span").css("display", "none");

                    if(!phonenumber(client_phone_number))
                    {
                        $('#client_phone_number').css("border", "2px solid #dc3545");
                        $("#client_phone_number ~ span").css("display", "block");
                        valid = false;
                    }
                    else
                    {
                        $('#client_phone_number').css("border", "0px");
                        $("#client_phone_number ~ span").css("display", "none");
                    }
                }
            }
        }
    }

    if (valid)
    {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }

    return valid;
}

function fixStepIndicator(n)
{
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++)
    {
        x[i].className = x[i].className.replace(" active", "");
    }

    x[n].className += " active";
}
