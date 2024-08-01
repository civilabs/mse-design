<script setup>
import List from '@/Components/List.vue'
import { format } from 'date-fns'

defineProps({
    projects: Object,
})

const truncate = (text, maxLength) => {
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

const formatDate = (dateStr) => {
    const date = new Date(dateStr);
    return format(date, 'MMMM dd, yyyy');
}
</script>

<script>
import UserLayout from '@/Layouts/UserLayout.vue';
export default {
    layout: UserLayout
}
</script>

<template>

    <Head title="Projects List" />

    <List>
        <template v-slot:title>
            <div class="col-6">
                <h4 class="font-weight-normal">Projects</h4>
            </div>
            <div class="col-6 text-right">
                <Link class="btn btn-primary" :href="route('user.projects.create')">Add Project</Link>
            </div>
        </template>
        <template v-slot:thead>
            <tr>
                <th>#</th>
                <th>Project name</th>
                <th>Location</th>
                <th>Added on</th>
                <th>Image</th>
                <th></th>
            </tr>
        </template>
        <template v-if="Object.keys(projects).length" v-slot:tbody>
            <tr v-for="project, index in projects" :key="project.id">
                <td>{{ index + 1 }}</td>
                <td>{{ project.name }}</td>
                <td>{{ truncate(project.location, 100) }}</td>
                <td>{{ formatDate(project.created_at) }}</td>
                <td><img :src="'/storage/project/image/' + project.image" alt=""
                        style="width: 1.8rem; height: 1.8rem;" />
                </td>
                <td>
                    <a :href="route('user.projects.dashboard', project.id)">Open</a>
                </td>
            </tr>
        </template>
        <template v-else v-slot:tbody>
            <tr>
                <td colspan="6" class="text-center">
                    No projects yet
                </td>
            </tr>
        </template>
    </List>
</template>
