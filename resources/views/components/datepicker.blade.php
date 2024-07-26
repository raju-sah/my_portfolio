@props(['id'])

<div id="{{ $id }}"
    style="background: #fff; cursor: pointer; padding: 7px 10px; border: 1px solid #ccc; width: 100%; border-radius: 8px;">
    <span></span>
</div>
<input type="hidden" id="from_date_{{ $id }}" name="from_date">
<input type="hidden" id="to_date_{{ $id }}" name="to_date">
