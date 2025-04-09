<x-mail::message>
# {{ __('Good News') }}
 
{{ __('You have new job application') }}!
 
<x-mail::button :url="$view_all_applied_jobs">
    {{ __('View All Applied Jobs') }}
</x-mail::button>
 
{{ __('Thanks') }},<br>
{{ config('app.name') }}
</x-mail::message>
