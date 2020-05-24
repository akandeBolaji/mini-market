<template>
  <div class="card mt-4" :key="componentKey">
    <div class="card-header">New Market</div>
    <div class="card-body">
      <div
        v-if="status_msg"
        :class="{ 'alert-success': status, 'alert-danger': !status }"
        class="alert"
        role="alert"
      >{{ status_msg }}</div>
      <form>
        <div class="form-group">
          <label for="exampleFormControlInput1">Name</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            id="name"
            placeholder="Market Name"
            required
          />
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Description</label>
          <textarea v-model="description" class="form-control" id="post-content" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput1">Address</label>
          <input
            v-model="address"
            type="text"
            ref="autocomplete"
            class="form-control"
            id="title"
            placeholder="Enter Address Here"
            required
          />
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput1">Category</label>
          <input
            v-model="category"
            type="text"
            class="form-control"
            id="title"
            placeholder="Enter category Here"
            required
          />
        </div>
        <div class>
        <section v-if="updateImage.length > 0">
         <label for="exampleFormControlInput1">Update Images</label>
        <div class="row">
          <div class="col-md-3 mx-2 img-wrap" v-for="(img, i) in updateImage" :key=i>
            <span class="close" @click="deleteImage(i, img)">&times;</span>
            <img :src="img.url" class="img-thumbnail" alt="">
          </div>
        </div>
        </section>
        <section v-if="acceptImage">
         <label for="exampleFormControlInput1">Sample Images</label>
          <el-upload
            action="https://jsonplaceholder.typicode.com/posts/"
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :limit="3"
            :on-change="updateImageList"
            :auto-upload="false"
          >
            <i class="el-icon-plus"></i>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt />
          </el-dialog>
          </section>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <button
        type="button"
        @click="createMarket"
        class="btn btn-primary"
      >{{ isCreatingMarket ? "Creating..." : isUpdatingMarket ? "Updating..." : updateReceived ? "Update Market" : "Create Market" }}</button>
    </div>
  </div>
</template>

<script>
import { setTimeout } from "timers";
import { mapState, mapActions } from "vuex";
import { bus } from '../app'
export default {
  name: "create-market",
  props: ["markets"],
  data() {
    return {
      dialogImageUrl: "",
      dialogVisible: false,
      imageList: [],
      updateImage: [],
      status_msg: "",
      status: "",
      isCreatingMarket: false,
      isUpdatingMarket: false,
      acceptImage: true,
      id: '',
      name: "",
      updateReceived: false,
      description: "",
      category: "",
      address: "",
      address_lat: "",
      address_long: "",
      componentKey: 0,
      formatted_address: ''
    };
  },
  computed: {},
  mounted() {
    var autocomplete = new google.maps.places.Autocomplete(
        this.$refs["autocomplete"]
        );
    //console.log(this.autocomplete);
    google.maps.event.addListener(autocomplete, 'place_changed', () => {
        console.log('auto', autocomplete);
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        this.address_lat = lat;
        this.address_long = lng;
        this.formatted_address = place.formatted_address;
        this.address = place.formatted_address;
    })
  },
  created (){
    bus.$on('updateMarket', (market) => {
      this.id = market.id;
      this.name = market.name;
      this.description = market.description;
      this.category = market.category;
      this.address = market.address_address;
      this.formatted_address = market.address_address;
      this.address_lat = market.address_latitude;
      this.address_long = market.address_longitude;
      this.updateImage = market.images;
      this.updateReceived = true;
      this.acceptImage = false;
    });
  },
  methods: {
    ...mapActions(["getAllMarkets"]),
    deleteImage(index, img) {
        this.acceptImage = true;
        this.updateImage.splice(index, 1);
        this.deleteImageData(img);
    },

    deleteImageData(image) {
        api
        .post(`/admin/image/delete`, image)
        .then(res => {
          //okay
        })
        .catch(err => {
            //catch error
        })
    },

    updateImageList(file) {
      this.imageList.push(file.raw);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.imageList.push(file);
      this.dialogVisible = true;
    },
    createMarket(e) {
      e.preventDefault();
      if (!this.validateForm()) {
        return false;
      }
      const that = this;
      if (this.updateReceived)
      {
        this.isUpdatingMarket = true;
        this.isCreatingMarket = false;
      }
      else
      {
        this.isCreatingMarket = true;
        this.isUpdatingMarket = true;
      }
      let formData = new FormData();
      formData.append("id", this.id);
      formData.append("name", this.name);
      formData.append("description", this.description);
      formData.append("category", this.category);
      formData.append("address", this.address);
      formData.append("address_lat", this.address_lat);
      formData.append("address_long", this.address_long);
      $.each(this.imageList, function(key, image) {
        formData.append(`images[${key}]`, image);
      });
      let endpoint = this.updateReceived ? 'update' : 'create';
      api
        .post(`/admin/${endpoint}`, formData, {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(res => {
          this.name = this.description = this.address = this.category = "";
          this.status = true;
          this.showNotification("Market Successfully Created");
          this.isCreatingMarket = false;
          this.isUpdatingMarket = false;
          this.updateReceived = false;
          this.imageList = [];
          /*
           this.getAllPosts() can be used here as well
           note: "that" has been assigned the value of "this" at the top
           to avoid context related issues.
           */
          that.getAllMarkets();
          that.componentKey += 1;
        });
    },
    validateForm() {
      //no vaildation for images - it is needed
      if (!this.name) {
        this.status = false;
        this.showNotification("Market name cannot be empty");
        return false;
      }
      if (!this.description) {
        this.status = false;
        this.showNotification("Market description cannot be empty");
        return false;
      }
      if (!this.address) {
        this.status = false;
        this.showNotification("Market address cannot be empty");
        return false;
      }
      if (!this.address_lat || !this.address_long || this.address != this.formatted_address) {
        console.log(this.address_lat, this.address_long, this.address, this.formatted_address)
        this.status = false;
        this.showNotification("Market address not known");
        return false;
      }
      if (!this.category) {
        this.status = false;
        this.showNotification("Market category cannot be empty");
        return false;
      }
      if ((this.imageList.length != 3 && this.updateReceived == false) || ((this.imageList.length + this.updateImage.length) != 3) ) {

        this.status = false;
        this.showNotification("Sample Images must be three");
        return false;
      }
      return true;
    },
    showNotification(message) {
      this.status_msg = message;
      setTimeout(() => {
        this.status_msg = "";
      }, 3000);
    }
  }
};
</script>
<style>
    .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
    border-color: #409eff;
    }
    .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
    }
    .avatar {
    width: 178px;
    height: 178px;
    display: block;
    }
    .img-wrap {
    position: relative;
    display: inline-block;
    border: 1px black solid;
    font-size: 0;
    }

    .img-wrap .close {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    background-color: #FFF;
    padding: 5px 2px 2px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    opacity: .2;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
    }

    .img-wrap:hover .close {
    opacity: 1;
    }
</style>

