{{--@component('mail::message')--}}
{{--    تأكيد--}}

{{--    رمز التحقق الخاص بك هو :--}}
{{--    {{ $token }}--}}

{{--    , شكرآ--}}


{{--    protein-chef--}}

{{--    @endcomponent--}}

    <!doctype html>
    <html>
    <body>
    <h1 style="color: #Fd5A1F">Protien Chef</h1>
    <h3>
        <span> كود التفعيل هو </span>
        {{--    <span> Allo Chef </span>--}}
    </h3>
    <br>

    <a href="" style="background-color: #Fd5A1F; color: #fff; padding: 20px">
        {{ $token }}
    </a>
    </body>
    </html>
