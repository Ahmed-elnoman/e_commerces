@extends('admin.index')
@section('context')
    <div class="container-fluid p-0" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="roleFilter">Role</label>
                            <select class="js-example-basic-single form-control" name="state">
                                <option data-ng-repeat="role in roles" data-ng-value="role.ugroup_id"
                                    data-ng-bind="role.ugroup_name"></option>
                            </select>
                        </div>
                        {{-- It will be worked on soon --}}
                        <div class="mb-3">
                            <label for="roleFilter">Status</label>
                            <select id="filter-status" class="form-select">
                                <option value="">-----</option>
                                <option value="1">Active</option>
                                <option value="0">Blocd</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>Categories</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>

                        <div data-ng-if="users.length" class="table-responsive">
                            <table class="table table-hover" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="u in users track by $index">
                                        <td data-ng-bind="u.id"></td>
                                        <td data-ng-bind="u.user_name"></td>
                                        <td data-ng-bind="u.user_email"></td>
                                        <td data-ng-bind="u.user_mobile"></td>
                                        <td data-ng-bind="u.ugroup_name"></td>
                                        <td>
                                            <span
                                                class="badge bg-<%statusObject.color[u.user_active]%> rounded-pill font-monospace"><%statusObject.name[u.user_active]%></span>

                                        </td>
                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-success btn-circle bi bi-person-lock"
                                                    data-ng-click="editActive($index)"></button>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setUser($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!users.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle  display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="categoryModel" tabindex="-1" aria-labelledby="categoryModelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <form action="/categories/submit" method="post">
                            @csrf
                            <div class="mb-3">
                                <label id="cate_name">Category Name</label>
                                <input type="text" name="category_name" id="cate_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label id="cate_file">Category Image</label>
                                <input type="file" name="category_file" id="cate_file" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label id="cate_description">Category Description</label>
                                <textarea name="category_description" class="form-control" id="cate_description" cols="30" rows="7"></textarea>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label id="cate_mate_name">Category Meta Name</label>
                                        <input type="text" name="category_meta_name" id="cate_mate_name"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label id="cate_meta_keyword">Category Meta Keyword</label>
                                        <input type="text" name="category_meta_ketword" id="cate_meta_keyword"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label id="cate_meta_description">Category Meta Description</label>
                                        <textarea name="category_meta_description" class="form-control" id="cate_meta_description" cols="30"
                                            rows="7"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <button type="button" class="btn btn-outline-secondary me-auto "
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-success">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('js')
    <script>
        var scope, app = angular.module('myApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.updateUser = false;
            $scope.userId = 0;
            $scope.users = [];
            $scope.roles = [];
            $scope.page = 1;
            $scope.q = ' ';
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/categories/load/", {
                    status: $('#filter-status').val(),
                    q: $scope.q,
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.users = data;
                        $scope.page++;
                    });
                }, 'json');
            }
            $scope.setUser = (indx) => {
                $scope.updateUser = indx;
                $('#categoryModel').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.userId = index;
                $('#edit_active').modal('show');
            };
            $scope.deleletUser = (index) => {
                $scope.userId = index;
                $('#delete_user').modal('show');
            };
            $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#categoryModel form').on('submit', function(e) {
                e.preventDefault();
                controls.log(11)
                var form = $(this),
                    formData = new FormData(this),
                    action = form.attr('action'),
                    method = form.attr('method'),
                    controls = form.find('button, input'),
                    spinner = $('#locationModal .loading-spinner');
                spinner.show();
                controls.prop('disabled', true);
                $.ajax({
                    url: action,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function(data, textStatus, jqXHR) {
                    var response = JSON.parse(data);
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#useForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateUser === false) {
                                scope.users.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.users[scope.updateUser] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error(response.message);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    toastr.error("error");
                    controls.log(jqXHR.responseJSON.message);
                    $('#useForm').modal('hide');
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        });

        $(function() {
            $('#edit_active form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this),
                    formData = new FormData(this),
                    action = form.attr('action'),
                    method = form.attr('method'),
                    controls = form.find('button, input'),
                    spinner = $('#locationModal .loading-spinner');
                spinner.show();
                controls.prop('disabled', true);
                $.ajax({
                    url: action,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function(data, textStatus, jqXHR) {
                    var response = JSON.parse(data);
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#edit_active').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateUser === false) {
                                scope.users.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.users[scope.updateUser] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error(response.message);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    toastr.error(response.message);
                    controls.log(jqXHR.responseJSON.message);
                    $('#useForm').modal('hide');
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        })
        $(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
