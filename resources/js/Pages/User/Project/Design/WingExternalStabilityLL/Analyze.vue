<script setup>
import ShowCard from '@/Components/ShowCard.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({
    project: Object,
    design: Object,
    project: Object,
    dh_values: Array,
    rl_values: Array,
    p_ls_v_values: Array,
    p_ev_values: Array,
    m_ls_v_values: Array,
    m_ev_values: Array,
    p_ls_h_values: Array,
    p_eh_values: Array,
    p_eq_values: Array,
    m_ls_h_values: Array,
    m_eh_values: Array,
    m_eq_values: Array,
    pu_ser_i_v_values: Array,
    mu_ser_i_v_values: Array,
    pu_str_i_v_values: Array,
    mu_str_i_v_values: Array,
    pu_ee_i_v_values: Array,
    mu_ee_i_v_values: Array,
    pu_ser_i_lat_values: Array,
    mu_ser_i_lat_values: Array,
    pu_str_i_lat_values: Array,
    mu_str_i_lat_values: Array,
    pu_ee_i_lat_values: Array,
    mu_ee_i_lat_values: Array,
    ecc_brg_str_i_values: Array,
    s_u_brg_str_i_values: Array,
    check_brg_str_i_values: Array,
    ecc_ovt_str_i_values: Array,
    check_ovt_str_i_values: Array,
    phi_rr_str_i_class_1_values: Array,
    phi_rr_str_i_f_soil_values: Array,
    check_sld_str_i_class_1_values: Array,
    check_sld_str_i_f_soil_values: Array,
    ecc_brg_ee_i_values: Array,
    s_u_brg_ee_i_values: Array,
    check_brg_ee_i_values: Array,
    ecc_ovt_ee_i_values: Array,
    check_ovt_ee_i_values: Array,
    phi_rr_ee_i_class_1_values: Array,
    phi_rr_ee_i_f_soil_values: Array,
    check_sld_ee_i_class_1_values: Array,
    check_sld_ee_i_f_soil_values: Array,
    ecc_brg_ser_i_values: Array,
    s_u_brg_ser_i_values: Array,
    check_brg_ser_i_values: Array,
    dem_brg_str_i_values: Array,
    dem_brg_ee_i_values: Array,
    dem_brg_ser_i_values: Array,
    dem_ovt_str_i_values: Array,
    dem_ovt_ee_i_values: Array,
    dem_sld_str_i_values: Array,
    dem_sld_ee_i_values: Array,
    dem_ctrl_values: Array,
    limit_state_values: Array,
    nl_values: Array,
})
const form = useForm({ min_rl: '' })
const changeMinRL = () => {
    document.getElementById('close-change-min-rl').click()
    form.get(route('user.projects.designs.abutment_external_stability.analyze', {
        project: props.project.id,
        abutment_external_stability: props.design.id,
        min_rl: form.min_rl
    }), {
        preserveScroll: true,
        preserveState: true
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

    <Head title="Design Check" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Design Results</h3>
    <ShowCard title="Loads">
        <div class="row">
            <div class="col-md-6 offset-3">
                <img class="img-fluid w-100" :src="'/image/abutment.png'" alt="" />
            </div>
        </div>
    </ShowCard>
    <ShowCard title="Summary of Loads">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>DH (ft)</th>
                    <th>RL (ft)</th>
                    <th>PLS.V (kip/ft)</th>
                    <th>PEV (kip/ft)</th>
                    <th>MLS.V (kip.ft/ft)</th>
                    <th>MEV (kip.ft/ft)</th>
                    <th>PLS.H (kip/ft)</th>
                    <th>PEH (kip/ft)</th>
                    <th>PEQ (kip/ft)</th>
                    <th>MLS.H (kip.ft/ft)</th>
                    <th>MEH (kip.ft/ft)</th>
                    <th>MEQ (kip.ft/ft)</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dh.toFixed(2) }}</td>
                        <td>{{ rl_values[index].toFixed(2) }}</td>
                        <td>{{ p_ls_v_values[index].toFixed(1) }}</td>
                        <td>{{ p_ev_values[index].toFixed(2) }}</td>
                        <td>{{ m_ls_v_values[index].toFixed(2) }}</td>
                        <td>{{ m_ev_values[index].toFixed(2) }}</td>
                        <td>{{ p_ls_h_values[index].toFixed(3) }}</td>
                        <td>{{ p_eh_values[index].toFixed(3) }}</td>
                        <td>{{ p_eq_values[index].toFixed(3) }}</td>
                        <td>{{ m_ls_h_values[index].toFixed(3) }}</td>
                        <td>{{ m_eh_values[index].toFixed(3) }}</td>
                        <td>{{ m_eq_values[index].toFixed(3) }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Load Combinations">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th colspan="6">Vertical Loads</th>
                    <th colspan="6">Lateral Loads</th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="2">Service I</th>
                    <th colspan="2">Strength I</th>
                    <th colspan="2">Extreme Event I</th>
                    <th colspan="2">Service I</th>
                    <th colspan="2">Strength I</th>
                    <th colspan="2">Extreme Event I</th>
                </tr>
                <tr>
                    <th>DH (ft)</th>
                    <th>Pu_ser.I.V (kip/ft)</th>
                    <th>Mu_ser.I.V (kip.ft/ft)</th>
                    <th>Pu_str.I.V (kip/ft)</th>
                    <th>Mu_str.I.V (kip.ft/ft)</th>
                    <th>Pu_EE.I.V (kip/ft)</th>
                    <th>Mu_EE.I.V (kip.ft/ft)</th>
                    <th>Pu_ser.I.lat (kip/ft)</th>
                    <th>Mu_ser.I.lat (kip.ft/ft)</th>
                    <th>Pu_str.I.lat (kip/ft)</th>
                    <th>Mu_str.I.lat (kip.ft/ft)</th>
                    <th>Pu_EE.I.lat (kip/ft)</th>
                    <th>Mu_EE.I.lat (kip.ft/ft)</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dh.toFixed(2) }}</td>
                        <td>{{ pu_ser_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ser_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ pu_str_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ mu_str_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ pu_ee_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ee_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ pu_ser_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ser_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ pu_str_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ mu_str_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ pu_ee_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ee_i_lat_values[index].toFixed(2) }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Design Check - Strength  I">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th></th>
                    <th colspan="5">Bearing Pressure Calculations</th>
                    <th colspan="9">Overturning/Sliding Calculations</th>
                </tr>
                <tr>
                    <th>DH (ft)</th>
                    <th>RL (ft)</th>
                    <th>Pu_brg (kip/ft)</th>
                    <th>Mu_brg (kip.ft/ft)</th>
                    <th>Eccentricity (ft.)</th>
                    <th>σu_brg (ksf)</th>
                    <th>Bearing Check</th>
                    <th>Pu_sld (kip/ft)</th>
                    <th>Mu_sld (kip.ft/ft)</th>
                    <th>Eccentricity (ft.)</th>
                    <th>Eccentricity Check</th>
                    <th>Hu_sld (kip/ft)</th>
                    <th>ϕ_RR Class-1 (kip/ft)</th>
                    <th>ϕ_RR F.Soil. (kip/ft)</th>
                    <th>Sliding Check (Class-1 Fill)</th>
                    <th>Sliding Check (Foundation Soil)</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dh.toFixed(2) }}</td>
                        <td>{{ rl_values[index].toFixed(2) }}</td>
                        <td>{{ pu_str_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ mu_str_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ ecc_brg_str_i_values[index].toFixed(3) }}</td>
                        <td>{{ s_u_brg_str_i_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_brg_str_i_values[index] === 'Adequate', 'bg-light-red': check_brg_str_i_values[index] !== 'Adequate' }">
                            {{ check_brg_str_i_values[index] }}</td>
                        <td>{{ p_ev_values[index].toFixed(2) }}</td>
                        <td>{{ mu_str_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ ecc_ovt_str_i_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_ovt_str_i_values[index] === 'Adequate', 'bg-light-red': check_ovt_str_i_values[index] !== 'Adequate' }">
                            {{ check_ovt_str_i_values[index] }}</td>
                        <td>{{ pu_str_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ phi_rr_str_i_class_1_values[index].toFixed(3) }}</td>
                        <td>{{ phi_rr_str_i_f_soil_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_sld_str_i_class_1_values[index] === 'Adequate', 'bg-light-red': check_sld_str_i_class_1_values[index] !== 'Adequate' }">
                            {{ check_sld_str_i_class_1_values[index] }}</td>
                        <td
                            :class="{ 'bg-light-green': check_sld_str_i_f_soil_values[index] === 'Adequate', 'bg-light-red': check_sld_str_i_f_soil_values[index] !== 'Adequate' }">
                            {{ check_sld_str_i_f_soil_values[index] }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Design Check - Extreme Event  I">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th></th>
                    <th colspan="5">Bearing Pressure Calculations</th>
                    <th colspan="9">Overturning/Sliding Calculations</th>
                </tr>
                <tr>
                    <th>DH (ft)</th>
                    <th>RL (ft)</th>
                    <th>Pu_brg (kip/ft)</th>
                    <th>Mu_brg (kip.ft/ft)</th>
                    <th>Eccentricity (ft.)</th>
                    <th>σu_brg (ksf)</th>
                    <th>Bearing Check</th>
                    <th>Pu_sld (kip/ft)</th>
                    <th>Mu_sld (kip.ft/ft)</th>
                    <th>Eccentricity (ft.)</th>
                    <th>Eccentricity Check</th>
                    <th>Hu_sld (kip/ft)</th>
                    <th>ϕ_RR Class-1 (kip/ft)</th>
                    <th>ϕ_RR F.Soil. (kip/ft)</th>
                    <th>Sliding Check (Class-1 Fill)</th>
                    <th>Sliding Check (Foundation Soil)</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dh.toFixed(2) }}</td>
                        <td>{{ rl_values[index].toFixed(2) }}</td>
                        <td>{{ pu_ee_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ee_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ ecc_brg_ee_i_values[index].toFixed(3) }}</td>
                        <td>{{ s_u_brg_ee_i_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_brg_ee_i_values[index] === 'Adequate', 'bg-light-red': check_brg_ee_i_values[index] !== 'Adequate' }">
                            {{ check_brg_ee_i_values[index] }}</td>
                        <td>{{ p_ev_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ee_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ ecc_ovt_ee_i_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_ovt_ee_i_values[index] === 'Adequate', 'bg-light-red': check_ovt_ee_i_values[index] !== 'Adequate' }">
                            {{ check_ovt_ee_i_values[index] }}</td>
                        <td>{{ pu_ee_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ phi_rr_ee_i_class_1_values[index].toFixed(3) }}</td>
                        <td>{{ phi_rr_str_i_f_soil_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_sld_str_i_class_1_values[index] === 'Adequate', 'bg-light-red': check_sld_str_i_class_1_values[index] !== 'Adequate' }">
                            {{ check_sld_str_i_class_1_values[index] }}</td>
                        <td
                            :class="{ 'bg-light-green': check_sld_str_i_f_soil_values[index] === 'Adequate', 'bg-light-red': check_sld_str_i_f_soil_values[index] !== 'Adequate' }">
                            {{ check_sld_str_i_f_soil_values[index] }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Design Check - Extreme Event  I">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th></th>
                    <th colspan="5">Bearing Pressure Calculations</th>
                </tr>
                <tr>
                    <th>DH (ft)</th>
                    <th>RL (ft)</th>
                    <th>Pu_brg (kip/ft)</th>
                    <th>Mu_brg (kip.ft/ft)</th>
                    <th>Eccentricity (ft.)</th>
                    <th>σu_brg (ksf)</th>
                    <th>Bearing Check</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dh.toFixed(2) }}</td>
                        <td>{{ rl_values[index].toFixed(2) }}</td>
                        <td>{{ pu_ser_i_v_values[index].toFixed(2) }}</td>
                        <td>{{ mu_ser_i_lat_values[index].toFixed(2) }}</td>
                        <td>{{ ecc_brg_ser_i_values[index].toFixed(3) }}</td>
                        <td>{{ s_u_brg_ser_i_values[index].toFixed(3) }}</td>
                        <td
                            :class="{ 'bg-light-green': check_brg_ser_i_values[index] === 'Adequate', 'bg-light-red': check_brg_ser_i_values[index] !== 'Adequate' }">
                            {{ check_brg_ser_i_values[index] }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Percentage Demand">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th colspan="3">Bearing (% Demand)</th>
                    <th class="bg-lightblue"></th>
                    <th colspan="2">Overturning (% Demand)</th>
                    <th class="bg-lightblue"></th>
                    <th colspan="2">Sliding (% Demand)</th>
                    <th class="bg-lightblue"></th>
                    <th colspan="2">Controlling Demand</th>
                </tr>
                <tr>
                    <th>Strength I</th>
                    <th>EE I</th>
                    <th>Service I</th>
                    <th class="bg-lightblue"></th>
                    <th>Strength I</th>
                    <th>EE I</th>
                    <th class="bg-lightblue"></th>
                    <th>Strength I</th>
                    <th>EE I</th>
                    <th class="bg-lightblue"></th>
                    <th>% Demand</th>
                    <th>Limit State</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dem_brg_str_i_values[index].toFixed(2) }}</td>
                        <td>{{ dem_brg_ee_i_values[index].toFixed(2) }}</td>
                        <td>{{ dem_brg_ser_i_values[index].toFixed(2) }}</td>
                        <td class="bg-lightblue"></td>
                        <td>{{ dem_ovt_str_i_values[index].toFixed(2) }}</td>
                        <td>{{ dem_ovt_ee_i_values[index].toFixed(2) }}</td>
                        <td class="bg-lightblue"></td>
                        <td>{{ dem_sld_str_i_values[index].toFixed(2) }}</td>
                        <td>{{ dem_sld_ee_i_values[index].toFixed(2) }}</td>
                        <td class="bg-lightblue"></td>
                        <td>{{ dem_ctrl_values[index].toFixed(2) }}</td>
                        <td>{{ limit_state_values[index] }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <ShowCard title="Demand Summary">
        <table class="table compact-table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>DH (ft.)</th>
                    <th>RL (ft.)</th>
                    <th>Controls RL External Stability</th>
                    <th>NL</th>
                    <th>FBP (ksf)</th>
                    <th>FSL (kip/ft)</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dh_values.length">
                    <tr v-for="(dh, index) in dh_values" :key="index">
                        <td>{{ dh.toFixed(2) }}</td>
                        <td>{{ rl_values[index].toFixed(2) }}</td>
                        <td>{{ limit_state_values[index] }}</td>
                        <td>{{ nl_values[index].toFixed(2) }}</td>
                        <td>{{ s_u_brg_str_i_values[index].toFixed(3) }}</td>
                        <td>{{ pu_str_i_lat_values[index].toFixed(2) }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </ShowCard>
    <div class="text-right py-3">
        <a :href="route('user.projects.designs.abutment_external_stability.show', { 'project': project.id, 'abutment_external_stability': design.id })"
            class="btn btn-outline-primary mr-2">Back</a>
        <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal"
            data-bs-target="#modal-change-min-rl">Change
            Min.
            RL</button>
        <!-- <a :href="route('user.projects.designs.abutment_external_stability.word_report', { 'project': project.id, 'abutment_external_stability': design.id })"
            class="btn btn-primary mr-2">Word report</a>
        <a :href="route('user.projects.designs.abutment_external_stability.excel_report', { 'project': project.id, 'abutment_external_stability': design.id })"
            class="btn btn-primary mr-2">Excel report</a> -->

        <div class="modal modal-danger fade" id="modal-change-min-rl">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="changeMinRL()">
                        <div class="card">
                            <div class="card-header text-start">
                                <h4>Change Minimum Reinforcement</h4>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="input-group mt-4">
                                        <input id="min_rl" type="number" step="0.001" class="form-control"
                                            v-model="form.min_rl" name="min_rl" placeholder="Minimum Reinforcement"
                                            required>
                                    </div>
                                    <InputError :message="form.errors.min_rl"></InputError>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="button" id="close-change-min-rl" class="btn btn-primary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger ms-2">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.compact-table th,
.compact-table td {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
}

.bg-light-green {
    background-color: lightgreen;
}

.bg-light-red {
    background-color: lightcoral;
}
</style>