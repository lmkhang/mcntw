<!--BEGIN SIDEBAR MENU-->
<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
     data-position="right" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">

            <div class="clearfix"></div>
            <li class="{!! $active=='home'?'active':'' !!}"><a href="{{url('/adminntw')}}"><i
                            class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Dashboard</span></a></li>
            <li class="{!! $active=='profile'?'active':'' !!}"><a href="{{url('/adminntw/profile')}}"><i
                            class="fa fa-user fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Profile</span></a></li>
            <li class="{!! $active=='channels'?'active':'' !!}"><a href="{{url('/adminntw/channels')}}"><i
                            class="fa fa-desktop fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Channel Management</span></a></li>
        </ul>
    </div>
</nav>
<!--END SIDEBAR MENU-->