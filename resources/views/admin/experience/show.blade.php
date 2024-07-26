<div class=" title-section d-flex align-items-center mb-3">
    <span
        class="badge {{ $experience->status === 1 ? 'bg-success' : 'bg-danger' }} ml-auto">{{ $experience->status === 1 ? 'Active' : 'In Active' }}</span>
    <span class="badge bg-primary ms-3"><i class='bx bx-sort-alt-2'></i> Display Order
        &nbsp;{{ $experience->display_order }}</span>
    @php
        $createdDate = $experience->created_at->format('d M Y g:i A');
        $updatedDate = $experience->updated_at->format('d M Y g:i A');
    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> created_at:&nbsp;{{ $createdDate }}</span>
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> updated_at:&nbsp;{{ $updatedDate }}</span>

</div>

<div class="row border-top border-bottom py-3">

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">image</b>
            <img src="{{ $experience->image_path }}" class="img-fluid" alt="image" height="100" width="100">
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $experience->name }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Slug</b>
            <span>{{ $experience->slug }}</span>
        </div>
    </div>

</div>

</div>
<div class=" row border-bottom py-3">
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">location</b>
            <span>{{ $experience->location }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">web_url</b>
            <span>{{ $experience->web_url }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">role</b>
            <span>{{ $experience->role }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">year</b>
            <span>{{ $experience->date_from . '-' . ($experience->curently_here ? 'Present' : $experience->date_to) }}
            </span>
        </div>
    </div>
</div>

<div class="border-top border-bottom py-3">
    <div class="row">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Description</b>
            <span>{!! $experience->description !!}</span>
        </div>
    </div>
</div>
