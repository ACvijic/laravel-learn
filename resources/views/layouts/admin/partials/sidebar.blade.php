<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="#"><i class="fa fa-tasks fa-fw"></i> Menus<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('menus-list') }}">Preview all</a>
                    </li>
                    <li>
                        <a href="{{ route('menus-create') }}">New menu item</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"><i class="fa fa-font fa-fw"></i> News<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('news-list', $defaultLanguage->id) }}">Preview all</a>
                    </li>
                    <li>
                        <a href="{{ route('news-create') }}">New news article</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"><i class="fa  fa-folder-open  fa-fw"></i> Posts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('posts-list') }}">Preview all</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"><i class="fa fa-tags fa-fw"></i> Product categories<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('product-categories-list') }}">Preview all</a>
                    </li>
                    <li>
                        <a href="{{ route('product-categories-create') }}">New product category</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Products<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products-list') }}">Preview all</a>
                    </li>
                    <li>
                        <a href="{{ route('products-create') }}">New product</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"><i class="fa fa-comments-o fa-fw"></i> Comments<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('comments-list') }}">Preview all</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"><i class="fa fa-file-text fa-fw"></i> Pages<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('pages-list') }}">Preview all</a>
                    </li>
                    <li>
                        <a href="{{ route('pages-create') }}">New page</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            @if(auth()->check() && auth()->user()->role == \App\User::ROLE_ADMINISTRATOR)
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Admin users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('users-list') }}">Preview all</a>
                    </li>
                    <li>
                        <a href="{{ route('users-create') }}">New user</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            @endif
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
