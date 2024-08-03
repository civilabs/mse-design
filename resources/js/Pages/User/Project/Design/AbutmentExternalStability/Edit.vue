<script setup>
import Req from '@/Components/RequiredIndicator.vue'
import InputCard from '@/Components/InputCard.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({
    design: Object,
    project: Object
})
const form = useForm({
    // LS Moment Arm
    yev: props.design.abutment_external_stability.yev,
    yls_v: props.design.abutment_external_stability.yls_v,

    // Material Properties
    bstem_batter: props.design.abutment_external_stability.bstem_batter,
    b_i: props.design.abutment_external_stability.b_i,
    sigma_brg: props.design.abutment_external_stability.sigma_brg,
    delta_s: props.design.abutment_external_stability.delta_s,
    g_r_fill: props.design.abutment_external_stability.g_r_fill,
    phi_r_fill: props.design.abutment_external_stability.phi_r_fill,
    phi_f_soil: props.design.abutment_external_stability.phi_f_soil,

    // EQ Parameters
    pga: props.design.abutment_external_stability.pga,
    f_pga_eq: props.design.abutment_external_stability.f_pga_eq,
    k_v: props.design.abutment_external_stability.k_v,

    // Height and spacing
    min_design_height: props.design.abutment_external_stability.min_design_height,
    max_design_height: props.design.abutment_external_stability.max_design_height,
    s_v: props.design.abutment_external_stability.s_v,
})

const submit = (project_id, design_id) => {
    form.put(route('user.projects.designs.abutment_external_stability.update', { 'project': project_id, 'abutment_external_stability': design_id }), {
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

    <Head title="Add Test" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Add Design</h3>
    <form @submit.prevent="submit(project.id, design.id)">
        <InputCard title="LS Moment Arm">
            <div class="row">
                <div class="col-lg-6">
                    <div class="container-fluild form-group">
                        <label for="yev">YEV
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="yev" type="number" step="0.0000000001" class="form-control" v-model="form.yev"
                                name="yev" required autocomplete="yev">
                        </div>
                        <InputError :message="form.errors.yev"></InputError>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="container-fluild form-group">
                        <label for="yls_v">YLS.V
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="yls_v" type="number" step="0.0000000001" class="form-control"
                                v-model="form.yls_v" name="yls_v" required autocomplete="yls_v">
                        </div>
                        <InputError :message="form.errors.yls_v"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>
        <InputCard title="Material Properties">
            <div class="row">
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="bstem_batter">Ꞵstem-Batter (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="bstem_batter" type="number" step="0.0000000001" class="form-control"
                                v-model="form.bstem_batter" name="bstem_batter" required autocomplete="bstem_batter">
                        </div>
                        <InputError :message="form.errors.bstem_batter"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="b_i">Ꞵ (i) (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="b_i" type="number" step="0.0000000001" class="form-control" v-model="form.b_i"
                                name="b_i" required autocomplete="b_i">
                        </div>
                        <InputError :message="form.errors.b_i"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="sigma_brg">σ_brg (ksf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="sigma_brg" type="number" step="0.0000000001" class="form-control"
                                v-model="form.sigma_brg" name="sigma_brg" required autocomplete="sigma_brg">
                        </div>
                        <InputError :message="form.errors.sigma_brg"></InputError>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="delta_s">δs
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="delta_s" type="number" step="0.0000000001" class="form-control"
                                v-model="form.delta_s" name="delta_s" required autocomplete="delta_s">
                        </div>
                        <InputError :message="form.errors.delta_s"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="g_r_fill">ϒr.fill (pcf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="g_r_fill" type="number" step="0.0000000001" class="form-control"
                                v-model="form.g_r_fill" name="g_r_fill" required autocomplete="g_r_fill">
                        </div>
                        <InputError :message="form.errors.g_r_fill"></InputError>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="phi_r_fill">Ør.fill (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="phi_r_fill" type="number" step="0.0000000001" class="form-control"
                                v-model="form.phi_r_fill" name="phi_r_fill" required autocomplete="phi_r_fill">
                        </div>
                        <InputError :message="form.errors.phi_r_fill"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="phi_f_soil">ØF.soil (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="phi_f_soil" type="number" step="0.0000000001" class="form-control"
                                v-model="form.phi_f_soil" name="phi_f_soil" required autocomplete="phi_f_soil">
                        </div>
                        <InputError :message="form.errors.phi_f_soil"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>
        <InputCard title="EQ Parameters">
            <div class="row">
                <div class="col-md-4">
                    <div class="container-fluid form-group">
                        <label for="pga">PGA</label>
                        <div class="input-group mb-3">
                            <input id="pga" type="number" step="0.0000000001" class="form-control" v-model="form.pga"
                                name="pga" required autocomplete="pga">
                        </div>
                        <InputError :message="form.errors.pga"></InputError>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluid form-group">
                        <label for="f_pga_eq">F_PGA.EQ</label>
                        <div class="input-group mb-3">
                            <input id="f_pga_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.f_pga_eq" name="f_pga_eq" required autocomplete="f_pga_eq">
                        </div>
                        <InputError :message="form.errors.f_pga_eq"></InputError>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluid form-group">
                        <label for="k_v">K_V</label>
                        <div class="input-group mb-3">
                            <input id="k_v" type="number" step="0.0000000001" class="form-control" v-model="form.k_v"
                                name="k_v" required autocomplete="k_v">
                        </div>
                        <InputError :message="form.errors.k_v"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>
        <InputCard title="Design Height and Spacing">
            <div class="row">
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="min_design_height">Minimum Height
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="min_design_height" type="number" step="0.0000000001" class="form-control"
                                v-model="form.min_design_height" name="min_design_height" required
                                autocomplete="min_design_height">
                        </div>
                        <InputError :message="form.errors.min_design_height"></InputError>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="max_design_height">Maximum Height
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="max_design_height" type="number" step="0.0000000001" class="form-control"
                                v-model="form.max_design_height" name="max_design_height" required
                                autocomplete="max_design_height">
                        </div>
                        <InputError :message="form.errors.max_design_height"></InputError>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="s_v">Sv (ft)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="s_v" type="number" step="0.0000000001" class="form-control" v-model="form.s_v"
                                name="s_v" required autocomplete="s_v">
                        </div>
                        <InputError :message="form.errors.s_v"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>

        <div class="text-right py-3">
            <Link :href="route('user.projects.designs.index', project.id)" class="btn btn-outline-primary mr-2">Back
            </Link>
            <button type="submit" class="btn btn-danger mr-2">Update
            </button>
        </div>
    </form>
</template>

<style scoped>
#imageview {
    height: 100px;
}

.btn-circle {
    width: 25px;
    height: 25px;
    padding: 0px 0px;
    margin: 3px;
    border-radius: 15px;
    font-size: 15px;
    text-align: center;
}
</style>