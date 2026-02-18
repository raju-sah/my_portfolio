<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Enums\ArticleType;
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
        $articles = Article::query()
            ->select(['id', 'name', 'min_read', 'about', 'display_order', 'views', 'status', 'type'])
            ->orderBy('display_order')
            ->get()
            ->groupBy(fn($article) => $article->type->value);

        return view('admin.article.index', [
            'articles' => $articles,
            'articleCount' => Article::articles()->count(),
            'storyCount'   => Article::stories()->count(),
        ]);
    }

    public function updateOrder(Request $request): RedirectResponse
    {
        $order = $request->input('order');
        foreach ($order as $index => $id) {
            Article::where('id', $id)->update(['display_order' => $index + 1]);
        }
        return redirect()->back()->with('success', 'Order Updated Successfully!');
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
