            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li>
                    <a href="{{ route('home') }}">
                      <i class="fa fa-home"></i>
                      Dashboard
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('Gudang') }}">
                      <i class="fa fa-cubes"></i>
                      Gudang
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('Transaksi Penjualan') }}">
                      <i class="fa fa-truck"></i>
                      Penjualan
                    </a>
                  </li>
                  @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                  <li>
                    <a href="{{ route('Transaksi Pembelian') }}">
                      <i class="fa fa-desktop"></i>
                      Pembelian
                    </a>
                  </li>
                  @endif
                </ul>
              </div>
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-money"></i> Keuangan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                      <li><a href="{{ route('Hutang') }}">Hutang</a></li>
                      @endif
                      <li><a href="{{ route('Kas Harian') }}">Kas Harian</a></li>
                      @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                      <li><a href="{{ route('Piutang') }}">Piutang</a></li>
                      @endif
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-file-o"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('Laporan Arus Stok') }}">Arus Stok</a></li>
                      @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                      <li><a href="{{ route('Laporan Hutang') }}">Hutang</a></li>
                      <li class="sub_menu"><a href="{{ route('Laporan Laba Rugi') }}">Laba Rugi</a></li>
                      <li><a>Penjualan <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li class="sub_menu"><a href="{{ route('Laporan Penjualan Rangkuman') }}">Rangkuman</a></li>
                          <li class="sub_menu"><a href="{{ route('Laporan Penjualan Per Customer') }}">Per Customer</a></li>
                        </ul>
                      </li>
                      <li><a>Pembelian <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li class="sub_menu"><a href="{{ route('Laporan Pembelian Rangkuman') }}">Rangkuman</a></li>
                          <li class="sub_menu"><a href="{{ route('Laporan Pembelian Per Supplier') }}">Per Supplier</a></li>
                        </ul>
                      </li>
                      <li><a href="{{ route('Laporan Piutang') }}">Piutang</a></li>
                      @endif
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-database"></i> Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('Master Barang') }}">Barang</a></li>
                      <li><a href="{{ route('Master Customer') }}">Customer</a></li>
                      @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                      <li><a href="{{ route('Master Kategori') }}">Kategori</a></li>
                      <li><a href="{{ route('Master Supplier') }}">Supplier</a></li>
                      @endif
                      @if (session('user.roles_id') == 1)
                      <li><a href="{{ route('Master User') }}">User</a></li>
                      @endif
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings" href="
                  @if (session('user.roles_id') == 1 || session('user.roles_id') == 2) {{ route('Setting') }} @endif">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <form method="POST" action="{{ route('logout') }}" id="formLogout">
                @csrf
                <a data-toggle="tooltip" data-placement="top" title="Logout" onclick="$('#formLogout').submit();">
                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
              </form>
            </div>
            <!-- /menu footer buttons -->