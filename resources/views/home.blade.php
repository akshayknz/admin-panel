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
                @can('view bookings')
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Bookings</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="bookingTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                @can('view top treks')
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Top Treks</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="topTreksTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                @can('view clients')
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Clients</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="clientsTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                @can('view cities')
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cities</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="cityTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                @can('view states')
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>States</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="stateTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                @can('view age')
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Age</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="ageTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sales Team Report</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="salesteamTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cooks Rank</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="cookTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Trek Leaders Rank</h4> <!-- .card-title -->
                        </div>
                        <div class="card-body">
                            <table id="leaderTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    </script>
    @endsection