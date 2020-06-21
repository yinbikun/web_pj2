<template>
  <el-main class="profile-item">
    <el-card>
      <div slot="header" class="clearfix">
        上传图片
      </div>
      <div>
        <el-form ref="form" :model="uploadImageForm" label-width="80px">
          <el-row>
            <el-col :span="3">
              <el-upload
                  ref="imageUploadContainer"
                  action="http://test.sev7n.cn/api/personal/upload.php"
                  list-type="picture-card"
                  :limit="1"
                  :auto-upload="true"
                  :on-preview="handlePictureCardPreview"
                  :on-remove="handleRemove"
                  :on-success="handleUpload">
                <i class="el-icon-plus"></i>
              </el-upload>
              <el-dialog :visible.sync="dialogVisible">
                <img width="100%" :src="dialogImageUrl" alt="">
              </el-dialog>
            </el-col>
            <el-col :span="5">
              <el-form-item label="图片标题">
                <el-input v-model="uploadImageForm.picTitle" placeholder="请输入图片标题"></el-input>
              </el-form-item>
              <el-form-item label="图片描述">
                <el-input v-model="uploadImageForm.picDesc" placeholder="请输入图片描述"></el-input>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" @click="onSubmit">上传图片</el-button>
              </el-form-item>
            </el-col>
            <el-col :span="8" :offset="1">
              <el-form-item label="拍摄国家">
                <el-select v-model="uploadImageForm.picCountry" placeholder="选择拍摄国家" @change="selectCurCountry">
                  <el-option
                      v-for="item in picCountryOptions"
                      :key="item.ISO"
                      :label="item.Country_RegionName"
                      :value="item.ISO">
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="拍摄城市">
                <el-select v-model="uploadImageForm.picCity" placeholder="输入拍摄城市">
                  <el-option
                      v-for="item in picCityOptions"
                      :key="item.GeoNameID"
                      :label="item.AsciiName"
                      :value="item.GeoNameID">
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="风格">
                <el-select v-model="uploadImageForm.content" placeholder="风格">
                  <el-option
                          v-for="(item,index) in ContentListSelectArr"
                          :key="index"
                          :label="item.name"
                          :value="item.name">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
        </el-form>
      </div>
    </el-card>
  </el-main>
</template>

<script>
  import {uploadUserInfo} from "@/api";
  import {homeCountryList, homeCityList} from "@/api";

  export default {
    name: "PictureUploader",
    data() {
      return {
        dialogImageUrl: '',
        dialogVisible: false,
        uploadImageForm: {
          content: '',
          picTitle: '',
          picDesc: '',
          picCountry: '',
          picCity: '',
          picURL: '',
          uid: this.$store.state.userInfo.UID
        },
        picCountryOptions: [],
        picCityOptions: [],
        ContentListSelectArr: [
          {name:"Scenery"},
          {name:"City"},
          {name:"People"},
          {name:"Animal"},
          {name:"Building"},
          {name:"Wonder"},
          {name:"Other"}
        ],
      };
    },
    methods: {
      handleRemove(file, fileList) {
        if (fileList.length === 0) {
          this.uploadImageForm.picURL = "";
          this.$refs.imageUploadContainer.$el.className = "";
        }
      },
      handleUpload(response, file, fileList) {
        console.log(response)
        if (response && response.success) {
          this.uploadImageForm.picURL = response.data;
          this.$refs.imageUploadContainer.$el.className = "upload--disable";
        }
      },
      handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
      },


      //国家城市列表
      getHomeCountryList() {
        homeCountryList().then(res => {
          this.picCountryOptions = res.data.data;
        });
      },
      selectCurCountry(country) {
        console.log(country);
        var data = {country: country};
        homeCityList(data).then(res => {
          this.picCityOptions = res.data.data;
        });
      },


      onSubmit() {
        uploadUserInfo(this.uploadImageForm).then(res => {
          if (res && res.data.success) {
            this.uploadImageForm = {
              content: '',
              picTitle: '',
              picDesc: '',
              picCountry: '',
              picCity: '',
              picURL: '',
              uid: this.$store.state.userInfo.UID
            };
            this.dialogImageUrl = '';
            this.$message.success('保存成功');
          } else {
            this.$message.error(res.data.msg);
          }
        }, error => {
          this.$message.error(error.message);
        })
      }
    },

    mounted() {
      this.getHomeCountryList();
    },
  }
</script>

<style lang="less">
  .upload--disable .el-upload--picture-card {
    display: none;
  }
</style>
<style lang="less" scoped>
  .profile-item {
    padding: 2vh 8vw;
    min-height: calc(100vh - 181px);
  }
</style>