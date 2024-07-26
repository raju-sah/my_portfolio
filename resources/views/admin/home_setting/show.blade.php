<div class="row align-items-center  ">
    <div class="card-content mt-2"><b class="d-block text-uppercase text-14">title</b><span>{{$homeSetting->title}}</span></div>
<div class="card-content mt-2"><b class="d-block text-uppercase text-14">logo</b><x-table.table_image name="{{$homeSetting->logo }}" url="{{$homeSetting->logo_path }}"/>
<div class="card-content mt-2"><b class="d-block text-uppercase text-14">slug</b><span>{{$homeSetting->slug}}</span></div>
<div class="card-content mt-2"><b class="d-block text-uppercase text-14">description</b><span>{{$homeSetting->description}}</span></div>
<div class="card-content mt-2"><b class="d-block text-uppercase text-14">image</b><x-table.table_image name="{{$homeSetting->image }}" url="{{$homeSetting->image_path }}"/>
<div class="card-content mt-2"><b class="d-block text-uppercase text-14">status</b><span>{{$homeSetting->status}}</span></div>

</div>
</div>
