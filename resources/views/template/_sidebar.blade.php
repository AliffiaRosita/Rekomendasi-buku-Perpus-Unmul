<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
        <a href="{{url('/')}}" style="min-width:0px"><h5 class="text-white text-left text-bold">Rekomendasi Buku</h5></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="active">
                        <a href="{{url('/')}}" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                    </li>
                    <li >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layers-alt"></i><span>Master</span></a>
                        <ul class="collapse">
                        <li class="active"><a href="{{route('buku.index')}}">Buku</a></li>
                            <li><a href="{{route('pengunjung.index')}}">Pengunjung</a></li>
                            <li><a href="index3.html">Akun</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
