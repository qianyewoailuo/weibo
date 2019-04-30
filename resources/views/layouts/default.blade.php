<!DOCTYPE html>
<html>

<head>
  <title>@yield('title','Weibo APP') - Laravel入门</title>
  <!-- <link rel="stylesheet" href="/css/app.css"> -->
  <!-- <link rel="stylesheet" href="/css/app.css"> -->
  <!-- Laravel是以public文件夹为根目录的，因此我们可以使用下面这行代码来为Laravel引入样式 -->
  <!-- 注意这里必须要先重启npm watch-poll服务 -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
  @include('layouts._header')
  <div class="container">
    <div class="offset-md-1 col-md-10">
      @include('shared._messages')
      @yield('content')
      @include('layouts._footer')
    </div>
  </div>
</body>
  <script src="{{ mix('js/app.js') }}"></script>
</html>
