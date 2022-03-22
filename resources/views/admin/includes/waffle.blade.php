<li class="nav-item dropdown">
            <span class="nav-link fa-icon-wait nine-dots p-1" id="navbarDropdownMenu" role="button"
                  data-hide-on-body-scroll="data-hide-on-body-scroll" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="43" viewBox="0 0 16 16"
                     fill="none">
                    <circle cx="2" cy="2" r="2" fill="#6C6E71"/>
                    <circle cx="2" cy="8" r="2" fill="#6C6E71"/>
                    <circle cx="2" cy="14" r="2" fill="#6C6E71"/>
                    <circle cx="8" cy="8" r="2" fill="#6C6E71"/>
                    <circle cx="8" cy="14" r="2" fill="#6C6E71"/>
                    <circle cx="14" cy="8" r="2" fill="#6C6E71"/>
                    <circle cx="14" cy="14" r="2" fill="#6C6E71"/>
                    <circle cx="8" cy="2" r="2" fill="#6C6E71"/>
                    <circle cx="14" cy="2" r="2" fill="#6C6E71"/>
                </svg>
            </span>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-caret-bg"
         aria-labelledby="navbarDropdownMenu">
        <div class="card shadow-none">
            <div class="scrollbar-overlay nine-dots-dropdown">
                <div class="card-body px-3">
                    <div class="row text-center gx-0 gy-0">
                        <div class="col-4" disabled>
                            <div class="d-block bg-100 px-2 py-3 text-center text-decoration-none"
                               href="#">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-soft-light text-primary">
                                        <span class="fs-2">A</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Accounts</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                               href="{{ config('services.sidooh.services.notify_dashboard.url') }}" target="_blank">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-soft-primary text-primary">
                                        <span class="fs-2">N</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Notify</p>
                            </a>
                        </div>
                        <div class="col-4">
                            <div class="d-block bg-100 px-2 py-3 text-center text-decoration-none"
                               href="#">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-soft-dark text-primary">
                                        <span class="fs-2">S</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Savings</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-block bg-100 px-2 py-3 text-center text-decoration-none"
                               href="#">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-soft-info text-primary">
                                        <span class="fs-2">P</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Products</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-block bg-100 px-2 py-3 text-center text-decoration-none"
                               href="#">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-soft-danger text-primary">
                                        <span class="fs-2">P</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Payments</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-block bg-100 px-2 py-3 text-center text-decoration-none"
                               href="#">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-100 text-primary">
                                        <span class="fs-2">E</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Enterprise</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-block bg-100 px-2 py-3 text-center text-decoration-none"
                               href="#">
                                <div class="avatar avatar-2xl">
                                    <div class="avatar-name rounded-circle bg-soft-success text-primary">
                                        <span class="fs-2">U</span>
                                    </div>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">USSD</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="my-3 mx-n3 bg-200"/>
                        </div>

                        <div class="col-4">
                            <a class="d-block hover-bg-200 px-2 py-3 text-center text-decoration-none"
                               href="pages/user/profile.html" target="_blank">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="{{ asset('images/team/2.jpg') }}" alt=""/>
                                </div>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2">Account</p>
                            </a>
                        </div>
                        <div class="col-4">
                            <a class="d-block hover-bg-200 px-2 py-3 text-center text-decoration-none"
                               href="#!" target="_blank">
                                <img class="rounded" src="{{ asset('images/nav-icons/trello.png') }}" alt="" width="40"
                                     height="40"/>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">ClickUp</p>
                            </a>
                        </div>
                        <div class="col-4">
                            <a class="d-block hover-bg-200 px-2 py-3 text-center text-decoration-none"
                               href="#!" target="_blank">
                                <img class="rounded" src="{{ asset("images/nav-icons/slack.png") }}" alt="" width="40"
                                     height="40"/>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Slack</p>
                            </a>
                        </div>
                        <div class="col-4">
                            <a class="d-block hover-bg-200 px-2 py-3 text-center text-decoration-none"
                               href="#!" target="_blank">
                                <img class="rounded" src="{{ asset("images/nav-icons/google.png") }}" alt="" width="40"
                                     height="40"/>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Google</p>
                            </a>
                        </div>
                        <div class="col-4">
                            <a class="d-block hover-bg-200 px-2 py-3 text-center text-decoration-none"
                               href="https://github.com/Sidooh" target="_blank" rel="noopener noreferrer">
                                <img class="rounded" src="{{ asset("images/nav-icons/github-light.png") }}" alt=""
                                     width="40"
                                     height="40"/>
                                <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Github</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
