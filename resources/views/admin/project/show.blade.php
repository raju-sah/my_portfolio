<div class=" title-section d-flex align-items-center mb-3">
    <span
        class="badge {{ $project->status === 1 ? 'bg-success' : 'bg-danger' }} ml-auto">{{ $project->status === 1 ? 'Active' : 'In Active' }}</span>
    <span class="badge bg-primary ms-3"><i class='bx bx-sort-alt-2'></i> Display Order
        &nbsp;{{ $project->display_order }}</span>
    @php
        $createdDate = $project->created_at->format('d M Y g:i A');
        $updatedDate = $project->updated_at->format('d M Y g:i A');
    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> created_at:&nbsp;{{ $createdDate }}</span>
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i> updated_at:&nbsp;{{ $updatedDate }}</span>

</div>

<div class="row border-top border-bottom py-3">

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">image</b>
            <img src="{{ $project->image_path }}" class="img-fluid" alt="image" height="100" width="100">
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $project->name }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Slug</b>
            <span>{{ $project->slug }}</span>
        </div>
    </div>

</div>

</div>
<div class=" row border-bottom py-3">
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">github_url</b>
            <span>{{ $project->github_url }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">web_url</b>
            <span>{{ $project->web_url }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">year</b>
            <span>{{ $project->year }}</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">tech used</b>
            @php
                $techs = json_decode($project->tech_used);
            @endphp
            @if ($techs)
                @foreach ($techs as $key => $value)
                    <span class="badge bg-primary m-1">{{ $value ?? '' }}</span>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="border-top border-bottom py-3">
    <div class="row">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Description</b>
            <span>{!! $project->description !!}</span>
        </div>
    </div>
</div>
