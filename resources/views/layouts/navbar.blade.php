<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline {{ session()->has('direction')&& session('direction') == 'rtl'? 'ml-auto':'mr-auto'}}">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </form>
    
    <?php
        $langs = \App\Models\AdminLanguage::where('status', 1)->get();
        $icon = \App\Models\AdminLanguage::where('name', session('locale'))->first();
        if ($icon) {
        $lang_image = '/image/app/' . $icon->image;
        } else {
        $lang_image = '/image/app/English.jpg';
        }
    ?>
    <ul class="navbar-nav align-items-center mr-2">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <div class="align-items-center">
                    <span class="avatar1">
                        <img class="small_round flag" src="{{ asset($lang_image) }}">
                    </span>
                </div>
            </a>
            <div class="dropdown-menu  dropdown-menu-right dropdown-menu-flag ">
                <div class="dropdown-title">{{__('Language')}}</div>
                @foreach ($langs as $lang)
                    <a href="{{ url('/admin/settings/language/' . $lang->name) }}" class="dropdown-item py-3">
                        <span class="avatar1">
                            <img class="small_round flag rtl-float" src="{{ asset('image/app/' . $lang->image) }}">
                        </span>
                        <span>{{ $lang->name }}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </ul>
    <ul class="navbar-nav navbar-right">
        
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('image/user/'.Auth::user()->image) }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">{{__('Hi,')}} {{Auth::user()->name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{__('Logged in')}} {{ Carbon\Carbon::parse(Auth::user()->last_login)->diffForHumans() }} </div>
                
                <a href="{{ url('/admin/profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{__('Profile')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{url('/admin/logout')}}" class="dropdown-item has-icon text-danger" 
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{__('Logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>