<!-- 社交统计信息:关注 粉丝 微博数等局部视图 -->
<a href="#">
    <strong id="following" class="stats">
        {{ count($user->followings) }}
    </strong>
    关注
</a>
<a href="#">
    <strong id="followers" class="stats">
        {{ count($user->followers) }}
    </strong>
    粉丝
</a>
<a href="#">
    <strong id="statuses" class="stats">
        {{ $user->statuses()->count() }}
    </strong>
    微博
</a>
