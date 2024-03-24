<div class="left-side-bar">
    <div class="brand-logo">
        <a href="#">
            <img
                src="{{ asset('vendors/images/logo.svg')}}"
                alt=""
                class="light-logo" width="50"
            />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                {{-- <li>
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
                </li> --}}
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
                <li>
                    <a href="{{ route('manager.rate.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-textarea-resize"></span
                            ><span class="mtext">Quản lý đánh giá phim</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.history.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-textarea-resize"></span
                            ><span class="mtext">Quản lý lịch sử xem</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.watchlist.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-textarea-resize"></span
                            ><span class="mtext">Quản lý danh sách xem</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.comment.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-textarea-resize"></span
                            ><span class="mtext">Quản lý bình luận</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="mobile-menu-overlay"></div>