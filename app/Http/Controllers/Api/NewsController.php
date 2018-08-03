<?php

namespace App\Http\Controllers\Api;

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
    public function showNews(Request $request)
    {
        $news = $this->newsService->showNews($request->isLogin === 'true' ? true: false);
        return response()->json($news);
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
        $newsObj = $this->getNewsClass($request);
        $this->newsService->createNews($newsObj);
        return response()->json(['messsage' => 'success'],200);
    }

    /**
     * show edit form for news
     * @method showEditNews
     * @param  Request $request
     * @param  int $id
     * @return void
     */
    public function getNewsDetail($id)
    {
        $news = $this->newsService->showNewsDetail($id);
        if (!isset($news)) {
            return response()->json(['error' => 'cannot get news'],500);
        }
        return response()->json($news);
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
        return response()->json($this->newsService->showNewsDetail($id));
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
        return response()->json($this->newsService->showNewsDetail($id));
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
        $newsObj->public_flag = $request->public_flag ? 1 : 0;
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
