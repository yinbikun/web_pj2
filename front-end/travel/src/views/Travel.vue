<template>
  <el-container>
    <el-header height="81px">
      <travel-menu></travel-menu>
    </el-header>
    <router-view></router-view>
    <el-footer class="footer">
      Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：沪BILIBILI备17307130218号-1
    </el-footer>
  </el-container>
</template>

<script>
  import travelMenu from "./Menu"

  export default {
    name: 'Travel',
    components: {
      travelMenu
    }
  }
</script>
<style lang="less" scoped>
  .footer {
    width: 100%;
    height: 50px;
    background-color: black;
    bottom: 0;
    text-align: center;
    color: #fff;
    font-size: 12px;
    line-height: 50px;
  }
</style>