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
                center: new google.maps.LatLng(data.lat, data.lng),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, "click", () => {
                infowindow.setContent(`<div class="ui header">${market.name}</div><p>${market.description}</p>`);
                infowindow.open(map, marker);
            });
            data.markets.forEach((market) => {
                const lat = market.geometry.location.lat;
                const lng = market.geometry.location.lng;
                let marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    map: map
                });
            });
        }
    }
  }
</script>
