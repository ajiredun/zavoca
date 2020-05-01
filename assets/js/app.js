/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
global.$ = $;
//global.jQuery = $;
import 'popper.js';
import 'bootstrap';
import PerfectScrollbar from 'perfect-scrollbar/dist/perfect-scrollbar.js';
global.PerfectScrollbar = PerfectScrollbar;
import Chartist from 'chartist';
global.Chartist = Chartist;
import 'chartist-plugin-tooltips';
import 'raphael';
import 'morris.js/morris.js'
import './backoffice-theme/app';
import './backoffice-theme/app.init.dark';
import './backoffice-theme/app-style-switcher';
import './backoffice-theme/waves';
import './backoffice-theme/sidebarmenu';
import './backoffice-theme/custom';

import Swal from 'sweetalert2/dist/sweetalert2.js'
global.Swal = Swal;

// CODES START HERE
$(document).ready(function() {
    //ALERTS
    setTimeout(function () {
        $('.alert-fade').fadeOut();
    },5000);

    // Page Actions
    $('.zavoca-prompt').on('click',function (event) {


        var button = $(this);
        console.log(button);
        var button_href = button.attr('href');
        var zavoca_prompt = button.data('prompt');


        if (zavoca_prompt=="prompt") {
            event.preventDefault();

            var zavoca_prompt_sign = button.data('prompt-sign');
            var zavoca_prompt_message = button.data('prompt-message');
            var zavoca_prompt_button_confirm = button.data('prompt-button-confirm');
            var zavoca_prompt_button_cancel = button.data('prompt-button-cancel');


            var isConfirm = false;
            var labelConfirm = 'Ok';
            if (zavoca_prompt_button_confirm == "prompt-confirm") {
                isConfirm = true;
                var labelConfirm = 'Confirm';
            }

            var isCancel = false;
            if (zavoca_prompt_button_cancel == "prompt-cancel") {
                isCancel = true;
            }


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn waves-effect waves-light btn-rounded btn-primary',
                    cancelButton: 'mr-2 btn waves-effect waves-light btn-rounded btn-danger'
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
                title: '',
                text: zavoca_prompt_message,
                type: zavoca_prompt_sign,
                showCancelButton: isCancel,
                confirmButtonText: labelConfirm,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    if (isConfirm) {
                        window.location.href = button_href;
                    }
                }
            });
        }

    });
});