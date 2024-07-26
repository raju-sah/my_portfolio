@props([
  'id' => $name,
  'label' => 'CheckBox',
  'class' => '',
  'value' => 1,
  'message' => '',
  'isChecked' => false,
  'isEditMode' => '',
  'col' => '12',
  'name'
])

<div class="form-check col-md-{{$col}}">
    @if(isset($isEditMode))
        <input type="hidden" name="{{$name}}" value="0">
    @endif
    <input type="checkbox" name="{{$name}}" id="{{$id}}" value="{{$value}}" {{ $attributes->merge(['class' => $class . ' form-check-input']) }}
    @if(isset($isEditMode))
        {{$isChecked}}
            @endif
    >
    <label class="form-check-label" for="{{$id}}">{{$label}}</label>
</div>
