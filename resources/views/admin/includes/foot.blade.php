<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ url('admin/dist/') }}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ url('admin/dist/') }}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('admin/dist/') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="{{ url('admin/dist/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ url('admin/dist/') }}/assets/js/custom/widgets.js"></script>
<script src="{{ url('admin/dist/') }}/assets/js/custom/apps/chat/chat.js"></script>
<script src="{{ url('admin/dist/') }}/assets/js/custom/modals/upgrade-plan.js"></script>
<script src="{{ url('admin/dist/') }}/assets/js/custom/modals/create-app.js"></script>
<script src="{{ url('admin/dist/') }}/assets/js/custom/modals/users-search.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->

@yield('script')
