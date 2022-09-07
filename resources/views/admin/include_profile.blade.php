<div class="card profile-widget">
    <div class="profile-widget-header">
        <img alt="image" src="{{ url('/image/user/'.$user->image) }}" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
            <div class="profile-widget-item">
                <div class="profile-widget-item-label"> {{__('Posts')}} </div>
                <div class="profile-widget-item-value"> {{ $post_count }} </div>
            </div>
            <div class="profile-widget-item cursor-pointer" data-toggle="modal" data-target="#followers-model">
                <div class="profile-widget-item-label"> {{__('Followers')}} </div>
                <div class="profile-widget-item-value"> {{ $user->followersCount }} </div>
            </div>
            <div class="profile-widget-item cursor-pointer" data-toggle="modal" data-target="#following-model">
                <div class="profile-widget-item-label"> {{__('Following')}} </div>
                <div class="profile-widget-item-value"> {{ $user->followingCount }} </div>
            </div>
        </div>
    </div>
    <div class="profile-widget-description">
        <a href="{{ url('/admin/user/'.$user->id) }}">
            <div class="profile-widget-name"> {{ $user->name }}
                <div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div> {{ '@'.$user->user_id }}
                </div>
            </div>
        </a>
        <div class="mb-3">
            {{ $user->bio }}
        </div>
        <div class="badges">
            @if ($user->email != NULL)
                <span class="badge badge-gray">  {{$user->email}} </span>
            @else
                <span class="badge badge-danger"> {{$user->email}} </span>
            @endif
            
            @if ($user->is_verify == 1)
                <span class="badge badge-gray"> {{__('Verified')}} </span>
            @else
                <span class="badge badge-danger"> {{__('Unverified')}} </span>
            @endif

            @if ($user->follower_request == 1)
                <span class="badge badge-gray"> {{__('Private')}} </span>
            @else
                <span class="badge badge-gray"> {{__('Public')}} </span>
            @endif
            
            
            @if ($user->report > 0)
                @if ($user->report >= 1 && $user->report < 10)
                    <span class="badge badge-gray"> {{__('Report User :')}} {{$user->report}} {{__('Times')}} </span>
                @else
                    <span class="badge badge-danger"> {{__('Report User :')}} {{$user->report}} {{__('Times')}} </span>
                @endif
            @endif

            @if ($user->gender != null)
                <span class="badge badge-gray"> {{__('Gender :')}} {{$user->gender}} </span>
            @endif

            @if ($user->phone != null)
                <span class="badge badge-gray"> {{__('Phone :')}} {{$user->code}}{{$user->phone}} </span>
            @endif

            @if ($user->bdate != null)
                <span class="badge badge-gray"> {{__('Birthdate :')}} {{$user->bdate}} </span>
            @endif

        </div>
    </div>
</div>
 
<div class="modal fade model-1" tabindex="-1" role="dialog" id="followers-model" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{$user->user_id."'s"}} {{__('Followers')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled list-unstyled-border">
                    @if (count($user->followers) == 0)
                        <div class="empty-state col-12">
                            <div class="empty-state-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <h2> {{__('There are no followers.')}} </h2>
                        </div>
                    @else
                        @foreach ($user->followers as $item)
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$item->image) }}" alt="avatar">
                                <div class="media-body">
                                    <h6 class="media-title"><a href="{{ url('/admin/user/'.$item->id) }}"> {{ $item->name }} </a></h6>
                                    <div class="text-small text-muted"> {{ $item->user_id }} </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade model-1" tabindex="-1" role="dialog" id="following-model" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{$user->user_id."'s"}} {{__('Following')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled list-unstyled-border">
                    @if (count($user->followings) == 0)
                        <div class="empty-state col-12">
                            <div class="empty-state-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <h2> {{__('There are no Following.')}} </h2>
                        </div>
                    @else
                        @foreach ($user->followings as $item)
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$item->image) }}" alt="avatar">
                                <div class="media-body">
                                    <h6 class="media-title"><a href="{{ url('/admin/user/'.$item->id) }}"> {{ $item->name }} </a></h6>
                                    <div class="text-small text-muted"> {{ $item->user_id }} </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>