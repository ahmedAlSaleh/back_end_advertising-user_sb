<?php

namespace App\Services;


use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\Trader;
use App\Traits\ApiResponse;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostService
{
    use ImageTrait, ApiResponse;

    public function create_post($request)
    {

        $trader = Auth::user();


        $post = Post::create([
            'title' => request('title'),
            'trader_id' => $trader->id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {


                $imagePath = $this->addImage($image, 'postImage');
                // create image


                Image::create([
                    'url' => $imagePath,
                    'related_id' => $post->id,
                    'related_type' => Post::class,
                ]);
            }
        }

        return $this->success($post->load('image'), 'Post created successfully', 201);
    }

    public function get_my_posts(Request $request)
    {

        $trader = Auth::user();
        // Get the number of posts per page from the request, default to 5
        $perPage = $request->input('per_page', 5);

        $page = $request->input('page', 1);
        // Paginate the posts belonging to the authenticated trader
        $posts = Post::where('trader_id', $trader->id)
            ->with([
                'likes',
                'image',
            ])
            ->paginate($perPage, ['*'], 'page', $page);

        // Append likes and dislikes count to each post
        $posts->each(function ($post) {
            $post->likes_count = $post->likesCount();
            $post->dislikes_count = $post->dislikesCount();
        });

        // Retrieve the trader's store information
        $traderWithStore = Trader::where('id', $trader->id)
            ->with('store') // Eager load store information
            ->first();
        // Format response with paginated posts and trader's store information
        return $this->success([
            "trader" => [
                "id" => $traderWithStore->id,
                "owner_contact_number" => $traderWithStore->owner_contact_number,
                "whatsapp_number" => $traderWithStore->whatsapp_number,
                "telegram_number" => $traderWithStore->telegram_number,
                "social_media_link" => $traderWithStore->social_media_link,
                "city" => $traderWithStore->city,
                "store" => $traderWithStore->store, // Include store information
                "posts" => $posts,  // Paginated posts
            ]
        ]);
    }


    public function delete_post($request)
    {
        $postId = $request;
        $trader = Auth::user();
        $post = Post::where('id', $postId)
            ->where('trader_id', $trader->id)
            ->first();

        if (!$post) {
            return $this->error('Post not found or unauthorized', 404);
        }
        $post->delete();
        return $this->success(null, 'Post deleted successfully');
    }

    public function likePost(Request $request, $postId)
    {
        $trader = $request->is_trader;
        $post = Post::findOrFail($postId);
        $user = Auth::user();



        if ($trader) {

            $like = Like::where('post_id', $post->id)->where('trader_id', $user->id)->first();
        } else {

            $like = Like::where('post_id', $post->id)->where('user_id', $user->id)->first();
        }


        if ($like) {

            $like->update([
                'like' => !$like->like,
                'dislike' => $like->dislike ? false : $like->dislike
            ]);
        } else {

            if ($trader) {
                Like::create([
                    'post_id' => $post->id,
                    'trader_id' => $user->id,
                    'like' => true,
                    'dislike' =>false

                ]);
            } else {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'like' => true,
                    'dislike' =>false
                ]);
            }
        }
        return $this->success([
            'likes' => $post->likesCount(),
            'dislikes' => $post->dislikesCount()
        ]);
    }

    public function dislikePost(Request $request, $postId)
    {
        $trader = $request->is_trader;
        $post = Post::findOrFail($postId);
        $user = Auth::user();

        if ($trader) {

            $like = Like::where('post_id', $post->id)->where('trader_id', $user->id)->first();
        } else {

            $like = Like::where('post_id', $post->id)->where('user_id', $user->id)->first();
        }

        if ($like) {

            $like->update([
                'dislike' => !$like->dislike,
                'like' => $like->like ? false : $like->like
            ]);
        } else {

            if ($trader) {
                Like::create([
                    'post_id' => $post->id,
                    'trader_id' => $user->id,
                    'dislike' => true,
                    'like' => false
                ]);
            } else {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'dislike' => true,
                    'like' => false
                ]);
            }
        }
        return $this->success([
            'likes' => $post->likesCount(),
            'dislikes' => $post->dislikesCount()
        ]);
    }
}
