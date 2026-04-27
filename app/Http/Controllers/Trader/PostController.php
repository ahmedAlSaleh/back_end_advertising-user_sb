<?php
namespace App\Http\Controllers\Trader;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Services\PostService;
use Illuminate\Http\Request;


class PostController extends Controller {

    protected  $postservise;

    public function __construct(PostService $postService)
    {
        $this->postservise = $postService;
    }

        public function create_post(PostRequest $request)
        {
            $res = $this->postservise->create_post($request);
            return $res ;
        }
    public function get_my_posts(Request $request)
    {
        $res = $this->postservise->get_my_posts($request);
        return $res ;
    }
    public function delete_post($request)
    {
        $res = $this->postservise->delete_post($request);
        return $res ;
    }
    public function likePost(Request $request , $postId)
    {
        $res = $this->postservise->likePost($request  , $postId);
        return $res ;
    }
    public function dislikePost(Request $request , $postId)
    {
        $res = $this->postservise->dislikePost($request  , $postId);;
        return $res ;
    }

}

