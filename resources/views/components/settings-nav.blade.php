@props(['current'])

@php
    $items = [
        ['route' => 'settings.profile', 'label' => 'Profile'],
        ['route' => 'settings.password', 'label' => 'Password'],
        ['route' => 'settings.two-factor', 'label' => 'Two-factor'],
    ];
@endphp

<nav class="mb-8 flex flex-wrap gap-2" aria-label="Settings">
    @foreach ($items as $item)
        @php $active = $current === $item['route']; @endphp
        <a
            href="{{ route($item['route']) }}"
            @if ($active) aria-current="page" @endif
            class="rounded-lg px-3 py-1.5 text-sm no-underline transition
                {{ $active
                    ? 'bg-aura-primary-600 text-white'
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}"
        >{{ $item['label'] }}</a>
    @endforeach
</nav>
