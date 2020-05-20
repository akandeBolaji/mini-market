<template>
  <div class="ui grid">
    <div class="six wide column">
        <searchMarket @addToMap="addLocationsToGoogleMaps($event)"/>
    </div>
    <div class="ten wide column segment ui" ref="map">

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
        }
    }
  }
</script>
