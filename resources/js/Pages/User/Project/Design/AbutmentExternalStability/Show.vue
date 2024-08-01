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
    deleteForm.delete(route('user.projects.designs.abutment_external_stability.destroy', { 'project': project_id, 'abutment_external_stability': design_id }), {
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
                    <td>YEV</td>
                    <td>{{ design.abutment_external_stability.yev }}</td>
                    <td>YLS.V</td>
                    <td>{{ design.abutment_external_stability.yls_v }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Material Properties">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td>f'c (ksi)</td>
                    <td>{{ design.abutment_external_stability.fpc }}</td>
                    <td>fy (ksi)</td>
                    <td>{{ design.abutment_external_stability.fy }}</td>
                    <td>γ conc (kcf)</td>
                    <td>{{ design.abutment_external_stability.g_conc }}</td>
                </tr>
                <tr>
                    <td>E steel (ksi)</td>
                    <td>{{ design.abutment_external_stability.e_steel }}</td>
                    <td>E conc (ksi)</td>
                    <td>{{ design.abutment_external_stability.e_conc }}</td>
                    <td>C'F soil (psf)</td>
                    <td>{{ design.abutment_external_stability.cpf_soil }}</td>
                </tr>
                <tr>
                    <td>β stem-Batter (deg)</td>
                    <td>{{ design.abutment_external_stability.bstem_batter }}</td>
                    <td>θ (deg)</td>
                    <td>{{ design.abutment_external_stability.theta }}</td>
                    <td>β (i) (deg)</td>
                    <td>{{ design.abutment_external_stability.b_i }}</td>
                </tr>
                <tr>
                    <td>σ_brg (ksf)</td>
                    <td>{{ design.abutment_external_stability.sigma_brg }}</td>
                    <td>δs</td>
                    <td>{{ design.abutment_external_stability.delta_s }}</td>
                    <td>γ r.fill (pcf)</td>
                    <td>{{ design.abutment_external_stability.g_r_fill }}</td>
                </tr>
                <tr>
                    <td>φ r.fill (deg)</td>
                    <td>{{ design.abutment_external_stability.phi_r_fill }}</td>
                    <td>C'r .Fill (psf)</td>
                    <td>{{ design.abutment_external_stability.cpr_fill }}</td>
                    <td>γ B.Fill (pcf)</td>
                    <td>{{ design.abutment_external_stability.g_b_fill }}</td>
                </tr>
                <tr>
                    <td>φ B.Fill (deg)</td>
                    <td>{{ design.abutment_external_stability.phi_b_fill }}</td>
                    <td>C'B.Fill (psf)</td>
                    <td>{{ design.abutment_external_stability.cpb_fill }}</td>
                    <td>γ F.soil (pcf)</td>
                    <td>{{ design.abutment_external_stability.g_f_soil }}</td>
                </tr>
                <tr>
                    <td>φ F.soil (deg)</td>
                    <td>{{ design.abutment_external_stability.phi_f_soil }}</td>
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
                    <td>PGA</td>
                    <td>{{ design.abutment_external_stability.pga }}</td>
                    <td>S_s.EQ</td>
                    <td>{{ design.abutment_external_stability.s_s_eq }}</td>
                    <td>S_1.EQ</td>
                    <td>{{ design.abutment_external_stability.s_1_eq }}</td>
                </tr>
                <tr>
                    <td>F_PGA.EQ</td>
                    <td>{{ design.abutment_external_stability.f_pga_eq }}</td>
                    <td>F_A.EQ</td>
                    <td>{{ design.abutment_external_stability.f_a_eq }}</td>
                    <td>F_V.EQ</td>
                    <td>{{ design.abutment_external_stability.f_v_eq }}</td>
                </tr>
                <tr>
                    <td>S_D1.EQ</td>
                    <td>{{ design.abutment_external_stability.s_d1_eq }}</td>
                    <td>A_s.EQ</td>
                    <td>{{ design.abutment_external_stability.a_s_eq }}</td>
                    <td>K_V</td>
                    <td>{{ design.abutment_external_stability.k_v }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Design Height and Spacing">
        <table class="table mb-4 table-bordered">
            <tbody>
                <tr>
                    <td>Minimum Height</td>
                    <td>{{ design.abutment_external_stability.min_design_height }}</td>
                    <td>Maximum Height</td>
                    <td>{{ design.abutment_external_stability.max_design_height }}</td>
                    <td>Sv (ft)</td>
                    <td>{{ design.abutment_external_stability.s_v }}</td>
                    <td>Sh (ft)</td>
                    <td>{{ design.abutment_external_stability.s_h }}</td>
                </tr>
            </tbody>
        </table>
    </ShowCard>
    <div class="text-right py-3">
        <Link :href="route('user.projects.designs.index', project.id)" class="btn btn-primary mr-2">Back</Link>
        <Link v-if="can.edit_design"
            :href="route('user.projects.designs.abutment_external_stability.edit', { 'project': project.id, 'abutment_external_stability': design.id })"
            class="btn btn-outline-primary mr-2">Edit
        </Link>
        <Link
            :href="route('user.projects.designs.abutment_external_stability.analyze', { 'project': project.id, 'abutment_external_stability': design.id })"
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
