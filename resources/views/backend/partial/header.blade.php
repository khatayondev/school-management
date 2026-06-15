@php
    $words = explode(" ", auth()->user()->name);
    $initials = "";
    foreach ($words as $w) {
        $initials .= substr($w, 0, 1);
    }
    $initials = strtoupper(substr($initials, 0, 3));
    if (empty($initials)) {
        $initials = "DKA";
    }
@endphp
<header class="main-header" style="background: #ffffff; border-bottom: 1px solid rgba(11, 94, 215, 0.06); height: 64px !important;">
    <nav class="navbar navbar-static-top" style="background: #ffffff; margin: 0; padding: 0; display: flex; align-items: center; justify-content: space-between; height: 64px !important; border: none !important; box-shadow: none !important;">

        <!-- Header Left: Sidebar Toggle + Search -->
        <div style="display: flex; align-items: center; flex: 1;">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="color: #94a3b8; padding: 22px 20px; float: left; font-size: 16px; border: none; background: transparent;">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <!-- Pill Search Bar matching screenshot -->
            <div class="navbar-search hidden-xs" style="padding: 12px 15px;">
                <div style="position: relative; display: flex; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 14px; width: 260px; transition: all 0.2s; gap: 8px;">
                    <i class="fa fa-search" style="color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" placeholder="Search..." style="border: none; background: transparent; width: 100%; outline: none; font-size: 13px; color: #1a1a2e; font-family: 'Poppins', sans-serif;">
                    <span style="font-size: 10px; color: #94a3b8; border: 1px solid #e2e8f0; border-radius: 6px; padding: 2px 6px; font-family: monospace; font-weight: bold; background: #ffffff; white-space: nowrap; display: inline-flex; align-items: center; gap: 2px; line-height: 1;">⌘F</span>
                </div>
            </div>
        </div>

        <!-- Header Right: Notifications + User Profile -->
        <div style="display: flex; align-items: center; padding-right: 20px;">
            <ul class="nav navbar-nav" style="display: flex; align-items: center; gap: 15px; margin: 0; list-style: none;">
                
                <!-- Notification Bell -->
                <li class="dropdown messages-menu" style="display: inline-block;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #94a3b8; font-size: 18px; padding: 10px; position: relative; display: flex; align-items: center; justify-content: center; background: transparent; text-decoration: none;">
                        <i class="fa fa-bell-o"></i>
                        <span style="position: absolute; top: 8px; right: 8px; width: 8px; height: 8px; background: #f97316; border-radius: 50%;"></span> 
                    </a>
                    <ul class="dropdown-menu" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #f1f5f9; padding: 0;">
                        <li class="header" style="font-weight: 600; color: #334155; padding: 10px 15px; border-bottom: 1px solid #f1f5f9; font-size: 13px; font-family: 'Poppins', sans-serif;">You have 0 recent notifications</li>
                        <li>
                            <ul class="menu notification_top"></ul>
                        </li>
                        <li class="footer" style="padding: 10px 15px; text-align: center; border-top: 1px solid #f1f5f9;"><a href="{{route('user.notification_unread')}}" style="color: #0B5ED7; font-weight: 600; text-decoration: none; font-size: 12px; font-family: 'Poppins', sans-serif;">See All Notifications</a></li>
                    </ul>
                </li>                                                 
                
                <!-- User profile dropdown matching screenshot -->
                <li class="dropdown user user-menu" style="display: inline-block;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; background: transparent;">
                        <!-- Initials circle avatar -->
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #0B5ED7; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 10px rgba(11, 94, 215, 0.25);">
                            {{ $initials }}
                        </div>
                        <!-- Name & Email text info -->
                        <div class="user-info-text hidden-xs" style="display: inline-flex; flex-direction: column; text-align: left; line-height: 1.3;">
                            <span class="user-name" style="font-size: 13px; font-weight: 600; color: #1a1a2e; font-family: 'Poppins', sans-serif;">{{ auth()->user()->name }}</span>
                            <span class="user-email" style="font-size: 11px; color: #9ca3af; font-family: 'Poppins', sans-serif;">{{ auth()->user()->email ?? 'k.asante@htu.edu.gh' }}</span>
                        </div>
                        <i class="fa fa-angle-down" style="color: #94a3b8; font-size: 14px;"></i>
                    </a>

                    <ul class="dropdown-menu" style="border-radius: 16px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15); border: 1px solid #e2e8f0; padding: 8px; width: 220px; font-family: 'Poppins', sans-serif; margin-top: 10px; border-top: none;">
                        <!-- User Info Header inside dropdown -->
                        <li style="padding: 12px 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 6px;">
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a2e;">{{ auth()->user()->name }}</div>
                            <div style="font-size: 11px; color: #9ca3af; word-break: break-all;">{{ auth()->user()->email ?? 'k.asante@htu.edu.gh' }}</div>
                        </li>
                        
                        <!-- Menu Items -->
                        <li>
                            <a href="{{ URL::route('profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #4b5563; font-size: 13px; font-weight: 500; border-radius: 8px; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-user" style="font-size: 14px; color: #9ca3af; width: 16px; text-align: center;"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::route('change_password') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #4b5563; font-size: 13px; font-weight: 500; border-radius: 8px; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-key" style="font-size: 14px; color: #9ca3af; width: 16px; text-align: center;"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::route('lockscreen') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #4b5563; font-size: 13px; font-weight: 500; border-radius: 8px; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-eye-slash" style="font-size: 14px; color: #9ca3af; width: 16px; text-align: center;"></i>
                                <span>Lock Screen</span>
                            </a>
                        </li>
                        
                        <!-- Divider -->
                        <li style="height: 1px; background: #f1f5f9; margin: 6px 0;"></li>
                        
                        <!-- Logout Item -->
                        <li>
                            <a href="{{ URL::route('logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #ef4444; font-size: 13px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-power-off" style="font-size: 14px; color: #ef4444; width: 16px; text-align: center;"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>         
            </ul>
        </div>
    </nav>
</header>
<style>
/* Remove default hover backgrounds for a cleaner look */
.main-header .navbar .nav > li > a:hover, 
.main-header .navbar .nav > li > a:active, 
.main-header .navbar .nav > li > a:focus {
    background: transparent !important;
}
</style>