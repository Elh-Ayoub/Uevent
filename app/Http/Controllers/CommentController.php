<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => ['required', 'string', 'max:500'],
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        if(!Event::find($id)){
            return back()->with('fail', 'Event not found!');
        }
        $comment = Comment::create([
            'author' => Auth::id(),
            'content' => $request->comment,
            'event_id' => $id,
        ]);
        if($comment){
            return back()->with('success', 'Commented in post successfully!');
        }else{
            return back()->with('fail', 'Something went wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:500'],
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        $comment = Comment::find($id);
        if(!$comment){
            return back()->with('fail', 'Comment requested not found!');
        }
        $comment->update(['content' => $request->content]);
        return back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Comment::find($id)){
            Comment::destroy($id);
            return back()->with('success', 'Comment deleted successfully!');
        }else{
            return back()->with('fail', 'Comment requested not found!');
        }
    }
}
