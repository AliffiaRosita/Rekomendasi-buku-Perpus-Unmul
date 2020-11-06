<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
        <a href="{{url('/dashboard')}}" style="min-width:0px"><h5 class="text-white text-left text-bold">Rekomendasi Buku</h5></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{Request::segment(1)==='dashboard'?'active':''}}" >
                        <a href="{{url('/dashboard')}}" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                    </li>
                    {{-- <li class=""> --}}
                        {{-- <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layers-alt"></i><span>Master</span></a> --}}
                        {{-- <ul class="collapse"> --}}
                        <li class="{{Request::segment(1)==='buku'?'active':''}}" aria-expanded="true">
                           <a href="{{route('buku.index')}}"><i class="ti-book"></i> <span> Buku</span></a></li>
                        <li class="{{Request::segment(1)==='pengunjung'?'active':''}}" aria-expanded="true">
                            <a href="{{route('pengunjung.index')}}"><i class="ti-user"></i> <span>Pengunjung</span> </a>
                        </li>
                        <li class="{{Request::segment(1)==='perhitungan'?'active':''}}" aria-expanded="true">
                            <a href="{{route('calc.show')}}"><i class="ti-ruler-alt-2"></i> <span>Perhitungan</span> </a>
                        </li>
                        {{-- </ul> --}}
                    {{-- </li> --}}
                </ul>
            </nav>
        </div>
    </div>
</div>
