<div class="card p-2">
    <span class="fs-6"
        style=" text-underline-position: under; text-decoration: underline dashed 1px  #000;">Views by Page title
        & Page Path </span>
    <div class="d-flex justify-content-between mt-3">
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Page title
        </span>
        <span class="fw-light"
            style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;"> Page Path
        </span>
        <span class="fw-light me-4"
        style=" font-size: 14px; text-underline-position: under; text-decoration: underline dashed 1px  #000;">Views
    </span>
    </div>
    @foreach($viewsByTitle as $view)
    <div class="row d-flex justify-content-between mt-3">
        <div class="col-md-4">
            <span class="" style="font-size: 13px;">{{ $view['pageTitle'] }}</span>
        </div>
        <div class="col-md-6">
            <a href="{{ $view['pagePath'] }}" target="_blank">
                <span class="" style="font-size: 13px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $view['pagePath'] }}
                </span>
            </a>
        </div>
        <div class="col-md-1">
            <span class="" style="font-size: 13px;">{{ $view['screenPageViews'] }}</span>
        </div>
    </div>
@endforeach
</div>