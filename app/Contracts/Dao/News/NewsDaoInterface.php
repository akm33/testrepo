<?php

namespace App\Contracts\Dao\News;

interface NewsDaoInterface
{
    public function showNews($is_user_loggedin);
    public function showNewsDetail($id);
    public function createNews($newsObj);
    public function updateNews($newsObj, $id);
    public function deleteNews($id);
}
