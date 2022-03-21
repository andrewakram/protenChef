@extends('admin.index')

@section('style')
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
                    <h1 class="d-flex align-items-center fw-bolder fs-3 my-1" style="color: #F48120">
                         بيانات الطلب
                    </h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('home')}}" class="text-muted text-hover-primary">الرئيسية</a>
                        </li>
                        <!--end::Item-->
                        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="
                                @if($status == 'pending')
                                {{route('admin.orders',['pending'])}}
                                @elseif($status == 'accepted')
                                {{route('admin.orders',['accepted'])}}
                                @elseif($status == 'canceled')
                                {{route('admin.orders',['canceled'])}}
                                @elseif($status == 'finished')
                                {{route('admin.orders',['finished'])}}
                                @endif" class="text-muted text-hover-primary">

                                الطلبات
                                @if($status == 'pending')
                                    قيد الموافقة
                                @elseif($status == 'accepted')
                                    المقبولة(الحالية)
                                @elseif($status == 'canceled')
                                    الملغية
                                @elseif($status == 'finished')
                                    المنتهية
                                @endif
                            </a>
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
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
                <!--begin::Form-->
                <form action="{{route('admin.users.update')}}" method="post" enctype="multipart/form-data"
                      class="form d-flex flex-column flex-lg-row gap-7 gap-lg-10">
                    @csrf
                    <input type="hidden" name="row_id" value="{{$row->id}}">
                    <!--begin::Aside column-->
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px">

                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>رقم الطلب</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <span style="font-size: large"
                                      class="badge badge-secondary">
                                    {{$row->order_num}}
                                </span>
                                <!--end::Image input-->
                                <!--begin::Description-->
                            {{--                                <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg </div>--}}
                            <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->

                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>الباقة</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <span style="font-size: large"
                                      class="badge badge-secondary">
                                    {{$row->package_name_ar}}
                                </span>
                                <br>
                                <br>
                                <span style="font-size: large"
                                      class="badge badge-secondary">
                                    {{$row->package_type_ar}}
                                </span>
                                <!--end::Image input-->
                                <!--begin::Description-->
                            {{--                                <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg </div>--}}
                            <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::Status-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>الحالة</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="rounded-circle bg-success w-15px h-15px"
                                         id="kt_ecommerce_add_product_status"></div>
                                </div>
                                <!--begin::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select2-->
                                <select name="status" required class="form-select mb-2" data-control="select2"
                                        data-hide-search="true" data-placeholder="إختر الحالة"
                                        id="kt_ecommerce_add_product_status_select">
                                    <option></option>
                                    <option value="pending" {{$row->status == "pending" ? "selected" : ""}}>قيد الموافقة</option>
                                    <option value="accepted" {{$row->status == "accepted" ? "selected" : ""}}>مقبول</option>
                                    <option value="finished" {{$row->status == "finished" ? "selected" : ""}}>مكتمل</option>
                                    <option value="canceled" {{$row->status == "canceled" ? "selected" : ""}}>ملغي</option>
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                            {{--                                <div class="text-muted fs-7">Set the product status.</div>--}}
                            <!--end::Description-->
                                <!--begin::Datepicker-->
                            {{--                                <div class="d-none mt-10">--}}
                            {{--                                    <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and time</label>--}}
                            {{--                                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date &amp; time" />--}}
                            {{--                                </div>--}}
                            <!--end::Datepicker-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Status-->

                    </div>
                    <!--end::Aside column-->
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin:::Tabs-->
{{--                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">--}}
{{--                            <!--begin:::Tab item-->--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link text-active-warning pb-4 active" data-bs-toggle="tab"--}}
{{--                                   href="#kt_ecommerce_add_product_general">بيانات بيانات الطلب</a>--}}
{{--                            </li>--}}
{{--                            <!--end:::Tab item-->--}}
{{--                            <!--begin:::Tab item-->--}}
{{--                        --}}{{--                            <li class="nav-item">--}}
{{--                        --}}{{--                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Advanced</a>--}}
{{--                        --}}{{--                            </li>--}}
{{--                        <!--end:::Tab item-->--}}
{{--                        </ul>--}}
                        <!--end:::Tabs-->
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general"
                                 role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>بيانات الطلب</h2>
                                            </div>
                                        </div>

                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span style="font-size: large">
                                                            إسم العميل:
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <span style="font-size: large"
                                                          class="badge badge-secondary">
                                                        <a href="{{route('admin.users.edit',[$row->user_id])}}" target="_blank">
                                                        {{$row->User->name}}
                                                        </a>
                                                    </span>
                                                    </div>

                                                    <div class="col-md-2"></div>

                                                    <div class="col-md-2">
                                                        <span style="font-size: large">
                                                            الجوال :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <span style="font-size: large"
                                                          class="badge badge-secondary">
                                                        {{$row->User->phone}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span style="font-size: large">
                                                            البريد الإلكتروني :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <span style="font-size: large"
                                                          class="badge badge-secondary">
                                                        {{$row->User->email}}
                                                    </span>
                                                    </div>

                                                    <div class="col-md-2"></div>

                                                    <div class="col-md-2">

                                                    </div>
                                                    <div class="col-md-3">

                                                    </div>
                                                </div>

                                                <hr>
                                            </div>

                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            تاريخ إنشاء الطلب :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <span style="font-size: large"
                                                          class="badge badge-secondary">
                                                        {{\Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i A')}}
                                                    </span>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            تاريخ بدء الباقة :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <span style="font-size: large"
                                                          class="badge badge-secondary">
                                                        {{$row->start_date}}
                                                    </span>
                                                    </div>
                                                </div>


                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            طريقة إستلام الطلب :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">

                                                        @if(isset($row->lat) && isset($row->lng))
                                                            <a href="https://maps.google.com/maps?q={{$row->lat}},{{$row->lng}}&hl=es&z=14&amp;" target="_blank" class="btn btn-primary" title="{{$row->location_body}}">
                                                                <i class="fa fa-map"></i>
                                                            </a>
                                                        @else
                                                            <span style="font-size: large"
                                                                  class="badge badge-secondary">
                                                                إستلام من المقر&nbsp;
                                                            </span>
                                                        @endif
                                                    </div>


                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            سعر الباقة :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <span style="font-size: large"
                                                          class="badge badge-secondary">
                                                        {{$row->package_price}}
                                                        &nbsp;</span>
                                                        &nbsp;
                                                        ريال
                                                    </div>
                                                </div>

                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            تكلفة الشحن :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">

                                                        @if(isset($row->lat) && isset($row->lng) && isset($row->shipping_price))
                                                            <span style="font-size: large"
                                                                  class="badge badge-secondary">
                                                                {{$row->shipping_price}}&nbsp;
                                                                &nbsp;
                                                                ريال
                                                            </span>
                                                        @else
                                                            <span style="font-size: large"
                                                                  class="badge badge-secondary">
                                                                0
                                                                &nbsp;
                                                                ريال
                                                            </span>
                                                        @endif
                                                    </div>


                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            الخصم :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if(isset($row->discount_price))
                                                            <span style="font-size: large"
                                                                  class="badge badge-secondary">
                                                                {{$row->discount_price}}&nbsp;
                                                                &nbsp;
                                                                ريال
                                                            </span>
                                                        @else
                                                            <span style="font-size: large"
                                                                  class="badge badge-secondary">
                                                                0
                                                                &nbsp;
                                                                ريال
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            @if(isset($row->total_price))
                                            <div class="mb-10 fv-row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="font-size: large">
                                                            إجمالي التكلفة :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="font-size: large"
                                                              class="badge badge-secondary">
                                                            {{$row->total_price}}&nbsp;
                                                            &nbsp;
                                                            ريال
                                                        </span>
                                                    </div>


                                                    <div class="col-md-3">

                                                    </div>
                                                    <div class="col-md-3">
                                                    </div>
                                                </div>
                                                @endif


                                            </div>
                                            <!--end::Input group-->

                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::General options-->

                                </div>
                            </div>
                            <!--end::Tab pane-->
                        </div>
                        <!--end::Tab content-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{route('admin.orders',[$row->status])}}" id="kt_ecommerce_add_product_cancel"
                               class="btn btn-light me-5">عودة</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-secondary">
                                <span class="indicator-label">حفظ</span>
                                <span class="indicator-progress">إنتظر قليلا . . .
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->

@endsection



@section('script')


@endsection
