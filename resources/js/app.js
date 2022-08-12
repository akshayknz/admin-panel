require('admin-lte');
import "bootstrap";
require('./bootstrap');
const Swal = require('sweetalert2');
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});
let baseUrl = document.getElementById('base-url').value;
let headers = {
    // "Content-Type": "multipart/form-data",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
}

$(function () { 
    /**
     * Init
     */
    var d = new Date();
    $('#daterangepicker').daterangepicker({
        startDate: d, 
        endDate: d.setDate(d.getDate() - 30)
    })
    $('.select2').select2();

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

    const percentElement = (num) => {
        let cls = 'neutral'
        let arrow = ''
        switch (true) {
            case num == 0:
                cls = 'neutral'
                break;
            case num > 0:
                cls = 'positive'
                arrow = '▲'
                break;
            case num < 0:
                cls = 'negative'
                arrow = '▼'
                break;
            default:
                cls = 'neutral'
                break;
        }

        return `<span class="percent ${cls}">${arrow}${num}%</span>`;
    }

    const userOperations = (id) => {
        return `<div>
        <button class="btn btn-primary" 
            onClick = "editUser(${id})" 
            data-toggle="modal" 
            data-target="#modal-edit" >Edit</button>
        <button class="btn btn-primary" 
            onClick = "deleteUser(${id})"
            data-toggle="modal" 
            data-target="#modal-default" >Delete</button>
        </div>`;
    }

    const roleOperations = (id) => {
        return `<div>
        <button class="btn btn-primary" 
            onClick = "editRole('${id}')" 
            data-toggle="modal" 
            data-target="#modal-edit" >Edit</button>
        <button class="btn btn-primary" 
            onClick = "deleteRole('${id}')"
            data-toggle="modal" 
            data-target="#modal-default" >Delete</button>
        </div>`;
    }

    $('#daterangepicker').on('apply.daterangepicker', (ev, picker) => {
        setBookingData(ev.currentTarget.value);
        $("#bookingTable").DataTable().ajax.reload()
        $("#topTreksTable").DataTable().ajax.reload()
        $("#clientsTable").DataTable().ajax.reload()
        $("#cityTable").DataTable().ajax.reload()
        $("#stateTable").DataTable().ajax.reload()
        $("#ageTable").DataTable().ajax.reload()
        $("#revenueTable").DataTable().ajax.reload()
        $("#tthdataTable").DataTable().ajax.reload()
        $("#cookTable").DataTable().ajax.reload()
        $("#leaderTable").DataTable().ajax.reload()
        $("#salesteamTable").DataTable().ajax.reload()
    });

    /**
     * Datatables
     */

    //Bookings
    let bookingTable = $("#bookingTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": [
        //     { extend: 'copy', className: 'btn btn-secondary ' },
        //     { extend: 'csv', className: 'btn btn-secondary ' },
        //     { extend: 'excel', className: 'btn btn-secondary ' },
        //     { extend: 'pdf', className: 'btn btn-secondary ' },
        //     { extend: 'print', className: 'btn btn-secondary ' },
        //     { extend: 'colvis', className: 'btn btn-secondary ' }
        // ],
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
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
                return `${content.bookings_count} (${percentElement(content.percent)})`
            }
        },
        {
            "title": "Convert",
            "render": function (data, type, content, meta) {
                return `${content.bookings_count_paid} (${percentElement(content.percent_paid)})`
            }
        }
        ]
    });
    // .buttons().container().appendTo('#bookingTable_wrapper .col-md-6:eq(0)');

    let topTreksTable = $("#topTreksTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
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
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Top Treks",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.trek_name;
            }
        },
        {
            "title": "No. Booking",
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
    });

    let clientsTable = $("#clientsTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
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
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
                return `${content[keys[0]]} (${percentElement(content.past)})`;
            }
        }
        ]
    });

    let cityTable = $("#cityTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
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
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Realtime",
            "render": function (data, type, content, meta) {
                return `${content[1]} (${percentElement(content[2])})`;
            }
        }
        ]
    });

    let stateTable = $("#stateTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
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
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Realtime",
            "render": function (data, type, content, meta) {
                return `${content[1]} (${percentElement(content[2])})`;
            }
        }
        ]
    });

    let ageTable = $("#ageTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ajax": {
            "url": "getAges",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Age Range",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content[0];
            }
        },
        {
            "title": "Realtime",
            "render": function (data, type, content, meta) {
                return `${content[1]} (${percentElement(content[2])})`;
            }
        }
        ]
    });

    let revenueTable = $("#revenueTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "order": [[3, 'desc']],
        "ajax": {
            "url": "getRevenue",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Revenue",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.trek_name;
            }
        },
        {
            "title": "No. trekkers",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.total_participants;
            }
        },
        {
            "title": "Amount",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.paid_sum;
            }
        }
        ]
    });

    let cookTable = $("#cookTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ajax": {
            "url": "getCooks",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Name",
            "width": "60%",
            "render": function (data, type, content, meta) {
                console.log(data);
                return content.name;
            }
        },
        {
            "title": "Batch",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.batches;
            }
        },
        {
            "title": "Days",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.days;
            }
        },
        {
            "title": "Star Rating",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.rating;
            }
        }
        ]
    });

    let leaderTable = $("#leaderTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ajax": {
            "url": "getLeaders",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Name",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.name;
            }
        },
        {
            "title": "Batch",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.batches;
            }
        },
        {
            "title": "Days",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.days;
            }
        },
        {
            "title": "Star Rating",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.rating;
            }
        }
        ]
    });

    let salesteamTable = $("#salesteamTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ajax": {
            "url": "getSalesteam",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
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
            "title": "Name",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content.name;
            }
        },
        {
            "title": "No. Trek",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return content[Object.keys(content)[0]].length;
            }
        },
        {
            "title": "Login Hrs",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return 35;
            }
        },
        {
            "title": "Revenue",
            "width": "60%",
            "render": function (data, type, content, meta) {
                console.log(content);
                return content.departure;
            }
        },
        {
            "title": "Convert",
            "width": "60%",
            "render": function (data, type, content, meta) {
                return percentElement(content.departure_past);
            }
        }
        ]
    });

    let tthdataTable = $("#tthdataTable").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "dom": 'lBfrtip',
        "lengthMenu": [ [ 5, 10, 50, -1 ], [ 'Show 5 rows', 'Show 10 rows', 'Show 50 rows', 'Show all rows' ] ],
        "buttons": [
            { extend: 'copy', className: 'btn btn-outline-danger ' },
            { extend: 'csv', className: 'btn btn-outline-danger ' },
            { extend: 'excel', className: 'btn btn-outline-danger ' },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4',  className: 'btn btn-outline-danger ' },
            { extend: 'pageLength', className: 'btn btn-outline-danger ' }
        ],
        "rowsGroup": [1, 2, 7, 8 , 9, 10, 11, 12 ],
        "order": [[ 0, "desc" ]],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
        },
        "ordering": true, 
        // "scrollX": false,
        "columnDefs": [{
            orderable: false,
            targets: "no-sort"
        }],
        "ajax": {
            "url": "getTthdata",
            "dataSrc": "",
            "type" : "POST",
            "data": function ( d ) {
               return  $.extend(d, bookingData);
            }
        },
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'booking-' + aData.id);
        },
        "columnDefs": [{
            "defaultContent": "-",
            "targets": "_all"
          }]
    }).buttons().container().appendTo('#bookingTable_wrapper .col-md-6:eq(0)');



    let usersTable = $("#usersTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ajax": {
            "url": "getUsers",
            "dataSrc": "",
            "type" : "GET"
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
            "sortable": false,
            "width": "10%",
            "render": function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "title": "Name",
            "render": function (data, type, content, meta) {
                return content.name;
            }
        },
        {
            "title": "Email",
            "render": function (data, type, content, meta) {
                return content.email;
            }
        },
        {
            "title": "Role",
            "render": function (data, type, content, meta) {
                return content.roles;
            }
        },
        {
            "title": "Operations",
            "sortable": false,
            "width": "160px",
            "render": function (data, type, content, meta) {
                return userOperations(content.id);
            }
        }
        ]
    });

    async function addRolesToSelect2(id) {
        await fetch(baseUrl+'/getRoles').then(data => data.json())
        .then(data => {
            var d = data.map(val => Object.keys(val)[0])
            var newOption = '';
            $(id).empty().trigger('change');
            d.forEach(element => {
                newOption = new Option(element, element, true, true);
                $(id).append(newOption).trigger('change');
            });
        });
    }

    window.editUser = (id) => {
        document.querySelector('#modal-edit form').reset()
        fetch(baseUrl+'/editUsers?id='+id).then(data => data.json())
        .then(data => {
            document.querySelector('input#edit-name').value = data[0].name;
            document.querySelector('input#edit-userid').value = data[0].id;
            document.querySelector('input#edit-email').value = data[0].email;
            addRolesToSelect2('#edit-role').then(()=>{
                $('#edit-role').val(data[0]['roles']); 
                $('#edit-role').trigger('change'); 
            });
        });
    }

    const resetFormErrors = (form) => {
        form.querySelectorAll("[id$='error']").forEach(element => {
            element.innerText = ''
        });
    }

    window.updateUser = (e) => {
        e.preventDefault()
        let formData = new FormData(e.currentTarget)
        let form = e.currentTarget
        showLoading(form);
        console.log(...formData);
        fetch(baseUrl+'/updateUser', {
            method: 'POST',
            headers: headers,
            body: formData,
        }).then(response => response.json())
        .then(data => {
            hideLoading(form);
            resetFormErrors(form);
            if(data.errors){
                let d = data.errors;
                for (const property in d) {
                    document.querySelector(`#edit-${property}-error`).innerText = d[property]
                    document.querySelector(`#edit-${property}-error`).style.display = 'block'
                }
            }else{
                $('#modal-edit').modal('toggle');
                $("#usersTable").DataTable().ajax.reload()
                Toast.fire({
                    icon: 'success',
                    title: 'User updated.'
                })
            }
        }).catch((error) => {console.error('Error:', error);});
    }
    
    window.addUser = () => {
        document.querySelector('#modal-add form').reset()
        addRolesToSelect2('#add-role').then(()=>{
            $('#add-role').val(null).trigger('change') 
        })
    }

    window.createUser = (e) => {
        e.preventDefault()
        let formData = new FormData(e.currentTarget)
        let form = e.currentTarget
        showLoading(form);
        fetch(baseUrl+'/createUser', {
            method: 'POST',
            headers: headers,
            body: formData,
        }).then(response => response.json())
        .then(data => {
            hideLoading(form);
            resetFormErrors(form);
            if(data.errors){
                let d = data.errors;
                for (const property in d) {
                    document.querySelector(`#add-${property}-error`).innerText = d[property]
                    document.querySelector(`#add-${property}-error`).style.display = 'block'
                }
            }else{
                $('#modal-add').modal('toggle');
                $("#usersTable").DataTable().ajax.reload()
                Toast.fire({
                    icon: 'success',
                    title: 'User created.'
                })
            }
        }).catch((error) => {console.error('Error:', error);});
    }

    window.deleteUser = (id) => {
        Swal.fire({
          title: 'Do you want to delete this user?',
          showCancelButton: true,
          confirmButtonText: 'Delete',
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(baseUrl+'/deleteUser/'+id, {
                method: 'DELETE',
                headers: headers
            }).then(response => response.json())
            .then((data) => {
                $("#usersTable").DataTable().ajax.reload()
                Swal.fire('Saved!', '', 'success')
            })
          }
        })
    }

    let rolesTable = $("#rolesTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ajax": {
            "url": "getRoles",
            "dataSrc": "",
            "type" : "GET"
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
            "title": "Name",
            "width": "20%",
            "render": function (data, type, content, meta) {
                return Object.keys(content)[0];
            }
        },
        {
            "title": "Permissions",
            "render": function (data, type, content, meta) {
                return content[Object.keys(content)[0]];
            }
        },
        {
            "title": "Operations",
            "sortable": false,
            "width": "160px",
            "render": function (data, type, content, meta) {
                return roleOperations(Object.keys(content));
            }
        }
        ]
    });

    async function addPermissionsToSelect2(id) {
        await fetch(baseUrl+'/getPermissions').then(data => data.json())
        .then(data => {
            var newOption = '';
            $(id).empty().trigger('change');
            data.forEach(element => {
                newOption = new Option(element, element, true, true);
                $(id).append(newOption).trigger('change');
            });
        });
    }

    window.editRole = (id) => {
        document.querySelector('#modal-edit form').reset()
        fetch(baseUrl+'/editRole?id='+id).then(data => data.json())
        .then(data => {
            console.log();
            document.querySelector('input#edit-id').value = id;
            document.querySelector('input#edit-name').value = Object.keys(data[0])[0];
            addPermissionsToSelect2('#edit-role').then(()=>{
                $('#edit-role').val(data[0][Object.keys(data[0])[0]]); 
                $('#edit-role').trigger('change'); 
            });
        });
    }

    window.updateRole = (e) => {
        e.preventDefault()
        let formData = new FormData(e.currentTarget)
        let form = e.currentTarget
        showLoading(form);
        fetch(baseUrl+'/updateRole', {
            method: 'POST',
            headers: headers,
            body: formData,
        }).then(response => response.json())
        .then(data => {
            hideLoading(form);
            resetFormErrors(form);
            if(data.errors){
                let d = data.errors;
                for (const property in d) {
                    document.querySelector(`#edit-${property}-error`).innerText = d[property]
                    document.querySelector(`#edit-${property}-error`).style.display = 'block'
                }
            }else{
                $('#modal-edit').modal('toggle');
                $("#rolesTable").DataTable().ajax.reload()
                Toast.fire({
                    icon: 'success',
                    title: 'Role updated.'
                })
            }
        }).catch((error) => {console.error('Error:', error);});
    }
    
    window.addRole = () => {
        document.querySelector('#modal-add form').reset()
        addPermissionsToSelect2('#add-role').then(()=>{
            $('#add-role').val(null).trigger('change') 
        })
    }

    window.createRole = (e) => {
        e.preventDefault()
        let formData = new FormData(e.currentTarget)
        let form = e.currentTarget
        showLoading(form);
        fetch(baseUrl+'/createRole', {
            method: 'POST',
            headers: headers,
            body: formData,
        }).then(response => response.json())
        .then(data => {
            hideLoading(form);
            resetFormErrors(form);
            if(data.errors){
                let d = data.errors;
                for (const property in d) {
                    document.querySelector(`#add-${property}-error`).innerText = d[property]
                    document.querySelector(`#add-${property}-error`).style.display = 'block'
                }
            }else{
                $('#modal-add').modal('toggle');
                $("#rolesTable").DataTable().ajax.reload()
                Toast.fire({
                    icon: 'success',
                    title: 'Role created.'
                })
            }
        }).catch((error) => {console.error('Error:', error);});
    }

    window.deleteRole = (id) => {
        Swal.fire({
          title: 'Do you want to delete this role?',
          showCancelButton: true,
          confirmButtonText: 'Delete',
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(baseUrl+'/deleteRole/'+id, {
                method: 'DELETE',
                headers: headers
            }).then(response => response.json())
            .then((data) => {
                $("#rolesTable").DataTable().ajax.reload()
                Swal.fire('Saved!', '', 'success')
            })
          }
        })
    }

    window.changePassword = (e) => {
        if(e.currentTarget.checked){
            document.querySelector('#change-password-block').style.display = 'block'
        }else{
            document.querySelector('#change-password-block').style.display = 'none'
            document.querySelectorAll('#change-password-block input').forEach((el) => {
                el.value = ''
            })
        }
    }

    const showLoading = (el) => {
        el.querySelector('.spinner').style.display = 'inline-block';
    }

    const hideLoading = (el) => {
        el.querySelector('.spinner').style.display = 'none';
    }

    $('.dataTables_filter').parent().removeClass('col-md-6');

});