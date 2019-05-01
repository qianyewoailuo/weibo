<!-- 单条微博动态数据 -->
<li class="media mt-4 mb-4">
    <a href="{{route('users.show',$user->id)}}">
        <img src="{{$user->gravatar()}}" alt="{{$user->name}}" class="mr-3 gravatar" />
    </a>
    <div class="media-body">
        <!-- diffForHumans是日期友好处理 -->
        <h5 class="mt-0 mb-1">{{$user->name}} <small> / {{$status->created_at->diffForHumans()}}</small></h5>
        {{$status->content}}
    </div>
    <!-- 添加删除按键 -->
    @can('destroy',$status)
        <form action="{{ route('statuses.destroy',$status->id) }}" method="POST" onsubmit="return confirm('确定要删除吗?')">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger">删除</button>
            <!-- <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('你确定要删除吗')">删除</button> -->
        </form>
    @endcan
</li>


