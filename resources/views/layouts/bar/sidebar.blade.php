<div class="left-side-bar">
    <div class="brand-logo">
        <a href="https://ytebox.vn">
            <img
                src="{{ asset('vendors/images/logo_2.png')}}"
                alt=""
                class="light-logo" width="46"
            />
            @for ($i = 1; $i < 10; $i++)&NoBreak;@endfor 
            <span class="brand-text font-light">Y Tế Box</span>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('table.basic')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-table"></span
                            ><span class="mtext">Danh sách</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('table.data')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-search"></span
                            ><span class="mtext">Lấy đơn thuốc</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.user')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-textarea-resize"></span
                            ><span class="mtext">Quản lý người dùng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.api.key')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-textarea-resize"></span
                            ><span class="mtext">Quản lý API Key</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="mobile-menu-overlay"></div>