<div class="page-header">
    <div class="header-wrapper row m-0">
        <form class="form-inline search-full col" action="#" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper">
                <a href="{{ route('home') }}">
                    {{-- <img class="img-fluid" src="../assets/images/logo/logo.png" alt=""> --}}
                    {{ config('app.name', 'Vascomm') }}
                </a>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="left-header col horizontal-wrapper ps-0">
        </div>
        <div class="nav-right col-8 pull-right right-header p-0">
            <ul class="nav-menus">
                {{-- <li><span class="header-search"><i data-feather="search"></i></span></li> --}}
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"> </i><span class="badge rounded-pill badge-secondary">4 </span></div>
                    <div class="onhover-show-div notification-dropdown">
                        <h6 class="f-18 mb-0 dropdown-title">Notitications</h6>
                        <ul>
                            <li class="b-l-primary border-4">
                                <p>Delivery processing <span class="font-danger">10 min.</span></p>
                            </li>
                            <li class="b-l-success border-4">
                                <p>Order Complete<span class="font-success">1 hr</span></p>
                            </li>
                            <li class="b-l-info border-4">
                                <p>Tickets Generated<span class="font-info">3 hr</span></p>
                            </li>
                            <li class="b-l-warning border-4">
                                <p>Delivery Complete<span class="font-warning">6 hr</span></p>
                            </li>
                            <li>
                                <a class="f-w-700" href="#">Check all</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="onhover-dropdown">
                    <i data-feather="message-square"></i>
                    <div class="chat-dropdown onhover-show-div">
                        <h6 class="f-18 mb-0 dropdown-title">Messages</h6>
                        <ul class="py-0">
                            <li>
                                <div class="media">
                                    <img class="img-fluid b-r-5 me-2" src="../assets/images/user/1.jpg" alt="">
                                    <div class="media-body">
                                        <h6>Teressa</h6>
                                        <p>Reference site about Lorem Ipsum, give information on its origins.</p>
                                        <p class="f-8 font-primary mb-0">3 hours ago</p>
                                    </div>
                                    <span class="badge rounded-circle badge-primary">2</span>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="img-fluid b-r-5 me-2" src="../assets/images/user/2.jpg" alt="">
                                    <div class="media-body">
                                        <h6>Kori Thomas</h6>
                                        <p>Lorem Ipsum is simply dummy give information on its origins....</p>
                                        <p class="f-8 font-primary mb-0">1 hr ago</p>
                                    </div>
                                    <span class="badge rounded-circle badge-primary">2</span>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="img-fluid b-r-5 me-2" src="../assets/images/user/14.png" alt="">
                                    <div class="media-body">
                                        <h6>Ain Chavez</h6>
                                        <p>Lorem Ipsum is simply dummy...</p>
                                        <p class="f-8 font-primary mb-0">32 mins ago</p>
                                    </div>
                                    <span class="badge rounded-circle badge-primary">2</span>
                                </div>
                            </li>
                            <li class="text-center"> <a class="f-w-700" href="#">View All     </a></li>
                        </ul>
                    </div>
                </li>
                <li class="maximize">
                    <a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a>
                </li>
                <li class="profile-nav onhover-dropdown p-0 me-0">
                    <div class="media profile-media">
                        <img class="b-r-10" src="../assets/images/dashboard/profile.jpg" alt="">
                        <div class="media-body">
                            <span>{{ Auth::user()->name }}</span>
                            <p class="mb-0 font-roboto">
                                {{ auth()->user()->getRoleNames()[0] }} <i class="middle fa fa-angle-down"></i>
                            </p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="#"><i data-feather="user"></i><span>Account </span></a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i data-feather="log-out"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
                <div class="ProfileCard-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                </div>
                <div class="ProfileCard-details">
                    <div class="ProfileCard-realName">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </script>
        <script class="empty-template" type="text/x-handlebars-template">
            <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
        </script>
    </div>
</div>