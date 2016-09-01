// JavaScript Document

$(document).ready(function(e) {

$('.form_valid').submit(function(e) {
	$('.file-upload-button').css('color','#999');
	$('.alert-error').hide();
	$('.alert-info').hide();
	$('.alert-success').hide();
	$('.requir_mark').hide(); 
	$(this).find('input').removeClass('my_error');
	$(this).find('select').removeClass('my_error');
	$(this).find('.error_class').css('display','none');
	
	var error=0;
	
	$(this).find('input, select, textarea').each(function(index, element) {
		if($(this).hasClass('cpw'))
		{
			var cpw_length = $('.cpw').val().length; 
			if(cpw_length > 0 && cpw_length!=""){
				$('.npw').addClass('required');
				$('.cnf_npw').addClass('required');
			}
			else{
				$('.npw').removeClass('required');
				$('.cnf_npw').removeClass('required');
			}
		}
        if($(this).hasClass('required') || $(this).hasClass('required_sel') || $(this).hasClass('required_sel1') || $(this).hasClass('required_text'))
		{
			if($(this).hasClass('singlesel'))
			{ 
					if($(this).val()=='')
					{ 
						if($(this).hasClass('required_sel')){
							$(this).parent().parent().parent().addClass('my_error');
						}
						else if($(this).hasClass('required_sel1')){
							$(this).parent().parent().parent().parent().addClass('my_error');
						}
						else{
							$(this).parent().parent().addClass('my_error');
						}
						
						error="Please fill required fields.<span class='error_close'></span>";
						$(this).parents('.form_valid').find('.error_class').html(error);			
						$(this).parents('.form_valid').find('.error_class').css('display','block');
						$(this).focus();
						return false;
					}
			}
			else if($(this).hasClass('email_exists'))
			{ 
						$(this).addClass('my_error');
						error="Email already exists.<span class='error_close'></span>";
						$(this).parents('.form_valid').find('.error_class').html(error);			
						$(this).parents('.form_valid').find('.error_class').css('display','block');
						$(this).focus();
						return false;
			}
			else if($(this).hasClass('img_req'))
			{ 
					if($(this).val()=='')
					{ 
						$('.file-upload-button').css('color','red');
						error="Please fill required fields.<span class='error_close'></span>";
						$(this).parents('.form_valid').find('.error_class').html(error);			
						$(this).parents('.form_valid').find('.error_class').css('display','block');
						$(this).focus();
						return false;
					}
			}
			
			else if($(this).hasClass('required_text')){
					if($(this).val()=='')
					{
						$(this).parent().addClass('my_error');
						error="Please fill required fields.<span class='error_close'></span>";
						$(this).parents('.form_valid').find('.error_class').html(error);			
						$(this).parents('.form_valid').find('.error_class').css('display','block');
						$(this).focus();
						return false;
					}
			}
			else
			{
					if($(this).val()=='')
					{
						$(this).addClass('my_error');
						error="Please fill required fields.<span class='error_close'></span>";
						$(this).parents('.form_valid').find('.error_class').html(error);			
						$(this).parents('.form_valid').find('.error_class').css('display','block');
						$(this).focus();
						return false;
					}
			}
		}
		if($(this).hasClass('email'))
		{
			
			if($(this).val()!='')
			{
				var x=$(this).val();
	
				var atpos=x.indexOf("@");
	
				var dotpos=x.lastIndexOf(".");		
	
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	
				{
	
					$(this).addClass('my_error');
	
					error="Please enter valid email address.<span class='error_close'></span>";
	
					$(this).parents('.form_valid').find('.error_class').html(error);			
	
					$(this).parents('.form_valid').find('.error_class').css('display','block');
	
					//$(this).focus();
	
					return false;
	
				}
			}
		}
		if($(this).hasClass('number'))
		{
			var x=$(this).val();
			if (isNaN(x))
			{
				$(this).addClass('my_error');
				//error="Please enter only numbers in Phone number field.<span class='error_close'></span>";
				error="Please enter only numbers.<span class='error_close'></span>";
				$(this).parents('.form_valid').find('.error_class').html(error);			
				$(this).parents('.form_valid').find('.error_class').css('display','block');
				$(this).focus();
				return false;
			}
		}
		if($(this).hasClass('lettersonly'))
		{
			var x=$(this).val();
			var onlyLetters = /^[a-z A-Z]*$/.test(x);
			if (!onlyLetters)
			{
				$(this).addClass('my_error');
				error="Please enter only alphabets in name field.<span class='error_close'></span>";
				$(this).parents('.form_valid').find('.error_class').html(error);			
				$(this).parents('.form_valid').find('.error_class').css('display','block');
				$(this).focus();
				return false;
			}
		}
	
		if($(this).hasClass('phone'))
		{
			var x=$(this).val();
			if (x.length>0 && (x.length<8 || x.length>14))
			{
				$(this).addClass('my_error');
				error="Please fill correct Phone number.<span class='error_close'></span>";
				$(this).parents('.form_valid').find('.error_class').html(error);			
				$(this).parents('.form_valid').find('.error_class').css('display','block');
				$(this).focus();
				return false;
			}
		}		
		
		
		if($(this).hasClass('pwdcheck'))
		{	
			var pwd=$(this).val();
			if((pwd.length < 8) || (!pwd.match(/[A-z]/)) || (!pwd.match(/[A-Z]/)) || (!pwd.match(/\d/))){
					
					$(this).addClass('my_error');
					error="Password Minimum 8 Characters, 1 capital, 1 Small, 1 Number.<span class='error_close'></span>";
					$(this).parents('.form_valid').find('.error_class').html(error);			
					$(this).parents('.form_valid').find('.error_class').css('display','block');
					$(this).focus();
					return false;
			}
			//alert('test');
		
		}
		
		if($(this).hasClass('pass_confirm'))
		{	//alert('fff');
			var x=$(this).val();
			//alert(x);
			var y=$('#password1').val();
			//alert(y);
			var cpw=$('.cpw').val();
			//alert(cpw);
			
			if (x!=y)
			{
				if (cpw=="")
				{
					$('.cpw').addClass('my_error');
					error="Please enter current password.<span class='error_close'></span>";
					$('.cpw').parents('.form_valid').find('.error_class').html(error);			
					$('.cpw').parents('.form_valid').find('.error_class').css('display','block');
					$('.cpw').focus();
					return false;
				}
				else{
					$(this).addClass('my_error');
					error="Confirm password does not match.<span class='error_close'></span>";
					$(this).parents('.form_valid').find('.error_class').html(error);			
					$(this).parents('.form_valid').find('.error_class').css('display','block');
					$(this).focus();
					return false;
				}
			}
		}
		if($(this).hasClass('ajax_mobile'))
		{
			var mo=$(this).val();
			$.ajax({
				type:'POST',
				url:'ajax/check_mobile.php',
				data:'mobile='+mo,
				success: function(result)
				{
					if(result.trim()=='error')
					{
						error="Mobile number is already exists.<span class='error_close'></span>";
						$('.error_class').html(error);			
						$('.error_class').css('display','block');
						$('.ajax_mobile').focus();
						return false;
					}
				}
			});
		}
		if($(this).hasClass('server_pass'))
		{
			var pass=$(this).val();
			$.ajax({
				type:'POST',
				async:false,
				url:'ajax/pass_check.php',
				data:'password='+pass,
				success: function(result)
				{
					if(result.trim()=='error')
					{
						error="Current password not match.<span class='error_close'></span>";
						$('.error_class').html(error);			
						$('.error_class').css('display','block');
						//$(this).focus();
						return false;
					}
				}
			});
		}
		if($(this).hasClass('ajax_email'))
		{
			var email=$(this).val();
			$.ajax({
				type:'POST',
				async:false,
				url:'ajax/ajax_check_email.php',
				data:'email='+email,
				success: function(result)
				{
					if(result.trim()=='error')
					{
						error="Email address already exists.<span class='error_close'></span>";
						$('.error_class').html(error);			
						$('.error_class').css('display','block');
						return false;
					}
				}
			});
		}
		if($(this).hasClass('ajax_username'))
		{
			var username=$(this).val();
			$.ajax({
				type:'POST',
				async:false,
				url:'ajax/check_username.php',
				data:'username='+username,
				success: function(result)
				{
					if(result.trim()=='error')
					{
						error="Username already exist.<span class='error_close'></span>";
						$('.error_class').html(error);			
						$('.error_class').css('display','block');
						//$(this).focus();
						return false;
					}
				}
			});
		}
		
    });
	if(error==0)
	{
		return true;
	}
	else
	{	
		return false;
	}
});

 $(document).on('click', '.error_close', function () { 
	$(this).parent().css('display','none');
	$('#show_msg').css('display','none');	
 });

});

function close_pop(){
	$("#cboxClose").trigger("click");
}


