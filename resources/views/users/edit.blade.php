@extends('layouts.default')
@section('title','更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>更新个人资料</h5>
    </div>
    <div class="card-body">

      @include('shared._errors')

      <div class="gravatar_edit">
        <a href="http://gravatar.com/emails" target="_blank">
          <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" class="gravatar" />
        </a>
      </div>

      <form method="POST" action="{{ route('users.update', $user->id )}}">
        <!-- 因为要使用PATCH动作更新资源,需要添加一个隐藏域伪造PATCH请求,转码后为 -->
        {{ method_field('PATCH') }}
        <!-- 转码后为 <input type="hidden" name="_method" value="PATCH"> -->
        {{ csrf_field() }}

        <div class="form-group">
          <label for="name">名称：</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}">
        </div>

        <div class="form-group">
          <label for="email">邮箱：</label>
          <!-- 邮箱不能修改 disabled -->
          <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
          <label for="password">密码：</label>
          <input type="password" name="password" class="form-control" value="{{ old('password') }}">
        </div>

        <div class="form-group">
          <label for="password_confirmation">确认密码：</label>
          <!-- 使用comfirmed验证规则时,这里的确认密码名称为password_confirmation -->
          <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
      </form>
    </div>
  </div>
</div>
@stop
