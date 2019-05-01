@extends('layouts.default')
@section('title', '所有用户')

@section('content')
<div class="offset-md-2 col-md-8">
    <h2 class="mb-4 text-center">所有用户</h2>
    <!-- 用户列表 -->
    <div class="list-group list-group-flush">
        @foreach ($users as $user)
        @include('users._user')
        @endforeach
    </div>
    <!-- 分页 -->
    <div class="mt-3">
        {!! $users->render() !!}
    </div>
</div>
@stop
