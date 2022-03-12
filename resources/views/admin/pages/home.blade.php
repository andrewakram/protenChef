@extends('admin.index')
@section('style')
    <link href="{{ asset('admin/dist/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                     data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                     class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                        <h1 class=" fs-3 fw-bold my-1 ms-1 app-f-color" >الرئيسية</h1>
                        <!--begin::Separator-->
                        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                        <!--end::Separator-->
                    </h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-6 g-xl-9">
                    <div class="col-lg-6 col-xxl-4">
                        <!--begin::Card-->
                        <div class="card h-100">
                            <!--begin::Card body-->
                            <div class="card-body p-9">
                                <!--begin::Heading-->
                                <div class="fs-2hx fw-bolder">237</div>
                                <div class="fs-4 fw-bold text-gray-400 mb-7">الطلبات</div>
                                <!--end::Heading-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Chart-->
                                    <div class="d-flex flex-center h-100px w-100px me-9 mb-5">
                                        <canvas id="kt_project_list_chart"></canvas>
                                    </div>
                                    <!--end::Chart-->
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                        <!--begin::Label-->
                                        <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                            <div class="bullet bg-primary me-3"></div>
                                            <div class="text-gray-400">الطلبات الحالية</div>
                                            <div class="ms-auto fw-bolder text-gray-700">30</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                            <div class="bullet bg-success me-3"></div>
                                            <div class="text-gray-400">الطلبات المكتملة</div>
                                            <div class="ms-auto fw-bolder text-gray-700">45</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fs-6 fw-bold align-items-center">
                                            <div class="bullet bg-gray-300 me-3"></div>
                                            <div class="text-gray-400">الطلبات المرفوضه</div>
                                            <div class="ms-auto fw-bolder text-gray-700">25</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class="col-lg-6 col-xxl-4">
                        <!--begin::Budget-->
                        <div class="card h-100">
                            <div class="card-body p-9">
                                <div class="fs-2hx fw-bolder">$3,290.00</div>
                                <div class="fs-4 fw-bold text-gray-400 mb-7">المبيعات</div>
                                <div class="fs-6 d-flex justify-content-between mb-4">
                                    <div class="fw-bold">الباقة الاولي</div>
                                    <div class="d-flex fw-bolder">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
                                        <span class="svg-icon svg-icon-3 me-1 svg-icon-success">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none">
															<path
                                                                d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z"
                                                                fill="black"/>
															<path opacity="0.3"
                                                                  d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z"
                                                                  fill="black"/>
														</svg>
													</span>
                                        <!--end::Svg Icon-->$6,570
                                    </div>
                                </div>
                                <div class="separator separator-dashed"></div>
                                <div class="fs-6 d-flex justify-content-between my-4">
                                    <div class="fw-bold">الباقة الثانية</div>
                                    <div class="d-flex fw-bolder">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr006.svg-->
                                        <span class="svg-icon svg-icon-3 me-1 svg-icon-danger">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none">
															<path
                                                                d="M13.4 14.8L5.3 6.69999C4.9 6.29999 4.9 5.7 5.3 5.3C5.7 4.9 6.29999 4.9 6.69999 5.3L14.8 13.4L13.4 14.8Z"
                                                                fill="black"/>
															<path opacity="0.3"
                                                                  d="M19.8 8.5L8.5 19.8H18.8C19.4 19.8 19.8 19.4 19.8 18.8V8.5Z"
                                                                  fill="black"/>
														</svg>
													</span>
                                        <!--end::Svg Icon-->$408
                                    </div>
                                </div>
                                <div class="separator separator-dashed"></div>
                                <div class="fs-6 d-flex justify-content-between mt-4">
                                    <div class="fw-bold">الباقة الثالثه</div>
                                    <div class="d-flex fw-bolder">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
                                        <span class="svg-icon svg-icon-3 me-1 svg-icon-success">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none">
															<path
                                                                d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z"
                                                                fill="black"/>
															<path opacity="0.3"
                                                                  d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z"
                                                                  fill="black"/>
														</svg>
													</span>
                                        <!--end::Svg Icon-->$920
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Budget-->
                    </div>
                    <div class="col-lg-6 col-xxl-4">
                        <!--begin::Clients-->
                        <div class="card h-100">
                            <div class="card-body p-9">
                                <!--begin::Heading-->
                                <div class="fs-2hx fw-bolder">49</div>
                                <div class="fs-4 fw-bold text-gray-400 mb-7">العملاء</div>
                                <!--end::Heading-->
                                <!--begin::Users group-->
                                <div class="symbol-group symbol-hover mb-9">
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Alan Warden">
                                        <span class="symbol-label bg-warning text-inverse-warning fw-bolder">A</span>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Michael Eberon">
                                        <img alt="Pic" src="{{ asset('admin/dist/assets/media/avatars/150-12.jpg')}}"/>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Michelle Swanston">
                                        <img alt="Pic" src="{{ asset('admin/dist/assets/media/avatars/150-13.jpg')}}"/>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Francis Mitcham">
                                        <img alt="Pic" src="{{ asset('admin/dist/assets/media/avatars/150-5.jpg')}}"/>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Susan Redwood">
                                        <span class="symbol-label bg-primary text-inverse-primary fw-bolder">S</span>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Perry Matthew">
                                        <span class="symbol-label bg-info text-inverse-info fw-bolder">P</span>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                         title="Barry Walter">
                                        <img alt="Pic" src="{{ asset('admin/dist/assets/media/avatars/150-7.jpg')}}"/>
                                    </div>
                                    <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_view_users">
                                        <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bolder">+42</span>
                                    </a>
                                </div>
                                <!--end::Users group-->
                                <!--begin::Actions-->
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_view_users">كل العملاء</a>
                                </div>
                                <!--end::Actions-->
                            </div>
                        </div>
                        <!--end::Clients-->
                    </div>
                </div>
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap flex-stack my-5">
                    <!--begin::Heading-->
                    <!--end::Heading-->
                </div>
                <!--end::Toolbar-->
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card app-bg-color hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"/>
														<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5"
                                                              fill="black"/>
														<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"/>
														<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"/>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">+3000</div>
                                <div class="fw-bold text-gray-100">New Customers</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8 ">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                <span class="svg-icon svg-icon-warning svg-icon-3x ms-n1 ">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<path opacity="0.3"
                                                              d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z"
                                                              fill="black"/>
														<path
                                                            d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z"
                                                            fill="black"/>
														<path
                                                            d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z"
                                                            fill="black"/>
													</svg>
												</span>
                                <!--end::Svg Icon-->

                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">500M$</div>
                                <div class="fw-bold text-gray-400">عدد الوجبات</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card app-bg-color hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<path opacity="0.3"
                                                              d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                              fill="black"/>
														<path
                                                            d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                            fill="black"/>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-white fw-bolder fs-2 mb-2 mt-5">$50,000</div>
                                <div class="fw-bold text-white">Milestone Reached</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-body hoverable card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                                <span class="svg-icon svg-icon-warning svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<path opacity="0.3"
                                                              d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z"
                                                              fill="black"/>
														<path
                                                            d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z"
                                                            fill="black"/>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">500M$</div>
                                <div class="fw-bold text-gray-400">عدد الوجبات</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8">
                        <!--begin::Advance Table Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">أحدث الطلبات</span>
                                </h3>
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3">كل
                                        الطلبات</a>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-3">
                                <div class="tab-content">
                                    <!--begin::Table-->
                                    <div class="table-responsive">
                                        <table
                                            class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                            <thead>
                                            <tr class="text-left text-uppercase">
                                                <th style="min-width: 100px" class="pl-7">
                                                    <span class="text-dark-75"> بيانات العميل</span>
                                                </th>
                                                <th style="min-width: 100px" class="pl-7">
                                                    <span class="text-dark-75">رقم الحجز</span>
                                                </th>
                                                <th style="min-width: 100px" class="pl-7">
                                                    <span class="text-dark-75">السعر</span>
                                                </th>
                                                <th style="min-width: 130px" class="pl-7">
                                                    <span class="text-dark-75">تاريخ الانشاء</span>
                                                </th>
                                                <th style="min-width: 100px" class="pl-7">
                                                    <span class="text-dark-75">حالة الحجز</span>
                                                </th>
                                                <th style="min-width: 80px" class="pl-7">
                                                    <span class="text-dark-75"> الاجرائات</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--                                @foreach($newest_orders as $row)--}}
                                            {{--                                --}}
                                            {{--                                @endforeach--}}
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Advance Table Widget 4-->
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0">
                                <h3 class="card-title font-weight-bolder text-dark">احدث العملاء</h3>
                                <div class="card-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <a href="#"
                                           class="btn btn-light-warning btn-sm font-weight-bolder">كل العملاء</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="table-responsive">
                                    <table
                                        class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                        <tbody>
                                        @if(count($newest_customers) >0)
                                            @foreach($newest_customers as $row)
                                                <tr>
                                                    <td class="pl-0 py-8">
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                                <div class="symbol symbol-40 symbol-sm flex-shrink-0">
                                                                    <img class="" src="{{$row->image}}"
                                                                         alt="photo">
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a href="javascript:void(this)"
                                                                   class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$row->name}}</a>
                                                                <span
                                                                    class="text-muted font-weight-bold d-block">{{$row->phone}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$row->created_at->format('Y-m-d')}}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->

@endsection
@section('script')
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('admin/dist/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{ asset('admin/dist/assets/js/custom/apps/projects/list/list.js')}}"></script>
<script src="{{ asset('admin/dist/assets/js/custom/widgets.js')}}"></script>
<script src="{{ asset('admin/dist/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{ asset('admin/dist/assets/js/custom/modals/upgrade-plan.js')}}"></script>
<script src="{{ asset('admin/dist/assets/js/custom/modals/create-app.js')}}"></script>
<script src="{{ asset('admin/dist/assets/js/custom/modals/users-search.js')}}"></script>
<!--end::Page Vendors Javascript-->
@endsection
