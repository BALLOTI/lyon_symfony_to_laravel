<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;


/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{

    public function index(){

        return view('post.index', ['posts' => Post::all()]);

    }
    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:post|max:100',
            'description' => 'required|min:10',
        ], [
            'title.required' => 'Le titre est obligatoire',
            'title.min' => 'Le titre est trop courte',
            'description.required'  => 'La description est obligatoire',
            'description.min'  => 'La description est trop courte',
        ]);

        if ($validator->fails()) {
            return redirect()->route('post.create')
                ->withErrors($validator)
                ->withInput();
        }

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect()->route('post.index')->with('message', 'Votre post a bien été ajouté');

    }

    public function show(Post $id){
        dump($id->title);
        return view('post.new');

    }

    public function remove(Post $id){

      //  $id = Post::find($id);

        $id->delete();

        return redirect()->route('post.index')->with('message', 'Votre post a bien été supprimé');

    }

}
