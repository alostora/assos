@component('mail::message')
# Welcome you can now change your password

{{$info->name}}

@component('mail::button', ['url' => url('resetPassword/'.$info->verify_token)])
Change Pass
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
