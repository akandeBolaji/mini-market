<template>
    <div>
        <div>
            <searchMarket @addToMap="addLocationsToGoogleMaps($event)" @addDefault="addDefaultLocation($event)" />
        </div>
        <div ref="map">

        </div>
    </div>
</template>
<script>
  import searchMarket from '../components/SearchMarket.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
      searchMarket,
    },
    methods: {
        addLocationsToGoogleMaps(data) {

            var map = new google.maps.Map(this.$refs['map'], {
                zoom: 15,
                center: new google.maps.LatLng(data.markets[0].address_latitude, data.markets[0].address_longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false
            });
            data.markets.forEach((market) => {
                const lat = market.address_latitude;
                const lng = market.address_longitude;
                let marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    map: map
                });
                var infowindow = new google.maps.InfoWindow();
                infowindow.setContent(`<div class="ui header">${market.name}</div><p>${market.description}</p>`);
                infowindow.open(map, marker);
                	// google.maps.event.addListener(marker, "click", () => {
                    // infowindow.setContent(`<div class="ui header">${market.name}</div><p>${market.description}</p>`);
                    // infowindow.open(map, marker);
                    // });
                });
        },

        addDefaultLocation(data) {
            var map = new google.maps.Map(this.$refs['map'], {
            zoom: 15,
            center: new google.maps.LatLng(data.lat, data.lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false
            });

            const lat = data.lat;
            const lng = data.lng;
            let marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map
            });
            var infowindow = new google.maps.InfoWindow();
            infowindow.setContent(`<div class="ui header">Your location</div>`);
            infowindow.open(map, marker);


        },
    }
  }
</script>
