<template>
  <div class="ui grid">
    <div class="six wide column">
        <searchMarket/>
    </div>
    <div class="ten wide column segment ui" ref="map">

    </div>
  </div>
</template>
<script>
  import search from '../components/SearchMarket.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
      searchMarket,
    }
  }
</script>
