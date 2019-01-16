<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param News $news
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(News $news, Category $category)
    {
        $attributes = $this->validateNews();
        $attributes['owner_id'] = auth()->id();
        $news->create($attributes);
        flash('Новость создана');
        return redirect('/news');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news, Category $category)
    {
        $categories = Category::all();
        return view('news.edit', [
            'news' => $news,
            'categories' => $categories
        ]);// TODO: Передать текущую категорию
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $news->update($this->validateNews());
        return redirect('/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(News $news)
    {
        $news->delete();
        flash('Новость удалена');
        return redirect('/news');
    }

    protected function validateNews()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);
    }
}
