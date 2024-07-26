<div class="card p-4 w-50">
    <span class="fs-6 dashed-text"
        style=" text-underline-position: under; text-decoration: underline dashed 1px  #000;">Top Devices</span>
    <div class="d-flex justify-content-between mt-3">
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Devices
        </span>
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Users
        </span>
        <span class="fw-light  me-4"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Views
        </span>
    </div>
    @foreach ($devices as $device)
        <div class="row d-flex justify-content-between mt-3">
            <div class="col-md-5">
                <span class="" style="font-size: 13px;">{{ $device['deviceCategory'] }}</span>
            </div>
            <div class="col-md-4">
                <span class="" style="font-size: 13px;">{{ $device['activeUsers'] }}</span>
            </div>
            <div class="col-md-2">
                <span class="" style="font-size: 13px;">{{ $device['screenPageViews'] }}</span>
            </div>
        </div>
    @endforeach
</div>
