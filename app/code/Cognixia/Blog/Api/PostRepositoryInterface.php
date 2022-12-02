<?php

namespace Cognixia\Blog\Api;

interface PostRepositoryInterface
{
    /**
     * Get List of all Posts
     * 
     * @return object
     */
    public function getList();

    /**
     * @param in $id
     * @return mixed
     */
    public function getPost(int $id);
}
