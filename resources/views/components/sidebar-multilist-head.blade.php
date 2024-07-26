@props([
    'icon' => 'bx bx-home-circle',
    'name' => 'Multi Sidebar',
    'routes' => [],
])

@php
    $hasRoute = false;
    foreach ($routes as $uri) {
        if (request()->is($uri . '*')) {
            $hasRoute = true;
            break;
        }
    }
@endphp

<li class="menu-item {{ $hasRoute ? 'active open' : '' }}">
    <a href="#menu-{{ Str::slug($name) }}" class="menu-link menu-toggle {{ $hasRoute ? '' : 'collapsed' }}" data-bs-toggle="collapse" aria-expanded="{{ $hasRoute ? 'true' : 'false' }}">
        <i class="menu-icon tf-icons {{ $icon }}"></i>
        <span class="text-truncate" data-i18n="{{ $name }}">{{ $name }}</span>
    </a>
    <ul  class="sub collapse  {{ $hasRoute ? 'show' : '' }}" id="menu-{{ Str::slug($name) }}">
        {{ $slot }}
    </ul>
</li>
