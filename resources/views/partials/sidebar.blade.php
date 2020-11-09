<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        <h3>{{strtoupper(config('app.name'))}}</h3>
    </div>
    <ul class="c-sidebar-nav ps ps--active-y">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link c-active" href="{{route('admin.index')}}">
                <i class="cil-speedometer c-sidebar-nav-icon"></i>
                Dashboard
            </a>
        </li>
        <li class="c-sidebar-nav-title">System</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('admin.sales.index')}}">
                <i class="cil-cart text-success c-sidebar-nav-icon"></i>
                 Sales
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('admin.users.index')}}">
                <i class="cil-user text-info c-sidebar-nav-icon"></i>
                 Users
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('admin.payments.index')}}"> 
                <i class="cil-money text-warning c-sidebar-nav-icon"></i>
                Payments
            </a>
        </li>
        <li class="c-sidebar-nav-title">
            Properties
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-label" href="{{route('admin.properties.index')}}"> 
                <i class="cil-apps-settings text-danger c-sidebar-nav-icon"></i>
                All properties
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-label" href="{{route('admin.properties.create')}}"> 
                <i class="cil-plus text-info c-sidebar-nav-icon"></i>
                Create property
            </a>
        </li>
        <li class="c-sidebar-nav-title">Plans</li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-label" href="{{route('admin.plans.index')}}"> 
                <i class="cil-apps-settings text-warning c-sidebar-nav-icon"></i>
                All plans
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-label" href="{{route('admin.plans.create')}}"> 
                <i class="cil-plus text-success c-sidebar-nav-icon"></i>
                Create plan
            </a>
        </li>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 780px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 469px;"></div></div>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-unfoldable"></button>
</div>