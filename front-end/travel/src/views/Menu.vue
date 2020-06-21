<template>
  <div class="menu">
    <el-row>
      <el-col :span="2" class="menu-title"><i class="el-icon-s-promotion"></i>旅图网</el-col>
      <el-col :span="19">
        <el-menu :default-active="activeIndex" mode="horizontal" :router="true">
          <el-menu-item index="home">首页</el-menu-item>
          <el-menu-item index="list">热门预览</el-menu-item>
          <el-menu-item index="search">搜索图片</el-menu-item>
        </el-menu>
      </el-col>
      <el-col :span="3">
        <el-row v-if="isLogin" class="user-info">
          <el-col :span="5">
            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
          </el-col>
          <el-col :span="19">
            <div class="personal-name">{{userName}}</div>
            <el-dropdown @command="handleCommand">
              <span class="el-dropdown-link personal-btn">
                个人中心<i class="el-icon-arrow-down el-icon--right"></i>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item icon="el-icon-upload" command="toUpload">上传照片</el-dropdown-item>
                <el-dropdown-item icon="el-icon-picture" command="toPhoto">我的照片</el-dropdown-item>
                <el-dropdown-item icon="el-icon-star-on" command="toLove">我的收藏</el-dropdown-item>
                <el-dropdown-item icon="el-icon-unlock" command="logout">登出</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </el-col>
        </el-row>
        <el-row v-if="!isLogin" class="user-login-leader">
          您还没有登录，点击<span class="personal-btn" @click="onLoginHandler">登录</span>
        </el-row>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  export default {
    name: "Menu",
    data() {
      return {
        activeIndex: 'home',
      }
    },
    created() {
      // 初始化当前选中项
      this.activeIndex = this.$route.name.toLowerCase();
      // 查询会话登录状态
      this.loadSession();
    },
    computed: {
      isLogin() {
        return !!this.$store.state.userInfo.UID;
      },
      userName() {
        return this.$store.state.userInfo.UserName;
      }
    },
    methods: {
      onLoginHandler() {
        this.$router.push({name: "Login"});
      },
      handleCommand(command) {
        switch (command) {
          case 'logout':
            this.onLogoutHandler();
            break;
          case 'toPhoto':
            this.toPhotoHandler();
            break;
          case 'toLove':
            this.toLoveHandler();
            break;
          case 'toUpload':
            this.toUploadHandler();
            break;
        }
      },
      loadSession() {
        const isLogin = sessionStorage.getItem("is_login");
        if (isLogin === "1") {
          const userInfoSession = JSON.parse(sessionStorage.getItem("userInfo"));
          this.$store.commit("setUserInfo", userInfoSession);
        }
      },
      onLogoutHandler() {
        this.$cookie.remove("is_login");
        this.$store.commit("setUserInfo", {
          DateJoined: "",
          DateLastModified: "",
          Email: "",
          UID: "",
          UserName: ""
        });
        sessionStorage.clear();
        this.$router.push({name: "Login"});
      },
      toLoveHandler() {
        if (this.$route.name.toLowerCase() !== "love") {
          this.activeIndex = "love";
          this.$router.push({name: "Love"});
        }
      },
      toPhotoHandler() {
        if (this.$route.name.toLowerCase() !== "photo") {
          this.activeIndex = "photo";
          this.$router.push({name: "Photo"});
        }
      },
      toUploadHandler() {
        if (this.$route.name.toLowerCase() !== "upload") {
          this.activeIndex = "upload";
          this.$router.push({name: "Upload"});
        }
      }
    }
  }
</script>

<style lang="less" scoped>
  .menu {
    padding-top: 20px;

    .menu-title {
      box-sizing: border-box;
      text-align: center;
      line-height: 60px;
    }

    .user-login-leader,
    .user-info {
      box-sizing: border-box;
      padding: 10px;
      line-height: 20px;
      height: 40px;

      .personal-name {
        padding-left: 5px;
      }

      .personal-btn {
        font-size: 12px;
        padding: 0 5px;
        color: #909399;

        &:hover {
          cursor: pointer;
          text-decoration: underline;
          color: #303133;
        }
      }
    }

    .user-login-leader {
      text-align: center;
      line-height: 40px;
      font-size: 12px;
      color: #000000;
    }
  }
</style>