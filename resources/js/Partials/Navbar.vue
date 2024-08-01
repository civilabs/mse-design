<script setup>
import { onMounted } from 'vue'

onMounted(() => {
    // Navbar on mobile
    let elements = document.querySelectorAll(".nav-link");

    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", () => {
            document.querySelector(".offcanvas-collapse").classList.toggle("open");
        });
    }

    document.querySelector(".navbar-toggler").addEventListener("click", () => {
        document.querySelector(".offcanvas-collapse").classList.toggle("open");
    });

    // Hover on desktop
    function toggleDropdown(e) {
        const _d = e.target.closest(".dropdown");
        let _m = document.querySelector(".dropdown-menu", _d);

        setTimeout(
            function () {
                const shouldOpen = _d.matches(":hover");
                _m.classList.toggle("show", shouldOpen);
                _d.classList.toggle("show", shouldOpen);

                _d.setAttribute("aria-expanded", shouldOpen);
            },
            e.type === "mouseleave" ? 300 : 0
        );
    }

    // On hover
    const dropdownCheck = document.querySelector('.dropdown');

    if (dropdownCheck !== null) {
        document.querySelector(".dropdown").addEventListener("mouseleave", toggleDropdown);
        document.querySelector(".dropdown").addEventListener("mouseover", toggleDropdown);

        // On click
        document.querySelector(".dropdown").addEventListener("click", (e) => {
            const _d = e.target.closest(".dropdown");
            let _m = document.querySelector(".dropdown-menu", _d);
            if (_d.classList.contains("show")) {
                _m.classList.remove("show");
                _d.classList.remove("show");
            } else {
                _m.classList.add("show");
                _d.classList.add("show");
            }
        });
    }
})
</script>

<template>
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">
            <Link class="navbar-brand logo-text d-flex align-items-center" :href="route('welcome')">
            <img class="d-none d-md-block" src="/image/logo.png" height="60" alt="CDOT MSE Design Logo">
            <img class="d-md-none" src="/image/logo.png" height="45" alt="CDOT MSE Design Logo">
            <span class="ms-2">MSE DESIGN</span>
            </Link>

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('welcome')" :class="{ 'active': $page.url == '/' }">Home
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('about')"
                            :class="{ 'active': $page.url.startsWith('/about') }">
                        About</Link>
                    </li>
                    <template v-if="$page.props.auth.user">
                        <li class="nav-item dropdown ms-md-3">
                            <div class="btn-group">
                                <a data-bs-toggle="dropdown" href="#" data-bs-display="static" aria-expanded="false">
                                    <img v-if="$page.props.auth.user.image"
                                        :src="'/storage/user/image/' + $page.props.auth.user.image"
                                        class="rounded-circle" height="30" alt="img" loading="lazy" />
                                    <img v-else :src="'/storage/user/image/default.png'" class="rounded-circle"
                                        height="35" alt="img" loading="lazy" />
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" :href="route('user.projects.index')">Projects</a>
                                    </li>
                                    <li>
                                        <div class=" dropdown-divider">
                                        </div>
                                    </li>
                                    <li>
                                        <Link class="dropdown-item" :href="route('logout')" method="post">
                                        Logout
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </template>
                    <template v-else>
                        <span class="nav-item">
                            <a class="btn-solid-sm" :href="route('login')">Sign in</a>
                        </span>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.btn-solid-sm {
    display: inline-block;
    padding: 1rem 1.5rem 1rem 1.5rem;
    border: 1px solid #0092ff;
    border-radius: 30px;
    background-color: #0092ff;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    line-height: 0;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-solid-sm:hover {
    background-color: transparent;
    color: #333333;
    /* needs to stay here because of the color property of a tag */
    text-decoration: none;
}

/**********************/
/*     Navigation     */
/**********************/
.navbar {
    background-color: #fcfafb;
    font-weight: 400;
    font-size: 1.1rem;
    line-height: 0.875rem;
    box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.05);
}

.navbar .navbar-brand {
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
}

.navbar .logo-image img {
    width: 126px;
    height: 32px;
}

.navbar .logo-text {
    color: #223150;
    font-weight: 500;
    font-size: 1.875rem;
    line-height: 1rem;
    text-decoration: none;
}

