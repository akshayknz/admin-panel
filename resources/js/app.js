require('./bootstrap');
require('admin-lte');
import "bootstrap";
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});
$(function () {

    /**
     * Init
     */
    var d = new Date();
    $('#daterangepicker').daterangepicker({
        startDate: d, 
        endDate: d.setDate(d.getDate() - 30)
    })

    document.querySelector('.nav-item.dropdown.user-menu').addEventListener('click',(e)=>{
        e.currentTarget.querySelector('.dropdown-menu').classList.toggle('show')
    })

    //Date Range Logic
    let bookingData = {};
    const setBookingData = ( data = $('#daterangepicker').val() ) => {
        bookingData = {
            "date" : data
        };
    }
    setBookingData();

    $('#daterangepicker').on('apply.daterangepicker', (ev, picker) => {
        setBookingData(ev.currentTarget.value);
        $("#bookingTable").DataTable().ajax.reload()
        $("#topTreksTable").DataTable().ajax.reload()
        $("#clientsTable").DataTable().ajax.reload()
        $("#cityTable").DataTable().ajax.reload()
        $("#stateTable").DataTable().ajax.reload()
    });

    /**
     * Datatables
     */

    //Bookings
    let bookingTable = $("#bookingTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            { extend: 'copy', className: 'btn btn-secondary ' },
            { extend: 'csv', className: 'btn btn-secondary ' },
            { extend: 'excel', className: 'btn btn-secondary ' },
            { extend: 'pdf', className: 'btn btn-secondary ' },
            { extend: 'print', className: 'btn btn-secondary ' },
            { extend: 'colvis', className: 'btn btn-secondary ' }
        ],
        "ajax": {
            "url": "getBookings",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
          }],
        "columns": [
        {
            "title": "Sl. No.",
            sortable: false,
            "width": "10%",
            "render": function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "title": "Booking",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.trek_name;
            }
        },
        {
            "title": "New booking",
            "render": function (data, type, content, meta) {
                return `${content.bookings_count} (${content.percent}%)`
            }
        },
        {
            "title": "Convert",
            "render": function (data, type, content, meta) {
                return `${content.bookings_count_paid} (${content.percent_paid}%)`
            }
        }
        ]
    }).buttons().container().appendTo('#bookingTable_wrapper .col-md-6:eq(0)');

    let topTreksTable = $("#topTreksTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            { extend: 'copy', className: 'btn btn-secondary ' },
            { extend: 'csv', className: 'btn btn-secondary ' },
            { extend: 'excel', className: 'btn btn-secondary ' },
            { extend: 'pdf', className: 'btn btn-secondary ' },
            { extend: 'print', className: 'btn btn-secondary ' },
            { extend: 'colvis', className: 'btn btn-secondary ' }
        ],
        "ajax": {
            "url": "getBookings",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
          }],
        "columns": [
        {
            "title": "Sl. No.",
            sortable: false,
            "width": "10%",
            "render": function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "title": "Booking",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.trek_name;
            }
        },
        {
            "title": "New booking",
            "render": function (data, type, content, meta) {
                return `${content.bookings_count}`
            }
        },
        {
            "title": "Convert",
            "render": function (data, type, content, meta) {
                return `${content.bookings_count_paid}`
            }
        }
        ]
    }).buttons().container().appendTo('#topTreksTable_wrapper .col-md-6:eq(0)');

    let clientsTable = $("#clientsTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            { extend: 'copy', className: 'btn btn-secondary ' },
            { extend: 'csv', className: 'btn btn-secondary ' },
            { extend: 'excel', className: 'btn btn-secondary ' },
            { extend: 'pdf', className: 'btn btn-secondary ' },
            { extend: 'print', className: 'btn btn-secondary ' },
            { extend: 'colvis', className: 'btn btn-secondary ' }
        ],
        "ajax": {
            "url": "getClients",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
          }],
        "columns": [
        {
            "title": "Sl. No.",
            sortable: false,
            "width": "10%",
            "render": function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "title": "Client",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return Object.keys(content)[0];
            }
        },
        {
            "title": "",
            "render": function (data, type, content, meta) {
                var keys = Object.keys(content);
                return `${content[keys[0]]} (${content.past}%)`;
            }
        }
        ]
    }).buttons().container().appendTo('#clientsTable_wrapper .col-md-6:eq(0)');

    let cityTable = $("#cityTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            { extend: 'copy', className: 'btn btn-secondary ' },
            { extend: 'csv', className: 'btn btn-secondary ' },
            { extend: 'excel', className: 'btn btn-secondary ' },
            { extend: 'pdf', className: 'btn btn-secondary ' },
            { extend: 'print', className: 'btn btn-secondary ' },
            { extend: 'colvis', className: 'btn btn-secondary ' }
        ],
        "ajax": {
            "url": "getCities",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
          }],
        "columns": [
        {
            "title": "Sl. No.",
            sortable: false,
            "width": "10%",
            "render": function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "title": "City",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content[0];
            }
        },
        {
            "title": "",
            "render": function (data, type, content, meta) {
                return `${content[1]} (${content[2]}%)`;
            }
        }
        ]
    }).buttons().container().appendTo('#cityTable_wrapper .col-md-6:eq(0)');

    let stateTable = $("#stateTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            { extend: 'copy', className: 'btn btn-secondary ' },
            { extend: 'csv', className: 'btn btn-secondary ' },
            { extend: 'excel', className: 'btn btn-secondary ' },
            { extend: 'pdf', className: 'btn btn-secondary ' },
            { extend: 'print', className: 'btn btn-secondary ' },
            { extend: 'colvis', className: 'btn btn-secondary ' }
        ],
        "ajax": {
            "url": "getStates",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
          }],
        "columns": [
        {
            "title": "Sl. No.",
            sortable: false,
            "width": "10%",
            "render": function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "title": "State",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content[0];
            }
        },
        {
            "title": "",
            "render": function (data, type, content, meta) {
                return `${content[1]} (${content[2]}%)`;
            }
        }
        ]
    }).buttons().container().appendTo('#stateTable_wrapper .col-md-6:eq(0)');
    
    // $("#bookingTable").DataTable({
    //     "responsive": true,
    //     "lengthChange": false,
    //     "autoWidth": false,
    //     "buttons": [
    //         { extend: 'copy', className: 'btn btn-secondary ' },
    //         { extend: 'csv', className: 'btn btn-secondary ' },
    //         { extend: 'excel', className: 'btn btn-secondary ' },
    //         { extend: 'pdf', className: 'btn btn-secondary ' },
    //         { extend: 'print', className: 'btn btn-secondary ' },
    //         { extend: 'colvis', className: 'btn btn-secondary ' }
    //     ]
    // })
    // .buttons().container().appendTo('#bookingTable_wrapper .col-md-6:eq(0)');
    // anisha03121992
    $('.dataTables_filter').parent().removeClass('col-md-6');
});