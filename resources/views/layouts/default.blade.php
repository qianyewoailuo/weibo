<!DOCTYPE html>
<html>

<head>
  <title>@yield('title','Weibo APP') - Laravel入门</title>
  <!-- <link rel="stylesheet" href="/css/app.css"> -->
  <link rel="stylesheet" href="/css/app.css">
  <!-- Laravel是以public文件夹为根目录的，因此我们可以使用下面这行代码来为Laravel引入样式 -->
  <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/">Weibo App</a>
      <!-- justify-content-end 末尾定位 -->
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
        <li class="nav-item"><a class="nav-link" href="#">登录</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div>
</body>

</html>
