<?php

namespace App\Http\Controllers\Project\Design;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignType;
use App\Models\Project;
use App\Models\WingExternalStabilityLl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WingExternalLController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(string $project_id)
    {
        Gate::authorize('create', [Design::class, $project_id]);
        $project = Project::find($project_id);
        return inertia('User/Project/Design/WingExternalStabilityLL/Create')->with([
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $project_id)
    {
        Gate::authorize('create', [Design::class, $project_id]);

        $validated = $request->validate([
            // LS Moment Arm
            'yev' => 'numeric|required',
            'yls_v' => 'numeric|required',

            // Material Properties
            'bstem_batter' => 'numeric|required',
            'b_i' => 'numeric|required',
            'sigma_brg' => 'numeric|required',
            'delta_s' => 'numeric|required',
            'g_r_fill' => 'numeric|required',
            'phi_r_fill' => 'numeric|required',
            'phi_f_soil' => 'numeric|required',

            // EQ Parameters
            'pga' => 'numeric|required',
            'f_pga_eq' => 'numeric|required',
            'k_v' => 'numeric|required',

            // Design Height and Spacing
            'min_design_height' => 'numeric|required',
            'max_design_height' => 'numeric|required',
            's_v' => 'numeric|required',
        ]);

        // Assuming you have a Design model
        $design = new Design();
        $design->user_id = Auth::id();
        $design->project_id = $project_id;
        $design->design_type_id = DesignType::WING_EXTERNAL_LL;
        $design->save();

        $wing_external_ll = new WingExternalStabilityLl($validated);
        $wing_external_ll->project_id = $project_id;
        $wing_external_ll->design_id = $design->id;
        $wing_external_ll->save();

        return redirect(route('user.projects.designs.index', $design->project_id));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $project_id, string $design_id)
    {
        $design = Design::with(['user', 'design_type', 'wing_external_stability_ll'])->findOrFail($design_id);
        Gate::authorize('view', [$design, $project_id]);
        $project = Project::findOrFail($project_id);
        return inertia('User/Project/Design/WingExternalStabilityLL/Show')->with([
            'project' => $project,
            'design' => $design,
            'can' => [
                'edit_design' => Auth::user()->can('update', $design),
                'delete_design' => Auth::user()->can('delete', $design),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $project_id, string $design_id)
    {
        $design = Design::with(['user', 'design_type', 'wing_external_stability_ll'])->findOrFail($design_id);
        Gate::authorize('update', $design);
        $project = Project::find($project_id);
        return inertia('User/Project/Design/WingExternalStabilityLL/Edit')->with([
            'design' => $design,
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $project_id, string $design_id)
    {
        $design = Design::findOrFail($design_id);
        Gate::authorize('update', $design);

        $validated = $request->validate([
            // LS Moment Arm
            'yev' => 'numeric|required',
            'yls_v' => 'numeric|required',

            // Material Properties
            'bstem_batter' => 'numeric|required',
            'b_i' => 'numeric|required',
            'sigma_brg' => 'numeric|required',
            'delta_s' => 'numeric|required',
            'g_r_fill' => 'numeric|required',
            'phi_r_fill' => 'numeric|required',
            'phi_f_soil' => 'numeric|required',

            // EQ Parameters
            'pga' => 'numeric|required',
            'f_pga_eq' => 'numeric|required',
            'k_v' => 'numeric|required',

            // Design Height and Spacing
            'min_design_height' => 'numeric|required',
            'max_design_height' => 'numeric|required',
            's_v' => 'numeric|required',
        ]);

        $design->wing_external_stability_ll->update($validated);

        return redirect(route('user.projects.designs.wing_external_stability_ll.show', [$project_id, $design->id]))->with('success', 'Design updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $project_id, string $design_id)
    {
        $design = Design::findOrFail($design_id);
        Gate::authorize('delete', $design);
        $design->delete();
        return redirect(route('user.projects.designs.index', $project_id))->with('success', 'Design deleted successfully');
    }

    /**
     * Analyze test data.
     */
    public function analyze(Request $request, string $project_id, string $design_id)
    {
        $design = Design::findOrFail($design_id);
        Gate::authorize('view', [$design, $project_id]);
        $design_detail = $design->wing_external_stability_ll;
        $project = Project::find($project_id);
        $min_rl = (float) $request->query('min_rl', 8);

        // Get input parameters
        $y_ls_ser_i = 1;
        $y_eh_ser_i = 1;
        $y_ev_ser_i = 1;
        $y_eq_ser_i = 0;
        $y_ls_str_i = 1.75;
        $y_eh_str_i = 1.5;
        $y_ev_str_i = 1.35;
        $y_eq_str_i = 0;
        $y_ev_str_i_min = 1;
        $y_ls_ee_i = 0.5;
        $y_eh_ee_i = 0;
        $y_ev_ee_i = 1;
        $y_eq_ee_i = 1;
        $phi_b_str = 0.65;
        $phi_b_ee = 0.9;
        $phi_sliding = 1;
        $yev = $design_detail->yev;
        $yls_v = $design_detail->yls_v;
        $bstem_batter = $design_detail->bstem_batter;
        $b_i = $design_detail->b_i;
        $sigma_brg = $design_detail->sigma_brg;
        $delta_s = $design_detail->delta_s;
        $g_r_fill = $design_detail->g_r_fill;
        $phi_r_fill = $design_detail->phi_r_fill;
        $phi_f_soil = $design_detail->phi_f_soil;
        $pga = $design_detail->pga;
        $f_pga_eq = $design_detail->f_pga_eq;
        $k_v = $design_detail->k_v;
        $min_design_height = $design_detail->min_design_height;
        $max_design_height = $design_detail->max_design_height;
        $s_v = $design_detail->s_v;

        // Initialize values for summary of loads table
        $rl_values = [];
        $p_ls_v_values = [];
        $h_eq_values = [];
        $p_ev_values = [];
        $m_ls_v_values = [];
        $m_ev_values = [];
        $p_ls_h_values = [];
        $p_eh_values = [];
        $p_eq_values = [];
        $m_ls_h_values = [];

        // Initialize values for load combinations table
        $pu_ser_i_v_values = [];
        $mu_ser_i_v_values = [];
        $pu_str_i_v_values = [];
        $pu_str_i_v_values = [];
        $pu_ser_i_lat_values = [];
        $mu_ser_i_lat_values = [];
        $pu_str_i_lat_values = [];
        $pu_str_i_lat_values = [];

        // Initialize values for design check - strength I table
        $ecc_brg_str_i_values = [];
        $s_u_brg_str_i_values = [];
        $check_brg_str_i_values = [];
        $ecc_ovt_str_i_values = [];
        $check_ovt_str_i_values = [];
        $phi_rr_str_i_class_1_values = [];
        $phi_rr_str_i_f_soil_values = [];
        $check_sld_str_i_class_1_values = [];
        $check_sld_str_i_f_soil_values = [];

        // Initialize values for design check - extreme event I table
        $ecc_brg_ee_i_values = [];
        $s_u_brg_ee_i_values = [];
        $check_brg_ee_i_values = [];
        $ecc_ovt_ee_i_values = [];
        $check_ovt_ee_i_values = [];
        $phi_rr_ee_i_class_1_values = [];
        $phi_rr_ee_i_f_soil_values = [];
        $check_sld_ee_i_class_1_values = [];
        $check_sld_ee_i_f_soil_values = [];

        // Initialize values for design check - service I table
        $ecc_brg_ser_i_values = [];
        $s_u_brg_ser_i_values = [];
        $check_brg_ser_i_values = [];

        // Initialize values for percentage demand table
        $dem_brg_str_i_values = [];
        $dem_brg_ee_i_values = [];
        $dem_brg_ser_i_values = [];
        $dem_ovt_str_i_values = [];
        $dem_ovt_ee_i_values = [];
        $dem_sld_str_i_values = [];
        $dem_sld_ee_i_values = [];
        $dem_ctrl_values = [];
        $limit_state_values = [];

        // Initialize values for demand summary table
        $nl_values = [];

        $dh_values = $this->generate_dh($min_design_height, $max_design_height, $s_v);
        foreach ($dh_values as $dh) {
            // Compute values for summary of loads table
            $rl = max(0.7 * $dh, $min_rl);
            $rl_values[] = $rl;
            $h_eq = $this->calculate_h_eq($dh);
            $h_eq_values[] = $h_eq;
            $sigma_ls_v = ($g_r_fill / 1000) * $h_eq;
            $p_ls_v = $sigma_ls_v * $rl;
            $p_ls_v_values[] = $p_ls_v;
            $sigma_ev = ($g_r_fill / 1000) * $dh;
            $p_ev = $rl * $sigma_ev;
            $p_ev_values[] = $p_ev;
            $m_ls_v = $yls_v * $p_ls_v;
            $m_ls_v_values[] = $m_ls_v;
            $m_ev = $yev * $p_ev;
            $m_ev_values[] = $m_ev;
            $k_a = tan((45 * (pi() / 180)) - (($phi_r_fill * (pi() / 180)) / 2)) ** 2;
            $sigma_ls_h = ($g_r_fill / 1000) * $h_eq * $k_a;
            $p_ls_h = $dh * $sigma_ls_h;
            $p_ls_h_values[] = $p_ls_h;
            $p_eh = 0.5 * ($g_r_fill / 1000) * $k_a * ($dh ** 2);
            $p_eh_values[] = $p_eh;
            $k_h = $pga * $f_pga_eq;
            $phi_mo = rad2deg(atan($k_h / (1 - $k_v)));
            $delta_s_radians = $delta_s * pi() / 180;
            $k_ae_term_1 = (cos(($phi_r_fill * pi() / 180) - ($phi_mo * pi() / 180) - ($bstem_batter * pi() / 180)) ** 2) /
                (cos($phi_mo * pi() / 180) * (cos($bstem_batter * pi() / 180) ** 2) * cos(($delta_s_radians + $bstem_batter + $phi_mo) * pi() / 180));
            $k_ae_term_2 = (1 + sqrt((sin(deg2rad($phi_r_fill + $delta_s_radians)) * sin(deg2rad($phi_r_fill - $phi_mo - $b_i))) / (cos(deg2rad($delta_s_radians + $bstem_batter + $phi_mo)) * cos(deg2rad($b_i - $bstem_batter))))) ** -2;
            $k_ae = $k_ae_term_1 * $k_ae_term_2;
            $omega_ir = $k_h * (0.5 * ($g_r_fill / 1000) * ($dh ** 2));
            $omega_ae = 0.5 * ($g_r_fill / 1000) * ($dh ** 2) * $k_ae;
            $omega_eq_1 = (1 * $omega_ae) + (0.5 * $omega_ir);
            $omega_eq_2 = (1 * $omega_ir) + (0.5 * $omega_ae);
            $p_eq = max($omega_eq_1, $omega_eq_2);
            $p_eq_values[] = $p_eq;
            $m_ls_h = $p_ls_h * ($dh / 2);
            $m_ls_h_values[] = $m_ls_h;
            $m_eh = $p_eh * ($dh / 3);
            $m_eh_values[] = $m_eh;
            $m_1 = (1 * $omega_ae * ($dh / 3)) + (0.5 * $omega_ir * (0.5 * $dh));
            $m_2 = (0.5 * $omega_ae * ($dh / 3)) + (1 * $omega_ir * (0.5 * $dh));
            $m_eq = max($m_1, $m_2);
            $m_eq_values[] = $m_eq;

            // Compute values for load combinations table
            $pu_ser_i_v = ($y_ls_ser_i * $p_ls_v) + ($y_ev_ser_i * $p_ev);
            $pu_ser_i_v_values[] = $pu_ser_i_v;
            $mu_ser_i_v = ($y_ls_ser_i * $m_ls_v) + ($y_ev_ser_i * $m_ev);
            $mu_ser_i_v_values[] = $mu_ser_i_v;
            $pu_str_i_v = ($y_ls_str_i * $p_ls_v) + ($y_ev_str_i * $p_ev);
            $pu_str_i_v_values[] = $pu_str_i_v;
            $mu_str_i_v = ($y_ls_str_i * $m_ls_v) + ($y_ev_str_i * $m_ev);
            $mu_str_i_v_values[] = $mu_str_i_v;
            $pu_ee_i_v = ($y_ls_ee_i * $p_ls_v) + ($y_ev_ee_i * $p_ev);
            $pu_ee_i_v_values[] = $pu_ee_i_v;
            $mu_ee_i_v = ($y_ls_ee_i * $m_ls_v) + ($y_ev_ee_i * $m_ev);
            $mu_ee_i_v_values[] = $mu_ee_i_v;
            $pu_ser_i_lat = ($y_ls_ser_i * $p_ls_h) + ($y_eh_ser_i * $p_eh) + ($y_eq_ser_i * $p_eq);
            $pu_ser_i_lat_values[] = $pu_ser_i_lat;
            $mu_ser_i_lat = ($y_ls_ser_i * $m_ls_h) + ($y_eh_ser_i * $m_eh) + ($y_eq_ser_i * $m_eq);
            $mu_ser_i_lat_values[] = $mu_ser_i_lat;
            $pu_str_i_lat = ($y_ls_str_i * $p_ls_h) + ($y_eh_str_i * $p_eh) + ($y_eq_str_i * $p_eq);
            $pu_str_i_lat_values[] = $pu_str_i_lat;
            $mu_str_i_lat = ($y_ls_str_i * $m_ls_h) + ($y_eh_str_i * $m_eh) + ($y_eq_str_i * $m_eq);
            $mu_str_i_lat_values[] = $mu_str_i_lat;
            $pu_ee_i_lat = ($y_ls_ee_i * $p_ls_h) + ($y_eh_ee_i * $p_eh) + ($y_eq_ee_i * $p_eq);
            $pu_ee_i_lat_values[] = $pu_ee_i_lat;
            $mu_ee_i_lat = ($y_ls_ee_i * $m_ls_h) + ($y_eh_ee_i * $m_eh) + ($y_eq_ee_i * $m_eq);
            $mu_ee_i_lat_values[] = $mu_ee_i_lat;

            // Compute values for design check - strength I table
            $ecc_brg_str_i = $mu_str_i_lat / $pu_str_i_v;
            $ecc_brg_str_i_values[] = $ecc_brg_str_i;
            $s_u_brg_str_i = $pu_str_i_v / ($rl - 2 * $ecc_brg_str_i);
            $s_u_brg_str_i_values[] = $s_u_brg_str_i;
            $check_brg_str_i = $s_u_brg_str_i < ($phi_b_str * $sigma_brg) ? "Adequate" : "Inadequate";
            $check_brg_str_i_values[] = $check_brg_str_i;
            $ecc_ovt_str_i = $mu_str_i_lat / ($y_ev_str_i_min * $p_ev);
            $ecc_ovt_str_i_values[] = $ecc_ovt_str_i;
            $check_ovt_str_i = $ecc_ovt_str_i < (0.25 * $rl) ? "Adequate" : "Inadequate";
            $check_ovt_str_i_values[] = $check_ovt_str_i;
            $phi_rr_str_i_class_1 = $phi_sliding * $y_ev_str_i_min * $p_ev * tan(deg2rad($phi_r_fill));
            $phi_rr_str_i_class_1_values[] = $phi_rr_str_i_class_1;
            $phi_rr_str_i_f_soil = $phi_sliding * $y_ev_str_i_min * $p_ev * tan(deg2rad($phi_f_soil));
            $phi_rr_str_i_f_soil_values[] = $phi_rr_str_i_f_soil;
            $check_sld_str_i_class_1 = $phi_rr_str_i_class_1 > $pu_str_i_lat ? "Adequate" : "Inadequate";
            $check_sld_str_i_class_1_values[] = $check_sld_str_i_class_1;
            $check_sld_str_i_f_soil = $phi_rr_str_i_f_soil > $pu_str_i_lat ? "Adequate" : "Inadequate";
            $check_sld_str_i_f_soil_values[] = $check_sld_str_i_f_soil;

            // Compute values for design check - extreme event I table
            $ecc_brg_ee_i = $mu_ee_i_lat / $pu_ee_i_v;
            $ecc_brg_ee_i_values[] = $ecc_brg_ee_i;
            $s_u_brg_ee_i = $pu_ee_i_v / ($rl - 2 * $ecc_brg_ee_i);
            $s_u_brg_ee_i_values[] = $s_u_brg_ee_i;
            $check_brg_ee_i = $s_u_brg_ee_i < ($phi_b_ee * $sigma_brg) ? "Adequate" : "Inadequate";
            $check_brg_ee_i_values[] = $check_brg_ee_i;
            $ecc_ovt_ee_i = $mu_ee_i_lat / ($y_ev_ee_i * $p_ev);
            $ecc_ovt_ee_i_values[] = $ecc_ovt_ee_i;
            $check_ovt_ee_i = $ecc_ovt_ee_i < (0.25 * $rl) ? "Adequate" : "Inadequate";
            $check_ovt_ee_i_values[] = $check_ovt_ee_i;
            $phi_rr_ee_i_class_1 = $phi_sliding * $y_ev_ee_i * $p_ev * tan(deg2rad($phi_r_fill));
            $phi_rr_ee_i_class_1_values[] = $phi_rr_ee_i_class_1;
            $phi_rr_ee_i_f_soil = $phi_sliding * $y_ev_ee_i * $p_ev * tan(deg2rad($phi_f_soil));
            $phi_rr_ee_i_f_soil_values[] = $phi_rr_ee_i_f_soil;
            $check_sld_ee_i_class_1 = $phi_rr_ee_i_class_1 > $pu_ee_i_lat ? "Adequate" : "Inadequate";
            $check_sld_ee_i_class_1_values[] = $check_sld_ee_i_class_1;
            $check_sld_ee_i_f_soil = $phi_rr_ee_i_f_soil > $pu_ee_i_lat ? "Adequate" : "Inadequate";
            $check_sld_ee_i_f_soil_values[] = $check_sld_ee_i_f_soil;

            // Compute values for design check - service I table
            $ecc_brg_ser_i = $mu_ser_i_lat / $pu_ser_i_v;
            $ecc_brg_ser_i_values[] = $ecc_brg_ser_i;
            $s_u_brg_ser_i = $pu_ser_i_v / ($rl - 2 * $ecc_brg_ser_i);
            $s_u_brg_ser_i_values[] = $s_u_brg_ser_i;
            $check_brg_ser_i = $s_u_brg_ser_i < ($phi_b_ee * $sigma_brg) ? "Adequate" : "Inadequate";
            $check_brg_ser_i_values[] = $check_brg_ser_i;

            // Compute values for percentage demand table
            $dem_brg_str_i = $s_u_brg_str_i / ($phi_b_str * $sigma_brg) * 100;
            $dem_brg_str_i_values[] = $dem_brg_str_i;
            $dem_brg_ee_i = $s_u_brg_ee_i / ($phi_b_ee * $sigma_brg) * 100;
            $dem_brg_ee_i_values[] = $dem_brg_ee_i;
            $dem_brg_ser_i = $s_u_brg_ser_i / ($phi_b_str * (0.65 * $sigma_brg)) * 100;
            $dem_brg_ser_i_values[] = $dem_brg_ser_i;
            $dem_ovt_str_i = $ecc_ovt_str_i / (0.25 * $rl) * 100;
            $dem_ovt_str_i_values[] = $dem_ovt_str_i;
            $dem_ovt_ee_i = $ecc_ovt_ee_i / (0.25 * $rl) * 100;
            $dem_ovt_ee_i_values[] = $dem_ovt_ee_i;
            $dem_sld_str_i = $pu_str_i_lat / $phi_rr_str_i_f_soil * 100;
            $dem_sld_str_i_values[] = $dem_sld_str_i;
            $dem_sld_ee_i = $pu_ee_i_lat / $phi_rr_ee_i_f_soil * 100;
            $dem_sld_ee_i_values[] = $dem_sld_ee_i;
            $dem_values = [
                'BEARING STRENGTH I' => $dem_brg_str_i,
                'BEARING EXTREME EVENT I' => $dem_brg_ee_i,
                'BEARING SERVICE I' => $dem_brg_ser_i,
                'OVERTURNING STRENGTH I' => $dem_ovt_str_i,
                'OVERTURNING EXTREME EVENT I' => $dem_ovt_ee_i,
                'SLIDING STRENGTH I' => $dem_sld_str_i,
                'SLIDING EXTREME EVENT I' => $dem_sld_ee_i,
            ];
            $dem_ctrl = max($dem_values);
            $dem_ctrl_values[] = $dem_ctrl;
            $limit_state = array_search($dem_ctrl, $dem_values);
            $limit_state_values[] = $limit_state;

            // Compute values for demand summary table
            $nl = ceil($dh / $s_v);
            $nl_values[] = $nl;
        }

        return inertia('User/Project/Design/WingExternalStabilityLL/Analyze')->with([
            'project' => $project,
            'design' => $design,
            'dh_values' => $dh_values,
            'rl_values' => $rl_values,
            'p_ls_v_values' => $p_ls_v_values,
            'p_ev_values' => $p_ev_values,
            'm_ls_v_values' => $m_ls_v_values,
            'm_ev_values' => $m_ev_values,
            'p_ls_h_values' => $p_ls_h_values,
            'p_eh_values' => $p_eh_values,
            'p_eq_values' => $p_eq_values,
            'm_ls_h_values' => $m_ls_h_values,
            'm_eh_values' => $m_eh_values,
            'm_eq_values' => $m_eq_values,
            'pu_ser_i_v_values' => $pu_ser_i_v_values,
            'mu_ser_i_v_values' => $mu_ser_i_v_values,
            'pu_str_i_v_values' => $pu_str_i_v_values,
            'mu_str_i_v_values' => $mu_str_i_v_values,
            'pu_ee_i_v_values' => $pu_ee_i_v_values,
            'mu_ee_i_v_values' => $mu_ee_i_v_values,
            'pu_ser_i_lat_values' => $pu_ser_i_lat_values,
            'mu_ser_i_lat_values' => $mu_ser_i_lat_values,
            'pu_str_i_lat_values' => $pu_str_i_lat_values,
            'mu_str_i_lat_values' => $mu_str_i_lat_values,
            'pu_ee_i_lat_values' => $pu_ee_i_lat_values,
            'mu_ee_i_lat_values' => $mu_ee_i_lat_values,
            'ecc_brg_str_i_values' => $ecc_brg_str_i_values,
            's_u_brg_str_i_values' => $s_u_brg_str_i_values,
            'check_brg_str_i_values' => $check_brg_str_i_values,
            'ecc_ovt_str_i_values' => $ecc_ovt_str_i_values,
            'check_ovt_str_i_values' => $check_ovt_str_i_values,
            'phi_rr_str_i_class_1_values' => $phi_rr_str_i_class_1_values,
            'phi_rr_str_i_f_soil_values' => $phi_rr_str_i_f_soil_values,
            'check_sld_str_i_class_1_values' => $check_sld_str_i_class_1_values,
            'check_sld_str_i_f_soil_values' => $check_sld_str_i_f_soil_values,
            'ecc_brg_ee_i_values' => $ecc_brg_ee_i_values,
            's_u_brg_ee_i_values' => $s_u_brg_ee_i_values,
            'check_brg_ee_i_values' => $check_brg_ee_i_values,
            'ecc_ovt_ee_i_values' => $ecc_ovt_ee_i_values,
            'check_ovt_ee_i_values' => $check_ovt_ee_i_values,
            'phi_rr_ee_i_class_1_values' => $phi_rr_ee_i_class_1_values,
            'phi_rr_ee_i_f_soil_values' => $phi_rr_ee_i_f_soil_values,
            'check_sld_ee_i_class_1_values' => $check_sld_ee_i_class_1_values,
            'check_sld_ee_i_f_soil_values' => $check_sld_ee_i_f_soil_values,
            'ecc_brg_ser_i_values' => $ecc_brg_ser_i_values,
            's_u_brg_ser_i_values' => $s_u_brg_ser_i_values,
            'check_brg_ser_i_values' => $check_brg_ser_i_values,
            'dem_brg_str_i_values' => $dem_brg_str_i_values,
            'dem_brg_ee_i_values' => $dem_brg_ee_i_values,
            'dem_brg_ser_i_values' => $dem_brg_ser_i_values,
            'dem_ovt_str_i_values' => $dem_ovt_str_i_values,
            'dem_ovt_ee_i_values' => $dem_ovt_ee_i_values,
            'dem_sld_str_i_values' => $dem_sld_str_i_values,
            'dem_sld_ee_i_values' => $dem_sld_ee_i_values,
            'dem_ctrl_values' => $dem_ctrl_values,
            'limit_state_values' => $limit_state_values,
            'nl_values' => $nl_values,
        ]);
    }

    /**
     * Generate dh using min height, max height, and s_v.
     */
    function generate_dh($min_design_height, $max_design_height, $s_v)
    {
        $values = [];
        $spacing = $s_v / 2;
        for ($height = $min_design_height; $height <= $max_design_height; $height += $spacing) {
            $values[] = $height;
        }
        return $values;
    }

    /**
     * Calculate h_eq based on given dh using weighted interpolation between predefined values.
     */
    function calculate_h_eq($dh)
    {
        if ($dh <= 5.0) {
            return 4.0;
        } elseif ($dh >= 20.0) {
            return 2.0;
        } elseif ($dh > 5.0 && $dh <= 10.0) {
            return 4.0 - (($dh - 5.0) / 5.0) * (4.0 - 3.0);
        } else {
            return 3.0 - (($dh - 10.0) / 10.0) * (3.0 - 2.0);
        }
    }
}
