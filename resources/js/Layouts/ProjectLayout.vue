<script>
import SuccessMessage from '@/Components/SuccessMessage.vue'
import ErrorMessage from '@/Components/ErrorMessage.vue'
import $ from 'jquery';
export default {
    mounted() {
        $('[data-widget="treeview"]').Treeview('init');
    }
}
</script>
<script setup>
import { ref } from 'vue'
defineProps({
    project: Object
})
const hideSidebar = () => {
    if (ref(window.innerWidth).value <= 768) {
        document.body.classList.add('sidebar-closed')
        document.body.classList.add('sidebar-collapse')
        document.body.classList.remove('sidebar-open')
    }
}
</script>

<template>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <Link :href="route('user.projects.index')" class="nav-link">Projects</Link>
                </li>
                <li class="nav-item">
                    <Link :href="route('welcome')" class="nav-link">Home</Link>
                </li>
                <li class="nav-item d-none d-md-block">
                    <Link :href="route('about')" class="nav-link">About</Link>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <div class="btn-group dropstart">
                    <a class="me-2" data-bs-toggle="dropdown" href="#" data-bs-display="static" aria-expanded="false">
                        <img v-if="$page.props.auth.user.image"
                            :src="'/storage/user/image/' + $page.props.auth.user.image" class="rounded-circle"
                            height="30" alt="img" loading="lazy" />
                        <img v-else :src="'/storage/user/image/default.png'" class="rounded-circle" height="35"
                            alt="img" loading="lazy" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start dropdown-menu-lg-start">
                        <li>
                            <Link class="dropdown-item d-flex" :href="route('user.profile.show')">
                            <img v-if="$page.props.auth.user.image"
                                :src="'/storage/user/image/' + $page.props.auth.user.image" class="rounded-circle"
                                height="45" alt="img" loading="lazy" />
                            <img v-else :src="'/storage/user/image/default.png'" class="rounded-circle" height="45"
                                alt="img" loading="lazy" />
                            <div class="ms-2">
                                <div>{{ $page.props.auth.user.name }}</div>
                                <small>{{ $page.props.auth.user.email }}</small>
                            </div>
                            </Link>
                            <hr>
                        </li>
                        <li>
                            <Link class="dropdown-item" :href="route('logout')" method="post">
                            Logout
                            </Link>
                        </li>
                    </ul>
                </div>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-gray elevation-3">

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div v-if="project.image" class="image">
                        <img :src="'/storage/project/image/' + project.image" class="img-circle elevation-2" alt="">
                    </div>
                    <div v-else class="image">
                        <img :src="'/storage/project/image/default.jpg'" class="img-circle elevation-2" alt="">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ project.name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item" @click="hideSidebar">
                            <Link :href="route('user.projects.dashboard', project.id)" class="nav-link"
                                :class="{ 'active': $page.url.includes(`/${project.id}/dashboard`) }">
                            <i class="nav-icon fa-solid fa-list"></i>
                            <p>Dashboard</p>
                            </Link>
                        </li>
                        <li class="nav-item" @click="hideSidebar">
                            <Link :href="route('user.projects.members.index', project.id)" class="nav-link"
                                :class="{ 'active': $page.url.includes(`/${project.id}/members`) }">
                            <i class="nav-icon fa-solid fa-users"></i>
                            <p>Project Members</p>
                            </Link>
                        </li>
                        <li class="nav-item" @click="hideSidebar">
                            <Link :href="route('user.projects.designs.index', project.id)" class="nav-link"
                                :class="{ 'active': $page.url.includes(`/${project.id}/designs`) }">
                            <i class="nav-icon fa-solid fa-object-group"></i>
                            <p>Designs</p>
                            </Link>
                        </li>
                        <li class="nav-item" @click="hideSidebar">
                            <Link :href="route('user.projects.documents.index', project.id)" class="nav-link"
                                :class="{ 'active': $page.url.includes(`/${project.id}/documents`) }">
                            <i class="nav-icon fa-solid fa-folder-open"></i>
                            <p>Documents</p>
                            </Link>
                        </li>
                        <li v-if="$page.props.auth.user.id === project.user_id" class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-exclamation-triangle"></i>
                                <p>Actions<i class="right fa fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <Link :href="route('user.projects.delete_project', project.id)" class="nav-link">
                                    <i class="nav-icon fa fa-minus-circle text-danger"></i>
                                    <p>Delete Project</p>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->

        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="py-2">
                    <SuccessMessage />
                    <ErrorMessage />
                </div>
                <slot />
            </div>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">

            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ new Date().getFullYear() }} <a href="https://www.codot.gov/"
                    target="_blank">CDOT</a>.</strong> All
            rights
            reserved.
        </footer>
    </div>
</template>

<style scoped>
hr {
    border-color: #666666;
}
</style>
