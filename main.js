$(function() {
	const FORM = $('.contact-form');
	
	var form_inputs = $('formInputs');
	
	$(form).submit(function(e) {
		e.preventDefault();
		
		var formData = $(form).serialize();
		
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		}).done(function(response) {
			$(form_inputs).removeClass('error');
			$(form_inputs).addClass('success');
			
			$(form_inputs).text(response);
			
			$('.name').val('');
			$('.email').val('');
			$('message').val('');
		}).fail(function(data) {
			$(form_inputs).removeClass('success');
			$(form_inputs).addClass('error');
			
			if(data.responseText !== '') {
				$(form_inputs).text(data.responseText);
			}else {
				$(form_inputs).text('An error has occured, message could not be sent');
			}
		});
	});	
});