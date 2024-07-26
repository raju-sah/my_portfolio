<form id="dimensionFilterForm" class="mt-4">
    @csrf
    <div class="row">
        @php
            $countryList = $countryCityList->groupBy('country')->map(function ($cities) {
                return [
                    'activeUsers' => $cities->sum('activeUsers'),
                    'screenPageViews' => $cities->sum('screenPageViews'),
                    'cities' => $cities->pluck('city')->unique()->toArray(),
                ];
            });
        @endphp

        <div class="col-md-2">
            <label for="country" class="form-label">Country</label>
            <select name="country" id="country" class="form-select">
                <option value="">Select</option>
                @foreach ($countryList as $country => $data)
                    <option value="{{ $country }}">{{ $country }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="city" class="form-label">City</label>
            <select name="city" id="city" class="form-select">
                <option value="">Select</option>
                @foreach ($countryCityList as $city)
                    <option value="{{ $city['city'] }}">{{ $city['city'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="operatingSystem" class="form-label">Operating System</label>
            <select name="operatingSystem" id="operatingSystem" class="form-select">
                <option value="">Select</option>
                @foreach ($operatingSystems as $operatingSystem)
                    <option value="{{ $operatingSystem['operatingSystem'] }}">{{ $operatingSystem['operatingSystem'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="userSource" class="form-label">User Source</label>
            <select name="firstUserSource" id="userSource" class="form-select">
                <option value="">Select</option>
                @foreach ($userSources as $userSource)
                    <option value="{{ $userSource['firstUserSource'] }}">{{ $userSource['firstUserSource'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="newVsReturning" class="form-label">User Type</label>
            <select name="newVsReturning" id="newVsReturning" class="form-select">
                <option value="">Select</option>
                @foreach (\App\Enums\VisitorType::cases() as $case)
                    <option value="{{ $case->value }}">{{ $case->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="pageTitle" class="form-label">Page Title</label>
            <select name="pageTitle" id="pageTitle" class="form-select">
                <option value="">Select</option>
                @foreach ($viewsByTitle as $pageTitle)
                    <option value="{{ $pageTitle['pageTitle'] }}">{{ $pageTitle['pageTitle'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <x-form.date-picker col="3" label="Date Range" id="dateRangePicker" :displayDateRange="false" />

        <div class="col-md-2 ">
            <label for="paginate" class="form-label">Pagination</label>
            <select name="paginate" id="paginate" class="form-select">
                @foreach (\App\Enums\PaginationFilterType::cases() as $case)
                    <option value="{{ $case->value }}">{{ $case->value == -1 ? 'All' : $case->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <x-form.button id="submitButton" class="btn mt-2" type="submit" style="height: 36px">
                <i class="bx bx-filter-alt"></i> Filter
            </x-form.button>
        </div>
    </div>
</form>

<div class="table-responsive pt-5 pb-5">
    <table id="filteredData" class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th class="text-center fw-bold fs-6" colspan="8">dimensions</th>
                <th class="text-center fw-bold fs-6" colspan="10">metrics</th>
            </tr>
            <tr>
                <th>SN</th>
                <th>date</th>
                <th>country</th>
                <th>city</th>
                <th>device</th>
                <th>operating System</th>
                <th>User Source</th>
                <th>page Title</th>
                <th>user type</th>
                <th>Views</th>
                <th>Users</th>
                <th>new Users</th>
                <th>sessions</th>
                <th>event Count</th>
                <th>event Count PerUser</th>
                <th>events PerSession</th>
                <th>user Engagement Duration</th>
                <th>engagement Rate</th>
                <th>bounce Rate</th>
            </tr>
        </thead>
        <tbody id="tablecontents">
    @include('_helpers.loading')
        </tbody>
    </table>
</div>

@push('custom_js')
    @include('_helpers.datePickerComp', ['id' => 'dateRangePicker', 'displayDateRange' => false])

    <script>
        $(document).ready(function() {

            const form = $('#dimensionFilterForm');
           
            form.on('submit', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $("#filteredData").offset().top + 30
                }, 'fast');

                showLoading();

                $.ajax({
                    url: "{{ route('home.filter-dimensions') }}",
                    type: "GET",
                    dataType: "json",
                    data: form.serialize(),
                    success: function(response) {
                        fetchFilterData(response.data);
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

            function fetchFilterData(data) {
                const tableContents = $('#tablecontents');
                tableContents.empty();
                hideLoading();

                if (data.length === 0) {
                    tableContents.append('<tr class="text-center"><td colspan="19">No data found</td></tr>');
                    return;
                }

                const formatter = new Intl.DateTimeFormat('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                const fragment = document.createDocumentFragment();

                data.forEach((entry, index) => {
                    const date = new Date(
                        entry.dimensions[0].substring(0, 4),
                        entry.dimensions[0].substring(4, 6) - 1,
                        entry.dimensions[0].substring(6, 8)
                    );

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${formatter.format(date)}</td>
                        ${entry.dimensions.slice(1).map(d => `<td>${d}</td>`).join('')}
                        ${entry.metrics.slice(0, 5).map(m => `<td>${m}</td>`).join('')}
                        <td>${parseFloat(entry.metrics[5]).toFixed(2)}</td>
                        <td>${parseFloat(entry.metrics[6]).toFixed(2)}</td>
                        <td>${entry.metrics[7]} s</td>
                        <td>${(parseFloat(entry.metrics[8]) * 100).toFixed(2)}%</td>
                        <td>${(parseFloat(entry.metrics[9]) * 100).toFixed(2)}%</td>
                    `;
                    fragment.appendChild(row);
                });

                tableContents.append(fragment);
            }

        });
    </script>
@endpush
