<?php
declare(strict_types=1);

namespace Controllers\Api\PostCategory;

use Models\Post\PostCategory;

class PostCategoriesApiController
{
    public function getAll()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(PostCategory::getAll(), JSON_UNESCAPED_UNICODE);
    }

    public function getByMainId($mainId)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(PostCategory::getByMainId($mainId), JSON_UNESCAPED_UNICODE);
    }
}
