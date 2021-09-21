@extends('layouts.back-end.app')

@section('title','Customer List')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm">
                    <h1 class="page-header-title">Customer
                        <span class="badge badge-soft-dark ml-2">{{\App\User::count()}}</span>
                    </h1>
                </div>
            </div>
            <!-- End Row -->

            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="tio-chevron-left"></i>
              </a>
            </span>

                <span class="hs-nav-scroller-arrow-next" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="tio-chevron-right"></i>
              </a>
            </span>

                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Customer {{trans('messages.List')}} </a>
                    </li>
                    {{--<li class="nav-item">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Open</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Unfulfilled</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Unpaid</a>
                    </li>--}}
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <form action="javascript:">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="search" class="form-control"
                                       placeholder="Search customer" aria-label="Search customer">
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <div class="d-sm-flex justify-content-sm-end align-items-sm-center">



                            <!-- Unfold -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#showHideDropdown",
                                     "type": "css-animation"
                                   }'>
                                    <i class="tio-table mr-1"></i> Columns <span
                                        class="badge badge-soft-dark rounded-circle ml-1">6</span>
                                </a>

                                <div id="showHideDropdown"
                                     class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card"
                                     style="width: 15rem;">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">Name</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_name">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                           id="toggleColumn_name" checked>
                                                    <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">Email</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_email">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                           id="toggleColumn_email" checked>
                                                    <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">Phone</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm"
                                                       for="toggleColumn_phone">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                           id="toggleColumn_phone" checked>
                                                    <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">Total order</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm"
                                                       for="toggleColumn_total_order">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                           id="toggleColumn_total_order" checked>
                                                    <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="mr-2">Actions</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm"
                                                       for="toggleColumn_actions">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                           id="toggleColumn_actions" checked>
                                                    <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       style="width: 100%"
                       data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                      }],
                     "order": [],
                     "info": {
                       "totalQty": "#datatableWithPaginationInfoTotalQty"
                     },
                     "search": "#datatableSearch",
                     "entries": "#datatableEntries",
                     "pageLength": 25,
                     "isResponsive": false,
                     "isShowPaging": false,
                     "pagination": "datatablePagination"
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="">
                           #
                        </th>
                        <th class="table-column-pl-0">{{trans('messages.Name')}}</th>
                        <th>{{trans('messages.Email')}}</th>
                        <th>{{trans('messages.Phone')}}</th>
                        <th>{{trans('messages.Total')}} {{trans('messages.Order')}} </th>
                        <th>{{trans('messages.Action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($customers as $key=>$customer)
                        <tr class="">
                            <td class="">
                                {{$key+1}}
                            </td>
                            <td class="table-column-pl-0">
                                <a href="{{route('admin.customer.view',[$customer['id']])}}">
                                    {{$customer['f_name']." ".$customer['l_name']}}
                                </a>
                            </td>
                            <td>
                                {{$customer['email']}}
                            </td>
                            <td>
                               {{$customer['phone']}}
                            </td>
                            <td>
                                <label class="badge badge-soft-info">
                                    {{$customer->orders->count()}}
                                </label>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <i class="tio-settings"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('admin.customer.view',[$customer['id']])}}">
                                            <i class="tio-visible"></i> {{trans('messages.View')}}
                                        </a>
                                        {{--<a class="dropdown-item" target="" href="">
                                            <i class="tio-download"></i> Suspend
                                        </a>--}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="mr-2">Showing:</span>

                            <!-- Select -->
                            <select id="datatableEntries" class="js-select2-custom"
                                    data-hs-select2-options='{
                                    "minimumResultsForSearch": "Infinity",
                                    "customClass": "custom-select custom-select-sm custom-select-borderless",
                                    "dropdownAutoWidth": true,
                                    "width": true
                                  }'>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                            <!-- End Select -->

                            <span class="text-secondary mr-2">of</span>

                            <!-- Pagination Quantity -->
                            <span id="datatableWithPaginationInfoTotalQty"></span>
                        </div>
                    </div>

                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF NAV SCROLLER
            // =======================================================
            $('.js-nav-scroller').each(function () {
                new HsNavScroller($(this)).init()
            });

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });


            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'd-none'
                    },
                    {
                        extend: 'excel',
                        className: 'd-none'
                    },
                    {
                        extend: 'csv',
                        className: 'd-none'
                    },
                    {
                        extend: 'pdf',
                        className: 'd-none'
                    },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: '<div class="text-center p-4">' +
                        '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                        '<p class="mb-0">No data to show</p>' +
                        '</div>'
                }
            });

            $('#export-copy').click(function () {
                datatable.button('.buttons-copy').trigger()
            });

            $('#export-excel').click(function () {
                datatable.button('.buttons-excel').trigger()
            });

            $('#export-csv').click(function () {
                datatable.button('.buttons-csv').trigger()
            });

            $('#export-pdf').click(function () {
                datatable.button('.buttons-pdf').trigger()
            });

            $('#export-print').click(function () {
                datatable.button('.buttons-print').trigger()
            });

            $('#datatableSearch').on('mouseup', function (e) {
                var $input = $(this),
                    oldValue = $input.val();

                if (oldValue == "") return;

                setTimeout(function () {
                    var newValue = $input.val();

                    if (newValue == "") {
                        // Gotcha
                        datatable.search('').draw();
                    }
                }, 1);
            });

            $('#toggleColumn_name').change(function (e) {
                datatable.columns(1).visible(e.target.checked)
            })

            $('#toggleColumn_email').change(function (e) {
                datatable.columns(2).visible(e.target.checked)
            })

            $('#toggleColumn_phone').change(function (e) {
                datatable.columns(3).visible(e.target.checked)
            })

            $('#toggleColumn_total_order').change(function (e) {
                datatable.columns(4).visible(e.target.checked)
            })

            $('#toggleColumn_actions').change(function (e) {
                datatable.columns(5).visible(e.target.checked)
            })

            // INITIALIZATION OF TAGIFY
            // =======================================================
            $('.js-tagify').each(function () {
                var tagify = $.HSCore.components.HSTagify.init($(this));
            });
        });
    </script>
@endpush
