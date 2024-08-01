<script setup>
import { useForm } from '@inertiajs/vue3'
import InputCard from '@/Components/InputCard.vue'
import InputError from '@/Components/InputError.vue'
const props = defineProps({
    project: Object,
    design_types: Object
})
const form = useForm({
    key: ''
})
const submit = (project_id) => {
    form.get(route(`user.projects.designs.${form.key}.create`, { 'project': project_id }))
}
</script>
<script>
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
export default {
    layout: ProjectLayout
}
</script>

<template>

    <Head title="Add Design" />

    <form @submit.prevent="submit(project.id)">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <InputCard title="Select Design Type">
                    <div class="container-fluild form-group">
                        <div class="input-group mb-4">
                            <select id="key" name="key" class="form-control" v-model="form.key" required>
                                <option value="" selected>Design types</option>
                                <option v-for="design_type in design_types" :value="design_type.key"
                                    :key="design_type.id">
                                    {{ design_type.name }}
                                </option>
                            </select>
                        </div>
                        <InputError :message="form.errors.key"></InputError>
                    </div>
                    <div class="text-right pt-3 mb-3">
                        <button type="submit" class="btn btn-primary mr-2">Proceed
                        </button>
                    </div>
                </InputCard>
            </div>
        </div>
    </form>
</template>
