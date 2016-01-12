<!--BEGIN SIDEBAR MENU-->
<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
     data-position="right" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">

            <div class="clearfix"></div>
            <li class="{!! $active=='dashboard'?'active':'' !!}"><a href="{{url('/dashboard')}}"><i
                            class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Dashboard</span></a></li>
            <li class="{!! $active=='sign_contract'?'active':'' !!}"><a href="{{url('/dashboard/sign_contract')}}"><i
                            class="fa fa-pencil fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Sign Contract</span></a></li>
            <li class="{!! $active=='profile'?'active':'' !!}"><a href="{{url('/dashboard/profile')}}"><i
                            class="fa fa-user fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Profile</span></a></li>
        </ul>
    </div>
</nav>
<!--END SIDEBAR MENU-->