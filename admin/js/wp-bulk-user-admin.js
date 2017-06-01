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

        /* Properties declaration */
        var $wpbu_users = $('#wpbu_users');
        var $wpbu_im_file = $('#wpbu_im_file');
        var $wpbu_btn_import = $('#wpbu_btn_import');
        var $wpbu_user_add_new_row = $('#wpbu_user_add_new_row');
        var $wpbu_send_user_notification = $('#wpbu_send_user_notification');

        /* On change event of browsing file */
        $wpbu_im_file.change(function () {
            check_file_extension($(this));
        });

        /* Click event of import button */
        $wpbu_btn_import.click(function () {
            if (check_file_extension($wpbu_im_file)) {
                var extension = $wpbu_im_file.val().split('.').pop();
                switch (extension) {
                    case 'csv':
                        extension = 'csv';
                        break;
                    case 'xlsx':
                        extension = 'xlsx';
                        break;
                    default:
                        extension = 'csv';
                        break;
                }
                import_file(extension, $wpbu_im_file);
            }
        });

        /* Click event of insert button click */
        $('#wpbu-btn-insert-text').click(function () {
            if ($wpbu_users.val().length < 1) {
                swal({
                    title: 'Oops!',
                    type: 'error',
                    text: 'User Information is missing, please enter again.',
                    allowOutsideClick: false
                }).then(function () {
                    $wpbu_users.focus();
                });
            } else {
                if (!$wpbu_send_user_notification.is(':checked')) {
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

        /* AJAX definition of adding multiple user */
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
                    swal({
                        title: 'All Done!',
                        type: 'success',
                        text: 'See the log details above of the form.',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    });
                    $('.wpbu-console').html('');
                    if (data.mismatch !== undefined && data.mismatch.error.type === 'error') {
                        create_log(data.mismatch.error.message, 'error');
                    }
                    if (data.insert !== undefined) {
                        if (data.insert.error !== undefined && data.insert.error.type === 'warning') {
                            create_log(data.insert.error.message, 'warning');
                        }
                        if (data.insert.success !== undefined && data.insert.success.type === 'success') {
                            create_log(data.insert.success.message, 'success');
                        }
                    }
                    if (data.username !== undefined && data.username.exists.type === 'error') {
                        create_log(data.username.exists.message, 'error');
                    }
                    if (data.email !== undefined && data.email.exists.type === 'error') {
                        create_log(data.email.exists.message, 'error');
                    }
                    if (data.invalid !== undefined && data.invalid.type === 'error') {
                        create_log(data.invalid.message, 'error');
                    }
                    if (data.empty !== undefined && data.empty.type === 'error') {
                        create_log(data.empty.message, 'error');
                    }
                },
                error: function (xhr, status, text) {
                    swal({
                        title: status.toUpperCase() + ': ' + xhr.status,
                        type: 'error',
                        text: text.toUpperCase(),
                        showConfirmButton: true,
                        allowOutsideClick: false
                    });
                }
            });
        };

        /* AJAX definition of importing file */
        var import_file = function (extension, object) {
            var form_data = new FormData();
            var individual_file = object[0].files[0]; //$(document).find('input[type="file"]');
            form_data.append('file', individual_file);
            form_data.append('action', 'import_file');
            form_data.append('extension', extension);
            form_data.append('security', ajax_object.ajax_nonce);
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: ajaxurl,
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    swal({
                        title: 'Uploading...',
                        type: 'info',
                        text: '',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function (data) {
                    swal({
                        title: 'All Done!',
                        type: 'success',
                        text: 'See the log details above of the form.',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    });
                    $('.wpbu-console').html('');
                    if (data.insert !== undefined) {
                        if (data.insert.error !== undefined && data.insert.error.type === 'warning') {
                            create_log(data.insert.error.message, 'warning');
                        }
                        if (data.insert.success !== undefined && data.insert.success.type === 'success') {
                            create_log(data.insert.success.message, 'success');
                        }
                    }
                    if (data.username !== undefined && data.username.exists.type === 'error') {
                        create_log(data.username.exists.message, 'error');
                    }
                    if (data.email !== undefined && data.email.exists.type === 'error') {
                        create_log(data.email.exists.message, 'error');
                    }
                },
                error: function (xhr, status, text) {
                    swal({
                        title: status.toUpperCase() + ': ' + xhr.status,
                        type: 'error',
                        text: text.toUpperCase(),
                        showConfirmButton: true,
                        allowOutsideClick: false
                    });
                }
            });
        };

        /* Create log result of adding multiple user */
        var create_log = function (message, type) {
            $('.wpbu-console').show().append('<p class="wpbu-log wpbu-' + type + '">' + message + '</p><p>&nbsp;</p>');
        };

        /* Check file extension is CSV/XLSX */
        var check_file_extension = function (object) {
            var file = object.val();
            var extension = file.split('.').pop();
            if (extension !== "xlsx" && extension !== "csv") {
                swal(
                    'Format Error!',
                    'Please provide only (.csv, .xlsx) format!',
                    'error'
                );
                object.val('');
            } else {
                return true;
            }
        };

        /* Click event on add new row button */
        var counter = 1;
        $wpbu_user_add_new_row.click(function () {
            var roles = JSON.parse($(this).attr('data-roles'));
            var options = '';
            roles.forEach(function (data) {
                options += '<option value="' + data + '">' + data + '</option>';
            });
            console.log(roles);
            $('.form-table tr:nth-child(' + counter + ')').after('<tr valign="top" id="row_' + (counter + 1) + '">' +
                '<th scope="row">' +
                '<label><a class="wpbu-remove" data-counter="' + (counter + 1) + '">Remove #' + ((counter < 9) ? '0' + (counter + 1) : (counter + 1)) + '</a></label>' +
                '</th>' +
                '<td scope="row">' +
                '<input class="wpbu-input-md" id="wpbu_user_login" name="wpbu_user_login" placeholder="Username (required)">&nbsp;' +
                '<input class="wpbu-input-md" id="wpbu_email" name="wpbu_email" placeholder="Email (required)">&nbsp;' +
                '<input class="wpbu-input-md" id="wpbu_first_name" name="wpbu_first_name" placeholder="First Name">&nbsp;' +
                '<input class="wpbu-input-md" id="wpbu_last_name" name="wpbu_last_name" placeholder="Last Name">&nbsp;' +
                '<input class="wpbu-input-md" id="wpbu_url" name="wpbu_url" placeholder="Website">&nbsp;' +
                '<input class="wpbu-input-md" id="wpbu_password" name="wpbu_password" placeholder="Password">&nbsp;' +
                '<select id="wpbu_role" class="wpbu-input-md" name="wpbu_role">' + options + '</select>' +
                '</td>' +
                '</tr>');
            counter++;
        });

        $(document).on('click', '.wpbu-remove', function () {
            var count = $(this).attr('data-counter');
            $('#row_' + count).remove();
            counter--;
        });

    });

})(jQuery);
