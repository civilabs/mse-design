<script setup>
import { useForm } from '@inertiajs/vue3'
import Req from '@/Components/RequiredIndicator.vue'
import InputError from '@/Components/InputError.vue'
const props = defineProps({
    project: Object,
    member: Object,
    member_roles: Object,
    can: Object
})
const editForm = useForm({
    member_role_id: props.member.member_role_id
})
const editMember = (project_id, member_id) => {
    editForm.put(route('user.projects.members.update', { 'project': project_id, 'member': member_id }), {
        onFinish: () => {
            document.getElementById('close-edit').click()
            deleteForm.reset()
        },
    })
}
const deleteForm = useForm({})
const deleteMember = (project_id, member_id) => {
    document.getElementById('close-delete').click()
    deleteForm.delete(route('user.projects.members.destroy', { 'project': project_id, 'member': member_id }), {
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

    <Head title="Show Member" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Member details</h3>
    <div class="container-fluid py-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h4 class="font-weight-normal">Basic data</h4>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 my-auto">
                        <img v-if="member.user.image" :src="'/storage/user/image/' + member.user.image"
                            style="width: 100%" alt="image">
                        <img v-else :src="'/storage/user/image/default.png'" style="width: 100%" alt="image">
                    </div>

                    <div class="col-md-9 my-auto">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                Name <a class="float-right">{{ member.user.name }}</a>
                            </li>
                            <li class="list-group-item">
                                Email <a class="float-right">{{ member.user.email }}</a>
                            </li>
                            <li class="list-group-item">
                                Phone number <a class="float-right">{{ member.user.phone }}</a>
                            </li>
                            <li class="list-group-item">
                                Role <a class="float-right">{{ member.member_role.name }}</a>
                            </li>
                            <li class="list-group-item">
                                Date added <a class="float-right">{{ new Date(member.created_at).toLocaleString('en-us',
                            {
                                month: 'long', day: 'numeric', year: 'numeric'
                            }) }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right py-3">
            <Link :href="route('user.projects.members.index', project.id)" class="btn btn-primary mr-2">Back</Link>
            <a v-if="can.edit_member" data-bs-toggle="modal" href="#" data-bs-target="#modal-edit"
                class="btn btn-outline-primary mr-2">Edit role
            </a>
            <a v-if="can.delete_member" class="btn btn-danger" data-bs-toggle="modal" href="#"
                data-bs-target="#modal-delete">Delete</a>
        </div>
    </div>
    <!-- Edit member modal -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit.prevent="editMember(project.id, member.id)">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h4 class="font-weight-normal">Edit member role</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <label for="member_role_id">Member role
                                    <Req />
                                </label>
                                <div class="input-group mb-3">
                                    <select id="member_role_id" name="member_role_id" class="form-control"
                                        v-model="editForm.member_role_id" required>
                                        <option value="">Member roles</option>
                                        <option v-for="member_role in member_roles" :value="member_role.id"
                                            :key="member_role.id">
                                            {{ member_role.name }}</option>
                                    </select>
                                </div>
                                <InputError :message="editForm.errors.member_role_id">
                                </InputError>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-outline-primary m-1" data-bs-dismiss="modal"
                                    id="close-edit">Close</button>
                                <button type="submit" class="btn btn-danger m-1">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete member modal -->
    <div class="modal fade modal-danger" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit.prevent="deleteMember(project.id, member.id)">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h4 class="font-weight-normal">Delete member</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">You can only delete a member who does not have any designs. Are
                                you
                                sure you want to delete {{ member.user.name }}?
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-outline-primary m-1" id="close-delete"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger m-1">Delete</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>