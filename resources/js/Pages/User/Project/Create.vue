<script setup>
import { Map, View, Feature } from 'ol'
import Tile from 'ol/layer/Tile'
import OSM from 'ol/source/OSM'
import { fromLonLat, transform } from 'ol/proj'
import Point from 'ol/geom/Point'
import { Style } from 'ol/style'
import Icon from 'ol/style/Icon'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import { onMounted } from 'vue'
import Req from '@/Components/RequiredIndicator.vue'
import InputCard from '@/Components/InputCard.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
const form = useForm({
    name: '',
    location: '',
    latitude: '',
    longitude: '',
    description: '',
    image: ''
})
const acceptImage = (event) => {
    form.image = event.target.files[0]
    document.getElementById('imageview').src = window.URL.createObjectURL(event.target.files[0])
}
const submit = () => {
    form.post(route('user.projects.store'), {
        onFinish: () => {
            form.reset()
        },
    })
}
var layer;
var map;

const onLatLonBlur = () => {
    var cord = [document.getElementById('longitude').value, document.getElementById('latitude').value];
    map.removeLayer(layer);
    var myStyle = new Style({
        image: new Icon({
            anchor: [0.5, 35],
            anchorXUnits: 'fraction',
            anchorYUnits: 'pixels',
            src: '/image/map/icons/pin.png'
        })
    });
    layer = new VectorLayer({
        source: new VectorSource({
            features: [
                new Feature({
                    geometry: new Point(fromLonLat(cord))
                })
            ]
        }),
        style: myStyle
    });
    map.addLayer(layer);
}

onMounted(() => {
    if (!document.getElementById('map').firstChild) {
        map = new Map({
            target: 'map',
            layers: [
                new Tile({
                    source: new OSM()
                })
            ],
            view: new View({
                center: fromLonLat([-104, 38.6]),
                zoom: 6
            }),
        })
    }
    map.on('singleclick', function (evt) {
        var cord = transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326')
        form.latitude = cord[1]
        form.longitude = cord[0]
        map.removeLayer(layer)
        var myStyle = new Style({
            image: new Icon({
                anchor: [0.5, 35],
                anchorXUnits: 'fraction',
                anchorYUnits: 'pixels',
                src: '/image/map/icons/pin.png'
            })
        });
        layer = new VectorLayer({
            source: new VectorSource({
                features: [
                    new Feature({
                        geometry: new Point(fromLonLat(cord))
                    })
                ]
            }),
            style: myStyle
        })
        map.addLayer(layer)
    })
})
</script>
<script>
import UserLayout from '@/Layouts/UserLayout.vue';
export default {
    layout: UserLayout
}
</script>

<template>

    <Head title="Add Project" />

    <h3 class="mb-4 ms-3 pt-4 font-weight-normal">Add project</h3>
    <form @submit.prevent="submit">
        <InputCard title="Basic data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="container-fluild form-group">
                        <label for="name">Name
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="name" type="text" class="form-control" v-model="form.name" name="name"
                                placeholder="Name" required autocomplete="name">
                        </div>
                        <InputError :message="form.errors.name"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="location">Location
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="location" type="text" class="form-control" v-model="form.location"
                                name="location" placeholder="Location" required autocomplete="location">
                        </div>
                        <InputError :message="form.errors.location"></InputError>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="container-fluild form-group">
                        <label for="image">Project image</label>
                        <div class="input-group mb-3">
                            <input type="file" accept="image/*" @input="acceptImage" />
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                        </div>
                        <InputError :message="form.errors.image"></InputError>
                        <img id="imageview" src="">
                    </div>
                </div>
            </div>
        </InputCard>
        <InputCard title="Coordinates">
            <div class="row">
                <div class="col-md-8">
                    <div>Please zoom the map well and place the location accurately</div>
                    <div id="map"></div>
                </div>
                <div class="col-md-4">
                    <div class="container-fluild form-group">
                        <label for="latitude">Latitude (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="latitude" type="number" step="0.00000000000000001" class="form-control"
                                v-model="form.latitude" name="latitude" placeholder="Latitude" required
                                autocomplete="latitude">
                        </div>
                        <InputError :message="form.errors.latitude"></InputError>
                    </div>
                    <div class="container-fluild form-group">
                        <label for="longitude">Longitude (deg)
                            <Req />
                        </label>
                        <div class="input-group mb-3">
                            <input id="longitude" type="number" step="0.00000000000000001" class="form-control"
                                v-model="form.longitude" name="longitude" placeholder="Longitude" required
                                autocomplete="longitude">
                        </div>
                        <InputError :message="form.errors.longitude"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>
        <InputCard title="Description">
            <div class="row">
                <div class="col">
                    <div class="container-fluild form-group">
                        <div class="input-group">
                            <textarea placeholder="Description" v-model="form.description" class="form-control"
                                name="description" id="description" autocomplete="description" rows="5"></textarea>
                        </div>
                        <InputError :message="form.errors.description"></InputError>
                    </div>
                </div>
            </div>
        </InputCard>
        <div class="text-right py-3">
            <Link :href="route('user.projects.index')" class="btn btn-outline-primary mr-2">Back</Link>
            <button type="submit" class="btn btn-primary mr-2">Create
            </button>
        </div>
    </form>
</template>

<style scoped>
#imageview {
    height: 100px;
}

#map {
    height: 400px;
    width: 100%;
}
</style>
<style>
@import "ol/ol.css";
</style>