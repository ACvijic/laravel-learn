<!-- BEGIN: HEADER -->
<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
    <div class="c-navbar">
        <div class="container">
            <!-- BEGIN: BRAND -->
            <div class="c-navbar-wrapper clearfix">
                <div class="c-brand c-pull-left">
                    <a href="index.html" class="c-logo">
                        <img src="https://cubes.edu.rs/skins/frontend/images/logo.png" alt="CUBES" class="c-desktop-logo">
                        <img src="https://cubes.edu.rs/skins/frontend/images/logo.png" alt="CUBES" class="c-desktop-logo-inverse">
                        <img src="https://cubes.edu.rs/skins/frontend/images/logo.png" alt="CUBES" class="c-mobile-logo"> </a>
                    <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                    </button>
                    <button class="c-topbar-toggler" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <button class="c-search-toggler" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <!-- END: BRAND -->
                <!-- BEGIN: QUICK SEARCH -->
                <form class="c-quick-search" action="#">
                    <input type="text" name="query" placeholder="Type to search..." value="" class="form-control" autocomplete="off">
                    <span class="c-theme-link">&times;</span>
                </form>
                <!-- END: QUICK SEARCH -->
                <!-- BEGIN: HOR NAV -->
                <!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- BEGIN: MEGA MENU -->
                <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
                <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                    <ul class="nav navbar-nav c-theme-nav">
                        @if(count($menusHeader) > 0)
                            @foreach($menusHeader as $value)
                            <li class="c-menu-type-classic">
                                <a href="{{ $value->getSlugEasier() }}" @if($value->type == 'external-link') target='_blank' @endif class="c-link @if(count($value->submenus) > 0) dropdown-toggle @endif">
                                   {{ $value->title }}
                                   @if(count($value->submenus) > 0)
                                   <span class="c-arrow c-toggler"></span>
                                   @endif
                                </a>
                                @if(count($value->submenus) > 0)
                                <ul class="dropdown-menu c-menu-type-classic c-pull-left">
                                    @foreach($value->submenus as $value)
                                    <li class="dropdown-submenu">
                                        <a href="{{ $value->getSlugEasier() }}" @if($value->type == 'external-link') target='_blank' @endif>
                                            {{ $value->title }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        @endif
                        <li class="c-search-toggler-wrapper">
                            <a href="#" class="c-btn-icon c-search-toggler">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- END: MEGA MENU -->
                <!-- END: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- END: HOR NAV -->
            </div>
        </div>
    </div>
</header>
<!-- END: HEADER -->
