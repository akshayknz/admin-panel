@extends('layouts.app')

@section('content')

<div class="container-fluid">
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles</h1>
                </div>
                <div class="col-sm-6">
                    <div class="input-group d-flex justify-content-end">
                        <button class="btn btn-primary float-right"
                        data-toggle="modal" 
                        data-target="#modal-add"
                        onclick="addRole()"
                        >Add New Role</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="rolesTable" class="table table-bordered table-striped">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-edit" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form onsubmit="updateRole(event);">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="edit-name">Name</label>
                                <input autocomplete="new-password" type="text" class="form-control" id="edit-name" name="name"
                                    placeholder="Enter role name">
                                <span id="edit-name-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="edit-password">Permissions</label>
                                <div class="w-100 select2-wrap">
                                    <select class="select2 form-control" id="edit-role" name="permissions[]"
                                        data-placeholder="Select permissions"
                                        multiple="multiple">
                                    </select>
                                </div>
                                <span id="edit-permissions-error" class="error invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner spinner-border spinner-border-sm" 
                                role="status" style="display:none;"
                                aria-hidden="true"
                                ></span>
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-add" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form onsubmit="createRole(event);">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="add-name">Name</label>
                                <input autocomplete="new-password" type="text" class="form-control" id="add-name" name="name"
                                    placeholder="Enter role name">
                                <span id="add-name-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="add-password">Permissions</label>
                                <div class="w-100 select2-wrap">
                                    <select class="select2 form-control" id="add-role" 
                                        name="permissions[]"
                                        data-placeholder="Select permissions"
                                        multiple="multiple">
                                    </select>
                                </div>
                                <span id="add-permissions-error" class="error invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner spinner-border spinner-border-sm" 
                                role="status" style="display:none;"
                                aria-hidden="true"
                                ></span>
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    </script>
    @endsection