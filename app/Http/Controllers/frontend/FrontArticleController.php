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

    public function allArticleFilter(ArticleFilterRequest $request, AnalyticsService $analyticsService): View
    {
        // For general "Experience" views (passing fake article for now as per previous logic)
        $views = $analyticsService->pageViews($this->period, 'Articles');

        $from = $request->from_date ? Carbon::parse($request->from_date)->startOfDay() : null;
        $to = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;
        $order = $request->asc_desc_filter ?? 'desc';
        $perPage = $request->pagination_filter ?? 10;

        $articleQuery = Article::query()
            ->select(['id', 'name', 'description', 'image', 'slug', 'min_read', 'about', 'created_at', 'views'])
            ->where('status', 1)
            ->articles()
            ->withAvgRating();

        $storyQuery = Article::query()
            ->select(['id', 'name', 'description', 'image', 'slug', 'min_read', 'about', 'created_at', 'views'])
            ->where('status', 1)
            ->stories()
            ->withAvgRating();

        // Apply Common Filter (Ordering)
        if ($request->common_filter === CommonFilterType::Views->value) {
            $articleQuery->orderBy('views', $order);
            $storyQuery->orderBy('views', $order);
        } elseif ($request->common_filter === CommonFilterType::Ratings->value) {
            $articleQuery->orderBy('reviews_avg_rating', $order);
            $storyQuery->orderBy('reviews_avg_rating', $order);
        } else {
            $articleQuery->orderBy('created_at', $order);
            $storyQuery->orderBy('created_at', $order);
        }

        // Apply Date Range
        if ($from && $to) {
            $articleQuery->whereBetween('created_at', [$from, $to]);
            $storyQuery->whereBetween('created_at', [$from, $to]);
        }

        // Handle Pagination
        if ($perPage == -1) {
            $all_articles = $articleQuery->get();
            $all_stories = $storyQuery->get();
        } else {
            $all_articles = $articleQuery->take($perPage)->get();
            $all_stories = $storyQuery->take($perPage)->get();
        }

        return view('frontend.article.all_articles', [
            'request'      => $request,
            'all_articles' => $all_articles,
            'all_stories'  => $all_stories,
            'views'        => $views,
        ]);
    }
}
