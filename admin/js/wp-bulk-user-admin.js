(function ($) {
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
        var $wpbu_users = $('#wpbu_users');
        var $wpbu_send_user_notification = $('#wpbu_send_user_notification');
        $('#wpbu_im_file').change(function () {
            var file = $(this).val();
            var extension = file.split('.').pop();
            if (extension !== "xlsx" && extension !== "csv") {
                swal(
                    'Format Error!',
                    'Please provide only (.csv, .xlsx) format!',
                    'error'
                );
                $(this).val('');
            }
        });
        $('#wpbu-btn-insert-text').click(function () {
            if($wpbu_users.val().length < 1) {
                swal({
                    title: 'Oops!',
                    type: 'error',
                    text: 'User Information is missing, please enter again.',
                    allowOutsideClick: false
                }).then(function () {
                    $wpbu_users.focus();
                });
            } else {
                if(!$wpbu_send_user_notification.is(':checked')) {
                    swal({
                        title: 'Relax!',
                        text: "You won't be able to send email to these users!",
                        type: 'warning',
                        showCancelButton: true,
                        allowOutsideClick: false,
                        confirmButtonColor: '#4fd629',
                        cancelButtonColor: '#dd9c4e',
                        confirmButtonText: 'Yes, send email!',
                        cancelButtonText: 'No, not now!'
                    }).then(function () {
                        $wpbu_send_user_notification.prop('checked', true);
                        swal({
                            title: 'Cool!',
                            text: 'These new users will get notified now.',
                            type: 'success'
                        });
                        $wpbu_send_user_notification.val('1');
                        add_multiple_users();
                    }, function (dismiss) {
                        if (dismiss === 'cancel') {
                            swal({
                                title: 'May be wrong!',
                                text: 'These new users will NOT get any email now.',
                                type: 'error'
                            });
                            $wpbu_send_user_notification.val('0');
                            add_multiple_users();
                        }
                    });

                } else {
                    add_multiple_users();
                }
            }
        });
        var add_multiple_users = function () {
            $.ajax({
                data: {
                    'action': 'add_multiple_users',
                    'security': ajax_object.ajax_nonce,
                    'wpbu_users': $wpbu_users.val(),
                    'wpbu_send_user_notification': $wpbu_send_user_notification.val()
                },
                dataType: 'JSON',
                type: 'POST',
                url: ajaxurl,
                beforeSend: function () {
                    swal({
                        title: 'Processing...',
                        type: 'info',
                        text: '',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function (data) {

                }
            });
        };
    });

})(jQuery);
