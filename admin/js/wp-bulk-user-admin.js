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
		$('.wpbu-loading').hide();
		$('#wpbu_im_file').change(function () {
			var file = $(this).val();
			var extension = file.split('.').pop();
			if (extension !== "xlsx" && extension !== "xls" && extension !== "csv") {
				swal(
					'Format Error!',
					'Please provide only (.csv, .xls, .xlsx) format!',
					'error'
				);
				$(this).val('');
			}
		});
		$('#btn-import').click(function () {
			if($('#wpbu_im_file').val()) {
				swal({
					title: 'Hang Tight!',
					text: 'Processing please wait. Don\'t close your browser!',
					type: 'info',
					allowOutsideClick: false
				}).then(function () {
					$('.wpbu-loading').show();
				});
			} else {
				swal(
					'Opps!',
					'You don\'t select any file, please provide a file!',
					'error'
				);
			}

			//$('#form-import').submit();
		});
	})

})( jQuery );
