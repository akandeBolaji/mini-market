<template>
  <div class="row">
    <div class="col-md-6" v-for="(market, i) in markets" :key=i>
      <div class="card mt-4">
        <img v-if="market.images.length" class="card-img-top" :src="market.images[0].url">
        <div class="card-body">
          <p class="card-text"><strong>{{ market.name }}</strong> <br>
            {{ truncateText(market.description) }}
          </p>
        </div>
        <button v-if="deleting != market.id" class="btn btn-success m-2" @click="viewMarket(i)">View Market</button>
        <button v-else class="btn btn-secondary m-2" disabled>Deleting Market ...</button>
      </div>
    </div>
    <el-dialog v-if="currentMarket" :visible.sync="marketDialogVisible" width="40%">
      <span>
        <h3>{{ currentMarket.name }}</h3>
        <div class="row">
          <div class="col-md-6" v-for="(img, i) in currentMarket.images" :key=i>
            <img :src="img.url" class="img-thumbnail" alt="">
          </div>
        </div>
        <hr>
        <p>{{ currentMarket.description }}</p>
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="updateMarket(currentMarket)">Update</el-button>
        <el-button type="danger" @click="deleteMarket(currentMarket)">Delete</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { bus } from '../app'
export default {
  name: 'all-markets',
  data() {
    return {
      marketDialogVisible: false,
      deleting: '',
      currentMarket: '',
    };
  },
  computed: {
    ...mapState(['markets'])
  },
  beforeMount() {
    this.$store.dispatch('getAllMarkets');
  },
  methods: {
    ...mapActions(["getAllMarkets"]),
    truncateText(text) {
      if (text.length > 24) {
        return `${text.substr(0, 24)}...`;
      }
      return text;
    },
    viewMarket(marketIndex) {
      const market = this.markets[marketIndex];
      this.currentMarket = market;
      this.marketDialogVisible = true;
    },
    updateMarket(market) {
      this.marketDialogVisible = false;
      bus.$emit('updateMarket', market);
    },
    deleteMarket(market) {
      this.marketDialogVisible = false;
      this.deleting = market.id;
      api
        .post(`/admin/delete`, {'id' : market.id})
        .then(res => {
          this.getAllMarkets();
        });
      //bus.$emit('deleteMarket', market);
    },
  },
}
</script>
