<script setup>
import Req from '@/Components/RequiredIndicator.vue'
import InputCard from '@/Components/InputCard.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({
    project: Object
})
const form = useForm({
    // LS Moment Arm
    yev: '',
    yls_v: '',

    // Material Properties
    // fpc: '',
    // fy: '',
    // g_conc: '',
    // e_steel: '',
    // e_conc: '',
    // cpf_soil: '',
    bstem_batter: '',
    // theta: '',
    b_i: '',
    sigma_brg: '',
    delta_s: '',
    g_r_fill: '',
    phi_r_fill: '',
    // cpr_fill: '',
    // g_b_fill: '',
    // phi_b_fill: '',
    // cpb_fill: '',
    // g_f_soil: '',
    phi_f_soil: '',

    // EQ Parameters
    pga: '',
    // s_s_eq: '',
    // s_1_eq: '',
    f_pga_eq: '',
    // f_a_eq: '',
    // f_v_eq: '',
    // s_d1_eq: '',
    // a_s_eq: '',
    k_v: '',

    // Height and spacing
    min_design_height: '',
    max_design_height: '',
    s_v: '',
    // s_h: ''
})

const submit = (project_id) => {
    form.post(route('user.projects.designs.abutment_external_stability.store', project_id), {
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
    <form @submit.prevent="submit(project.id)">
        <InputCard title="Load and Resistance Factors">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5>Design Information</h5>
                    <p>Design Standard: AASHTO</p>
                    <h6>Parameters Used:</h6>
                    <ul>
                        <li>Load Factors: Service, Strength, Extreme Event</li>
                        <li>Resistance Factors: Bearing, Sliding, Extreme Event</li>
                        <li>Material Properties: Concrete strength, Steel yield strength, Soil properties</li>
                        <li>Seismic Parameters: Peak Ground Acceleration, Site Class Factors</li>
                    </ul>
                    <br>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="6">Resistance Factors</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>φb.str</td>
                                <td>0.65</td>
                                <td>φb.ee</td>
                                <td>0.9</td>
                                <td>φsliding</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3">Strength I</th>
                            </tr>
                        </thead>
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Vertical Loads</th>
                                <th>Lateral Loads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>YLS.str.I</td>
                                <td>1.75</td>
                                <td>1.75</td>
                            </tr>
                            <tr>
                                <td>YEH.str.I</td>
                                <td>1.5</td>
                                <td>1.5</td>
                            </tr>
                            <tr>
                                <td>YEV.str.I</td>
                                <td>1.35</td>
                                <td>1.35</td>
                            </tr>
                            <tr>
                                <td>YEQ.str.I</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>YEV.str.I.Min</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3">Service I</th>
                            </tr>
                        </thead>
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Vertical Loads</th>
                                <th>Lateral Loads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>YLS.ser.I</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>YEH.ser.I</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>YEV.ser.I</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>YEQ.ser.I</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3">Extreme Event I</th>
                            </tr>
                        </thead>
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Vertical Loads</th>
                                <th>Lateral Loads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>YLS.ee.I</td>
                                <td>0.5</td>
                                <td>0.5</td>
                            </tr>
                            <tr>
                                <td>YEH.ee.I</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>YEV.ee.I</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>YEQ.ee.I</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </InputCard>
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
                <!-- <div class="col-md-3">
                    <div class="container-fluild form-group">
                        <label for="fpc">f'c (ksi)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="fpc" type="number" step="0.0000000001" class="form-control" v-model="form.fpc"
                                name="fpc" required autocomplete="fpc">
                        </div>
                        <InputError :message="form.errors.fpc"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="fy">fy (ksi)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="fy" type="number" step="0.0000000001" class="form-control" v-model="form.fy"
                                name="fy" required autocomplete="fy">
                        </div>
                        <InputError :message="form.errors.fy"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="g_conc">ϒconc (kcf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="g_conc" type="number" step="0.0000000001" class="form-control"
                                v-model="form.g_conc" name="g_conc" required autocomplete="g_conc">
                        </div>
                        <InputError :message="form.errors.g_conc"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="e_steel">Esteel (ksi)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="e_steel" type="number" step="0.0000000001" class="form-control"
                                v-model="form.e_steel" name="e_steel" required autocomplete="e_steel">
                        </div>
                        <InputError :message="form.errors.e_steel"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="e_conc">Econc (ksi)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="e_conc" type="number" step="0.0000000001" class="form-control"
                                v-model="form.e_conc" name="e_conc" required autocomplete="e_conc">
                        </div>
                        <InputError :message="form.errors.e_conc"></InputError>
                    </div>
                </div> -->
                <div class="col-md-3">
                    <!-- <div class="container-fluild form-group">
                        <label for="cpf_soil">C'F.soil (psf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="cpf_soil" type="number" step="0.0000000001" class="form-control"
                                v-model="form.cpf_soil" name="cpf_soil" required autocomplete="cpf_soil">
                        </div>
                        <InputError :message="form.errors.cpf_soil"></InputError>
                    </div> -->
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
                    <!-- <div class="container-fluild form-group">
                        <label for="ϴ">ϴ (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="theta" type="number" step="0.0000000001" class="form-control"
                                v-model="form.theta" name="theta" required autocomplete="theta">
                        </div>
                        <InputError :message="form.errors.theta"></InputError>
                    </div> -->
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
                <div class="col-md-3">
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
                    <!-- <div class="container-fluild form-group">
                        <label for="cpr_fill">C'r .Fill (psf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="cpr_fill" type="number" step="0.0000000001" class="form-control"
                                v-model="form.cpr_fill" name="cpr_fill" required autocomplete="cpr_fill">
                        </div>
                        <InputError :message="form.errors.cpr_fill"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="g_b_fill">ϒB.Fill (pcf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="g_b_fill" type="number" step="0.0000000001" class="form-control"
                                v-model="form.g_b_fill" name="g_b_fill" required autocomplete="g_b_fill">
                        </div>
                        <InputError :message="form.errors.g_b_fill"></InputError>
                    </div> -->
                </div>
                <div class="col-md-3">
                    <!-- <div class="container-fluild form-group">
                        <label for="phi_b_fill">ØB.Fill (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="phi_b_fill" type="number" step="0.0000000001" class="form-control"
                                v-model="form.phi_b_fill" name="phi_b_fill" required autocomplete="phi_b_fill">
                        </div>
                        <InputError :message="form.errors.phi_b_fill"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="cpb_fill">C'B.Fill (psf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="cpb_fill" type="number" step="0.0000000001" class="form-control"
                                v-model="form.cpb_fill" name="cpb_fill" required autocomplete="cpb_fill">
                        </div>
                        <InputError :message="form.errors.cpb_fill"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="g_f_soil">ϒF.soil (pcf)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="g_f_soil" type="number" step="0.0000000001" class="form-control"
                                v-model="form.g_f_soil" name="g_f_soil" required autocomplete="g_f_soil">
                        </div>
                        <InputError :message="form.errors.g_f_soil"></InputError>
                    </div> -->
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
                <div class="col-md-3">
                    <div class="container-fluid form-group">
                        <label for="pga">PGA</label>
                        <div class="input-group mb-3">
                            <input id="pga" type="number" step="0.0000000001" class="form-control" v-model="form.pga"
                                name="pga" required autocomplete="pga">
                        </div>
                        <InputError :message="form.errors.pga"></InputError>
                    </div>
                    <!-- <div class="container-fluid form-group">
                        <label for="s_s_eq">S_s.EQ</label>
                        <div class="input-group mb-3">
                            <input id="s_s_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.s_s_eq" name="s_s_eq" required autocomplete="s_s_eq">
                        </div>
                        <InputError :message="form.errors.s_s_eq"></InputError>
                    </div>
                    <div class="container-fluid form-group">
                        <label for="s_1_eq">S_1.EQ</label>
                        <div class="input-group mb-3">
                            <input id="s_1_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.s_1_eq" name="s_1_eq" required autocomplete="s_1_eq">
                        </div>
                        <InputError :message="form.errors.s_1_eq"></InputError>
                    </div> -->
                </div>
                <div class="col-md-3">
                    <div class="container-fluid form-group">
                        <label for="f_pga_eq">F_PGA.EQ</label>
                        <div class="input-group mb-3">
                            <input id="f_pga_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.f_pga_eq" name="f_pga_eq" required autocomplete="f_pga_eq">
                        </div>
                        <InputError :message="form.errors.f_pga_eq"></InputError>
                    </div>
                    <!-- <div class="container-fluid form-group">
                        <label for="f_a_eq">F_A.EQ</label>
                        <div class="input-group mb-3">
                            <input id="f_a_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.f_a_eq" name="f_a_eq" required autocomplete="f_a_eq">
                        </div>
                        <InputError :message="form.errors.f_a_eq"></InputError>
                    </div> -->
                </div>
                <div class="col-md-3">
                    <!-- <div class="container-fluid form-group">
                        <label for="f_v_eq">F_V.EQ</label>
                        <div class="input-group mb-3">
                            <input id="f_v_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.f_v_eq" name="f_v_eq" required autocomplete="f_v_eq">
                        </div>
                        <InputError :message="form.errors.f_v_eq"></InputError>
                    </div>
                    <div class="container-fluid form-group">
                        <label for="s_d1_eq">S_D1.EQ</label>
                        <div class="input-group mb-3">
                            <input id="s_d1_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.s_d1_eq" name="s_d1_eq" required autocomplete="s_d1_eq">
                        </div>
                        <InputError :message="form.errors.s_d1_eq"></InputError>
                    </div> -->
                </div>
                <div class="col-md-3">
                    <!-- <div class="container-fluid form-group">
                        <label for="a_s_eq">A_s.EQ</label>
                        <div class="input-group mb-3">
                            <input id="a_s_eq" type="number" step="0.0000000001" class="form-control"
                                v-model="form.a_s_eq" name="a_s_eq" required autocomplete="a_s_eq">
                        </div>
                        <InputError :message="form.errors.a_s_eq"></InputError>
                    </div> -->
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
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <!-- <div class="container-fluild form-group">
                        <label for="s_h">Sh (ft)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="s_h" type="number" step="0.0000000001" class="form-control" v-model="form.s_h"
                                name="s_h" required autocomplete="s_h">
                        </div>
                        <InputError :message="form.errors.s_h"></InputError>
                    </div> -->
                </div>
            </div>
        </InputCard>

        <div class="text-right py-3">
            <Link :href="route('user.projects.designs.index', project.id)" class="btn btn-outline-primary mr-2">Back
            </Link>
            <button type="submit" class="btn btn-primary mr-2">Create
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