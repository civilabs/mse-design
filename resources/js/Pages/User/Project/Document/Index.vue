<script setup>
import List from '@/Components/List.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({
    project: Object,
    documents: Object,
    can: Object,
})
const deleteForm = useForm({})
const deleteDocument = (project_id, document_id) => {
    document.getElementById('close-delete-' + document_id).click()
    deleteForm.delete(route('user.projects.documents.destroy', { 'project': project_id, 'document': document_id }), {
        onFinish: () => {
            deleteForm.reset()
        },
    })
}
</script>

<script>
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
export default {
    layout: (h, page) => h(ProjectLayout, { 'project': page.props.project }, () => page)
}
</script>

<template>

    <Head title="Documents" />

    <List>
        <template v-slot:title>
            <div class="col-6">
                <h4 class="font-weight-normal">Documents</h4>
            </div>
            <div class="col-6 text-right">
                <Link v-if="can.create_document" class="btn btn-primary mx-2"
                    :href="route('user.projects.documents.create', project.id)">Add
                Document
                </Link>
            </div>
        </template>
        <template v-slot:thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Uploaded by</th>
                <th></th>
                <th></th>
            </tr>
        </template>
        <template v-if="Object.keys(documents).length" v-slot:tbody>
            <tr v-for="document, index in documents" :key="document.id">
                <td>{{ index + 1 }}</td>
                <td>{{ document.name }}</td>
                <td>{{ document.user.name }}</td>
                <td>
                    <a
                        :href="route('user.projects.documents.download', { 'project': project.id, 'document': document.id })">
                        Download
                    </a>
                </td>
                <td><a v-if="$page.props.auth.user.id == document.user_id" class="text-danger" data-bs-toggle="modal"
                        href="#" :data-bs-target="'#modal-delete-' + document.id">Delete</a></td>

                <!-- Delete document modal -->
                <div class="modal fade modal-danger" :id="'modal-delete-' + document.id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form @submit.prevent="deleteDocument(project.id, document.id)">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <h4 class="font-weight-normal">Delete document</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">Are you sure you want to delete this document?
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-outline-primary m-1"
                                                data-bs-dismiss="modal"
                                                :id="'close-delete-' + document.id">Close</button>
                                            <button type="submit" class="btn btn-danger m-1">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </tr>
        </template>
        <template v-else v-slot:tbody>
            <tr>
                <td colspan="6" class="text-center">
                    No documents yet
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