(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function () {
		$('.wpbu-console').hide();
		$('#wpbu_im_file').change(function () {
			var file = $(this).val();
			var extension = file.split('.').pop();
			if (extension != "xlsx" && extension != "xls" && extension != "csv") {
				swal(
					'Format Error!',
					'Please provide only (.csv, .xls, .xlsx) format!',
					'error'
				);
				$(this).val('');
			}
		});
		$('#btn-insert-text').click(function () {
			$('.wpbu-console').show();
			$('.wpbu-console').html('<p class="wpbu-log">Log Output...</p><p class="wpbu-log">================================================================</p>');
			for (var i=1; i<=100; i++) {
				delay
				setInterval(function () {
					$('.wpbu-console').append('<p class="wpbu-log wpbu-success">This is a log of #'+i+'</p>');
					$('.wpbu-console').append('<p class="wpbu-log wpbu-warning">This is a log of #'+i+'</p>');
					$('.wpbu-console').append('<p class="wpbu-log wpbu-danger">This is a log of #'+i+'</p>');
				}, 500);
			}
			$('.wpbu-console').append('<p class="wpbu-log">================================================================</p>');
			$('.wpbu-console').append('<p class="wpbu-log">Completed...</p><p>&nbsp;</p>');
		});
		// http://jsfiddle.net/8ZtqL/1/
		var logOutput = function(text,elem,delay){
			if(!elem){
				elem = $("body");
			}
			if(!delay){
				delay = 300;
			}
			if(text.length >0){
				//append first character
				elem.append(text[0]);
				setTimeout(
					function(){
						//Slice text by 1 character and call function again
						addTextByDelay(text.slice(1),elem,delay);
					},delay
				);
			}
		}
	})

})( jQuery );
