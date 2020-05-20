<template>
  <div class="container">
    <div class="row">
        <div class="col-md-6">
            <createMarket />
        </div>
        <div class="col-md-6 posts-container" style="height: 35rem; overflow-y: scroll">
            <allMarket />
        </div>
      </div>
  </div>
</template>
<script>
  import createMarket from '../../components/CreateMarket.vue'
  import allMarket from '../../components/AllMarket.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
      createMarket,
      allMarket
    }
  }
</script>
