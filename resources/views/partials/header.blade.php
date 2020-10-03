<button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
    <i class="cil-menu"></i>
</button>
<a class="c-header-brand d-lg-none c-header-brand-sm-up-center" href="#">
    <i class="full"></i>
</a>
<button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
    <i class="cil-menu"></i>
</button>


<ul class="c-header-nav d-md-down-none">
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Dashboard</a></li>
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li>
</ul>

<ul class="c-header-nav mfs-auto mr-5">
    <li class="c-header-nav-item dropdown d-md-down-none mx-2 show">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
            <i class="cil-bell"></i>
            @if(auth()->user()->unreadNotifications->count())
                <span class="badge badge-pill badge-danger">{{auth()->user()->unreadNotifications->count()}}</span>
            @endif
        </a>

        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
            <div class="dropdown-header bg-light">
                <strong>You have {{auth()->user()->unreadNotifications->count()}} unread notifications</strong>
            </div>
            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                @if($notification->unread())
                <a class="dropdown-item" href="{{route('admin.notifications.read',$notification)}}">
                    <strong>
                        {!!@$notification->data['icon']!!}
                        {!!$notification->data['message']!!}
                    </strong>
                </a>
                @else
                <a class="dropdown-item" href="{{route('admin.notifications.read',$notification)}}">
                    {!!@$notification->data['icon']!!}
                    {!!$notification->data['message']!!}
                </a>
                @endif
            @empty
            @endforelse
                <div class="dropdown-footer text-center bg-light">
                    <strong>
                        <a href="{{route('admin.notifications.read-all')}}" class="text-danger">
                            Clear all
                        </a>
                    </strong>
                </div>
            
        </div>
    </li>
</ul>