<div class="widget recent-posts">
    <h2 class="title">Recent posts</h2>
    <ul>
        @foreach ($posts->take(5) as $post)
            <li>
                <a href="{{ $post->getUrl() }}">
                    {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>