<template>
    <div class="six wide column container">
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
                <i class="dot circle link icon green"></i>
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
            <button class="ui button green" @click="findMarket">Find Market</button>
        </div>
        </form>
        <div class="ui segment"  style="min-height:500px; overflow:scroll">
            <div class="ui divided items" v-if="markets.length > 0">
                <div class="item" v-for="market in markets" :key="market.id">
                    <div class="content">
                        <div class="header">{{market.name}}</div>
                        <div class="meta">{{market.description}}</div>
                        <div v-if="market.distance">{{ market.distance.toString().substring(0, 6) }}km</div>
                    </div>
                </div>
            </div>
            <div v-else>
                No Results Founds
            </div>
        </div>
    </div>

</template>
<script>
export default {
    data() {
        return {
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
            console.log('hi');
            navigator.geolocation.getCurrentPosition(
            position => {
                this.lat = position.coords.latitude;
                this.lng = position.coords.longitude;
                this.$emit('addDefault', {
                    'lat' : this.lat,
                    'lng' : this.lng
                });
                console.log('hi',this.lng, this.lat);
            },
            error => {
                console.log("Error getting location");
            }
            );
        },
        findMarket(e) {
            e.preventDefault();
            if (!this.validateForm()) {
                return false;
            }
            api
                .post("/search", {
                    'search': this.search,
                    'type': this.type,
                    'radius': this.radius,
                    'lat': this.lat,
                    'lng': this.lng
                })
                .then(res => {
                    this.markets = res.data.data;
                    console.log(this.markets);
                    this.$emit('addToMap', {
                        'lat' : this.lat,
                        'lng' : this.lng,
                        'markets': this.markets,
                    });
                }).catch(error => {
                    this.showNotification("A server error");
                    console.log(error.message);
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

