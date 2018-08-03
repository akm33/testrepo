<?php

namespace App\Http\Controllers\News;

use App\Contracts\Services\News\NewsServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NewsController extends Controller
{
    private $newsService;

    /**
     * constructor
     * @method __construct
     * @param  NewsServiceInterface $newsService
     */
    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * show all news
     * @method showNews
     * @return void
     */
    public function showNews()
    {
        $news = $this->newsService->showNews(Auth::check());
        return view('news.show', compact('news'));
    }

    /**
     * Show view for single news
     * @method showSingleNews
     * @param  Request $request
     * @param  int $id
     * @return void
     */
    public function showNewsDetail(Request $request, $id)
    {
        $request['id'] = $request->route('id');
        if ($this->validateID($request)->fails()) {
            return view('errors.404');
        }
        $news = $this->newsService->showNewsDetail($id);
        if (!isset($news)) {
            return view('errors.404');
        } elseif (!Auth::check() && !$news->public_flag) {
            return redirect('/login');
        }
        return view('news.show_single', compact('news'));
    }

    /**
     * show create form for news
     * @method showCreateNews
     * @return void
     */
    public function showCreateNews()
    {
        return view('news.create');
    }

    /**
     * create a single news
     * @method createNews
     * @param  Request $request
     * @return void
     */
    public function createNews(Request $request)
    {
        $validator = $this->validateInputNews($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $newsObj = $this->getNewsClass($request);
        $this->newsService->createNews($newsObj);
        return redirect('/');
    }

    /**
     * show edit form for news
     * @method showEditNews
     * @param  Request $request
     * @param  int $id
     * @return void
     */
    public function showEditNews(Request $request, $id)
    {
        $request['id'] = $request->route('id');
        if ($this->validateID($request)->fails()) {
            return view('errors.404');
        }
        $news = $this->newsService->showNewsDetail($id);
        if (!isset($news)) {
            return view('errors.404');
        }
        return view('news.edit', compact('news'));
    }

    /**
     * update news by id
     * @method updateNews
     * @param  Request $request
     * @param  int $id
     * @return void
     */
    public function updateNews(Request $request, $id)
    {
        $validator = $this->validateInputNews($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $newsObj = $this->getNewsClass($request);
        $this->newsService->updateNews($newsObj, $id);
        return redirect('/');
    }

    /**
     * delete news by id
     * @method deleteNews
     * @param  Request $request
     * @param  int $id
     * @return void
     */
    public function deleteNews(Request $request, $id)
    {
        $this->newsService->deleteNews($id);
        return redirect('/');
    }

    /**
     * create news Object
     * @method getNewsClass
     * @param  Request $request
     * @return News $newsObj
     */
    private function getNewsClass($request)
    {
        $newsObj = new \stdClass();
        $newsObj->title = trim($request->title);
        $newsObj->message = $request->message;
        $newsObj->public_flag = isset($request->public_flag) ? 1 : 0;
        return $newsObj;
    }

    /**
     * validation for news form
     * @method validateCreateNews
     * @param  Request $request
     * @return void
     */
    private function validateInputNews(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'message' => 'required',
        ]);
    }

    /**
     * validation for id from route
     * @method validateID
     * @param  Request $request
     * @return void
     */
    private function validateID(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
    }
}
