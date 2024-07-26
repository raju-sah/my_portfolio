<div class=" title-section d-flex align-items-center mb-3">
    <span
        class="badge {{ $review->status === 1 ? 'bg-success' : 'bg-danger' }} ml-auto">{{ $review->status === 1 ? 'Active' : 'In Active' }}</span>
    <span class="ms-3">
        @for ($i = 0; $i < $review->rating; $i++)
            <i class='bx bxs-star' style="color: #ffc700;"></i>
        @endfor
    </span>
    <span class="reviews-count">(&nbsp;{{ $review->rating }} Star )</span>
    @php
        $createdDate = $review->created_at->format('dS M Y g:i A');
        $updatedDate = $review->updated_at->format('dS M Y g:i A');

    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> created_at:&nbsp;{{ $createdDate }}</span>
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> updated_at:&nbsp;{{ $updatedDate }}</span>
</div>

<div class="row border-top border-bottom py-3">



    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $review->name }}</span>
        </div>
    </div>

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">email</b>
            <span>{{ $review->email }}</span>
        </div>
    </div>
</div>

<div class="border-top border-bottom py-3">
    <div class="row">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Description</b>
            <span>{!! $review->description !!}</span>
        </div>
    </div>
</div>
