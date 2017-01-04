jQuery(document).ready(function($){
	$('#bbdi_create_pages').on('click', function(){
		clickButton(this, $, 'Working...');
	});
	$('#bbdi_create_categories').on('click', function(){
		clickButton(this, $, 'Working...');
	});
	$('#bbdi_set_options').on('click', function(){
		clickButton(this, $, 'Working...');
	});
	$('#bbdi_create_menu').on('click', function(){
		clickButton(this, $, 'Working...');
	});

	// On button click, pop up the wp media library and insert the image url to the input field
	/*$( 'button#bbd_init_logo_upload' ).on( 'click', function(e){

		e.preventDefault();

		var input = $( 'input#bbd_init_logo_slug' );

		wp.media.editor.send.attachment = function( props, attachment ) {
			input.val( attachment.url );
			//console.log(props, attachment);
			return attachment[0];
		}
		wp.media.editor.open( $(this) );
		return false;

	});*/

	var custom_uploader;

	$( 'button#bbd_init_logo_upload' ).on( 'click', function(e){
		e.preventDefault();

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false,
			type: 'image'
		});

		custom_uploader.on( 'select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();
			$( 'input#bbd_init_logo_slug' ).val(attachment.url);
		});

		custom_uploader.open();
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