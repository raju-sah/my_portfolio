<div class="card p-2 w-25 ms-3">
    <div class="d-flex justify-content-between mt-3">
        <span class="fw-light"
            style="font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px #000;">Country</span>
        <span class="fw-light"
            style="font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px #000;">Visitors</span>
        <span class="fw-light"
            style="font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px #000;">Views</span>
    </div>
    @php
        $countryDataMap = $countryCityList
            ->groupBy('country')
            ->map(function ($cities) {
                return [
                    'activeUsers' => $cities->sum('activeUsers'),
                    'screenPageViews' => $cities->sum('screenPageViews'),
                ];
            })->sortByDesc('activeUsers')->take(10);
    @endphp
    @foreach ($countryDataMap as $country => $data)
        <div class="row d-flex justify-content-between mt-3">
            <div class="col-md-6">
                <span class="" style="font-size: 13px;">{{ $country }}</span>
            </div>
            <div class="col-md-3">
                <span class=""
                    style="font-size: 13px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $data['activeUsers'] }}
                </span>
            </div>
            <div class="col-md-3">
                <span class="" style="font-size: 13px;">{{ $data['screenPageViews'] }}</span>
            </div>
        </div>
    @endforeach
    <div class="row">
        @php
            $countryList = $countryCityList->groupBy('country')->map(function ($cities) {
                return [
                    'activeUsers' => $cities->sum('activeUsers'),
                    'screenPageViews' => $cities->sum('screenPageViews'),
                ];
            });
        @endphp
    </div>
</div>
