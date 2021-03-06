@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">

            <img src="{{ $d->user->avatar }}" width="40px" height="40px">

            <span>{{ $d->user->name }}, <b>{{ $d->user->points }} exp</b></span>

            @if($d->hasBestAnswer())

                <span class="btn btn-success btn-xs pull-right btn-success">CLOSED</span>

            @else

                <span class="btn btn-success btn-xs pull-right btn-danger">OPEN</span>

            @endif



            @if(Auth::id() == $d->user->id )

                @if(!$d->hasBestAnswer())

                    <a href="{{ route('discussion.edit', ['slug' => $d->slug]) }}"
                       class="btn btn-info pull-right btn-xs" style="margin-right: 8px">Edit</a>

                @endif
            @endif



            @if($d->is_being_watched_by_auth_user())

                <a href="{{ route('discussion.unwatch', ['id' => $d->id]) }}"
                   class="btn btn-default pull-right btn-xs" style="margin-right: 8px">Unwatch</a>

            @else

                <a href="{{ route('discussion.watch', ['id' => $d->id]) }}" class="btn btn-default pull-right btn-xs"
                   style="margin-right: 8px">Watch</a>

            @endif

        </div>

        <div class="panel-body">

            <h4 class="text-center">

                {{ $d->title }}

            </h4>
            <hr>

            <p>{{ $d->content }}</p>

            <hr>

            @if($best_answer)

                <div class="text-center" style="padding: 40px">

                    <h3 class="text-center">BEST ANSWER</h3>

                    <div class="panel panel-success">

                        <div class="panel-heading">

                            <img src="{{ $best_answer->user->avatar }}" width="40px" height="40px">

                            <span>{{ $best_answer->user->name }} <b>{{ $best_answer->user->points }} exp</b></span>

                        </div>

                        <div class="panel-body">

                            {{ $best_answer->content }}

                        </div>

                    </div>

                </div>

            @endif

        </div>

        <div class="panel-footer">

            <span>

                   {{ $d->replies->count() }} replies

               </span>

            <a href="{{ route('channel', ['slug' => $d->channel->slug]) }}" class="pull-right btn btn-default btn-xs">
                {{ $d->channel->title }}
            </a>

        </div>

    </div>

    @foreach($d->replies as $r)

        <div class="panel panel-default">

            <div class="panel-heading">

                <img src="{{ $r->user->avatar }}" width="40px" height="40px">

                <span>{{ $r->user->name }}, <b>{{ $r->user->points }} exp</b></span>

                @if(!$best_answer)

                    @if(Auth::id() == $d->user->id)

                        <a href="{{ route('discussion.best.answer', ['id' => $r->id ]) }}"
                           class="btn btn-xs btn-info pull-right" style="margin-left: 8px">Mark as best answer</a>

                    @endif


                    @if(Auth::id() == $r->user->id)

                        @if(!$r->best_answer)

                            <a href="{{ route('reply.edit', ['id' => $r->id ]) }}"
                               class="btn btn-xs btn-info pull-right">Edit</a>

                        @endif

                    @endif

                @endif

            </div>

            <div class="panel-body">

                <p>{{ $r->content }}</p>

            </div>

            <div class="panel-footer">

                @if($r->is_liked_by_auth_user())

                    <a href="{{ route('reply.unlike', ['id' => $r->id ]) }}" class="btn btn-danger btn-xs">Unlike
                        <span class="badge">{{ $r->likes->count() }}</span></a>

                @else

                    <a href="{{ route('reply.like', ['id' => $r->id ]) }}" class="btn btn-success btn-xs">Like
                        <span class="badge">{{ $r->likes->count() }}</span></a>

                @endif

            </div>

        </div>

    @endforeach

    <div class="panel panel-default">

        <div class="panel-body">

            @if(Auth::check())

                <form action="{{ route('discussion.reply', ['id' => $d->id]) }}" method="post">

                    {{ csrf_field() }}

                    <div class="form-group">

                        <label for="reply">Leave a reply</label>

                        <textarea name="reply" id="reply" cols="30" rows="10" class="form-control"></textarea>

                    </div>

                    <div class="form-group">

                        <button class="btn pull-right" type="submit">Leave a reply</button>

                    </div>

                </form>

            @else

                <div class="text-center">

                    <h2>Sign in to leave a reply</h2>

                </div>

            @endif

        </div>

    </div>

@endsection
