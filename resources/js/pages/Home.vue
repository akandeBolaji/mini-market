<template>
    <div>
        <searchMarket @addToMap="readMap($event)" class="mt-3"/>
        <div class="row mt-3">
            <div class="col-md-6 mb-4" v-if="markets" v-for="market in markets" :key="market.id">
                <div class="card bg-light mx-3">
                    <div class="card-title h1 mx-3">{{market.name}}</div>
                    <div class="card-title h4 mx-3">{{market.description}}</div>
                    <div class="card-subtitle mb-2 mx-3"> {{market.category}} | {{market.address_address}} </div>
                    <div class="card-subtitle mb-2 mx-3" v-if="market.distance">{{ market.distance.toString().substring(0, 6) }}km</div>
                    <div class="card-body card-body-cascade text-center">
                    <div :id="market.id" :ref="market.id" class="z-depth-1-half map-container-5" style="height: 300px">
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
        markets: [],
      }
    },
    watch: {
        // whenever question changes, this function will run
        markets: function (newMarket) {
            console.log('market changed');
        setTimeout(() => {
        this.addLocationsToGoogleMaps();
      }, 1000);

        }
    },
    components: {
      searchMarket,
    },
    methods: {
        readMap(data) {
             console.log('market hmm');
            this.markets = data.markets
        },
        addLocationsToGoogleMaps() {
            //this.markets = data.markets;
            this.markets.forEach (market => {
                console.log(this.$refs[`${market.name}`])
                var map = new google.maps.Map(document.getElementById(`${market.id}`), {
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
                var content = '';
                market.images.forEach(image => {
                    content += `<img class="img-responsive px-1" width="33%" height="100%" src="${image.url}">`
                });
                infowindow.setContent(`<div class="card-text row">
                                        <div class="col">
                                            ${content}
                                        </div>
                                        </div>`);
                infowindow.open(map, marker);
            })
        },
    }
  }
</script>
<style scoped>
.map-container-5{
overflow:hidden;
padding-bottom:56.25%;
position:relative;
height:0;
}
.map-container-5 iframe{
left:0;
top:0;
height:100%;
width:100%;
position:absolute;
}
</style>


