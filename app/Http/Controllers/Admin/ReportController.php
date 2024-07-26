<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFilterType;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Review;
use App\Traits\DatatableTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    use DatatableTrait;

    public function reportFilter(Request $request)
    {
        if ($request->ajax()) {
           
            $query = Article::query()->select(['id', 'name', 'slug', 'views', 'created_at'])
                ->whereBetween('created_at', [$request->from_date, $request->to_date])
                ->withAvgRating();

            if ($request->has('common_filter')) {
                switch ($request->common_filter) {
                    case CommonFilterType::Views->value:
                        $query->orderBy('views', $request->asc_desc_filter);
                        break;
                    case CommonFilterType::Ratings->value:
                        $query->orderBy('reviews_avg_rating', $request->asc_desc_filter);
                        break;
                    default:
                        $query->orderBy('created_at', $request->asc_desc_filter);
                        break;
                }
            } else {
                $query->orderBy('created_at', $request->asc_desc_filter);
            }

            $config = [
                'additionalColumns' => [
                    'avg_rating' => function ($row) {
                        return $row->reviews_avg_rating . '/5';
                    },
                    'created_at' => function ($row) {
                        return $row->created_at->format('dS M, Y H:i A');
                    },

                    'report_button' => function ($row) {
                        return '<a href="' . route('admin.article-reports.index', ['article_id' => $row->id]) . '" class=""><i class="bx bxs-report"></i></a>';
                    },
                ],
                'disabledButtons' => ['edit', 'delete', 'view'],
                'model' => 'Article',
                'rawColumns' => ['report_button'],
                'sortable' => false,
                'routeClass' => null,
            ];

            return $this->getDataTable($request, $query, $config)->make(true);
        }

        return view('admin.report.article_filter', [
            'columns' => ['name', 'slug', 'views', 'avg_rating', 'created_at', 'report_button'],
        ]);
    }

    public function articleReport(Request $request): View
    {
        return view('admin.report.article_report', [
            'articles' => Article::where('status', 1)->pluck('name', 'id'),
            'filtered_article' => Article::select(['id', 'name', 'slug', 'views', 'min_read', 'about'])
                ->where('status', 1)
                ->where('id', $request->article_id)
                ->withAvgRating()
                ->withCount([
                    'reviews' => function ($query) {
                        $query->where('status', 1);
                    },
                ])
                ->addSelect([
                    'highest_rating' => Review::selectRaw('MAX(rating)')->where('article_id', $request->article_id),
                    'lowest_rating' => Review::selectRaw('MIN(rating)')->where('article_id', $request->article_id),
                ])
                ->first(),

            'highest_ratings' => Review::select('id', 'rating', 'name', 'email', 'created_at')
                ->where('article_id', $request->article_id)
                ->orderBy('rating', 'desc')
                ->limit(3)
                ->get(),
            'lowest_ratings' => Review::select('id', 'rating', 'name', 'email', 'created_at')
                ->where('article_id', $request->article_id)
                ->orderBy('rating', 'asc')
                ->limit(3)
                ->get(),
            'latest_ratings' => Review::select('id', 'rating', 'name', 'email', 'created_at')
                ->where('article_id', $request->article_id)
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }

    public function generatePDF(Request $request): Response
    {
        $filtered_article = Article::select(['id', 'name', 'slug', 'image', 'views', 'min_read', 'about'])
            ->where('status', 1)
            ->where('id', $request->article_id)
            ->withAvgRating()
            ->withCount([
                'reviews' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->addSelect([
                'highest_rating' => Review::selectRaw('MAX(rating)')->where('article_id', $request->article_id),
                'lowest_rating' => Review::selectRaw('MIN(rating)')->where('article_id', $request->article_id),
            ])
            ->first();

        $pdf = Pdf::loadView('admin.pdf.article_report', [
            'filtered_article' => $filtered_article,

            'highest_ratings' => Review::select(['rating', 'name', 'email', 'created_at'])
                ->where('article_id', $request->article_id)
                ->orderBy('rating', 'desc')
                ->limit(3)
                ->get(),
            'lowest_ratings' => Review::select(['rating', 'name', 'email', 'created_at'])
                ->where('article_id', $request->article_id)
                ->orderBy('rating')
                ->limit(3)
                ->get(),
            'latest_ratings' => Review::select(['rating', 'name', 'email', 'created_at'])
                ->where('article_id', $request->article_id)
                ->latest()
                ->limit(5)
                ->get(),
        ]);
        return $pdf->download($filtered_article->getPDFFileName('article-report_'));
    }
}
