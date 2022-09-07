<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            @php
                $color_logo = \App\Models\Setting::first()->color_logo;
            @endphp
            <a href="{{ url('/admin/dashboard') }}">
                <img src="{{ asset('image/app/'.$color_logo) }}" alt="logo" width="80"
                  class="mb-5 mt-2">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/admin/dashboard') }}">
              <img src="{{ asset('image/app/'.$color_logo) }}" alt="logo" width="50"
                  class="mb-5 mt-2">
            </a>
        </div>
            <!-- sidebar menu -->
            <ul class="sidebar-menu mt-5">
                <!-- menu item -->
                
                <!-- Dahboard -->
                @can('admin_dashboard')
                    <li class="{{ request()->is('admin/dashboard*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/dashboard') }}"><i class="fas fa-chart-bar"></i><span> {{__('Dashboard')}} </span></a>
                    </li>
                @endcan

                <!-- Role -->
                @if(auth()->user()->can('role_access') && auth()->user()->can('role_create'))
                    <li class="dropdown {{ request()->is('admin/role*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-secret"></i><span> {{__('Roles')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/role')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/role') }}"> {{__('Roles')}} </a></li>
                            <li class="{{ request()->is('admin/role/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/role/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('role_access'))
                    <li class="{{ request()->is('admin/role*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/role') }}"><i class="fas fa-user-secret"></i><span> {{__('Roles')}} </span></a>
                    </li>
                @endif
                
                <!-- Admin User -->
                @if(auth()->user()->can('admin_user_access') && auth()->user()->can('admin_user_create'))
                    <li class="dropdown {{ request()->is('admin/admin-user*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i><span> {{__('Admin User')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/admin-user')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/admin-user') }}"> {{__('Admin Users')}} </a></li>
                            @can('admin_user_create')
                                <li class="{{ request()->is('admin/admin-user/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/admin-user/create') }}"> {{__('Create New')}} </a></li>
                            @endcan
                        </ul>
                    </li>
                @elseif(auth()->user()->can('admin_user_access'))
                    <li class="{{ request()->is('admin/admin-user*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/admin-user') }}"><i class="fas fa-user"></i><span> {{__('Admin User')}} </span></a>
                    </li>
                @endif
                
                <!-- App User -->
                @if(auth()->user()->can('app_user_access') && auth()->user()->can('app_user_report_access'))
                    <li class="dropdown {{ request()->is('admin/user*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i><span> {{__('User')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/user')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/user') }}"> {{__('Users')}} </a></li>
                             <li class="{{ request()->is('admin/user/reports')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/user/reports') }}"> {{__('Reports')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('app_user_access'))
                    <li class="{{ request()->is('admin/user*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/user') }}"><i class="fas fa-users"></i><span> {{__('User')}} </span></a>
                    </li>
                @elseif(auth()->user()->can('app_user_report_access'))
                    <li class="{{ request()->is('admin/user/reports*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/user/reports') }}"><i class="fas fa-users"></i><span> {{__("Reported Users")}} </span></a>
                    </li>
                @endif
                
                <!-- Banner -->
                @if(auth()->user()->can('banner_access') && auth()->user()->can('banner_create'))
                    <li class="dropdown {{ request()->is('admin/banner*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-image"></i><span> {{__('Banners')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/banner')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/banner') }}"> {{__('Banners')}} </a></li>
                            <li class="{{ request()->is('admin/banner/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/banner/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('banner_access'))
                    <li class="{{ request()->is('admin/banner*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/banner') }}"><i class="fas fa-image"></i><span> {{__('Banners')}} </span></a>
                    </li>
                @endif
                
                <!-- Challenge -->
                @if(auth()->user()->can('challenge_access') && auth()->user()->can('challenge_create'))
                    <li class="dropdown {{ request()->is('admin/challenge*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-hashtag"></i><span> {{__('Challenges')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/challenge')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/challenge') }}"> {{__('Challenges')}} </a></li>
                            <li class="{{ request()->is('admin/challenge/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/challenge/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('challenge_access'))
                    <li class="{{ request()->is('admin/challenge*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/challenge') }}"><i class="fas fa-hashtag"></i><span> {{__('Challenges')}} </span></a>
                    </li>
                @endif
                
                <!-- Song Section -->
                @if(auth()->user()->can('song_section_access') && auth()->user()->can('song_section_create'))
                    <li class="dropdown {{ request()->is('admin/song_section*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-list-alt"></i><span> {{__('Song Sections')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/song_section')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/song_section') }}"> {{__('Song Sections')}} </a></li>
                            <li class="{{ request()->is('admin/song_section/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/song_section/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('song_section_access'))
                    <li class="{{ request()->is('admin/song_section*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/song_section') }}"><i class="fas fa-hashtag"></i><span> {{__('Song Sections')}} </span></a>
                    </li>
                @endif

                <!-- Songs -->
                @if(auth()->user()->can('song_access') && auth()->user()->can('song_create'))
                    <li class="dropdown {{ request()->is('admin/songs*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-music"></i><span> {{__('Songs')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/songs')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/songs') }}"> {{__('Songs')}} </a></li>
                            <li class="{{ request()->is('admin/songs/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/songs/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('song_access'))
                    <li class="{{ request()->is('admin/songs*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/songs') }}"><i class="fas fa-music"></i><span> {{__('Songs')}} </span></a>
                    </li>
                @endif
               
                <!-- Video -->
                @if(auth()->user()->can('video_access') && auth()->user()->can('video_report_access') && auth()->user()->can('video_edit')
                || auth()->user()->can('video_access') && auth()->user()->can('video_report_access')
                || auth()->user()->can('video_report_access') && auth()->user()->can('video_edit')
                || auth()->user()->can('video_access') && auth()->user()->can('video_edit'))
                    <li class="dropdown {{ request()->is('admin/video*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-video"></i><span> {{__('Videos')}} </span></a>
                        <ul class="dropdown-menu">
                            
                            @can('video_access')
                                <li class="{{ request()->is('admin/video')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/video') }}"> {{__('Videos')}} </a></li>
                            @endcan
                            
                            @can('video_report_access')
                                <li class="{{ request()->is('admin/video/reports')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/video/reports') }}"> {{__('Reports')}} </a></li>
                            @endcan
                            
                            @can('video_edit')
                                <li class="{{ request()->is('admin/video/unapproved')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/video/unapproved') }}"> {{__('Unapproved Video')}} </a></li>
                            @endcan
                        </ul>
                    </li>
                @elseif(auth()->user()->can('video_access'))
                    <li class="{{ request()->is('admin/video*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/video') }}"><i class="fas fa-video"></i><span> {{__('Videos')}} </span></a>
                    </li>
                @elseif(auth()->user()->can('video_report_access'))
                    <li class="{{ request()->is('admin/video*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/video/reports') }}"><i class="fas fa-video"></i><span> {{__("Reported Videos")}} </span></a>
                    </li>
                @endif

                <!-- Report Reasons -->
                @if(auth()->user()->can('report_reason_access') && auth()->user()->can('report_reason_create'))
                    <li class="dropdown {{ request()->is('admin/report-reason*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-flag"></i><span> {{__('Report Reasons')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/report-reason')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/report-reason') }}"> {{__('Report Reasons')}} </a></li>
                            <li class="{{ request()->is('admin/report-reason/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/report-reason/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('report_reason_access'))
                    <li class="{{ request()->is('admin/report-reason*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/report-reason') }}"><i class="fas fa-flag"></i><span> {{__('Report Reasons')}} </span></a>
                    </li>
                @endif
                
                <!-- Report Reasons -->
                @if(auth()->user()->can('comment_access') && auth()->user()->can('comment_report_access'))
                    <li class="dropdown {{ request()->is('admin/comment*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-comment"></i><span> {{__('Comments')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/comment')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/comment') }}"> {{__('Comments')}} </a></li>
                            @can('comment_report_access')
                                <li class="{{ request()->is('admin/comment/reports')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/comment/reports') }}"> {{__('Reports')}} </a></li>
                            @endcan
                        </ul>
                    </li>
                @elseif(auth()->user()->can('comment_access'))
                    <li class="{{ request()->is('admin/comment*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/comment') }}"><i class="fas fa-comment"></i><span> {{__('Comments')}} </span></a>
                    </li>
                @elseif(auth()->user()->can('comment_report_access'))
                    <li class="{{ request()->is('admin/comment*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/comment/reports') }}"><i class="fas fa-comment"></i><span> {{__("Reported Comments")}} </span></a>
                    </li>
                @endif
                
                <!-- Language -->
                @if(auth()->user()->can('language_access') && auth()->user()->can('language_create'))
                    <li class="dropdown {{ request()->is('admin/language*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-language"></i><span> {{__('Languages')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/language')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/language') }}"> {{__('Languages')}} </a></li>
                            <li class="{{ request()->is('admin/language/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/language/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('language_access'))
                    <li class="{{ request()->is('admin/language*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/language') }}"><i class="fas fa-language"></i><span> {{__('Languages')}} </span></a>
                    </li>
                @endif
                
                <!-- Advertisements -->
                @if(auth()->user()->can('advertisement_access') && auth()->user()->can('advertisement_create'))
                    <li class="dropdown {{ request()->is('admin/advertisements*')  ? 'active' : ''}}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-ad"></i><span> {{__('Advertisements')}} </span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('admin/advertisements')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/advertisements') }}"> {{__('Advertisements')}} </a></li>
                            <li class="{{ request()->is('admin/advertisements/create')  ? 'active' : ''}}" ><a class="nav-link" href="{{ url('/admin/advertisements/create') }}"> {{__('Create New')}} </a></li>
                        </ul>
                    </li>
                @elseif(auth()->user()->can('advertisement_access'))
                    <li class="{{ request()->is('admin/advertisements*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/advertisements') }}"><i class="fas fa-flag"></i><span> {{__('Advertisements')}} </span></a>
                    </li>
                @endif
                
                @can('user_problem_access')
                    <li class="{{ request()->is('admin/problem_report*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/problem_report') }}"><i class="fas fa-question"></i><span> {{__('User Problems')}} </span></a>
                    </li>
                @endcan 

                @can('report_access')
                    <li class="{{ request()->is('admin/report*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/report') }}"><i class="fas fa-file"></i><span> {{__('Report')}} </span></a>
                    </li>
                @endcan
                
                
                @can('notification_access')
                    <li class="{{ request()->is('admin/notification*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/notification') }}"><i class="fas fa-bell"></i><span> {{__('Notification Template')}} </span></a>
                    </li>
                @endcan
                
                
                @can('settings_access')
                    <li class="{{ request()->is('admin/privacy*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/privacy') }}"><i class="fas fa-shield-alt"></i><span> {{__('Policy & Terms')}} </span></a>
                    </li>
                @endcan

                
                @can('settings_access')
                    <li class="{{ request()->is('admin/settings*')  ? 'active' : ''}}">
                        <a href="{{ url('/admin/settings') }}"><i class="fas fa-cog"></i><span> {{__('Settings')}} </span></a>
                    </li>
                @endcan

          </ul>
    </aside>
</div>
