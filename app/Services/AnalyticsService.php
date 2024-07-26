<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\FilterExpressionList;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\OrderBy;
use Illuminate\Support\Collection;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics;

class AnalyticsService
{
    public function getAnalyticsData(Period $period, array $metrics, array $dimensions = [], int $limit = 0, array $orderBy = []): Collection
    {
        return Analytics::get($period, $metrics, $dimensions, $limit, $orderBy);
    }
    public function filterAnalyticsData($dataToFilter, $start_date, $end_date, array $dimensions = [], array $metrics = [], array $orderBy = [])
    {
      putenv('GOOGLE_APPLICATION_CREDENTIALS=' . public_path('assets/GoogleAnalyticsCredentials/google_analytics.json'));
      $propertyId = config('analytics.property_id');
      $client = new BetaAnalyticsDataClient();
    
      $filters = array_filter($dataToFilter, function ($value) {
        return !empty($value);
      });
    
      if (empty($filters)) {
        $dimensionFilter = null;
      } else {
        $dimensionFilter = new FilterExpression([
          'and_group' => new FilterExpressionList([
            'expressions' => array_map(function ($key, $value) {
              return new FilterExpression([
                'filter' => new Filter([
                  'field_name' => $key,
                  'string_filter' => new StringFilter([
                    'match_type' => MatchType::EXACT,
                    'value' => $value,
                  ]),
                ]),
              ]);
            }, array_keys($filters), $filters),
          ]),
        ]);
      }
    
      $request = [
        'property' => "properties/$propertyId",
        'dateRanges' => [
          new DateRange([
            'start_date' => $start_date,
            'end_date' => $end_date,
          ]),
        ],
        'dimensions' => array_map(function ($dimension) {
          return new Dimension(['name' => $dimension]);
        }, $dimensions),

        'metrics' => array_map(function ($metric) {
          return new Metric(['name' => $metric]);
        }, $metrics),

        'orderBys' => array_map(function($key, $direction) {
          return (new OrderBy())
              ->setDimension(new OrderBy\DimensionOrderBy([
                  'dimension_name' => $key,
              ]))
              ->setDesc($direction === 'desc');
      }, array_keys($orderBy), $orderBy),
      ];
    
      if ($dimensionFilter !== null) {
        $request['dimensionFilter'] = $dimensionFilter;
      }
    
      return $client->runReport($request);
    }

    //---------------for front end-----------------------------
    public function pageViews(Period $period, string $pageTitle = null):array
    {
        return $this->getAnalyticsData($period, ['screenPageViews'], ['pageTitle'])->where('pageTitle', $pageTitle)->first() ?? [];
    }
    
}
