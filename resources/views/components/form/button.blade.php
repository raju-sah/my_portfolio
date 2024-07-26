    @props([
      'id' => 'id',
      'class' =>'',
      'type' => 'submit'
    ])

    <br>
    <button id="{{$id}}" {{ $attributes->merge(['class' => $class . ' btn btn-sm btn-dark']) }} type="{{$type}}">{{$slot}}</button>