.offcanvas-collapse {
    position: fixed;
    top: 4.3rem;
    /* adjusts the height between the top of the page and the offcanvas menu */
    bottom: 0;
    left: 100%;
    width: 100%;
    padding-right: 1rem;
    padding-left: 1rem;
    overflow-y: auto;
    visibility: hidden;
    background-color: #fcfafb;
    transition: visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
}

.offcanvas-collapse.open {
    visibility: visible;
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
}

.navbar .navbar-nav {
    margin-top: 0.75rem;
    margin-bottom: 0.5rem;
}

.navbar .nav-item .nav-link {
    padding-top: 0.625rem;
    padding-bottom: 0.625rem;
    color: #5e6576;
    text-decoration: none;
    transition: all 0.2s ease;
}

.navbar .nav-item.dropdown.show .nav-link,
.navbar .nav-item .nav-link:hover,
.navbar .nav-item .nav-link.active {
    color: #0092ff;
}

/* Dropdown Menu */
.navbar .dropdown .dropdown-menu {
    animation: fadeDropdown 0.2s;
    /* required for the fade animation */
}

@keyframes fadeDropdown {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

.navbar .dropdown-menu {
    margin-top: 0.25rem;
    margin-bottom: 0.25rem;
    border: none;
    background-color: #fcfafb;
}

.navbar .dropdown-item {
    padding-top: 0.625rem;
    padding-bottom: 0.625rem;
    color: #5e6576;
    font-weight: 400;
    font-size: 1.1rem;
    line-height: 0.875rem;
    text-decoration: none;
}

.navbar .dropdown-item:hover {
    background-color: #fcfafb;
    color: #0092ff;
}

.navbar .dropdown-divider {
    width: 100%;
    height: 1px;
    margin: 0.5rem auto 0.5rem auto;
    border: none;
    background-color: #d1d1d1;
}

/* end of dropdown menu */

.navbar .navbar-toggler {
    padding: 0;
    border: none;
    font-size: 1.25rem;
}

/*************************/
/*     Media Queries     */
/*************************/

/* Min-width 992px */
@media (min-width: 992px) {

    /* Navigation */
    .navbar {
        /* padding-top: 1.75rem; */
        background-color: #fcfafb;
        box-shadow: none;
        transition: all 0.2s;
    }

    .navbar.top-nav-collapse {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        background-color: #fcfafb;
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.05);
    }

    .offcanvas-collapse {
        position: static;
        top: auto;
        bottom: auto;
        left: auto;
        width: auto;
        padding-right: 0;
        padding-left: 0;
        background-color: transparent;
        overflow-y: visible;
        visibility: visible;
    }

    .offcanvas-collapse.open {
        -webkit-transform: none;
        transform: none;
    }

    .navbar .navbar-nav {
        margin-top: 0;
        margin-bottom: 0;
    }

    .navbar .nav-item .nav-link {
        padding-right: 0.75rem;
        padding-left: 0.75rem;
    }

    .navbar .dropdown-menu {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        box-shadow: 0 3px 3px 1px rgba(0, 0, 0, 0.08);
    }

    .navbar .dropdown-divider {
        width: 90%;
    }

    .navbar .nav-item .btn-solid-sm {
        margin-top: 0;
        margin-left: 1rem;
    }

    /* end of navigation */
}

/* end of min-width 992px */


/* Min-width 1200px */
@media (min-width: 1200px) {

    /* General Styles */
    .container {
        max-width: 1300px;
    }

    /* end of general styles */
}

/* end of min-width 1200px */

/* max-width 992px */
@media (max-width: 992px) {
    .navbar {
        background-color: #fcfafb;
        font-weight: 400;
        font-size: 1.7rem;
        line-height: 2.8rem;
        text-align: center;
        box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.05);
    }

    .nav-link {
        border-bottom: 1px solid #dddddd;
        margin-left: 5rem;
        margin-right: 5rem;
    }

    .btn-solid-sm {
        display: inline-block;
        padding: 1.5rem 2rem 1.5rem 2rem;
        border-radius: 10px;
        font-weight: 400;
        font-size: 1.7rem;
        line-height: 0;
        margin-top: 1rem;
        text-decoration: none;
        transition: all 0.2s;
    }

}

/* end of max-width 992px */
</style>