<header>
    <nav class="navbar navbar-expand">
        <div class="container-fluid">
            <div class="bg-white d-flex">
                <div class="p-l-40 p-t-25 p-b-15">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                        <g clip-path="url(#clip0_579_491)">
                            <path
                                d="M17.5 1.16674L18.2583 0.280077C18.047 0.0993258 17.7781 0 17.5 0C17.2219 0 16.953 0.0993258 16.7417 0.280077L17.5 1.16674ZM1.16667 15.1667L0.408333 14.2801L0 14.6301V15.1667H1.16667ZM12.8333 33.8334V35.0001C13.1428 35.0001 13.4395 34.8772 13.6583 34.6584C13.8771 34.4396 14 34.1428 14 33.8334H12.8333ZM22.1667 33.8334H21C21 34.1428 21.1229 34.4396 21.3417 34.6584C21.5605 34.8772 21.8572 35.0001 22.1667 35.0001V33.8334ZM33.8333 15.1667H35V14.6301L34.5917 14.2801L33.8333 15.1667ZM3.5 35.0001H12.8333V32.6667H3.5V35.0001ZM34.5917 14.2801L18.2583 0.280077L16.7417 2.05341L33.075 16.0534L34.5917 14.2801ZM16.7417 0.280077L0.408333 14.2801L1.925 16.0534L18.2583 2.05341L16.7417 0.280077ZM14 33.8334V26.8334H11.6667V33.8334H14ZM21 26.8334V33.8334H23.3333V26.8334H21ZM22.1667 35.0001H31.5V32.6667H22.1667V35.0001ZM35 31.5001V15.1667H32.6667V31.5001H35ZM0 15.1667V31.5001H2.33333V15.1667H0ZM17.5 23.3334C18.4283 23.3334 19.3185 23.7022 19.9749 24.3585C20.6313 25.0149 21 25.9052 21 26.8334H23.3333C23.3333 25.2863 22.7188 23.8026 21.6248 22.7086C20.5308 21.6147 19.0471 21.0001 17.5 21.0001V23.3334ZM17.5 21.0001C15.9529 21.0001 14.4692 21.6147 13.3752 22.7086C12.2812 23.8026 11.6667 25.2863 11.6667 26.8334H14C14 25.9052 14.3687 25.0149 15.0251 24.3585C15.6815 23.7022 16.5717 23.3334 17.5 23.3334V21.0001ZM31.5 35.0001C32.4283 35.0001 33.3185 34.6313 33.9749 33.975C34.6312 33.3186 35 32.4283 35 31.5001H32.6667C32.6667 31.8095 32.5438 32.1062 32.325 32.325C32.1062 32.5438 31.8094 32.6667 31.5 32.6667V35.0001ZM3.5 32.6667C3.19058 32.6667 2.89383 32.5438 2.67504 32.325C2.45625 32.1062 2.33333 31.8095 2.33333 31.5001H0C0 32.4283 0.368749 33.3186 1.02513 33.975C1.6815 34.6313 2.57174 35.0001 3.5 35.0001V32.6667Z"
                                fill="black" />
                        </g>
                        <defs>
                            <clipPath id="clip0_579_491">
                                <rect width="35" height="35" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <img class="logo-image" src="{{ url('auth/img/logo-auth.png'); }}" alt="Logo">
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav ms-auto mb-2 mb-lg-0 dropdown">
                    <a href="#" data-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-mdx me-3">
                                    <img src="{{ Auth::user()->gambar_url }}" alt="" class="object-fit-cover">                               
                                </div>
                            </div>
                            <div class="navbar-user-name d-flex align-items-center">
                                <p class="mb-0">{{Auth::user()->name ? ucfirst(Auth::user()->name) : Auth::user()->email}}</p>
                            </div>
                            <div class="navbar-icon text-end align-items-center">
                                <i class="bi bi-caret-down-fill"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item p-t-20 p-b-15 open-modal-change-password" href="#">
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item p-t-20 p-b-15 text-danger" href="{{ route('logout') }}">
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>