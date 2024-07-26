<div class=" title-section d-flex align-items-center mb-3">
    <span
        class="badge {{ $article->status === 1 ? 'bg-success' : 'bg-danger' }} ml-auto">{{ $article->status === 1 ? 'Active' : 'In Active' }}</span>
    <span class=" badge bg-primary ms-3"><i class='bx bx-show'></i>{{ $article->views }}&nbsp;Views</span>
    <span class="badge bg-primary ms-3"><i class='bx bx-sort-alt-2'></i> Display Order
        &nbsp;{{ $article->display_order }}</span>
    @php
        $createdDate = $article->created_at->format('d M Y g:i A');
        $updatedDate = $article->updated_at->format('d M Y g:i A');
    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> created_at:&nbsp;{{ $createdDate }}</span>
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> updated_at:&nbsp;{{ $updatedDate }}</span>
</div>

<div class="row border-top border-bottom py-3">

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">image</b>
            <x-table.table_image name="{{ $article->image }}" url="{{ $article->image_path }}" height="100px"
                width="200px" />
        </div>
    </div>

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $article->name }}</span>
        </div>
    </div>

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Slug</b>
            <span>{{ $article->slug }}</span>
        </div>
    </div>
</div>

<div class="row border-bottom py-3">
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">about</b>
            @foreach ($article->about as $about)
                <span class="badge bg-primary"> {{ $about }}</span>
            @endforeach
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">min_read</b>
            <span>{{ $article->min_read }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">created_at</b>
            <span>{{ $article->created_at }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">updated_at</b>
            <span>{{ $article->updated_at }}</span>
        </div>
    </div>

</div>

<div class="border-top border-bottom py-3">
    <div class="row">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Description</b>
            <span>{!! $article->description !!}</span>
        </div>
    </div>
</div>
