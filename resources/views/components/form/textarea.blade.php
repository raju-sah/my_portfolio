@props([
  'id' => $name,
  'label' => 'Label',
  'class' => 'form-control text-14',
  'value' => '',
  'type' => 'text',
  'message' => '',
  'col' => '12',
  'req' => false,
  'name'
])

<div class="col-md-{{$col}}">
    <label for="{{$id}}" class="col-form-label">{{$label}} @if($req === true)
            <span class="text-danger">*</span>
        @endif</label>

    <textarea name="{{$name}}" id="{{$id}}"  {{ $attributes->merge(['class' => $class . ' form-control text-14']) }}>{{$value}}</textarea>
    @error($name) <span class="text-danger small">{{ $message }}</span> @enderror
</div>
