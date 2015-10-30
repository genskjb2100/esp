var closeAlert = '<a href="#" class="close fade in" data-dismiss="alert">&times;</a>';
function getInternetExplorerVersion() 
{
  var rv = -1;
  if (navigator.appName == 'Microsoft Internet Explorer') {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  } else if (navigator.appName == 'Netscape') {
    var ua = navigator.userAgent;
    var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}

function showMessage(alert_class, alert_message, alert_type_class)
{
  $("."+alert_class).addClass(alert_type_class).html(closeAlert+alert_message).show();
}

function validateIE(alert_class)
{
	if (getInternetExplorerVersion() == -1) 
  {
		// do nothing, not IE
    return;
	} 
  else if (getInternetExplorerVersion() != 11) 
  {
    resetAlertType(alert_class);
    $("."+alert_class).addClass('alert-warning').html(closeAlert+'For security purposes please upgrade to Internet Explorer 11 or use an alternative browser.').show();
    
	}
}

function resetAlertType(alert_class)
{
  $("."+alert_class).removeClass("alert-success").removeClass("alert-info").removeClass("alert-warning").removeClass("alert-danger");
}

$(function(){
  //refresh_digital_clock();
 $("#login_form").submit(function(e){
    e.preventDefault();

    if($("#username").val() == '' || $("#password").val() == '')
    {
      showMessage('alert', "All Fields are required.", "alert-danger");
    }else{
      $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: $(this).serialize(),
      }).done(function(msg){
        //var obj = JSON.parse(msg);
        if(msg.status == 'success'){
          location.reload();
        }else{
          $(".alert").text(msg.message).addClass('alert-danger').show();
        }
      });
    }

 });
});