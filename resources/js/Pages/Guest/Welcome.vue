<script setup>
</script>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
export default {
    layout: GuestLayout
}
</script>

<template>

    <Head title="Home" />

    <div class="d-none d-lg-block">
        <div class="container vh-100 d-flex align-items-center">
            <div class="row m-2">
                <div class="col-lg-6 order-lg-2 d-flex align-items-center">
                    <img class="img-fluid mx-2" :src="'image/header.jpg'" alt="" />
                </div>
                <div class="col-lg-6 order-lg-1">
                    <h1 class="h1-large text-uppercase mb-4">Mechanically Stabilized Earth Wall Design System</h1>
                    <p>Welcome to our web-based design system for mechanically stabilized earth walls, designed for the
                        Colorado Department of Transportation. Easily create projects, input design data, and
                        generate detailed designs with our intuitive interface.</p>
                    <p>Key features include data storage, advanced analysis tools, comprehensive reporting, and
                        map-based visualization. Our secure, subscription-based system ensures you can access your data
                        anytime, anywhere, perfect for engineers, construction managers, and researchers. Simplify your
                        design process with our all-in-one platform.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="d-lg-none">
        <div class="container">
            <div class="row m-2 py-3 my-5">
                <div class="col-lg-6 my-2">
                    <img class="img-fluid mx-2" :src="'image/header.jpg'" alt="" />
                </div>
                <div class="col-lg-6 order-lg-1">
                    <h2 class="h1-large text-uppercase my-3">Mechanically Stabilized Earth Wall Design System</h2>
                    <p>Welcome to our web-based design system for mechanically stabilized earth walls, designed for the
                        Colorado Department of Transportation. Easily create projects, input design data, and
                        generate detailed designs with our intuitive interface.</p>
                    <p>Key features include data storage, advanced analysis tools, comprehensive reporting, and
                        map-based visualization. Our secure, subscription-based system ensures you can access your data
                        anytime, anywhere, perfect for engineers, construction managers, and researchers. Simplify your
                        design process with our all-in-one platform.</p>
                </div>
            </div>
        </div>
    </div>
</template>
