<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Requests\Admin\ArticleUpdateRequest;
use App\Traits\DatatableTrait;
use App\Traits\StatusTrait;
use App\Traits\UploadFileTrait;

class ArticleController extends Controller
{
    use StatusTrait, DatatableTrait,UploadFileTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Article::query()        // this is working because it has query() and other does not work because those doesnot have query()
            ->select(['id', 'name', 'min_read', 'about', 'display_order', 'views', 'status'])
            ->latest();
    
            $config = [
                'additionalColumns' => [
                    'min_read' => function ($row) {
                        return $row->min_read . ' min';
                    },
                ],
                'disabledButtons' => [],
                'model' => 'Article',
                'rawColumns' => ['min_read'],
                'sortable' => false,
                'routeClass' => null,
            ];
    
            return $this->getDataTable($request, $query, $config)->make(true);
        }

        // foreach ($articles as $article) {
        //     $article->about = explode(',', $article->about);
        //     $article->min_read = $article->min_read . ' min';
        // }

        return view('admin.article.index', [
            'columns' => ['name', 'min_read', 'about', 'display_order', 'views', 'status'],
        ]);
    }

    public function create(): View
    {
        return view('admin.article.create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = Article::create($request->safe()->except('image'));
        if ($request->hasFile('image')) {
            $article->storeImage('image', 'article-images', $request->file('image'));
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article Created Successfully!');
    }

    public function show(Article $article): View
    {
        $article->about = explode(',', $article->about);
        $article->min_read = $article->min_read . ' min read';

        return view('admin.article.show', compact('article'));
    }

    public function edit(Article $article): View
    {
        return view('admin.article.edit', compact('article'));
    }

    public function update(ArticleUpdateRequest $request, Article $article): RedirectResponse
    {
        $article->update($request->safe()->except('image'));
        if ($request->hasFile('image')) {
            $article->updateImage('image', 'article-images', $request->file('image'));
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article Updated Successfully!');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->image) {
            $article->deleteImage('image', 'article-images');
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('error', 'Article Deleted Successfully!');
    }

    public function changeStatus(Request $request): void
    {
        $this->changeItemStatus('Article', $request->id, $request->status);
    }

   
}
