<div class="card p-4 w-50">
    <span class="fs-6"
        style=" text-underline-position: under; text-decoration: underline dashed 1px  #000;">Top Operating Systems</span>
    <div class="d-flex justify-content-between mt-3">
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Operating System
        </span>
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Users
        </span>
        <span class="fw-light me-4"
        style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Views
    </span>
    </div>
    @foreach($operatingSystems as $operatingSystem)
    <div class="row d-flex justify-content-between mt-3">
        <div class="col-md-6">
            <span class="" style="font-size: 13px;">{{ $operatingSystem['operatingSystem'] }}</span>
        </div>
        <div class="col-md-3">
            <span class="" style="font-size: 13px;">{{ $operatingSystem['activeUsers'] }}</span>
        </div>
        <div class="col-md-2">
            <span class="" style="font-size: 13px;">{{ $operatingSystem['screenPageViews'] }}</span>
        </div>
    </div>
@endforeach
</div>