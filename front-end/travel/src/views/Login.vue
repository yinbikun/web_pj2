<template>
  <div class="login">
    <div class="login-panel">
      <el-header class="login-header">
        <i class="el-icon-user-solid"></i>LOGIN
      </el-header>
      <el-container>
        <el-main>
          <el-form :rules="loginFormRules" ref="loginForm" :model="loginForm" label-width="80px">
            <el-form-item label="用户名" prop="username">
              <el-input placeholder="请输入用户名" v-model="loginForm.username"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
              <el-input placeholder="请输入密码" type="password" v-model="loginForm.password"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onLoginSubmit">登录</el-button>
              <el-button @click="onRegisterRouteClick">没有账号?注册</el-button>
            </el-form-item>
          </el-form>
        </el-main>
      </el-container>
    </div>
  </div>
</template>

<script>
  import md5 from 'js-md5';
  import {userLogin} from "@/api";

  export default {
    name: 'Login',
    data() {
      return {
        loginForm: {
          username: "",
          password: ""
        },
        loginFormRules: {
          username: [
            {required: true, message: '请输入用户名', trigger: 'blur'},
            {min: 3, max: 30, message: '长度在 3 到 30 个字符', trigger: 'blur'}],
          password: [
            {required: true, message: '请输入密码', trigger: 'blur'}]
        }
      }
    },
    methods: {
      /**
       * 点击登录按钮
       */
      onLoginSubmit() {
        this.$refs.loginForm.validate((valid) => {
          if (valid) {
            // md5加盐
            const hash = md5.create();
            hash.update(this.loginForm.password + "salt");

            // 用户登录请求参数
            let loginData = {
              user_name: this.loginForm.username,
              user_pwd: hash.hex(),
            }
            // 发送请求
            userLogin(loginData).then(res => {
              if (res && res.data.success) {
                // 登录成功
                this.$message.success('登录成功');
                // 保存登录cookie状态
                this.$cookie.set("is_login", "1", {expires: 1});
                this.$store.commit("setUserInfo", res.data.data);
                sessionStorage.setItem("userInfo", JSON.stringify(res.data.data));
                sessionStorage.setItem("is_login", "1");
                // 进入主页
                this.$router.push("Travel");
              } else {
                this.$message.error('用户名或密码错误');
              }
            }, error => {
              this.$message.error(error.message);
            });
          } else {
            console.log('表单校验不通过');
            return false;
          }
        });
      },
      /**
       * 点击跳转到注册按钮
       */
      onRegisterRouteClick() {
        this.$router.push("Register");
      }
    }
  }
</script>

<style lang="less">
  .login {
    background-image: url("../assets/login-bg.jpeg");
    width: 100vw;
    height: 100vh;
    background-size: 100% 100%;
  }

  .login-panel {
    position: absolute;
    width: 22vw;
    min-height: 15vw;
    border: 1px solid #fff;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #ffffffe1;
    border-radius: 5%;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    overflow: hidden;

    .login-header {
      letter-spacing: .5em;
      text-align: center;
      font-size: 18px;
      height: 60px;
      line-height: 60px;
      background: #d9f3f3;
    }
  }
</style>