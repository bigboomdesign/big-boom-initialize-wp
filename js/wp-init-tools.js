jQuery(document).ready(function($){
	$('#wpinit_create_pages').on('click', function(){
		clickButton(this, $, 'Working...');
	});
	$('#wpinit_create_categories').on('click', function(){
		clickButton(this, $, 'Working...');
	});
	$('#wpinit_set_options').on('click', function(){
		clickButton(this, $, 'Working...');
	});
	$('#wpinit_create_menu').on('click', function(){
		clickButton(this, $, 'Working...');
	});	
});
function clickButton(elem, $, preMessage){
	var preMessage = preMessage || '';
	var button = elem;
	var $button = $(elem);
	var id = button.id;
	var $message = $button.closest('.action-button-container').find('.message')
	$.ajax({
		url: ajaxurl,
		data: {
			action: button.id,
		},
		beforeSend: function(){
			$message.html(preMessage);
		},
		success: function(data){
			$message.html(data);
		}
	});	
}