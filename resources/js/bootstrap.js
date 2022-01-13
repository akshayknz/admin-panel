window._ = require('lodash');
import "bootstrap";
require("admin-lte/plugins/jquery/jquery");
require("admin-lte/node_modules/bootstrap/js/src/dropdown.js");
require("admin-lte/plugins/datatables/jquery.dataTables");
require("admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js");
require("admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js");
require("admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js");
require("admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js");
require("admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js");
require("admin-lte/plugins/jszip/jszip.min.js");
require("admin-lte/plugins/pdfmake/pdfmake.min.js");
require("admin-lte/plugins/pdfmake/vfs_fonts.js");
require("admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js");
require("admin-lte/plugins/datatables-buttons/js/buttons.print.min.js");
require("admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js");
require("admin-lte/plugins/daterangepicker/daterangepicker");
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
