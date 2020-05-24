<template>
    <div>
        <searchMarket @addToMap="addLocationsToGoogleMaps($event)" @addDefault="addDefaultLocation($event)" />
    <div class="row" v-if="market" v-for="market in markets" :key="market.id">
    <div class="col-md-6 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-title h2">{{market.name}}</div>
            <div class="card-subtitle mb-2"> {{market.category}} | {{market.address_address}} </div>
            <div class="card-subtitle mb-2" v-if="market.distance">{{ market.distance.toString().substring(0, 6) }}km</div>
        <div class="card-body card-body-cascade text-center">
            <div id="map-container-google-8" :ref="market.id" class="z-depth-1-half map-container-5" style="height: 300px">
            </div>
        </div>


        </div>
    </div>

    </div>
    </div>
</template>
<script>
  import searchMarket from '../components/SearchMarket.vue'
  export default {
    data() {
      return {
        market: [],
      }
    },
    components: {
      searchMarket,
    },
    methods: {
        addLocationsToGoogleMaps(data) {
            this.market = data.markets;
            this.market.forEach (market => {
                var map = new google.maps.Map(this.$refs[`${this.market.id}`], {
                zoom: 15,
                center: new google.maps.LatLng(market.address_latitude, market.address_longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false
                });
                let marker = new google.maps.Marker({
                    position: new google.maps.LatLng(market.address_latitude, market.address_longitude),
                    map: map
                });
                var infowindow = new google.maps.InfoWindow();
                infowindow.setContent(`<div class="ui header">${market.name}</div><p>${market.description}</p>`);
            })
        },

        addDefaultLocation(data) {
            // var map = new google.maps.Map(this.$refs['map'], {
            // zoom: 15,
            // center: new google.maps.LatLng(data.lat, data.lng),
            // mapTypeId: google.maps.MapTypeId.ROADMAP,
            // mapTypeControl: false
            // });

            // const lat = data.lat;
            // const lng = data.lng;
            // let marker = new google.maps.Marker({
            //     position: new google.maps.LatLng(lat, lng),
            //     map: map
            // });
            // var infowindow = new google.maps.InfoWindow();
            // infowindow.setContent(`<div class="ui header">Your location</div>`);
            // infowindow.open(map, marker);


        },
    }
  }
</script>

