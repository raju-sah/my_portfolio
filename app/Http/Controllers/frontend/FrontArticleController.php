<?php

namespace App\Http\Controllers\frontend;

use App\Enums\ArticleType;
use App\Enums\CommonFilterType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ArticleFilterRequest;
use App\Models\Article;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\View\View;
use Spatie\Analytics\Period;

class FrontArticleController extends Controller
{

    public function __construct(public $period = null)
    {
        $this->period = Period::create(Carbon::parse('2024-05-25')->startOfDay(), Carbon::now());
    }

    public function showArticle($slug, Article $article, AnalyticsService $analyticsService): View
    {
        $views  = $analyticsService->pageViews($this->period, $article->name);

        $article = Article::query()
            ->select(['id', 'name', 'description', 'image', 'slug', 'views', 'min_read', 'about', 'created_at'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->withAvgRating()
            ->firstOrFail();
        return  view('frontend.article.article_single_page', [
            'article' => $article,
            'views' => $views
        ]);
    }

    public function allArticleFilter(ArticleFilterRequest $request, Article $article, AnalyticsService $analyticsService): View
    {
        $views  = $analyticsService->pageViews($this->period, $article->name);

        $startDate = Carbon::parse($request->from_date)->startOfDay();
        $endDate   = Carbon::parse($request->to_date)->endOfDay();

        // Base query for articles (type = article)
        $articleQuery = Article::query()
            ->select(['id', 'name', 'description', 'image', 'slug', 'min_read', 'about', 'created_at'])
            ->where('status', 1)
            ->articles()
            ->withAvgRating();

        // Base query for stories (type = story)
        $storyQuery = Article::query()
            ->select(['id', 'name', 'description', 'image', 'slug', 'min_read', 'about', 'created_at'])
            ->where('status', 1)
            ->stories()
            ->withAvgRating();

        $most_rated    = collect();
        $most_viewed   = collect();
        $default_result = collect();

        switch ($request->common_filter) {
            case CommonFilterType::Views->value:
                $most_viewed = $articleQuery
                    ->clone()
                    ->orderBy('views', $request->asc_desc_filter)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->take($request->pagination_filter === '-1' ? $articleQuery->count() : $request->pagination_filter)
                    ->get();
                break;
            case CommonFilterType::Ratings->value:
                $most_rated = $articleQuery
                    ->clone()
                    ->orderBy('reviews_avg_rating', $request->asc_desc_filter)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->take($request->pagination_filter === '-1' ? $articleQuery->count() : $request->pagination_filter)
                    ->get();
                break;
        }

        if ($request->has('pagination_filter') && $request->has('asc_desc_filter')) {
            $default_result = $articleQuery
                ->clone()
                ->orderBy('created_at', $request->asc_desc_filter)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->take($request->pagination_filter === '-1' ? $articleQuery->count() : $request->pagination_filter)
                ->get();
        }

        return view('frontend.article.all_articles', [
            'request'         => $request,
            'most_rated'      => $most_rated,
            'most_viewed'     => $most_viewed,
            'default_results' => $default_result,
            'all_articles'    => $articleQuery->clone()->orderBy('created_at', 'desc')->get(),
            'all_stories'     => $storyQuery->clone()->orderBy('created_at', 'desc')->get(),
            'views'           => $views,
        ]);
    }
}
