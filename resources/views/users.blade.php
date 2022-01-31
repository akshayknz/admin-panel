@extends('layouts.app')

@section('content')

<div class="container-fluid">
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <div class="input-group d-flex justify-content-end">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"
                            onclick="addUser()">Add New User</button>
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
                            <table id="usersTable" class="table table-bordered table-striped">
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
                <form onsubmit="updateUser(event);">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-userid" name="userid">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="edit-name">Name</label>
                                <input autocomplete="new-password" type="text" class="form-control" id="edit-name"
                                    name="name" placeholder="Enter name">
                                <span id="edit-name-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="edit-email">Email address</label>
                                <input autocomplete="new-password" type="email" class="form-control" id="edit-email"
                                    name="email" placeholder="Enter email">
                                <span id="edit-email-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger" type="checkbox"
                                    id="change-password" name="change-password" onChange="changePassword(event);">
                                <label for="change-password" class="custom-control-label">Change password</label>
                            </div>
                            <div class="form-group" id="change-password-block" 
                                style="display:none;margin-left: 6px;
                                    border-left: 4px solid rgba(0, 0, 0, 0.2);
                                    padding-left: 20px;">
                            <div class="form-group">
                                <label for="edit-password">Password</label>
                                <input autocomplete="new-password" type="password" class="form-control"
                                    id="edit-password" name="password" placeholder="Password">
                                <span id="edit-password-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="edit-confirm-password">Confirm Password</label>
                                <input autocomplete="new-password" type="password" class="form-control"
                                    id="edit-confirm-password" name="confirm-password" placeholder="Password">
                                <span id="edit-confirm-password-error" class="error invalid-feedback"></span>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="edit-password">Role</label>
                                <div class="w-100 select2-wrap">
                                    <select class="select2 form-control" id="edit-role" name="roles[]"
                                        data-placeholder="Select a role" multiple="multiple">
                                    </select>
                                </div>
                                <span id="edit-roles-error" class="error invalid-feedback"></span>
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
                <form onsubmit="createUser(event);">
                    <div class="modal-header">
                        <h4 class="modal-title">Add User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="add-name">Name</label>
                                <input autocomplete="new-password" type="text" class="form-control" id="add-name"
                                    name="name" placeholder="Enter name">
                                <span id="add-name-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="add-email">Email address</label>
                                <input autocomplete="new-password" type="email" class="form-control" id="add-email"
                                    name="email" placeholder="Enter email">
                                <span id="add-email-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="add-password">Password</label>
                                <input autocomplete="new-password" type="password" class="form-control"
                                    id="add-password" name="password" placeholder="Password">
                                <span id="add-password-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="add-confirm-password">Confirm Password</label>
                                <input autocomplete="new-password" type="password" class="form-control"
                                    id="add-confirm-password" name="confirm-password" placeholder="Password">
                                <span id="add-confirm-password-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="add-password">Role</label>
                                <div class="w-100 select2-wrap">
                                    <select class="select2 form-control" id="add-role" name="roles[]"
                                        data-placeholder="Select a role" multiple="multiple">
                                    </select>
                                </div>
                                <span id="add-roles-error" class="error invalid-feedback"></span>
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