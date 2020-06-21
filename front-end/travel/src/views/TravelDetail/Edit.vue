<template>
  <el-form ref="form" :model="uploadImageForm" label-width="80px">
    <el-form-item label="图片标题">
      <el-input v-model="uploadImageForm.picTitle" placeholder="请输入图片标题"></el-input>
    </el-form-item>
    <el-form-item label="图片描述">
      <el-input v-model="uploadImageForm.picDesc" placeholder="请输入图片描述"></el-input>
    </el-form-item>
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
      <el-select v-model="uploadImageForm.picContent" placeholder="风格">
        <el-option
                v-for="(item,index) in ContentListSelectArr"
                :key="index"
                :label="item.name"
                :value="item.name">
        </el-option>
      </el-select>
    </el-form-item>
  </el-form>
</template>

<script>
  import {uploadUserInfo,homeCountryList,homeCityList} from "@/api";
  export default {
    name: "Edit",
    props: {
      defaultValue: {type: Object, default: void 0}
    },
    created() {
      console.log("defaultValue", this.defaultValue);
      if (this.defaultValue) {
        this.uploadImageForm.picTitle = this.defaultValue.Title;
        this.uploadImageForm.picDesc = this.defaultValue.Description;
        this.uploadImageForm.picCountry = this.defaultValue.Country_RegionCodeISO;
        this.uploadImageForm.picCity = this.defaultValue.CityCode;
        this.uploadImageForm.picContent = this.defaultValue.Content;
        this.uploadImageForm.picURL = this.defaultValue.PATH;
      }
    },
    mounted() {
      this.getHomeCountryList();
      this.selectCurCountry(this.defaultValue.Country_RegionCodeISO)
    },
    data() {
      return {
        uploadImageForm: {
          id:this.defaultValue.ImageID,
          picTitle: '',
          picDesc: '',
          picCountry: '',
          picCity: '',
          picURL: '',
          picContent:'',
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
      }
    },
    methods: {

      getHomeCountryList(){
        homeCountryList().then(res => {
          this.picCountryOptions = res.data.data;
        });
      },
      selectCurCountry(country){
        var data = {country:country};
        homeCityList(data).then(res => {
          this.picCityOptions = res.data.data;
        });
      },
      onSubmit() {
        uploadUserInfo(this.uploadImageForm).then(res=>{
          if (res && res.data.success) {
            this.$message.success('保存成功');
          }else{
            this.$message.error(res.data.msg);
          }
        }, error => {
          this.$message.error(error.message);
        })
      }
    }
  }
</script>

<style scoped>

</style>