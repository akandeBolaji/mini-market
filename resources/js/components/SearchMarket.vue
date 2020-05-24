<template>
    <div class="container">
        <div
        v-if="status_msg"
        :class="{ 'alert-success': status, 'alert-danger': !status }"
        class="alert"
        role="alert"
        >{{ status_msg }}</div>
        <form class="ui segment large form">
        <div class="ui segment">
            <div class="field">
                <label for="search">Search by:</label>
                <select v-model="type" name="search">
                    <option value="Name">Name</option>
                    <option value="Category">Category</option>
                    <option value="Nearest">Nearest market</option>
                </select>
            </div>
            <div class="field" v-if="type != 'Nearest'">
            <div class="ui right icon input large">
                <input type="text" placeholder="Enter search term" v-model="search" />
                <i class="dot circle link icon blue"></i>
            </div>
            </div>
            <div class="field">

            <div class="field" v-if="type == 'Nearest'">
                 <label for="location">Distance from your location :</label>
                <select v-model="radius" name="location">
                    <option value="5">5 KM</option>
                    <option value="10">10 KM</option>
                    <option value="15">15 KM</option>
                    <option value="20">20 KM</option>
                </select>
            </div>
            </div>
            <button class="ui button blue" @click="findMarket">
                {{ isFinding ? "Searching..." :  "Find Market" }}
            </button>
        </div>
        </form>
    </div>

</template>
<script>
export default {
    data() {
        return {
        isFinding: false,
        lat: 0,
        lng: 0,
        search: '',
        type: "Name",
        radius: "5",
        markets: [],
        status_msg: '',
        };
    },
    computed: {
        coordinates() {
        //return `${this.lat}, ${this.lng}`;
        return null;
        }
    },

    mounted() {
        this.getUserLocation();
    },

    methods: {
        getUserLocation() {
            navigator.geolocation.getCurrentPosition(
            position => {
                this.lat = position.coords.latitude;
                this.lng = position.coords.longitude;
            },
            error => {
                // console.log("Error getting location");
            }
            );
        },
        findMarket(e) {
            e.preventDefault();
            if (!this.validateForm()) {
                return false;
            }
            this.isFinding = true;
            api
                .post("/search", {
                    'search': this.search,
                    'type': this.type,
                    'radius': this.radius,
                    'lat': this.lat,
                    'lng': this.lng
                })
                .then(res => {
                    this.isFinding = false;
                    this.markets = res.data.data;
                    if (this.markets.length < 0) {
                        this.showNotification("No Market Found");
                    }
                    //console.log(this.markets);
                    this.$store.commit('marketFound', {market: this.markets});
                    this.$emit('addToMap', {
                        'lat' : this.lat,
                        'lng' : this.lng,
                        'markets': this.markets,
                    });
                }).catch(error => {
                    this.isFinding = false;
                    this.showNotification("A server error");
                    //console.log(error.message);
                });
        },
        validateForm() {
            //no vaildation for images - it is needed
            if (!this.type) {
                this.status = false;
                this.showNotification("Type cannot be empty");
                return false;
            }
            if (this.type != 'Nearest' && !this.search) {
                this.status = false;
                this.showNotification("Search cannot be empty");
                return false;
            }
            return true;
        },

        showNotification(message) {
            this.status_msg = message;
            setTimeout(() => {
                this.status_msg = "";
            }, 3000);
        },
    }

}
</script>

