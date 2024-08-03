<script setup>
import { useForm } from '@inertiajs/vue3'
import ShowCard from '@/Components/ShowCard.vue'
import { format } from 'date-fns'
const props = defineProps({
    design: Object,
    project: Object,
    can: Object
})
const deleteForm = useForm({})
const deleteDesign = (project_id, design_id) => {
    document.getElementById('close-delete').click()
    deleteForm.delete(route('user.projects.designs.wing_external_stability_ll.destroy', { 'project': project_id, 'wing_external_stability_ll': design_id }), {
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

    <Head title="Show Design" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Design Details</h3>
    <ShowCard title="Basic Data">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td>Design Type</td>
                    <td>{{ design.design_type.name }}</td>
                </tr>
                <tr>
                    <td>Date Added</td>
                    <td>{{ format(new Date(design.created_at), 'MMMM d, yyyy') }}</td>
                </tr>
                <tr>
                    <td>Added By</td>
                    <td>{{ design.user.name }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Moment Arm">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td style="width: 30%;">YEV</td>
                    <td style="width: 20%;">{{ design.wing_external_stability_ll.yev }}</td>
                    <td style="width: 30%;">YLS.V</td>
                    <td style="width: 20%;">{{ design.wing_external_stability_ll.yls_v }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Material Properties">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td style="width: 20%;">β stem-Batter (deg)</td>
                    <td style="width: 14%;">{{ design.wing_external_stability_ll.bstem_batter }}</td>
                    <td style="width: 20%;">β (i) (deg)</td>
                    <td style="width: 13%;">{{ design.wing_external_stability_ll.b_i }}</td>
                    <td style="width: 20%;">σ_brg (ksf)</td>
                    <td style="width: 13%;">{{ design.wing_external_stability_ll.sigma_brg }}</td>
                </tr>
                <tr>
                    <td>δs</td>
                    <td>{{ design.wing_external_stability_ll.delta_s }}</td>
                    <td>γ r.fill (pcf)</td>
                    <td>{{ design.wing_external_stability_ll.g_r_fill }}</td>
                    <td>φ r.fill (deg)</td>
                    <td>{{ design.wing_external_stability_ll.phi_r_fill }}</td>
                </tr>
                <tr>
                    <td>φ F.soil (deg)</td>
                    <td>{{ design.wing_external_stability_ll.phi_f_soil }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="EQ Parameters">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td style="width: 20%;">PGA</td>
                    <td style="width: 14%;">{{ design.wing_external_stability_ll.pga }}</td>
                    <td style="width: 20%;">F_PGA.EQ</td>
                    <td style="width: 13%;">{{ design.wing_external_stability_ll.f_pga_eq }}</td>
                    <td style="width: 20%;">K_V</td>
                    <td style="width: 13%;">{{ design.wing_external_stability_ll.k_v }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Design Height and Spacing">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td style="width: 20%;">Minimum Height</td>
                    <td style="width: 14%;">{{ design.wing_external_stability_ll.min_design_height }}</td>
                    <td style="width: 20%;">Maximum Height</td>
                    <td style="width: 13%;">{{ design.wing_external_stability_ll.max_design_height }}</td>
                    <td style="width: 20%;">Sv (ft)</td>
                    <td style="width: 13%;">{{ design.wing_external_stability_ll.s_v }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <div class="text-right py-3">
        <Link :href="route('user.projects.designs.index', project.id)" class="btn btn-primary mr-2">Back</Link>
        <Link v-if="can.edit_design"
            :href="route('user.projects.designs.wing_external_stability_ll.edit', { 'project': project.id, 'wing_external_stability_ll': design.id })"
            class="btn btn-outline-primary mr-2">Edit
        </Link>
        <Link
            :href="route('user.projects.designs.wing_external_stability_ll.analyze', { 'project': project.id, 'wing_external_stability_ll': design.id })"
            class="btn btn-primary mr-2">Analyze
        </Link>
        <a v-if="can.delete_design" class="btn btn-danger" data-bs-toggle="modal" href="#"
            data-bs-target="#modal-delete">Delete</a>
    </div>
    <!-- Delete design modal -->
    <div class="modal fade modal-danger" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit.prevent="deleteDesign(project.id, design.id)">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h4 class="font-weight-normal">Delete Design</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">This action cannot be reversed. Are you sure you want to delete this
                                design?
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
