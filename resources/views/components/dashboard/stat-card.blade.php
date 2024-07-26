@props([
    'icon',
    'count' => 0,
    'name' => 'Stat Card',
    'link' => 'javascript::void(0)',
    'color' => 'info',
    'class' => '',
    'style' => '',
])

<div class="card {{ $class }} h-100" style="{{ $style }}">
    <div class="card-body">
        <a style=" display: block; width: 90px" href="{{ $link }}">
            <div class="d-flex align-items-center mb-2 pb-1">
                <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-{{ $color }}"><i
                            class="{{ $icon }}"></i></span>
                </div>
                <h4 class="ms-1 mb-0">{{ $count }}</h4>
            </div>
            <p class="mb-1 text-black" style="font-size: 18px">{{ $name }}</p>
        </a>
    </div>
</div>
