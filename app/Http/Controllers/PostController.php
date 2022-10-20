<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{

    public function newPost(Request $request)
    {
        $this->validate($request, [
            'subtitle' => 'nullable|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'event_id' => 'required|string',
        ]);
        $post = new Post;
        $post->subtitle = $request->subtitle;
        $post->event_id = $request->event_id;

        $imageUrl = request()->file('picture')->store('public/posts');
        $imageUrl = substr($imageUrl, 7);

        Image::configure(array('driver' => 'gd'));

        Image::make(storage_path('app/public/' . $imageUrl))
            ->heighten(512)
            ->save(storage_path('app/public/' . $imageUrl));

        $post->picture = $imageUrl;

        $post->save();


        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ])->status(201);
    }

    public function updatePost(Request $request) {
        $this->validate($request, [
            'id' => 'required|integer',
            'subtitle' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $post = Post::findOrFail($request->id);
        if ($request->has('subtitle')) {
            $post->subtitle = $request->subtitle;
        }
        if (request()->hasFile('picture')) {
            $imageUrl = request()->file('picture')->store('public/posts');
            $imageUrl = substr($imageUrl, 7);

            Image::configure(array('driver' => 'gd'));

            Image::make(storage_path('app/public/' . $imageUrl))
                ->heighten(512)
                ->save(storage_path('app/public/' . $imageUrl));

            $previousImage = $post->picture;
            //delete previous image
            if($previousImage != null){
                if(file_exists(storage_path('app/public/' . $previousImage))){
                    unlink(storage_path('app/public/' . $previousImage));
                }
            }

            $post->picture = $imageUrl;
        }
        $post->save();

        return response()->json(['success' => 'Post updated successfully'])->status(200);
    }

    public function getPosts(Request $request, $event)
    {
        $ev = Event::findOrFail($event);
        if($ev->public == false){
            if(Auth::check() == false){
                abort(404);
            }else{
                if(Auth::user()->isAdmin == false){
                    abort(404);
                }
            }
        }
        $posts = $ev->posts()->get()->toArray();
        return response()->json($posts);
    }

    public function deletePost($id) {

        $post = Post::findOrFail($id);
        // The Picture gets deleted in the Post Model automatically
        $post->delete();

        return response()->json(['success' => 'Post deleted successfully'])->status(200);
    }

}
