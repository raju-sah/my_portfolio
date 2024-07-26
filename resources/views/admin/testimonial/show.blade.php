<div class=" title-section d-flex align-items-center mb-3">
    <span
        class="badge {{ $testimonial->status === 1 ? 'bg-success' : 'bg-danger' }} ml-auto">{{ $testimonial->status === 1 ? 'Active' : 'In Active' }}</span>
    <span class="badge bg-primary ms-3"><i class='bx bx-sort-alt-2'></i> Display Order
        &nbsp;{{ $testimonial->display_order }}</span>
    @php
        $createdDate = $testimonial->created_at->format('d M Y g:i A');
        $updatedDate = $testimonial->updated_at->format('d M Y g:i A');
    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> created_at:&nbsp;{{ $createdDate }}</span>
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> updated_at:&nbsp;{{ $updatedDate }}</span>
</div>

<div class="row border-top border-bottom py-3">
    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">image</b>
            <img src="{{ $testimonial->image_path }}" alt="image" height="200" width="200" class="img-fluid">
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $testimonial->name }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">email</b>
            <span>{{ $testimonial->email }}</span>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">phone</b>
            <span>{{ $testimonial->phone }}</span>
        </div>
    </div>

</div>

<div class=" row border-bottom py-3">
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">facebook_link</b>
            <span>{{ $testimonial->facebook_link }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">instagram_link</b>
            <span>{{ $testimonial->instagram_link }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">linkedin_link</b>
            <span>{{ $testimonial->linkedin_link }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">website_link</b>
            <span>{{ $testimonial->website_link }}
            </span>
        </div>
    </div>
</div>
<div class=" row border-bottom py-3">
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">github_link</b>
            <span>{{ $testimonial->github_link }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">position</b>
            <span>{{ $testimonial->position }}</span>
        </div>
    </div>
</div>

<div class="border-top border-bottom py-3">
    <div class="row">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Description</b>
            <span>{!! $testimonial->description !!}</span>
        </div>
    </div>
</div>