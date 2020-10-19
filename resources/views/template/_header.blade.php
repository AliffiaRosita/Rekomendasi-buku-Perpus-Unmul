<div class="header-area">
    <div class="row align-items-center">
        <!-- nav and search button -->
        <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- profile info & task notification -->
        <div class="col-md-6 col-sm-4 clearfix">
            <ul class="notification-area pull-right">

                 <li class="dropdown" style="min-width:200px">
                     <h5 class="text-center dropdown-toggle" data-toggle="dropdown"><img src="assets/images/author/avatar.png" width="30px" class="rounded-circle border-secondary border" height="30px" alt="">&nbsp; {{Auth::user()->visitor->nama_pengunjung}} </h5>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Profil</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();>Log Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                        </div>
                </li>

            </ul>
        </div>
    </div>
</div>
