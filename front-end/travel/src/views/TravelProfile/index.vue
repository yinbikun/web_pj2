<template>
  <el-main>
    <el-row class="profile-item">
      <el-col :span="24">
        <h1>个人中心</h1>
      </el-col>
      <el-col :span="24">
        <el-card>
          <div slot="header" class="clearfix">
            上传图片
          </div>
          <picture-uploader></picture-uploader>
        </el-card>
      </el-col>
      <el-col :span="24">
        <el-card>
          <div slot="header" class="clearfix">
            我的照片
          </div>
          <my-photo></my-photo>
        </el-card>
      </el-col>
      <el-col :span="24">
        <el-card>
          <div slot="header" class="clearfix">
            我的收藏
          </div>
          <my-love></my-love>
        </el-card>
      </el-col>
    </el-row>
  </el-main>
</template>

<script>
  import PictureUploader from "./PictureUploader";
  import MyPhoto from "./MyPhoto";
  import MyLove from "./MyLove";
  import DetailItem from "@/views/components/DetailItem";

  export default {
    name: 'TravelProfile',
    components: {PictureUploader, MyPhoto, MyLove, DetailItem},
    methods: {
    }
  }
</script>
<style lang="less" scoped>
  .profile-item {
    padding: 0 8vw;
    min-height: calc(100vh - 181px);
  }
</style>