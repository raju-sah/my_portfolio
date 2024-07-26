<div class="card p-2 w-25 ms-3">
    <div class="d-flex justify-content-between mt-3">
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">City
        </span>
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">
            Visitors
        </span>
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Views
        </span>
    </div>
    @foreach ($countryCityList->sortByDesc('activeUsers')->take(10) as $city)
        <div class="row d-flex justify-content-between mt-3">
            <div class="col-md-6">
                <span class="" style="font-size: 13px;">{{ $city['city'] }}</span>
            </div>
            <div class="col-md-3">
                <span class=""
                    style="font-size: 13px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $city['activeUsers'] }}
                </span>
            </div>
            <div class="col-md-3">
                <span class="" style="font-size: 13px;">{{ $city['screenPageViews'] }}</span>
            </div>
        </div>
    @endforeach
</div>
