<script setup>
import { Map, View, Feature, Overlay } from 'ol'
import Tile from 'ol/layer/Tile'
import OSM from 'ol/source/OSM'
import { fromLonLat, transform } from 'ol/proj'
import Point from 'ol/geom/Point'
import { Style } from 'ol/style'
import Icon from 'ol/style/Icon'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import { onMounted } from 'vue'
const props = defineProps({
    project: Object,
    cord: Object,
    recent_designs_count: Number,
    designs_count: Number,
    members_count: Number,
    documents_count: Number,
    can: Object
})
onMounted(() => {
    var map = new Map({
        target: 'map',
        layers: [
            new Tile({
                source: new OSM()
            })
        ],
        view: new View({
            center: fromLonLat(props.cord),
            zoom: 6
        }),
    })
    var myStyle = new Style({
        image: new Icon({
            anchor: [0.5, 35],
            anchorXUnits: 'fraction',
            anchorYUnits: 'pixels',
            src: '/image/map/icons/pin.png'
        })
    })
    var layer = new VectorLayer({
        source: new VectorSource({
            features: [
                new Feature({
                    geometry: new Point(fromLonLat([props.project
                        .longitude, props.project.latitude
                    ]))
                })
            ]
        }),
        style: (feature) => {
            return [myStyle];
        }
    });
    map.addLayer(layer);
    var tooltip = document.getElementById('tooltip')
    var overlay = new Overlay({
        element: tooltip,
        offset: [10, 0],
        positioning: 'bottom-left'
    });
    map.addOverlay(overlay);

    function displayTooltip(evt) {
        var pixel = evt.pixel;
        var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
            return feature;
        });
        tooltip.style.display = feature ? '' : 'none';
        if (feature) {
            overlay.setPosition(evt.coordinate);
            tooltip.innerHTML = 'Project location';
        }
    };

    map.on('pointermove', displayTooltip);
})
</script>

<script>
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
export default {
    layout: (h, page) => h(ProjectLayout, { 'project': page.props.project }, () => page)
}
</script>

<template>

    <Head title="Dashboard" />

    <div class="container-fluid py-3">
        <div class="card p-3">
            <div class="row">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="info-box my-1">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-object-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ recent_designs_count }}
                            </span>
                            <span class="info-box-text">Recent designs</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="info-box my-1">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-object-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ designs_count }}
                            </span>
                            <span class="info-box-text">Total designs</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="info-box my-1">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">{{ members_count }}</span>
                            <span class="info-box-text">Project members</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="info-box my-1">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">{{ documents_count }}</span>
                            <span class="info-box-text">Documents</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h4 class="font-weight-normal">Basic data</h4>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 my-auto">
                        <img v-if="project.image" :src="'/storage/project/image/' + project.image" style="width: 100%"
                            alt="image">
                        <img v-else :src="'/storage/project/image/default.jpg'" style="width: 100%" alt="image">
                    </div>

                    <div class="col-md-6 col-lg-8 my-auto">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                Name <a class="float-right">{{ project.name }}</a>
                            </li>
                            <li class="list-group-item">
                                Location <a class="float-right">{{ project.location }}</a>
                            </li>
                            <li class="list-group-item">
                                Latitude (deg) <a class="float-right">{{ project.latitude }}</a>
                            </li>
                            <li class="list-group-item">
                                Longitude (deg) <a class="float-right">{{ project.longitude }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="font-weight-normal">Location on Map</h4>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                        <div id="tooltip" class="text-bold"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-11">
                                <h4 class="font-weight-normal">Description</h4>
                            </div>
                            <div class="col-1 text-right">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ project.description }}
                    </div>
                </div>
            </div>
        </div>
        <div v-if="can.edit_project" class="text-right py-3">
            <Link :href="route('user.projects.edit', project.id)" class="btn btn-primary px-4">Edit</Link>
        </div>
    </div>
</template>

<style>
@import 'ol/ol.css';
</style>
<style scoped>
#map {
    height: 25rem;
    width: 100%;
}
</style>