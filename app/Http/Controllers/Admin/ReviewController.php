<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Review;
use App\Traits\DatatableTrait;
use App\Traits\StatusTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    use StatusTrait, DatatableTrait;

    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Review::query()->select(['id', 'name', 'email', 'rating', 'article_id', 'status'])
            ->with('article:id,name')
            ->latest();
        
        if ($request->filter_by_article) {
            $query->where('article_id', $request->filter_by_article);
        }


        $config = [
            'additionalColumns' => [
                'article_name' => function ($row) {
                    return $row->article?->name ?? 'N/A';
                },
            ],
            'disabledButtons' => ['edit'],
            'model' => 'Review',
            'rawColumns' => ['article_name'],
            'sortable' => false,
            'routeClass' => 'reviews',
        ];

        return $this->getDataTable($request, $query, $config)->make(true);
    }

    return view('admin.article_review.index', [
        'columns' => ['name', 'email', 'rating', 'article_name', 'status'],
        'articles' => Article::where('status', 1)->pluck('name', 'id'),
    ]);
}

    public function show(Review $review): View
    {
        return view('admin.article_review.show', [
            'review' => $review->load('article:id,name'),
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('error', 'Article Deleted Successfully!');
    }

    public function changeStatus(Request $request): void
    {
        $this->changeItemStatus('Review', $request->id, $request->status);
    }

    public function showNotification(Review $review): View
    {
        return view('admin.article_review.article_review_notification', compact('review'));
    }
}
