@extends('layouts.app')

@section('content')

<div class="container-fluid">
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Report</h1>
                </div>
                <div class="col-sm-6">
                        <div class="input-group w-50 float-right">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="daterangepicker">
                        </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @can('view tth data')
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>TTH Data</h4> <!-- .card-title -->
                        </div>
                        <style>
                            .no-sort:after, .no-sort:before {
   content: none !important;
}
.dt-button-collection {
    top: 23px;
    position: relative;
    /* left: 20vw; */
}

.dt-button-collection button.dt-button.button-page-length {
    border: 1px solid #000;
    border-color: #dc3545;
    color: #dc3545;
    background: transparent;
    border-radius: 5px;
    padding: 5px 16px;
}
#tthdataTable {
    table-layout: fixed;
}

#tthdataTable td {
    text-overflow: ellipsis;
}
                        </style>
                        <div class="card-body" >
                            <table width="100%"  id="tthdataTable" class="table table-bordered table-responsive">
                                <thead class="bg-danger">
                                    <td class="no-sort">Sl. No.</td>
                                    <td>Name</td>
                                    <td class="no-sort">Gender</td>
                                    <td class="no-sort">Trek</td>
                                    <td class="no-sort">Trek Date</td>
                                    <td class="no-sort">Trek ID</td>
                                    <td class="no-sort">Status</td>
                                    <td class="no-sort">DOB</td>
                                    <td class="no-sort">Email</td>
                                    <td class="no-sort">Phone</td>
                                    <td class="no-sort">State</td>
                                    <td class="no-sort">City</td>
                                    <td class="no-sort">Country</td>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </section>
    @endsection