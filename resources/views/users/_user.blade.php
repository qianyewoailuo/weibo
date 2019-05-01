<div class="list-group-item">
  <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width=32>
  <a href="{{ route('users.show', $user) }}">
    {{ $user->name }}
  </a>

  <!-- 模板中使用删除策略授权 -->
  @can('destroy',$user)
  <form action="{{route('users.destroy',$user->id)}}" method="post" class="float-right">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <button type="submit" class="btn btn-sm badge-danger delete-btn">删除</button>
  </form>
  @endcan
</div>