<template>
    <div>
        <label>
            Latitude:
            <input v-model.number="latInput" type="number" step="any">
        </label>
        <label>
            Longitude:
            <input v-model.number="lngInput" type="number" step="any">
        </label>
        <button @click="sendCoordinates">Send Coordinates</button>
        <div v-if="errors">
            <p class="text-red-600">Error: {{ errors }}</p>
        </div>
        <GoogleMap style="width: 100%; height: 500px" :center="center" :zoom="15">
            <Marker v-for="(marker, index) in markers" :key="index" :options="marker" />
        </GoogleMap>

    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";
import axios from "axios";

export default {
    components: { GoogleMap, Marker },
    data() {
        return {
            center: { lat: 50.4501, lng: 30.5234 },
            latInput: null,
            lngInput: null,
            markers: [],
            errors: null
        };
    },
    methods: {
        sendCoordinates() {
            axios.post('/api/coordinates', {
                lat: this.latInput,
                lng: this.lngInput
            })
                .then(() => {
                    this.errors = null; // Reset errors if the request was successful
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.message; // Save the error message
                    } else {
                        console.error(error); // Log the error to the console if it's not related to validation
                    }
                });
        },
        async fetchCoordinates() {
            try {
                const response = await axios.get('/api/coordinates');
                const data = response.data.data;

                this.markers.splice(0); // Очистить массив markers перед добавлением новых маркеров

                data.forEach(coordinate => {
                    const lat = parseFloat(coordinate.lat);
                    const lng = parseFloat(coordinate.lng);
                    this.markers.push({ position: { lat, lng }, label: "L", title: "LADY LIBERTY" });
                });

                const lastCoordinate = data[data.length - 1];
                this.center = { lat: parseFloat(lastCoordinate.lat), lng: parseFloat(lastCoordinate.lng) };
            } catch (error) {
                console.error(error);
            }
        }
    },
    mounted() {
        this.intervalId = setInterval(this.fetchCoordinates, 2000);
    },
    beforeUnmount() {
        clearInterval(this.intervalId);
    }
};
</script>
