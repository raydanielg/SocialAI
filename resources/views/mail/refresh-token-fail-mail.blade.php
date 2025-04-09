<x-mail::message>
# System Failure!

Autometic platforms/pages refresh (refresh token) fail for {{ $platformName }}, Please connect the platform again to continue.

<x-mail::button :url="route('user.platforms.index')">
Connect Platforms
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
