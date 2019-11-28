<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Discussion;
use Session;
use App\Reply;
use Notification;
use Illuminate\Http\Request;

class DiscussionsController extends Controller
{

    public function create()
    {

        return view('discuss');

    }

    public function store()
    {

        $this->validate(request(), [

            'channel_id' => 'required',

            'title' => 'required',

            'content' => 'required'
        ]);

        $discussion=Discussion::create([

            'title' => request()->title,

            'content' => request()->content,

            'channel_id' => request()->channel_id,

            'user_id' => Auth::id(),

            'slug' => str_slug(request()->title),

        ]);

        Session::flash('success', 'Discussion created successfully');

        return redirect()->route('discussion', ['slug' => $discussion->slug]);

    }

    public function show($slug)
    {

        $discussion = Discussion::where('slug', $slug)->first();

        $best_answer = $discussion->replies()->where('best_answer', 1)->first();

        return view('discussions.show')->with('d', $discussion)->with('best_answer', $best_answer);

    }

    public function reply($id)
    {

        $d = Discussion::find($id);

        $this->validate(request(), [

            'reply' => 'required'

        ]);

        $reply = Reply::create([

            'user_id' => Auth::id(),

            'discussion_id' => $id,

            'content' => request()->reply

        ]);

        $reply->user->pounts += 25;

        $reply->save();


        $watchers = array();

        foreach ($d->watchers as $watcher):

            array_push($watchers, User::find($watcher->user_id));

        endforeach;

        Notification::send($watchers, new \App\Notifications\NewReplyAdded($d));


        Session::flash('success', 'Replied to discussion');

        return redirect()->back();

    }


    public function edit($slug)
    {

        return view('discussions.edit', ['discussion' => Discussion::where('slug', $slug)->first()]);

    }

    public function update($id)
    {

        $this->validate(request(), [

            'content' => 'required'

        ]);

        $d = Discussion::find($id);

        $d->content = request()->content;

        $d->save();

        Session::flash('success', 'Discussion updated');

        return redirect()->route('discussion', ['slug' => $d->slug]);

    }


}
