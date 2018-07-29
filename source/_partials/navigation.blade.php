<nav class="navbar" role="navigation">
    <div class="container">

        <div class="navbar-brand">
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start">

                <a href="/" class="navbar-item">Posts</a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Portfolio
                    </a>

                    <div class="navbar-dropdown">
                        @foreach ($portfolio as $item)
                            <a href="{{ $item->getUrl() }}" class="navbar-item">{{ $item->title }}</a>
                        @endforeach
                    </div>
                </div>


                <a href="/about" class="navbar-item">About</a>
            </div>
        </div>

    </div>
</nav>