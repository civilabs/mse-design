<script setup>
import { Map, View, Feature, Overlay } from 'ol'
import Tile from 'ol/layer/Tile'
import OSM from 'ol/source/OSM'
import { fromLonLat } from 'ol/proj'
import Point from 'ol/geom/Point'
import { Style } from 'ol/style'
import Icon from 'ol/style/Icon'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import { onMounted } from 'vue'
const props = defineProps({
    projects: Object,
})
const truncate = (input) => {
    if (input.length > 15) {
        return input.substring(0, 15) + '...';
    }
    return input;
}
onMounted(() => {
    var map = new Map({
        target: 'map',
        layers: [
            new Tile({
                source: new OSM()
            })
        ],
        view: new View({
            center: fromLonLat([-104, 38.6]),
            zoom: 7
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
    var layers = [];
    props.projects.forEach(item => {
        var layer = new VectorLayer({
            source: new VectorSource({
                features: [
                    new Feature({
                        geometry: new Point(fromLonLat([item
                            .longitude, item.latitude
                        ])),
                        label: truncate(item.name),
                        name: item.name,
                        id: item.id
                    })
                ]
            }),
            style: (feature) => {
                return [myStyle];
            }
        });

        map.addLayer(layer);
        layers.push(layer);
    });
    map.on("click", (event) => {
        const feature = map.getFeaturesAtPixel(event.pixel);
        if (feature && feature.length > 0) {
            const url = window.location.origin + '/user/projects/' + feature[0].get("id") + '/dashboard';
            document.location.href = url;
        }
    })
    var tooltip = document.getElementById('tooltip');
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
            tooltip.innerHTML = feature.get('name');
        }
    };

    map.on('pointermove', displayTooltip);
});
</script>

<script>
import UserLayout from '@/Layouts/UserLayout.vue';
export default {
    layout: UserLayout
}
</script>

<template>

    <Head title="Projects Map" />

    <div id="map"></div>
    <div id="tooltip" class="text-bold"></div>
</template>

<style>
@import 'ol/ol.css';
</style>
<style scoped>
#map {
    height: 100vh;
    width: 120%;
}
</style>
