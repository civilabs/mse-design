<script setup>
import List from '@/Components/List.vue'
const props = defineProps({
    project: Object,
    members: Object,
    can: Object,
})
</script>

<script>
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
export default {
    layout: (h, page) => h(ProjectLayout, { 'project': page.props.project }, () => page)
}
</script>

<template>

    <Head title="Project Members List" />

    <List>
        <template v-slot:title>
            <div class="col-6">
                <h4 class="font-weight-normal">Project Members</h4>
            </div>
            <div class="col-6 text-right">
                <Link v-if="can.create_member" class="btn btn-primary mx-2"
                    :href="route('user.projects.members.create', project.id)">Add
                Member
                </Link>
            </div>
        </template>
        <template v-slot:thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
        </template>
        <template v-if="Object.keys(members).length" v-slot:tbody>
            <tr v-for="member, index in members" :key="member.id">
                <td>{{ index + 1 }}</td>
                <td>{{ member.user.name }}</td>
                <td>{{ member.member_role.name }}</td>
                <td>{{ member.user.phone }}</td>
                <td>{{ member.user.email }}</td>
                <td>
                    <Link :href="route('user.projects.members.show', { 'project': project.id, 'member': member.id })">
                    View
                    </Link>
                </td>
            </tr>
        </template>
        <template v-else v-slot:tbody>
            <tr>
                <td colspan="6" class="text-center">
                    No project members yet
                </td>
            </tr>
        </template>
    </List>
</template>

<style>
@import 'ol/ol.css';
</style>
<style scoped>
#map {
    height: 25rem;
    width: 100%;
}
</style>