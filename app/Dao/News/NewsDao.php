<?php

namespace App\Dao\News;

use App\Contracts\Dao\News\NewsDaoInterface;
use App\Models\News;

class NewsDao implements NewsDaoInterface
{
    /**
     * retrieve and show all news according to public flag
     * @method showNews
     * @return void
     */
    public function showNews($is_user_loggedin = false)
    {
        $news = News::orderby('date', 'desc');
        if (!$is_user_loggedin) {
            $news->where('public_flag', 1);
        }
        return $news->paginate(config('constants.PAGINATION'));
    }

    /**
     * get single news
     * @method showSingleNews
     * @param  int $id
     * @return void
     */
    public function showNewsDetail($id)
    {
        return News::where('id', $id)->first();
    }

    /**
     * create news
     * @method createNews
     * @param  object $newsObj
     * @return void
     */
    public function createNews($newsObj)
    {
        News::create([
            'date' => date('Y-m-d H:i:s'),
            'title' => $newsObj->title,
            'message' => $newsObj->message,
            'public_flag' => $newsObj->public_flag,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * update news by id
     * @method updateNews
     * @param  object $newsObj
     * @param  int $id
     * @return void
     */
    public function updateNews($newsObj, $id)
    {
        News::where('id', $id)->update([
            'date' => date('Y-m-d H:i:s'),
            'title' => $newsObj->title,
            'message' => $newsObj->message,
            'public_flag' => $newsObj->public_flag,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * delete news by id
     * @method deleteNews
     * @param  int $id
     * @return void
     */
    public function deleteNews($id)
    {
        News::where('id', $id)->delete();
    }
}
