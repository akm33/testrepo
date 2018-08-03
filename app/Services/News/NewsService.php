<?php

namespace App\Services\News;

use App\Contracts\Dao\News\NewsDaoInterface;
use App\Contracts\Services\News\NewsServiceInterface;

class NewsService implements NewsServiceInterface
{
    private $newsDao;

    /**
     * Constructor
     * @method __construct
     * @param  NewsDaoInterface $newsDao
     */
    public function __construct(NewsDaoInterface $newsDao)
    {
        $this->newsDao = $newsDao;
    }

    /**
     * Retrieve News
     * @method showNews
     * @param  Object $newsObj
     * @return void
     */
    public function showNews($is_user_loggedin)
    {
        return $this->newsDao->showNews($is_user_loggedin);
    }

    /**
     * Show News Detail
     *
     * @param int $id
     * @return void
     */
    public function showNewsDetail($id)
    {
        return $this->newsDao->showNewsDetail($id);
    }

    /**
     * Create News
     * @method createNews
     * @param  [Object] $newsObj
     * @return void
     */
    public function createNews($newsObj)
    {
        $this->newsDao->createNews($newsObj);
    }

    /**
     * update News
     * @method updateNews
     * @param  Object $newsObj
     * @param  int $id
     * @return void
     */
    public function updateNews($newsObj, $id)
    {
        return $this->newsDao->updateNews($newsObj, $id);
    }

    /**
     * Delete news by id
     * @method deleteNews
     * @param  int $id
     * @return void
     */
    public function deleteNews($id)
    {
        return $this->newsDao->deleteNews($id);
    }
}
