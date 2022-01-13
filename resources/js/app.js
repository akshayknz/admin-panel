require('./bootstrap');
require('admin-lte');
import "bootstrap";
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});
$('#daterangepicker').daterangepicker()
$(function () {
    document.querySelector('.nav-item.dropdown.user-menu').addEventListener('click',(e)=>{
        e.currentTarget.querySelector('.dropdown-menu').classList.toggle('show')
    })

    let bookingData = {};
    const setBookingData = ( data = $('#daterangepicker').val() ) => {
        bookingData = {
            "date" : data
        };
    }
    setBookingData();
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
                console.log(content.percent);
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

    $('#daterangepicker').on('apply.daterangepicker', (ev, picker) => {
        setBookingData(ev.currentTarget.value);
        $("#bookingTable").DataTable().ajax.reload()
    });

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
});