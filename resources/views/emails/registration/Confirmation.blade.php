@component('mail::message')
<p style="text-align: center;">
<strong style="box-sizing: border-box;">Congratulations {{ $name }}</strong>
</p>

Your account of **SLIET Alumni Association (SAA)** has been successfully verified by **Student Alumni Cell (SAC)**.


<p style="text-align: center;">
<strong style="box-sizing: border-box; font-style: italic; font-weight: 500">“A Connection for Life”</strong>
</p>

You can now connect to your old friends and your Alma Mater via this account.

To unlock the complete benefits of this account, please Sign In using this link and make your account operational.



@component('mail::button', ['url' => route('confirm',['token' => $token])])
Proceed to Login
@endcomponent

Regards,<br>
{{ config('app.name') }}

<br>
@component('mail::subcopy')
If you're having trouble clicking the "Proceed to Login" button, copy and paste the URL below into your web browser : {{ url($token) }}
@endcomponent

@endcomponent
