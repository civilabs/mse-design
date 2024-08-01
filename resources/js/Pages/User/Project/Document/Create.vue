<script setup>
import Req from '@/Components/RequiredIndicator.vue'
import InputCard from '@/Components/InputCard.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({
    project: Object
})
const form = useForm({
    name: '',
    file: '',
    description: ''
})
const submit = (project_id) => {
    form.post(route('user.projects.documents.store', project_id), {
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

    <Head title="Add Document" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Add Document</h3>
    <form @submit.prevent="submit(project.id)">
        <InputCard title="Basic data">
            <div class="row">
                <div class="container-fluild form-group">
                    <label for="name">Document name
                        <Req />
                    </label>
                    <div class="input-group mb-3">
                        <input id="name" type="text" class="form-control" v-model="form.name" name="name"
                            placeholder="Document name" required autocomplete="name">
                    </div>
                    <InputError :message="form.errors.name"></InputError>
                </div>
                <div class="container-fluild form-group">
                    <label for="file">File
                        <Req />
                    </label>
                    <div class="input-group mb-3">
                        <input type="file" @input="form.file = $event.target.files[0]" required />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>
                    <InputError :message="form.errors.file"></InputError>
                </div>
            </div>
        </InputCard>
        <InputCard title="Description">
            <div class="row">
                <div class="col">
                    <div class="container-fluild form-group">
                        <div class="input-group">
                            <textarea placeholder="Description" v-model="form.description" class="form-control"
                                name="description" id="description" autocomplete="description" rows="4"></textarea>
                        </div>
                        <InputError :message="form.errors.description"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>
        <div class="text-right py-3">
            <Link :href="route('user.projects.documents.index', project.id)" class="btn btn-outline-primary mr-2">Back
            </Link>
            <button type="submit" class="btn btn-primary mr-2">Create
            </button>
        </div>
    </form>
</template>
