@props([
    'id' => '',
    'label' => '',
    'col' => '6',
    'labelDisplay' => true,
    'displayDateRange' => false,
    'req' => false,
    'class' => '',
])

<div class="col-md-{{ $col }} {{ $class }}">
    @if ($labelDisplay === true)
        <label for="{{ $id }}" class="col-form-label">
            {{ $label }} @if ($req === true)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <div id="{{ $id }}" class="form-select" style="position: relative; top: -5px;">
        <i class='bx bxs-calendar'></i>&nbsp;
        <span></span>
        @if ($displayDateRange)
            ( <span id="{{ $id }}_date_range" style="font-size: 13px"></span> ){{-- date range show----- --}}
        @endif
        <input type="hidden" id="from_date_{{ $id }}" name="from_date">
        <input type="hidden" id="to_date_{{ $id }}" name="to_date">
    </div>
</div>
