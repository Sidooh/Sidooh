{{-- SIDE NAV --}}
{{-- TODO: Fix sidenav Icons --}}
{{-- TODO: Add Active links --}}
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                    data-bs-placement="left" title="Toggle Navigation">
                <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
            </button>
        </div>
        <a class="navbar-brand" href="{{ route('admin.index') }}">
            <div class="d-flex align-items-center py-3">
                <img class="me-2" src="{{ asset('images/logo.png') }}" alt="" style="width: 100%"/>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-chart-pie"></span>
                            </span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.index') }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Home</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.analytics') }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Analytics</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">User Management</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider"/>
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('admin.users.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-users"></span></span><span
                                class="nav-link-text ps-1">Users</span></div>
                    </a>
                    <a class="nav-link" href="{{ route('admin.accounts.index') }}"
                       role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-mobile-alt"></span></span><span
                                class="nav-link-text ps-1">Accounts</span>
                        </div>
                    </a>
                    <a class="nav-link" href="{{ route('admin.referrals.index') }}"
                       role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-redo"></span></span><span
                                class="nav-link-text ps-1">Invites</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Transactions</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider"/>
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('admin.transactions.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-globe"></span></span><span
                                class="nav-link-text ps-1">All transactions</span>
                        </div>
                    </a>
                    <a class="nav-link" href="{{ route('admin.earnings.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-money-bill-wave"></span></span><span
                                class="nav-link-text ps-1">Earnings</span>
                        </div>
                    </a>

                </li>

                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Agents</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider"/>
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('admin.subscriptions.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-globe"></span></span><span
                                class="nav-link-text ps-1">Subscriptions</span>
                        </div>
                    </a>
                    {{--                    <a class="nav-link" href="{{ route('admin.subscriptions.index') }}" role="button">--}}
                    {{--                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span--}}
                    {{--                                    class="fas fa-money-bill-wave"></span></span><span--}}
                    {{--                                class="nav-link-text ps-1">Inactive Subscriptions</span>--}}
                    {{--                        </div>--}}
                    {{--                    </a>--}}
                </li>

                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Finances</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider"/>
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('admin.vouchers.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-ticket-alt"></span></span><span
                                class="nav-link-text ps-1">Vouchers</span>
                        </div>
                    </a>
                    <a class="nav-link" href="{{ route('admin.sub-accounts.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-user"></span></span><span
                                class="nav-link-text ps-1">Sub Accounts</span>
                        </div>
                    </a>
                    <a class="nav-link" href="{{ route('admin.collective-investments.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-money-check"></span></span><span
                                class="nav-link-text ps-1">Collective Investments</span>
                        </div>
                    </a>
                    <a class="nav-link" href="{{ route('admin.sub-investments.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-piggy-bank"></span></span><span
                                class="nav-link-text ps-1">Sub Investments</span>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Notifications</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider"/>
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('admin.user-notifications.index') }}" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-envelope"></span></span><span
                                class="nav-link-text ps-1">User Notifications</span>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Analytics</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider"/>
                        </div>
                    </div>
                    <a class="nav-link" href="#" role="button">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-ticket-alt"></span></span><span
                                class="nav-link-text ps-1">Coming Soon</span>
                        </div>
                    </a>

                </li>

            </ul>

        </div>
    </div>
</nav>

{{-- TOP NAV --}}
<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-xl" style="display: none;">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard"
            aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="{{ route('admin.index') }}">
        <div class="d-flex align-items-center"><img class="me-2" src="{{ asset('images/logo.png') }}" alt=""
                                                    width="40"/><span class="font-sans-serif">sidooh</span></div>
    </a>
    {{--    <div class="collapse navbar-collapse scrollbar" id="navbarStandard">--}}
    {{--        <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">--}}
    {{--            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
    {{--                                             id="dashboard">Dashboard</a>--}}
    {{--                <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="dashboard">--}}
    {{--                    <div class="bg-white dark__bg-1000 rounded-3 py-2"><a class="dropdown-item link-600 fw-medium"--}}
    {{--                                                                          href="../index-2.html">Default</a><a--}}
    {{--                            class="dropdown-item link-600 fw-medium" href="dashboard-alt.html">Alternate</a></div>--}}
    {{--                </div>--}}
    {{--            </li>--}}
    {{--            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
    {{--                                             id="app">App</a>--}}
    {{--                <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="app">--}}
    {{--                    <div class="card navbar-card-app shadow-none dark__bg-1000">--}}
    {{--                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown"--}}
    {{--                                                                             src="../assets/img/illustrations/authentication-corner.png"--}}
    {{--                                                                             width="130" alt=""/>--}}
    {{--                            <div class="row">--}}
    {{--                                <div class="col-6 col-md-5">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../app/calendar.html">Calendar</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../app/chat.html">Chat</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../app/kanban.html">Kanban</a>--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Social</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../social/feed.html">Feed</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../social/profile.html">Profile</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../social/activity.html">Activity--}}
    {{--                                            log</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                      href="../social/notifications.html">Notifications</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../social/associations.html">Associations</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../social/people.html">Followers</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../social/settings.html">Settings</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../pages/privacy-policy.html">Privacy policy</a>--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Events</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../events/create-an-event.html">Create an event</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../events/event-detail.html">Event--}}
    {{--                                            detail</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                         href="../events/event-list.html">Event list</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-md-4">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Email</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../email/inbox.html">Inbox</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../email/email-detail.html">Email--}}
    {{--                                            detail</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                         href="../email/compose.html">Compose</a>--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">E-Commerce</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/product-list.html">Product list</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/product-grid.html">Product grid</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/product-details.html">Product details</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/order-list.html">Order list</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/order-details.html">Order details</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/customers.html">Customers</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/customer-details.html">Customer details</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../e-commerce/shopping-cart.html">Shopping cart</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../e-commerce/checkout.html">Checkout</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </li>--}}
    {{--            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
    {{--                                             id="pages">Pages</a>--}}
    {{--                <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="pages">--}}
    {{--                    <div class="card navbar-card-pages shadow-none dark__bg-1000">--}}
    {{--                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown"--}}
    {{--                                                                             src="../assets/img/illustrations/authentication-corner.png"--}}
    {{--                                                                             width="130" alt=""/>--}}
    {{--                            <div class="row">--}}
    {{--                                <div class="col-6 col-md-5">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../pages/landing.html">Landing</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../pages/pricing-default.html">Pricing default</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../pages/pricing-alt.html">Pricing--}}
    {{--                                            alt</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                      href="../pages/billing.html">Billing</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../pages/invoice.html">Invoice</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../pages/invite-people.html">Invite--}}
    {{--                                            people</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                         href="../pages/faq/faq-basic.html">Faq basic</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../pages/faq/faq-alt.html">Faq--}}
    {{--                                            alt</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                      href="../pages/faq/faq-accordion.html">Faq accordion</a></div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-md-4">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../pages/errors/404.html">404</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../pages/errors/500.html">500</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../pages/starter.html">Starter</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </li>--}}
    {{--            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
    {{--                                             id="authentication">Authentication</a>--}}
    {{--                <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="authentication">--}}
    {{--                    <div class="card navbar-card-auth shadow-none dark__bg-1000">--}}
    {{--                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown"--}}
    {{--                                                                             src="../assets/img/illustrations/authentication-corner.png"--}}
    {{--                                                                             width="130" alt=""/>--}}
    {{--                            <div class="row">--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Simple</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/basic/login.html">Login</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/basic/logout.html">Logout</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/basic/register.html">Register</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/basic/forgot-password.html">Forgot password</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/basic/confirm-mail.html">Confirm mail</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/basic/lock-screen.html">Lock screen</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Card</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/card/login.html">Login</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/card/logout.html">Logout</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/card/register.html">Register</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/card/forgot-password.html">Forgot password</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/card/confirm-mail.html">Confirm mail</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/card/lock-screen.html">Lock screen</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Split</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/split/login.html">Login</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/split/logout.html">Logout</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/split/register.html">Register</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/split/forgot-password.html">Forgot password</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/split/confirm-mail.html">Confirm mail</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/split/lock-screen.html">Lock screen</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Others</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../authentication/wizard.html">Wizard</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../index.html#authentication-modal" data-bs-toggle="modal">Modal</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </li>--}}
    {{--            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
    {{--                                             id="modules">Modules</a>--}}
    {{--                <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="modules">--}}
    {{--                    <div class="card navbar-card-components shadow-none dark__bg-1000">--}}
    {{--                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown"--}}
    {{--                                                                             src="../assets/img/illustrations/authentication-corner.png"--}}
    {{--                                                                             width="130" alt=""/>--}}
    {{--                            <div class="row">--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../components/accordion.html">Accordion</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/alerts.html">Alerts</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/avatar.html">Avatar</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/background.html">Background</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/badges.html">Badges</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/breadcrumb.html">Breadcrumbs</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/buttons.html">Buttons</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/bulk-select.html">Bulk select</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/cards.html">Cards</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/carousel.html">Carousel</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../components/cookie-notice.html">Cookie--}}
    {{--                                            notice</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                         href="../components/collapse.html">Collapse</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/close-button.html">Close button</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/dropdowns.html">Dropdowns</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/figures.html">Figures</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/hoverbox.html">Hoverbox</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/images.html">Images</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/list-group.html">List group</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/modals.html">Modals</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/navs.html">Navs</a></div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../components/navbar/default.html">Default</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/navbar/vertical.html">Vertical</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/navbar/top.html">Top</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/navbar/combo.html">Combo</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/navbar/darken-on-scroll.html">Darken on scroll</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/page-headers.html">Page headers</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/pagination.html">Pagination</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/popovers.html">Popovers</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/progress.html">Progress</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/search.html">Search</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../components/scrollspy.html">Scrollspy</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/sidepanel.html">Sidepanel</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/spinners.html">Spinners</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../components/tabs.html">Tabs</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/toasts.html">Toasts</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/tooltips.html">Tooltips</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../forms/checks.html">Checks</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../forms/form-control.html">Form--}}
    {{--                                            control</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                          href="../forms/form-wizard.html">Form wizard</a></div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="row mt-2">--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Forms</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../forms/input-group.html">Input--}}
    {{--                                            group</a><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                        href="../forms/layout.html">Layout</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../forms/range.html">Range</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../forms/select.html">Select</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../forms/validation.html">Validation</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../components/tables.html">Table</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/list.html">List</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/chartjs.html">Chartjs</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/echarts.html">ECharts</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">plugins</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/draggable.html">Draggable</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/dropzone.html">Dropzone</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/emoji-button.html">Emoji button</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/fullcalendar.html">Fullcalendar</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/glightbox.html">Glightbox</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/progressbar.html">Progressbar</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/inline-player.html">Inline player</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/lottie.html">Lottie</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/overlayscrollbars.html">Overlayscrollbars</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../plugins/typed-text.html">Typed text</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/tinymce.html">Tinymce</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/swiper.html">Swiper</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/rater.html">Rater</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/borders.html">Borders</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/clearfix.html">Clearfix</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/colors.html">Colors</a>--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Tables</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/map/google-map.html">Google map</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/map/leaflet-map.html">Leaflet map</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Charts</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../plugins/icons.html">Icons</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/anchor.html">Anchor</a>--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Maps</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/countup.html">Countup</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/choices.html">Choices</a>--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Others</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../plugins/date-picker.html">Date--}}
    {{--                                            picker</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="row mt-2">--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column">--}}
    {{--                                        <p class="nav-link text-700 mb-0 fw-bold">Utilities</p><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/colored-links.html">Colored links</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/display.html">Display</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/embed.html">Embed</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/flex.html">Flex</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/float.html">Float</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/grid.html">Grid</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/position.html">Position</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../utilities/spacing.html">Spacing</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                                                    href="../utilities/sizing.html">Sizing</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/stretched-link.html">Stretched link</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/text-truncation.html">Text truncation</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/typography.html">Typography</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/vertical-align.html">Vertical align</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium"--}}
    {{--                                            href="../utilities/visibility.html">Visibility</a><a--}}
    {{--                                            class="nav-link py-1 link-600 fw-medium" href="../widgets.html">Widgets</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-6 col-xxl-3">--}}
    {{--                                    <div class="nav flex-column"></div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </li>--}}
    {{--            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
    {{--                                             id="docs">Docs</a>--}}
    {{--                <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="docs">--}}
    {{--                    <div class="bg-white dark__bg-1000 rounded-3 py-2"><a class="dropdown-item link-600 fw-medium"--}}
    {{--                                                                          href="../documentation/getting-started.html">Getting--}}
    {{--                            started</a><a class="dropdown-item link-600 fw-medium"--}}
    {{--                                          href="../documentation/configuration.html">Configuration</a><a--}}
    {{--                            class="dropdown-item link-600 fw-medium" href="../documentation/styling.html">Styling</a><a--}}
    {{--                            class="dropdown-item link-600 fw-medium" href="../documentation/dark-mode.html">Dark--}}
    {{--                            mode<span class="badge rounded-pill ms-2 badge-soft-success">New</span></a><a--}}
    {{--                            class="dropdown-item link-600 fw-medium" href="../documentation/plugin.html">Plugin</a><a--}}
    {{--                            class="dropdown-item link-600 fw-medium" href="../documentation/gulp.html">Gulp</a><a--}}
    {{--                            class="dropdown-item link-600 fw-medium" href="../documentation/design-file.html">Design--}}
    {{--                            file</a><a class="dropdown-item link-600 fw-medium" href="../changelog.html">Changelog</a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </li>--}}
    {{--        </ul>--}}
    {{--    </div>--}}
    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill icon-indicator"--}}
        {{--               href="../e-commerce/shopping-cart.html"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7"--}}
        {{--                                                             style="font-size: 33px;"></span><span--}}
        {{--                    class="notification-indicator-number">1</span></a>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item dropdown">--}}
        {{--            <a class="nav-link notification-indicator notification-indicator-primary px-0 icon-indicator"--}}
        {{--               id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"--}}
        {{--               aria-expanded="false"><span class="fas fa-bell" data-fa-transform="shrink-6"--}}
        {{--                                           style="font-size: 33px;"></span></a>--}}
        {{--            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card"--}}
        {{--                 aria-labelledby="navbarDropdownNotification">--}}
        {{--                <div class="card card-notification shadow-none" style="max-width: 5rem">--}}
        {{--                    <div class="card-header">--}}
        {{--                        <div class="row justify-content-between align-items-center">--}}
        {{--                            <div class="col-auto">--}}
        {{--                                <h6 class="card-header-title mb-0">Notifications</h6>--}}
        {{--                            </div>--}}
        {{--                            <div class="col-auto"><a class="card-link fw-normal" href="#">Mark all as read</a></div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="scrollbar-overlay" style="max-height:19rem;">--}}
        {{--                        <div class="list-group list-group-flush fw-normal fs--1">--}}
        {{--                            <div class="list-group-title border-bottom">NEW</div>--}}
        {{--                            <div class="list-group-item">--}}
        {{--                                <a class="notification notification-flush notification-unread" href="#!">--}}
        {{--                                    <div class="notification-avatar">--}}
        {{--                                        <div class="avatar avatar-2xl me-3">--}}
        {{--                                            <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt=""/>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="notification-body">--}}
        {{--                                        <p class="mb-1"><strong>Emma Watson</strong> replied to your comment : "Hello--}}
        {{--                                            world 😍"</p>--}}
        {{--                                        <span class="notification-time"><span class="me-2" role="img"--}}
        {{--                                                                              aria-label="Emoji">💬</span>Just now</span>--}}
        {{--                                    </div>--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                            <div class="list-group-item">--}}
        {{--                                <a class="notification notification-flush notification-unread" href="#!">--}}
        {{--                                    <div class="notification-avatar">--}}
        {{--                                        <div class="avatar avatar-2xl me-3">--}}
        {{--                                            <div class="avatar-name rounded-circle"><span>AB</span></div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="notification-body">--}}
        {{--                                        <p class="mb-1"><strong>Albert Brooks</strong> reacted to <strong>Mia--}}
        {{--                                                Khalifa's</strong> status</p>--}}
        {{--                                        <span class="notification-time"><span--}}
        {{--                                                class="me-2 fab fa-gratipay text-danger"></span>9hr</span>--}}
        {{--                                    </div>--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                            <div class="list-group-title border-bottom">EARLIER</div>--}}
        {{--                            <div class="list-group-item">--}}
        {{--                                <a class="notification notification-flush" href="#!">--}}
        {{--                                    <div class="notification-avatar">--}}
        {{--                                        <div class="avatar avatar-2xl me-3">--}}
        {{--                                            <img class="rounded-circle" src="../assets/img/icons/weather-sm.jpg"--}}
        {{--                                                 alt=""/>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="notification-body">--}}
        {{--                                        <p class="mb-1">The forecast today shows a low of 20&#8451; in California. See--}}
        {{--                                            today's weather.</p>--}}
        {{--                                        <span class="notification-time"><span class="me-2" role="img"--}}
        {{--                                                                              aria-label="Emoji">🌤️</span>1d</span>--}}
        {{--                                    </div>--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                            <div class="list-group-item">--}}
        {{--                                <a class="border-bottom-0 notification-unread  notification notification-flush"--}}
        {{--                                   href="#!">--}}
        {{--                                    <div class="notification-avatar">--}}
        {{--                                        <div class="avatar avatar-xl me-3">--}}
        {{--                                            <img class="rounded-circle" src="../assets/img/logos/oxford.png" alt=""/>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="notification-body">--}}
        {{--                                        <p class="mb-1"><strong>University of Oxford</strong> created an event : "Causal--}}
        {{--                                            Inference Hilary 2019"</p>--}}
        {{--                                        <span class="notification-time"><span class="me-2" role="img"--}}
        {{--                                                                              aria-label="Emoji">✌️</span>1w</span>--}}
        {{--                                    </div>--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                            <div class="list-group-item">--}}
        {{--                                <a class="border-bottom-0 notification notification-flush" href="#!">--}}
        {{--                                    <div class="notification-avatar">--}}
        {{--                                        <div class="avatar avatar-xl me-3">--}}
        {{--                                            <img class="rounded-circle" src="../assets/img/team/10.jpg" alt=""/>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="notification-body">--}}
        {{--                                        <p class="mb-1"><strong>James Cameron</strong> invited to join the group: United--}}
        {{--                                            Nations International Children's Fund</p>--}}
        {{--                                        <span class="notification-time"><span class="me-2" role="img"--}}
        {{--                                                                              aria-label="Emoji">🙋‍</span>2d</span>--}}
        {{--                                    </div>--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-footer text-center border-top"><a class="card-link d-block"--}}
        {{--                                                                       href="../social/notifications.html">View all</a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button"--}}
        {{--                                         data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
        {{--                <div class="avatar avatar-xl">--}}
        {{--                    <img class="rounded-circle" src="../assets/img/team/3-thumb.png" alt=""/>--}}
        {{--                </div>--}}
        {{--            </a>--}}
        {{--            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">--}}
        {{--                <div class="bg-white dark__bg-1000 rounded-2 py-2">--}}
        {{--                    <a class="dropdown-item fw-bold text-warning" href="#!"><span class="fas fa-user me-1"></span><span>Something</span></a>--}}
        {{--                    <div class="dropdown-divider"></div>--}}
        {{--                    <a class="dropdown-item" href="../social/profile.html">Profile &amp; account</a>--}}
        {{--                    <div class="dropdown-divider"></div>--}}
        {{--                    <a class="dropdown-item" href="../social/settings.html">Settings</a>--}}
        {{--                    <a class="dropdown-item" href="../authentication/card/logout.html">Logout</a>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </li>--}}
    </ul>
</nav>
