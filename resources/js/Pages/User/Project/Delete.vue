<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
const props = defineProps({
    project: Object
})
const form = useForm({
    email: '',
})
const submit = (id) => {
    document.getElementById('close-delete').click()
    form.delete(route('user.projects.destroy', id), {
        onFinish: () => {
            form.reset()
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
    <Head title="Delete Project" />

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <br><br><br>
                <div class="card">
                    <div class="card-header pb-1">
                        <h4><i class="nav-icon fa fa-exclamation-circle text-danger"></i> Warning</h4>
                    </div>
                    <div class="card-body my-2">
                        The delete action is permanent and no data can be retrieved. Please be sure before making this
                        decision.
                    </div>

                    <div class="card-footer text-end">
                        <Link :href="route('user.projects.dashboard', project.id)" class="btn btn-primary">Go Back
                        </Link>
                        <button type="button" class="btn btn-outline-danger ms-2" data-bs-toggle="modal"
                            data-bs-target="#modal-delete">Delete</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal modal-danger fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="submit(project.id)">
                        <div class="card mb-0">
                            <div class="card-header pb-1">
                                <h4>Delete project</h4>
                            </div>

                            <div class="card-body">
                                <p>Please confirm that you have understood this message by entering your email before
                                    clicking the 'Delete anyway' button.</p>

                                <div>
                                    <div class="input-group mt-4"><span class="input-group-text">
                                            <i class="fa-solid fa-at"></i></span>
                                        <input id="email" type="email" class="form-control" v-model="form.email"
                                            name="email" placeholder="email" required autocomplete="username">
                                    </div>
                                    <InputError :message="form.errors.email"></InputError>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="button" id="close-delete" class="btn btn-primary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger ms-2">Delete anyway</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>