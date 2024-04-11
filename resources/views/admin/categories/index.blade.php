@extends('admin.index')
@section('context')
    <div class="container-fluid p-0" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">

            <div class="col-12 col-sm-8 col-lg-12">
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

                        <div data-ng-if="categories.length" class="table-responsive">
                            <table class="table table-hover" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Category Name</th>
                                        <th class="text-center">Category Meta Name</th>
                                        <th class="text-center">Category Descripton</th>
                                        <th class="text-center">Category Image</th>
                                        <th class="text-center">Category Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="category in categories track by $index">
                                        <td data-ng-bind="category.category_slug"></td>
                                        <td class="text-center" data-ng-bind="category.category_name"></td>
                                        <td class="text-center" data-ng-bind="category.category_mate_name"></td>
                                        <td class="text-center" data-ng-bind="category.category_description"></td>
                                        <td class="text-center">
                                            <img src="{{ asset('images/categories/') }}/<%category.category_file%>"
                                                alt="cate_iamge" width="30px">
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%categoryStatus.color[category.category_status]%> rounded-pill font-monospace p-2"><%categoryStatus.name[category.category_status]%></span>

                                        </td>
                                        <td class="col-fit">
                                            <div>
                                                <button
                                                    class="btn btn-outline-success btn-circle bi bi-wrench-adjustable-circle-fill"
                                                    data-ng-click="editActive($index)"></button>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setUser($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!categories.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle  display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="categoryModel" tabindex="-1" aria-labelledby="categoryModelLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-body">
                        <form action="/categories/submit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" data-ng-if="categoryUpdate !== false" value="put">
                            <input type="hidden" name="category_id"
                                data-ng-value="categoryUpdate !== false ? categories[categoryUpdate].id : 0">
                            @csrf
                            <div class="mb-3">
                                <label id="cate_name">Category Name</label>
                                <input type="text" name="category_name" id="cate_name" class="form-control"
                                    data-ng-value="categories[categoryUpdate].category_name">
                            </div>
                            <div class="mb-3">
                                <label id="cate_file">Category Image</label>
                                <input type="file" name="category_file" id="cate_file" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label id="cate_description">Category Description</label>
                                <textarea name="category_description" class="form-control" id="cate_description" cols="30" rows="7"><%categries[categoryUpdate].category_description%></textarea>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label id="cate_mate_name">Category Meta Name</label>
                                        <input type="text" name="category_meta_name" id="cate_mate_name"
                                            class="form-control"
                                            data-ng-value="categories[categoryUpdate].category_mate_name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label id="cate_meta_keyword">Category Meta Keyword</label>
                                        <input type="text" name="category_meta_ketword" id="cate_meta_keyword"
                                            class="form-control"
                                            data-ng-value="categories[categoryUpdate].category_mate_keyword">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label id="cate_meta_description">Category Meta Description</label>
                                        <textarea name="category_meta_description" class="form-control" id="cate_meta_description" cols="30"
                                            rows="7"><%categries[categoryUpdate].category_mate_description%></textarea>
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

        <div class="modal fade" id="edit_active" tabindex="-1" aria-labelledby="editStatusCategoryModelLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-body">
                        <form action="/categories/change_status" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" data-ng-if="categoryUpdate !== false" value="put">
                            <input type="hidden" name="category_id"
                                data-ng-value="categoryUpdate !== false ? categories[categoryUpdate].id : 0">
                            <input type="hidden" name="category_status"
                                data-ng-value="categoryUpdate !== false ? categories[categoryUpdate].category_status">
                            @csrf
                            <div class="mb-3">
                                <p>Are you sure the status has changed?</p>
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
        var limit = 7,
            scope, app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.categoryStatus = {
                name: ['active', 'blocked', ''],
                color: ['success', 'danger', '']
            }
            $scope.categoryUpdate = false;
            $scope.categories = [];
            $scope.roles = [];
            $scope.page = 1;
            $scope.last_id = 0;
            $scope.noMore = false;
            $scope.loading = false;

            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.categories = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }

                if ($scope.noMore) return;
                $scope.loading = true;
                $.post("/categories/load/", {
                    status: $('#filter-status').val(),
                    q: $scope.q,
                    page: $scope.page,
                    last_id: $scope.last_id,
                    limit: limit,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    let length = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (length) {
                            $scope.noMore = length < limit;
                            $scope.categories = data;
                            console.log(data)
                            $scope.last_id = data[length - 1].id;
                        }
                    });
                }, 'json');
            }
            $scope.setUser = (indx) => {
                $scope.categoryUpdate = indx;
                $('#categoryModel').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.categoryUpdate = index;
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
                    console.log(response);
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#categoryModel').modal('hide');
                        scope.$apply(() => {
                            if (scope.categoryUpdate === false) {
                                scope.categories.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.categories[scope.categoryUpdate] = response.data;
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
                        toastr.success('category status change successfully');
                        $('#edit_active').modal('hide');
                        scope.$apply(() => {
                            if (scope.categoryUpdate === false) {
                                scope.categories.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.categories[scope.categoryUpdate] = response.data;
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
            $(window).scroll(function() {
                if ($(window).scrollTop() >= ($(document).height() - $(window).height() - 90) &&
                    !scope
                    .loading) scope.dataLoader();
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
