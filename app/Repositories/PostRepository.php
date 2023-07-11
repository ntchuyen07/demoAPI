<?php

namespace App\Repositories;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface 
{
    private Post $post;
    public function __construct(Post $post) 
    {
        $this->post = $post;
    }

    public function getAllPost()
    {
        return $this->post->all();
    }

    public function getPostById($postId)
    {
        return $this->post->findOrFail($postId);
    }

    public function getPublishedPosts()
    {
        return $this->post->where('is_published', true)->get();
    }

    public function createPost(StorePostRequest $storePostRequest)
    {
        return $this->post->create($storePostRequest->toArray());
    }

    public function updatePost($postId, UpdatePostRequest $updatePostRequest)
    {
        $post = $this->post->find($postId);
        if($post) {
            $post->update($updatePostRequest->toArray());
        }
    }


    public function deletePost($postId)
    {
        $this->post->destroy($postId);
    }
}