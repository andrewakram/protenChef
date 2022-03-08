

<?php
$errors = session()->get("errors");
?>
@if( session()->has("errors"))
    <?php
    $e = implode(' - ', $errors->all());
    ?>

    <script>
        Swal.fire({
            icon: 'warning',
            title: "برجاء التأكد من البيانات.",
            text: "{{$e}} ",
            type: "error",
            timer: 5000,
            showConfirmButton: false
        });
    </script>

@endif

@if( session()->has("error"))
    <?php
    $e = session()->get("error");
    ?>

    <script>
        Swal.fire({
            icon: 'warning',
            title: "برجاء التأكد من البيانات.",
            text: "{{$e}} ",
            type: "error",
            timer: 5000,
            showConfirmButton: false
        });
    </script>

@endif

@if( session()->has("success"))
    <?php
    $e = session()->get("success");
    ?>

    <script>
        Swal.fire({
            icon: 'success',
            title: "تمت العملية بنجاح.",
            text: "{{$e}} ",
            type: "success",
            timer: 5000,
            showConfirmButton: false
        });
    </script>

@endif
{{--<script>--}}
{{--    toastr.options = {--}}
{{--        "closeButton": true,--}}
{{--        "debug": false,--}}
{{--        "newestOnTop": true,--}}
{{--        "progressBar": true,--}}
{{--        "positionClass": "toast-bottom-right",--}}
{{--        "preventDuplicates": false,--}}
{{--        "showDuration": "300",--}}
{{--        "hideDuration": "1000",--}}
{{--        "timeOut": "5000",--}}
{{--        "extendedTimeOut": "1000",--}}
{{--        "showEasing": "swing",--}}
{{--        "hideEasing": "linear",--}}
{{--        "showMethod": "fadeIn",--}}
{{--        "hideMethod": "fadeOut"--}}
{{--    };--}}

{{--    toastr.error("erorr" , "عفوا !" );--}}
{{--</script>--}}

