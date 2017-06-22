<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Auth;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{

    public function create(Request $request){


        $post = new Comment();
        $post->content = $request->content;
        $post->post_id = $request->post_id;
        $post->user_id = Auth::user()->id;
        $post->save();

        return redirect()->route('post.index')->with('message', 'Votre commentaire a bien été ajouté');

    }

    public function remove(Comment $id){

        $id->delete();

        return redirect()->route('post.index')->with('message', 'Votre commentaire a bien été supprimé');

    }
}
