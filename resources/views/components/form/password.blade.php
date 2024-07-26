
@props([
  'id' => $name,
  'label' => 'Label',
  'class' => '',
  'value' => '',
  'type' => 'password',
  'message' => '',
  'col' => '12',
  'req' => false,
  'labelDisplay' => true,
  'name'
])

<div class="mb-3 form-password-toggle col-md-{{$col}}">
    <div class="d-flex justify-content-between">
        <label class="form-label" for="{{$id}}">{{$label}} @if($req === true)<span class="text-danger">*</span>@endif</label>
    </div>
    <div class="input-group input-group-merge" style="position: relative">
        <input type="password" id="{{$id}}" class="form-control {{$class}}" name="{{$name}}" aria-describedby="{{$id}}" value="{{$value}}" style=" border-left-width: 1px; border-left-style: solid; border-radius: 0.375rem;"/>
        <span class="input-group-text cursor-pointer toggle-password" style="position: absolute;top: 5px;right: 2px;z-index: 11;border: 0; "><i class="bx bx-hide"></i></span>
    </div>
    @error($name) <span class="text-danger small">{{ $message }}</span> @enderror

</div>


