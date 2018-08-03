<?php

namespace App\Contracts\Services\News;

interface NewsServiceInterface
{
    public function showNews($is_user_loggedin);
    public function showNewsDetail($id);
    public function createNews($newsObj);
    public function updateNews($newsObj, $id);
    public function deleteNews($id);
}
