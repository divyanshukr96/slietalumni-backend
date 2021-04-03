@component('mail::message')
<span style="float: right; max-width: 120px;">![Student Alumni Cell](https://slietalumni.org/images/sac.png "Title")</span>
<span style="float: left; max-width: 120px;">![SLIET Alumni Association](https://slietalumni.org/images/SAA-logo-color.png "Title")</span>
<div style="margin-top: 80px;"></div>
#Greetings,
# Dear {{ ucwords($data->name) }}


SLIET Alumni Association truly expresses their gratitude to you for accepting our invitation and taking out your precious time to attend Annual Alumni Meet {{ $year }}. Your presence will definitely make the event more joyful and memorable. We whole heartedly thank you for the same.

We welcome any suggestions regarding the event that you may have.

We once again would like to thank you from the bottom of our heart for accepting our invitation. If there is any assistance required regarding route clarifications or conveyance requirements, please do let us know.

Looking forward to seeing you.

{{-- Action Button --}}

@component('mail::button', ['url' => '', 'color' => 'blue'])
    Alumni Meet Id - {{ $data->meet_id }}
@endcomponent
##Schedule: <br>
###14 Feb, 2020 - Start Night
###15 Feb, 2020 - Alumni Meet
######*Kindly find the attached detailed scheduled for February 15, 2020

**Warm Regards,**<br>
SLIET Alumni Association<br>
Student Alumni Cell, SLIET<br>
Dr. Sukhcharn Singh (Chairman, SAA)<br>
Mr. Winnerjit Singh (President, SAA)<br>
Dr. Major Singh Goraya (Secretary, SAA)

@endcomponent
