@extends('layouts.default')
@section('title',$user->name)
@section('content')
<div class="row">
    <div class="offset-md-2 col-md-8">
        <!-- 用户个人信息 -->
        <section class="user_info">
            @include('shared._user_info', ['user' => $user])
        </section>
        <!-- 用户统计信息 -->
        <section class="stats mt-2">
            @include('shared._stats',['user'=>$user])
        </section>
        <hr>
        <!-- 用户微博动态 -->
        <section class="status">
            @if($statuses->count() > 0)
            <ul class="list-unstyled">
                @foreach($statuses as $status)
                @include('statuses._status')
                @endforeach
            </ul>
            <div class="mt-5">
                {!! $statuses->render() !!}
            </div>
            @else
            <p>没有数据！</p>
            @endif
        </section>
    </div>
</div>
@stop
