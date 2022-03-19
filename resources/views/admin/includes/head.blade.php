<base href="">
<title>
    Proten Chef
</title>
<meta charset="utf-8"/>
<meta name="description" content="Proten Chef"/>
<meta name="keywords" content="Proten Chef"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="article"/>
<meta property="og:title" content="Proten Chef"/>
<meta property="og:url" content="http://tesolutionspro.com/metronic"/>
<meta property="og:site_name" content="Proten Chef"/>
<link rel="canonical" href="https://preview.keenthemes.com/metronic8"/>
<link rel="shortcut icon" href="{{url('/').'/uploads/Settings/'.\App\Models\Setting::where('key', 'fav_icon')->first()->value}}"/>
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->

<link href="{{ url('admin/dist/') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
      type="text/css"/>
<link href="{{ url('admin/dist/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
      type="text/css"/>
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{ url('admin/dist/') }}/assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css"/>
<link href="{{ url('admin/dist/') }}/assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css"/>
<!--end::Global Stylesheets Bundle-->

@yield('style')
