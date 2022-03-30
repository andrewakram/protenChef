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
                        <h1 class=" fs-3 fw-bold my-1 ms-1 app-f-color">الرئيسية</h1>
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
                                <div class="fs-2hx fw-bolder">{{$data['orders']}}</div>
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
                                            <div
                                                class="ms-auto fw-bolder text-gray-700">{{$data['current_orders']}}</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                            <div class="bullet bg-success me-3"></div>
                                            <div class="text-gray-400">الطلبات المكتملة</div>
                                            <div
                                                class="ms-auto fw-bolder text-gray-700">{{$data['finished_orders']}}</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fs-6 fw-bold align-items-center">
                                            <div class="bullet bg-danger me-3"></div>
                                            <div class="text-gray-400">الطلبات المرفوضه</div>
                                            <div
                                                class="ms-auto fw-bolder text-gray-700">{{$data['canceled_orders']}}</div>
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
                                <div class="fs-2hx fw-bolder">${{$data['sum_income']}}</div>
                                <div class="fs-4 fw-bold text-gray-400 mb-7">المبيعات</div>
                                @foreach($data['packages'] as $row)
                                    <div class="fs-6 d-flex justify-content-between mb-4">
                                        <div class="fw-bold">{{$row->title}}</div>
                                        <div class="d-flex fw-bolder">
                                            <!--end::Svg Icon-->${{$row->sum_package_income}}
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed"></div>
                                @endforeach

                            </div>
                        </div>
                        <!--end::Budget-->
                    </div>
                    <div class="col-lg-6 col-xxl-4">
                        <!--begin::Clients-->
                        <div class="card h-100">
                            <div class="card-body p-9">
                                <!--begin::Heading-->
                                <div class="fs-2hx fw-bolder">{{$data['customers']}}</div>
                                <div class="fs-4 fw-bold text-gray-400 mb-7">العملاء</div>
                                <!--end::Heading-->
                                <!--begin::Users group-->
                                <div class="symbol-group symbol-hover mb-9">
                                    @foreach($data['last_customers'] as $row )
                                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                           data-bs-target="#kt_modal_view_users">
                                            <img alt="Pic"
                                                 src="{{$row->image}}"/>
                                        </a>
                                    @endforeach
                                </div>
                                <!--end::Users group-->
                                <!--begin::Actions-->
                                <div class="d-flex">
                                    <a href="{{route('admin.users')}}" class="btn btn-primary btn-sm me-3">كل
                                        العملاء</a>
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

                                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Like.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path
                                            d="M9,10 L9,19 L10.1525987,19.3841996 C11.3761964,19.7920655 12.6575468,20 13.9473319,20 L17.5405883,20 C18.9706314,20 20.2018758,18.990621 20.4823303,17.5883484 L21.231529,13.8423552 C21.5564648,12.217676 20.5028146,10.6372006 18.8781353,10.3122648 C18.6189212,10.260422 18.353992,10.2430672 18.0902299,10.2606513 L14.5,10.5 L14.8641964,6.49383981 C14.9326895,5.74041495 14.3774427,5.07411874 13.6240179,5.00562558 C13.5827848,5.00187712 13.5414031,5 13.5,5 L13.5,5 C12.5694044,5 11.7070439,5.48826024 11.2282564,6.28623939 L9,10 Z"
                                            fill="#000000"/>
                                        <rect fill="#000000" opacity="0.3" x="2" y="9" width="5" height="11" rx="1"/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                                <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">{{$data['offers']}}</div>
                                <div class="fw-bold text-gray-100">العروض</div>
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
                                <span class="svg-icon svg-icon-warning svg-icon-3x ms-n1"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Food\Burger.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path
                                                d="M15,15 L15.9974233,16.1399123 C16.3611054,16.555549 16.992868,16.5976665 17.4085046,16.2339844 C17.4419154,16.20475 17.4733423,16.1733231 17.5025767,16.1399123 L18.5,15 L21,15 C20.4185426,17.9072868 17.865843,20 14.9009805,20 L9.09901951,20 C6.13415704,20 3.58145737,17.9072868 3,15 L15,15 Z"
                                                fill="#000000"/>
                                            <path
                                                d="M21,9 L3,9 L3,9 C3.58145737,6.09271316 6.13415704,4 9.09901951,4 L14.9009805,4 C17.865843,4 20.4185426,6.09271316 21,9 Z"
                                                fill="#000000"/>
                                            <rect fill="#000000" opacity="0.3" x="2" y="11" width="20" height="2"
                                                  rx="1"/>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{$data['meals']}}</div>
                                <div class="fw-bold text-gray-400">الوجبات</div>
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
                                <div class="text-white fw-bolder fs-2 mb-2 mt-5">{{$data['coupons']}}</div>
                                <div class="fw-bold text-white">كوبونات الخصم</div>
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
                                <span class="svg-icon svg-icon-warning svg-icon-3x ms-n1"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\Money.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path
                                                d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z"
                                                fill="#000000" opacity="0.3"
                                                transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
                                            <path
                                                d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z"
                                                fill="#000000"/>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{$data['price_plans']}}</div>
                                <div class="fw-bold text-gray-400">خطط الاسعار</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Advance Table Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">أحدث الطلبات</span>
                                </h3>
                                <div class="card-toolbar ">
                                    <a href="{{route('admin.orders',['pending'])}}" style="color: white;"
                                       class="btn app-bg-color font-weight-bolder font-size-sm mr-3 m-1">
                                        الطلبات قيد الموافقة</a>

                                    <a href="{{route('admin.orders',['accepted'])}}" style="color: white;"
                                       class="btn app-bg-color font-weight-bolder font-size-sm mr-3 m-1">
                                        الطلبات الحالية</a>

                                    <a href="{{route('admin.orders',['finished'])}}" style="color: white;"
                                       class="btn app-bg-color font-weight-bolder font-size-sm mr-3 m-1">
                                        الطلبات المنتهية</a>

                                    <a href="{{route('admin.orders',['canceled'])}}" style="color: white;"
                                       class="btn app-bg-color font-weight-bolder font-size-sm mr-3 m-1">
                                        الطلبات الملغية</a>
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
                                                <th class=" min-w-10px">#</th>
                                                <th class=" min-w-10px">رقم الطلب</th>
                                                <th class=" min-w-10px">حالة الطلب</th>
                                                <th class=" min-w-10px">العميل</th>
                                                <th class=" min-w-10px">الباقة</th>
                                                <th class=" min-w-10px">نوع الباقة</th>
                                                <th class=" min-w-10px">تاريخ البدء</th>
                                                <th class=" min-w-10px">تاريخ إنشاء الطلب</th>
                                                <th class=" min-w-10px">العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($newest_orders as $key => $row)
                                                <tr>
                                                    <td>
                                                        <span class="fw-bolder">{{$key+1}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">{{$row->order_num }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">
                                                            @if($row->status == 'pending')
                                                                <b class='badge badge-warning'>قيد الموافقة</b>
                                                            @elseif($row->status == 'accepted')
                                                                <b class='badge badge-success'>مقبول</b>
                                                            @elseif($row->status == 'canceled')
                                                                <b class='badge badge-danger'>ملغي</b>
                                                            @elseif($row->status == 'finished')
                                                                <b class='badge badge-info'>منتهي</b>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">
                                                            <a href="{{route('admin.users.edit',[$row->user_id])}}"
                                                               class="" title="العميل">
                                                                {{$row->User->name}}
                                                            </a>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">{{$row->package_name_ar }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">{{$row->package_type_ar }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">{{$row->start_date }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">{{$row->created_at }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bolder">
                                                            <a href="{{route('admin.orders.edit',[$row->id])}}"
                                                               class="btn btn-success btn-circle btn-sm m-1"
                                                               title="عرض التفاصيل">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                </div>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Advance Table Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">
                                        وجبات مطلوب تسليمها بتاريخ
                                        ]
                                        <span class="text-danger">
                                        {{$date}}
                                        </span>
                                        [
                                    </span>
                                </h3>
                                <div class="card-toolbar " >
                                    <form id="submit_btn" method="post" action="{{route('homeWzSearch')}}" style="display: inline-flex">
                                        @csrf

                                    <input class="form-control form-control-solid" type="date"  name="date" placeholder="إحتر التاريخ" id="kt_calendar_datepicker_end_date" />                                <!--end::Input-->                                <!--end::Input-->

                                    <button type="submit" class="btn app-bg-color font-weight-bolder font-size-sm mr-3 m-1"  style="color: white;">
                                        بحث
                                    </button>

                                    </form>
                                </div>
                            </div>


                            <!--begin::Content-->
                            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                                <!--begin::Post-->
                                <div class="post d-flex flex-column-fluid" id="kt_post">
                                    <!--begin::Container-->
                                    <div id="kt_content_container" class="container-xxl">
                                        <!--begin::Products-->
                                        <div class="card card-flush">
                                            <!--begin::Card header-->
                                        {{--                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">--}}
                                        {{--                        <!--begin::Card title-->--}}
                                        {{--                        <div class="card-title">--}}
                                        {{--                            <!--begin::Search-->--}}
                                        {{--                            <div class="d-flex align-items-center position-relative my-1">--}}
                                        {{--                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->--}}
                                        {{--                                <span class="svg-icon svg-icon-1 position-absolute ms-4">--}}
                                        {{--													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
                                        {{--														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />--}}
                                        {{--														<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />--}}
                                        {{--													</svg>--}}
                                        {{--												</span>--}}
                                        {{--                                <!--end::Svg Icon-->--}}
                                        {{--                                <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Product" />--}}
                                        {{--                            </div>--}}
                                        {{--                            <!--end::Search-->--}}
                                        {{--                        </div>--}}
                                        {{--                        <!--end::Card title-->--}}
                                        {{--                        <!--begin::Card toolbar-->--}}
                                        {{--                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">--}}
                                        {{--                            <div class="w-100 mw-150px">--}}
                                        {{--                                <!--begin::Select2-->--}}
                                        {{--                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">--}}
                                        {{--                                    <option></option>--}}
                                        {{--                                    <option value="all">All</option>--}}
                                        {{--                                    <option value="published">Published</option>--}}
                                        {{--                                    <option value="scheduled">Scheduled</option>--}}
                                        {{--                                    <option value="inactive">Inactive</option>--}}
                                        {{--                                </select>--}}
                                        {{--                                <!--end::Select2-->--}}
                                        {{--                            </div>--}}
                                        {{--                            <!--begin::Add product-->--}}
                                        {{--                            <a href="../../demo1/dist/apps/ecommerce/catalog/add-product.html" class="btn btn-primary">Add Product</a>--}}
                                        {{--                            <!--end::Add product-->--}}
                                        {{--                        </div>--}}
                                        {{--                        <!--end::Card toolbar-->--}}
                                        {{--                    </div>--}}
                                        <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="slider_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        {{--                                <th class="w-10px pe-2">--}}
                                                        {{--                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">--}}
                                                        {{--                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />--}}
                                                        {{--                                    </div>--}}
                                                        {{--                                </th>--}}
                                                        <th class=" min-w-10px">#</th>
                                                        <th class=" min-w-10px">العميل</th>
                                                        <th class=" min-w-10px">الاستلام</th>
                                                        <th class=" min-w-10px">الحالة</th>
                                                        <th class=" min-w-10px">الوجبة</th>
                                                        <th class=" min-w-10px">تاريخ التسليم</th>
                                                        <th class=" min-w-10px">التاريخ القديم (المستبدل)</th>
                                                        <th class=" min-w-10px">العمليات</th>

                                                    </tr>
                                                    <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600">

                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Products-->
                                    </div>
                                    <!--end::Container-->
                                </div>
                                <!--end::Post-->
                            </div>
                            <!--end::Content-->

                            <!--end::Body-->
                        </div>
                        <!--end::Advance Table Widget 4-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->

    <!--begin::Modal - change status-->
    <div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Status-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>الحالة</h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <form id="submit_btn" method="post" action="{{route('admin.orders.changeOrderMealStatus')}}">
                        @csrf
                        <input type="hidden" name="row_id" id="row_id">
                        <div class="card-body pt-0">
                            <!--begin::Select2-->
                            <div class="row">
                                <div class="col-lg-6">
                                    <select name="status" required class="form-select mb-2" data-control="select2"
                                            data-hide-search="true" data-placeholder="إختر الحالة"
                                            id="kt_ecommerce_add_product_status_select">
                                        <option></option>
                                        <option value="pending" {{$row->status == "pending" ? "selected" : ""}}>قيد
                                            التسليم
                                        </option>
                                        <option value="delivered" {{$row->status == "delivered" ? "selected" : ""}}>تم
                                            التسليم
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--end::Select2-->
                        </div>
                        <!--end::Card body-->
                        <div class="modal-footer">
                            <button type="submit" data-dismiss="modal" class="btn btn-primary submit_btn">تأكيد</button>
                        </div>
                    </form>
                </div>
                <!--end::Status-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - change status-->

@endsection
@section('script')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('admin/dist/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    {{--    <script src="{{ asset('admin/dist/assets/js/custom/apps/projects/list/list.js')}}"></script>--}}


    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <script>
        $(document).ready(function () {

            $("#slider_table").DataTable({
                "dom": "<'card-header border-0 p-0 pt-6'<'card-title' <'d-flex align-items-center position-relative my-1'f> r> <'card-toolbar' <'d-flex justify-content-end add_button'B> r>>  <'row'l r> <''t><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                processing: true,
                bLengthChange: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                aaSorting: [],
                lengthMenu: [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "الكل"]],
                "language": {
                    search: '<i class="fa fa-eye" aria-hidden="true"></i>',
                    searchPlaceholder: 'بحث سريع',
                    "url": "{{ url('admin/assets/ar.json') }}"
                },
                buttons: [
                    {
                        extend: 'colvis',
                        text: 'أظهر العمود',
                        title: '',
                        className: 'btn btn-primary me-3',
                        customize: function (win) {
                            $(win.document)
                                .css('direction', 'rtl');
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary me-3',
                        text: '<i class="bi bi-printer-fill "></i>',
                        titleAttr: 'طباعة',
                        customize: function (win) {
                            $(win.document.body)
                                .css('direction', 'rtl').prepend(
                                ' <table> ' +
                                '                        <tbody> ' +
                                '                                <tr>' +
                                '                                    <td style="text-align: center">  <p style="padding-right:150px">بروتين  شيف</p></td>' +
                                '                                    <td style="text-align: right"> <img src="{{asset('default.png')}}" width="150px" height="150px" /> </td>' +
                                '                                    <td style="text-align: right"><p>عنوان التقرير : وجبات تسلم بتاريخ {{$date}}</p>' +
                                '                                                                  <p>تاريخ التقرير : {{ Carbon\Carbon::now()->translatedFormat('l Y/m/d') }}</p>' +
                                '                                                                  <p>وقت التقرير : {{ Carbon\Carbon::now()->translatedFormat('h:i a') }}</p></td>' +
                                '                                </tr> ' +
                                '                        </tbody>' +
                                '                    </table>'
                            );
                        },
                        exportOptions: {
                            columns: [0, ':visible'],

                            stripHtml: false
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-primary me-3',
                        text: '<i class="bi bi-file-earmark-spreadsheet-fill "></i>',
                        titleAttr: 'تصدير لأكسيل',
                        title: '',
                        customize: function (win) {
                            $(win.document)
                                .css('direction', 'rtl');
                        },
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },


                ],
                ajax: '{{ route('homeMealsDatatables',[$date]) }}',
                "columns": [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "searchable": false, "orderable": false},
                    {"data": "user_name", "searchable": false, "orderable": false},
                    {"data": "delivery", "searchable": false, "orderable": false},
                    {"data": "status", "searchable": false, "orderable": false},
                    {"data": "meal_title_ar", "searchable": false, "orderable": false},
                    {"data": "date", "searchable": false, "orderable": false},
                    {"data": "old_date", "searchable": false, "orderable": false},
                    {"data": 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });
    </script>

    <script>

        $("#kt_ecommerce_products_table").find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
        });

        $("#kt_ecommerce_products_table").on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
    </script>

    {{-- change status --}}
    <script>
        $(document).on("click", ".changeStatus", function () {
            var row_id = $(this).data('id');
            $(".card #row_id").val(row_id);
        });

        $('.submit_btn').on('click', function () {
            $('#submit_btn').submit();
        })
    </script>

    Delete Multi

    <script>
        var $bulkDeleteBtn = $('#bulk_delete_btn');
        $bulkdeleteinput = $('#ids');

        $bulkDeleteBtn.click(function (e) {
            var $checkedBoxes = $('#kt_ecommerce_products_table input[type=checkbox]:checked').not('.select_all');
            var count = $checkedBoxes.length;
            if (count) {
                var myids = [];
                $bulkdeleteinput.val('');
                $.each($checkedBoxes, function () {
                    var value = $(this).val();
                    if (value !== 'on') {
                        myids.push(value);
                    }
                });
                // Set input value
                $bulkdeleteinput.val(myids);
                $('#dynamic').modal('show');
            } else {
                // No row selected
                toastr.warning('Choose At Least One');
            }
        });

        $('.delete_multi_btn').on('click', function () {
            $('#delete_multi_form').submit();
        })
    </script>

    <script>
        $(document).on("click", ".delete", function () {
            var id = $(this).data('id');
            var btn = $(this);
            Swal.fire({
                title: "تحذير.هل انت متأكد؟!",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f64e60",
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{route('admin.orders.delete')}}',
                        type: "post",
                        data: {'row_id': id, _token: CSRF_TOKEN},
                        dataType: "JSON",
                        success: function (data) {
                            if (data.message == "Success") {
                                btn.parents("tr").remove();
                                Swal.fire("نجاح", "تم الحذف بنجاح", "success");
                                // location.reload();
                            } else {
                                Swal.fire("نأسف", "حدث خطأ ما اثناء الحذف", "error");
                            }
                        },
                        fail: function (xhrerrorThrown) {
                            Swal.fire("نأسف", "حدث خطأ ما اثناء الحذف", "error");
                        }
                    });
                    // result.dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                } else if (result.dismiss === 'cancel') {
                    Swal.fire("ألغاء", "تم الالغاء", "error");
                }
            });
        });

    </script>



    <script>
        "use strict";
        var KTProjectList = {
            init: function () {
                !function () {
                    var t = document.getElementById("kt_project_list_chart");
                    if (t) {
                        var e = t.getContext("2d");
                        new Chart(e, {
                            type: "doughnut",
                            data: {
                                datasets: [{
                                    data: {!! $orders_numbers_chart !!} ,
                                    backgroundColor: ["#00A3FF", "#50CD89", "#dc3545"]
                                }],
                                labels: ["الطلبات الحالية", "الطلبات المكتملة", "الطلبات المرفوضة"]
                            },
                            options: {
                                chart: {fontFamily: "inherit"},
                                cutout: "75%",
                                cutoutPercentage: 65,
                                responsive: !0,
                                maintainAspectRatio: !1,
                                title: {display: !1},
                                animation: {animateScale: !0, animateRotate: !0},
                                tooltips: {
                                    enabled: !0,
                                    intersect: !1,
                                    mode: "nearest",
                                    bodySpacing: 5,
                                    yPadding: 10,
                                    xPadding: 10,
                                    caretPadding: 0,
                                    displayColors: !1,
                                    backgroundColor: "#20D489",
                                    titleFontColor: "#ffffff",
                                    cornerRadius: 4,
                                    footerSpacing: 0,
                                    titleSpacing: 0
                                },
                                plugins: {legend: {display: !1}}
                            }
                        })
                    }
                }()
            }
        };
        KTUtil.onDOMContentLoaded((function () {
            KTProjectList.init()
        }));
    </script>
    <script src="{{ asset('admin/dist/assets/js/custom/widgets.js')}}"></script>
    <script src="{{ asset('admin/dist/assets/js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{ asset('admin/dist/assets/js/custom/modals/upgrade-plan.js')}}"></script>
    <script src="{{ asset('admin/dist/assets/js/custom/modals/create-app.js')}}"></script>
    <script src="{{ asset('admin/dist/assets/js/custom/modals/users-search.js')}}"></script>
    <!--end::Page Vendors Javascript-->
@endsection
