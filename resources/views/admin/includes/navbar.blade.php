<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand" style="display: none;">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
            aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="{{ route('admin.index') }}">
        <div class="d-flex align-items-center">
            <img class="me-2" src="{{ asset('images/logo.png') }}" alt="" width="100"/>
            <span class="font-sans-serif">sidooh</span>
        </div>
    </a>
    <ul class="navbar-nav align-items-center d-none d-lg-block">
        <li class="nav-item">
            <div class="search-box" data-list='{"valueNames":["title"]}'>
                <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                        class="form-control search-input fuzzy-search" type="search" placeholder="Search..."
                        aria-label="Search"/>
                    <span class="fas fa-search search-box-icon"></span>
                </form>
                <button class="btn-close position-absolute end-0 top-50 translate-middle shadow-none p-1 me-1 fs--2"
                        type="button" data-bs-dismiss="search"></button>
                <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100">
                    <div class="scrollbar-overlay list py-3" style="max-height: 24rem;">
                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Recently
                            Browsed</h6><a class="dropdown-item fs--1 px-card py-1 hover-primary"
                                           href="../events/event-detail.html">
                            <div class="d-flex align-items-center">
                                <span class="fas fa-circle me-2 text-300 fs--2"></span>
                                <div class="fw-normal title">Pages <span
                                        class="fas fa-chevron-right mx-1 text-500 fs--2"
                                        data-fa-transform="shrink-2"></span> Events
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item fs--1 px-card py-1 hover-primary" href="../e-commerce/customers.html">
                            <div class="d-flex align-items-center">
                                <span class="fas fa-circle me-2 text-300 fs--2"></span>
                                <div class="fw-normal title">E-commerce <span
                                        class="fas fa-chevron-right mx-1 text-500 fs--2"
                                        data-fa-transform="shrink-2"></span> Customers
                                </div>
                            </div>
                        </a>
                        <hr class="bg-200"/>
                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Suggested
                            Filter</h6><a class="dropdown-item px-card py-1 fs-0" href="../e-commerce/customers.html">
                            <div class="d-flex align-items-center"><span
                                    class="badge fw-medium text-decoration-none me-2 badge-soft-warning">customers:</span>
                                <div class="flex-1 fs--1 title">All customers list</div>
                            </div>
                        </a>
                        <a class="dropdown-item px-card py-1 fs-0" href="../events/event-detail.html">
                            <div class="d-flex align-items-center"><span
                                    class="badge fw-medium text-decoration-none me-2 badge-soft-success">events:</span>
                                <div class="flex-1 fs--1 title">Latest events in current month</div>
                            </div>
                        </a>
                        <a class="dropdown-item px-card py-1 fs-0" href="../e-commerce/product-grid.html">
                            <div class="d-flex align-items-center"><span
                                    class="badge fw-medium text-decoration-none me-2 badge-soft-info">products:</span>
                                <div class="flex-1 fs--1 title">Most popular products</div>
                            </div>
                        </a>
                        <hr class="bg-200"/>
                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Files</h6><a
                            class="dropdown-item px-card py-2" href="#!">
                            <div class="d-flex align-items-center">
                                <div class="file-thumbnail me-2"><img class="border h-100 w-100 fit-cover rounded-3"
                                                                      src="{{ asset('images/products/3-thumb.png') }}"
                                                                      alt=""/>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 title">iPhone</h6>
                                    <p class="fs--2 mb-0"><span class="fw-semi-bold">Antony</span><span
                                            class="fw-medium text-600 ms-2">27 Sep at 10:30 AM</span></p>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item px-card py-2" href="#!">
                            <div class="d-flex align-items-center">
                                <div class="file-thumbnail me-2"><img class="img-fluid"
                                                                      src="{{ asset('images/icons/zip.png') }}" alt=""/>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 title">Sidooh v1.8.2</h6>
                                    <p class="fs--2 mb-0"><span class="fw-semi-bold">John</span><span
                                            class="fw-medium text-600 ms-2">30 Sep at 12:30 PM</span></p>
                                </div>
                            </div>
                        </a>
                        <hr class="bg-200"/>
                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Members</h6><a
                            class="dropdown-item px-card py-2" href="../social/profile.html">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-l status-online me-2">
                                    <img class="rounded-circle" src="{{ asset('images/team/1.jpg') }}" alt=""/>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 title">Anna Karinina</h6>
                                    <p class="fs--2 mb-0">Technext Limited</p>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item px-card py-2" href="../social/profile.html">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-l me-2">
                                    <img class="rounded-circle" src="{{ asset('images/team/2.jpg') }}" alt=""/>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 title">Antony Hopkins</h6>
                                    <p class="fs--2 mb-0">Brain Trust</p>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item px-card py-2" href="../social/profile.html">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-l me-2">
                                    <img class="rounded-circle" src="{{ asset('images/team/3.jpg') }}" alt=""/>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 title">Emma Watson</h6>
                                    <p class="fs--2 mb-0">Google</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        <li class="nav-item">
            <div class="theme-control-toggle fa-icon-wait px-2"><input
                    class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
                    type="checkbox" data-theme-control="theme" value="dark"/><label
                    class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                    for="themeControlToggle"
                    data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span
                        class="fas fa-sun fs-0"></span></label><label
                    class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                    for="themeControlToggle"
                    data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span
                        class="fas fa-moon fs-0"></span></label></div>
        </li>

        @include('admin.includes.waffle')

        <li class="nav-item dropdown">
            <a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="{{ asset('favicon.ico') }}" alt=""/>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <a class="dropdown-item fw-bold text-warning" href="#">
                        <span class="fas fa-user me-1"></span><span>Sidooh</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Profile &amp; account</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Settings</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item">Logout</button>
                    </form>
                </div>
            </div>
        </li>
    </ul>
</nav>

<script>
    let navbarPosition = localStorage.getItem('navbarPosition');
    let navbarVertical = document.querySelector('.navbar-vertical');
    let navbarTopVertical = document.querySelector('.content .navbar-top');
    let navbarTop = document.querySelector('[data-layout] .navbar-top');
    let navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');
    if (navbarPosition === 'top') {
        navbarTop.removeAttribute('style');
        navbarTopVertical.remove(navbarTopVertical);
        navbarVertical.remove(navbarVertical);
        navbarTopCombo.remove(navbarTopCombo);
    } else if (navbarPosition === 'combo') {
        navbarVertical.removeAttribute('style');
        navbarTopCombo.removeAttribute('style');
        navbarTop.remove(navbarTop);
        navbarTopVertical.remove(navbarTopVertical);
    } else {
        navbarVertical.removeAttribute('style');
        navbarTopVertical.removeAttribute('style');
        navbarTop.remove(navbarTop);
        // navbarTopCombo.remove(navbarTopCombo);
    }
</script>
