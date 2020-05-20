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
         <label for="exampleFormControlInput1">Sample Images</label>
          <el-upload
            action="https://jsonplaceholder.typicode.com/posts/"
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-change="updateImageList"
            :auto-upload="false"
          >
            <i class="el-icon-plus"></i>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt />
          </el-dialog>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <button
        type="button"
        @click="createMarket"
        class="btn btn-success"
      >{{ isCreatingPost ? "Creating..." : "Create Market" }}</button>
    </div>
  </div>
</template>

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
</style>

<script>
import { setTimeout } from "timers";
import { mapState, mapActions } from "vuex";
export default {
  name: "create-post",
  props: ["posts"],
  data() {
    return {
      dialogImageUrl: "",
      dialogVisible: false,
      imageList: [],
      status_msg: "",
      status: "",
      isCreatingPost: false,
      name: "",
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
  methods: {
    ...mapActions(["getAllPosts"]),
    checkAddress(address) {
        //console.log('auto', this.autocomplete);
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
      this.isCreatingPost = true;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("description", this.description);
      formData.append("category", this.category);
      formData.append("address", this.address);
      formData.append("address_lat", this.address_lat);
      formData.append("address_long", this.address_long);
      $.each(this.imageList, function(key, image) {
        formData.append(`images[${key}]`, image);
      });
      api
        .post("/admin/create", formData, {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(res => {
          this.title = this.body = "";
          this.status = true;
          this.showNotification("Market Successfully Created");
          this.isCreatingPost = false;
          this.imageList = [];
          /*
           this.getAllPosts() can be used here as well
           note: "that" has been assigned the value of "this" at the top
           to avoid context related issues.
           */
          that.getAllMarkets();
          that.componentKey += 1;
        })
        .error(error => {
            console.log(error.response.data);
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
      if (this.imageList.length != 3) {
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
