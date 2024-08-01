<script setup>
import List from '@/Components/List.vue'
import { format } from 'date-fns'
const props = defineProps({
    project: Object,
    designs: Object,
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

    <Head title="Designs" />

    <List>
        <template v-slot:title>
            <div class="col-6">
                <h4 class="font-weight-normal">Designs</h4>
            </div>
            <div class="col-6 text-right">
                <Link v-if="can.create_design" class="btn btn-primary mx-2"
                    :href="route('user.projects.designs.create', project.id)">Add
                Design
                </Link>
            </div>
        </template>
        <template v-slot:thead>
            <tr>
                <th>#</th>
                <th>Design type</th>
                <th>Added by</th>
                <th>Date</th>
                <th></th>
            </tr>
        </template>
        <template v-if="Object.keys(designs).length" v-slot:tbody>
            <tr v-for="design, index in designs" :key="design.id">
                <td>{{ index + 1 }}</td>
                <td>{{ design.design_type.name }}</td>
                <td>{{ design.user.name }}</td>
                <td>{{ format(new Date(design.created_at), 'MMMM d, yyyy') }}</td>
                <td>
                    <Link
                        :href="route(`user.projects.designs.${design.design_type.key}.show`, { 'project': project.id, [design.design_type.key]: design.id })">
                    view
                    </Link>
                </td>
            </tr>
        </template>
        <template v-else v-slot:tbody>
            <tr>
                <td colspan="6" class="text-center">
                    No designs yet
                </td>
            </tr>
        </template>
    </List>
</template>