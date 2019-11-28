@extends('layouts.app')

@section('content')

    @foreach($discussions as $d)

        <div class="panel panel-default">

            <div class="panel-heading">

                <img src="{{ $d->user->avatar }}" width="40px" height="40px">

                <span>{{ $d->user->name }}, <b>{{ $d->created_at->diffForHumans() }}</b></span>


                @if($d->hasBestAnswer())

                    <span class="btn btn-success btn-xs pull-right btn-success">CLOSED</span>

                @else

                    <span class="btn btn-success btn-xs pull-right btn-danger">OPEN</span>

                @endif

                <a href="{{ route('discussion', ['slug' => $d->slug]) }}" class="btn btn-default btn-xs pull-right"
                   style="margin-right: 8px">Read</a>

            </div>

            <div class="panel-body">

                <h4 class="text-center">

                    {{ $d->title }}

                </h4>

                <p>{{ str_limit($d->content, 200) }}</p>

            </div>

            <div class="panel-footer">

               <span>

                   {{ $d->replies->count() }} replies

               </span>

                <a href="{{ route('channel', ['slug' => $d->channel->slug]) }}"
                   class="pull-right btn btn-default btn-xs">
                    {{ $d->channel->title }}
                </a>

            </div>

        </div>

    @endforeach

    <div class="text-center">

        {{ $discussions->links() }}

    </div>

@endsection
