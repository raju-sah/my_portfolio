<div class=" title-section d-flex align-items-center mb-3">
    <span
        class="badge {{ $skill->status === 1 ? 'bg-success' : 'bg-danger' }} ml-auto">{{ $skill->status === 1 ? 'Active' : 'In Active' }}</span>
    <span class="badge bg-primary ms-3"><i class='bx bx-sort-alt-2'></i> Display Order
        &nbsp;{{ $skill->display_order }}</span>

    @php
        $createdDate = $skill->created_at->format('d M Y g:i A');
        $updatedDate = $skill->updated_at->format('d M Y g:i A');

    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> created_at:&nbsp;{{ $createdDate }}</span>
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> updated_at:&nbsp;{{ $updatedDate }}</span>

</div>

<div class="row border-top border-bottom py-3">

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">image</b>
            <x-table.table_image name="{{ $skill->image_path }}" url="{{ $skill->image_path }}" height="100px"
                width="100px" />
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $skill->name }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Slug</b>
            <span>{{ $skill->slug }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">percentage</b>
            <span class="badge bg-primary"> {{ $skill->percentage }}</span>
        </div>
    </div>
</div>
</div>
<div class="border-top border-bottom py-3">
    <div class="row">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Description</b>
            <span>{!! $skill->description !!}</span>
        </div>
    </div>
</div>
