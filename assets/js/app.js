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
//global.$ = $;
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

import './backoffice-theme/dashboard1'

// CODES START HERE
$(document).ready(function() {

});