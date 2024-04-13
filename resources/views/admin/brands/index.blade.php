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
                                    role="status"></span><span>Brands</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>

                        <div data-ng-if="brands.length" class="table-responsive">
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
                                    <tr data-ng-repeat="category in brands track by $index">
                                        <td data-ng-bind="category.category_slug"></td>
                                        <td class="text-center" data-ng-bind="category.category_name"></td>
                                        <td class="text-center" data-ng-bind="category.category_mate_name"></td>
                                        <td class="text-center" data-ng-bind="category.category_description"></td>
                                        <td class="text-center">
                                            <img src="{{ asset('images/brands/') }}/<%category.category_file%>"
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

                        <div data-ng-if="!brands.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle  display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.brands.modals')
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
            $scope.brandUpdate = false;
            $scope.brands = [];
            $scope.roles = [];
            $scope.page = 1;
            $scope.last_id = 0;
            $scope.noMore = false;
            $scope.loading = false;

            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.brands = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }

                if ($scope.noMore) return;
                $scope.loading = true;
                $.post("/brands/load/", {
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
                            $scope.brands = data;
                            console.log(data)
                            $scope.last_id = data[length - 1].id;
                        }
                    });
                }, 'json');
            }
            $scope.setUser = (indx) => {
                $scope.brandUpdate = indx;
                $('#categoryModel').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.brandUpdate = index;
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
                            if (scope.brandUpdate === false) {
                                scope.brands.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.brands[scope.brandUpdate] = response.data;
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
                            if (scope.brandUpdate === false) {
                                scope.brands.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.brands[scope.brandUpdate] = response.data;
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
