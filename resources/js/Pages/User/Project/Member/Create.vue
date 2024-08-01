<script setup>
import { watch } from 'vue'
import InputError from '@/Components/InputError.vue'
import List from '@/Components/List.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({
    project: Object,
    member_roles: Object,
    user: Object,
    email: String
})
const formSearch = useForm({
    email: props.email
})
const form = useForm({
    user_id: props.user ? props.user.id : '',
    member_role_id: ''
})
watch(() => props.user, (newUser) => {
    form.user_id = newUser ? newUser.id : ''
})
const searchMember = (id) => {
    formSearch.post(route('user.projects.members.search', id))
}
const submit = (project_id) => {
    form.post(route('user.projects.members.store', { 'project': project_id }), {
        onFinish: () => {
            form.reset()
        },
    })
}
</script>
<script>
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
export default {
    layout: ProjectLayout
}
</script>

<template>

    <Head title="Add Member" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Add Member</h3>
    <div class="card py-3">
        <div class="container my-5">
            <form @submit.prevent="searchMember(project.id)">
                <div class="row mb-4">
                    <div class="col-md-3 my-2 text-center">
                        <h5>Search by email</h5>
                    </div>
                    <div class="col-md-6 my-2">
                        <div>
                            <div class="input-group"><span class="input-group-text">
                                    <i class="fa-solid fa-at"></i></span>
                                <input id="email" type="email" class="form-control" v-model="formSearch.email"
                                    name="email" placeholder="email" required autocomplete="username">
                            </div>
                            <InputError :message="formSearch.errors.email"></InputError>
                        </div>
                    </div>
                    <div class="col-md-3 my-2 text-end text-md-center">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>

            <form @submit.prevent="submit(project.id)">
                <List>
                    <template v-slot:thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Member role</th>
                            <th></th>
                        </tr>
                    </template>
                    <template v-if="user && Object.keys(user).length" v-slot:tbody>
                        <tr>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <div>
                                    <div class="input-group mb-3">
                                        <select id="member_role_id" name="member_role_id" class="form-control"
                                            v-model="form.member_role_id" required>
                                            <option value="">Project type</option>
                                            <option v-for="member_role in member_roles" :value="member_role.id"
                                                :key="member_role.id">{{ member_role.name }}</option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.member_role_id"></InputError>
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </td>
                        </tr>
                    </template>
                    <template v-else-if="user === null" v-slot:tbody>
                        <tr>
                            <td colspan="3" class="text-center">
                                No member found with the specified email
                            </td>
                        </tr>
                    </template>
                </List>
            </form>
        </div>
    </div>
</template>
