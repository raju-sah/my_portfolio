<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DimensionFilterRequest;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(AnalyticsService $analyticsService): View
    {
        $startDate = Carbon::parse('2024-05-25')->startOfDay();
        $endDate = Carbon::now();
        $period = Period::create($startDate, $endDate);

        $metricsFilter = $analyticsService->getAnalyticsData($period, ['screenPageViews', 'activeUsers', 'newUsers', 'sessions', 'eventCount', 'eventCountPerUser', 'eventsPerSession', 'averageSessionDuration', 'bounceRate', 'engagementRate'], ['date']);

        $countryCityList = $analyticsService->getAnalyticsData($period, ['screenPageViews', 'activeUsers'], ['country', 'city']);

        $userType = $analyticsService->getAnalyticsData($period, ['activeUsers'], ['date', 'newVsReturning']);

        $viewsByTitle = $analyticsService->getAnalyticsData($period, ['screenPageViews'], ['pagePath', 'pageTitle']);

        $userSources = $analyticsService->getAnalyticsData($period, ['activeUsers', 'screenPageViews'], ['firstUserSource']);

        $operatingSystems = $analyticsService->getAnalyticsData($period, ['activeUsers', 'screenPageViews'], ['operatingSystem']);

        $devices = $analyticsService->getAnalyticsData($period, ['activeUsers', 'screenPageViews'], ['deviceCategory']);

        return view('home', [
            'metricsFilter' => $metricsFilter,
            'viewsByTitle' => $viewsByTitle,
            'countryCityList' => $countryCityList,
            'userType' => $userType,
            'userSources' => $userSources,
            'operatingSystems' => $operatingSystems->sortByDesc('activeUsers'),
            'devices' => $devices->sortByDesc('activeUsers'),
        ]);
    }

    public function drawChart(Request $request, AnalyticsService $analyticsService): JsonResponse
    {
        if ($request->ajax()) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $endDate = Carbon::parse($request->to_date)->endOfDay();
            $period = Period::create($startDate, $endDate);

            $metrics = [];

            if ($request->filled('firstType')) {
                $metrics[] = $request->firstType;
            }

            if ($request->filled('secondType')) {
                $metrics[] = $request->secondType;
            }

            $metricsFilter = $analyticsService->getAnalyticsData($period, $metrics, ['date']);

            return response()->json(['data' => $metricsFilter]);
        }
    }
    public function filterDimensions(DimensionFilterRequest $request, AnalyticsService $analyticsService): JsonResponse
    {
        if ($request->ajax()) {
            $dataToFilter = $request->safe()->except(['_token', 'from_date', 'to_date','paginate']);
    
            $response = $analyticsService->filterAnalyticsData(
                $dataToFilter, 
                $request->from_date, 
                $request->to_date, 
                ['date', 'country', 'city', 'deviceCategory', 'operatingSystem', 'firstUserSource', 'pageTitle', 'newVsReturning'], 
                ['screenPageViews', 'activeUsers', 'newUsers', 'sessions', 'eventCount', 'eventCountPerUser', 'eventsPerSession', 'userEngagementDuration', 'engagementRate', 'bounceRate'],
                ['date' => 'desc']
            );
    
            $combinedData = [];
    
            foreach ($response->getRows() as $row) {
                $dimensionValues = [];
                foreach ($row->getDimensionValues() as $dimensionValue) {
                    $dimensionValues[] = $dimensionValue->getValue();
                }
    
                $metricValues = [];
                foreach ($row->getMetricValues() as $metricValue) {
                    $metricValues[] = $metricValue->getValue();
                }
    
                if (count($dimensionValues) === count($metricValues)) {
                    $data = array_combine($dimensionValues, $metricValues);
                } else {
                    $data = [
                        'dimensions' => $dimensionValues,
                        'metrics' => $metricValues,
                    ];
                }
    
                $combinedData[] = $data;
            }
    
            $totalCount = count($response->getRows());
        $combinedData = collect($combinedData)
            ->take($request->paginate === '-1' ? $totalCount : (int)$request->paginate);

            return response()->json(['data' => $combinedData]);
        }
    
        return response()->json(['error' => 'Request must be AJAX'], 400);
    }
    
}
