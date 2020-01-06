@component('mail::message')
# Dear {{ $data['name'] }}

Thanks a lot for registering yourself for **Alumni Meet {{ date('Y') }}**


<u>Invoice Alumni Meet {{ date('Y') }}</u>
=========
Registration Charge  __({{ $data['coming'] }})    <span style="float: right;">₹ {{ $data['amount'] }}/-</span>__
<hr><br>



Kindly Pay your Alumni Meet registration fees on the given Bank Details and send us your payment receipt on
[alumnicell@sliet.ac.in](mailto:alumnicell@sliet.ac.in) for your payment Confirmation

<hr>
Bank Details :-
==========================
**Account No** - 3652214249<br>
**Name** - SLIET Alumni Association<br>
**IFSC Code** - CBIN0283105<br>
**Branch** - LONGOWAL<br>
**Bank Name** - Central Bank of India
<hr>

Contact Details :-
==========================
**Raghav Sharma ** - [+91-9569468234](tel:+91-9569468234)<br>
**Yash Verma** - [+91-7300633011](tel:+91-7300633011)<br>
<hr>


@lang('Regards'),<br>Student Alumni Cell<br>({{ config('app.name') }})<br>
Alumni Meet {{ date('Y') }}

@endcomponent
