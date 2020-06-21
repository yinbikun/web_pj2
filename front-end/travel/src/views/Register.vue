<template>
  <div class="register">
    <div class="register-panel">
      <el-header class="register-header">
        <i class="el-icon-user-solid"></i>REGISTER
      </el-header>
      <el-container>
        <el-main>
          <el-form :rules="registerFormRules" ref="registerForm" :model="registerForm" label-width="80px">
            <el-form-item label="邮箱" prop="email">
              <el-input placeholder="请输入邮箱地址" v-model="registerForm.email" type="email"></el-input>
            </el-form-item>
            <el-form-item label="用户名" prop="username">
              <el-input placeholder="请输入用户名" v-model="registerForm.username"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
              <el-input placeholder="请输入密码" type="password" v-model="registerForm.password"></el-input>
            </el-form-item>
            <el-form-item label="重复密码" prop="rePassword">
              <el-input placeholder="请再次输入密码" type="password" v-model="registerForm.rePassword"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onRegisterSubmit">创建账号</el-button>
              <el-button @click="onLoginRouteClick">已有帐号?登录</el-button>
            </el-form-item>
          </el-form>
        </el-main>
      </el-container>
    </div>
  </div>
</template>

<script>
  import md5 from 'js-md5';
  import {userRegister} from "@/api";

  export default {
    name: 'Register',
    data() {
      const validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'));
        } else if (value !== this.registerForm.password) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      const validateEmail = (rule, value, callback) => {
        let reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
        if (value === '') {
          callback(new Error('请输入邮箱地址'));
        } else if (!reg.test(value)) {
          callback(new Error('邮箱地址格式不正确!'));
        } else {
          callback();
        }
      };
      return {
        registerForm: {
          email: "",
          username: "",
          password: "",
          rePassword: "",
        },
        registerFormRules: {
          email: [
            {min: 3, max: 30, message: '长度在 3 到 30 个字符', trigger: 'blur'},
            {required: true, validator: validateEmail, trigger: 'blur'}],
          username: [
            {required: true, message: '请输入用户名', trigger: 'blur'},
            {min: 3, max: 30, message: '长度在 3 到 30 个字符', trigger: 'blur'}],
          password: [
            {required: true, message: '请输入密码', trigger: 'blur'},
            {min: 6, max: 30, message: '长度在 6 到 30 个字符', trigger: 'blur'}],
          rePassword: [
            {required: true, validator: validatePass, trigger: 'blur'},
            {min: 6, max: 30, message: '长度在 6 到 30 个字符', trigger: 'blur'}],
        }
      }
    },
    methods: {
      /**
       * 注册提交
       */
      onRegisterSubmit() {
        this.$refs.registerForm.validate((valid) => {
          if (valid) {
            // md5加盐
            const hash = md5.create();
            hash.update(this.registerForm.password + "salt");
            let pwd = hash.hex();
            hash.update(this.registerForm.rePassword + "salt");
            let rePwd = hash.hex();
            // 用户注册请求参数
            let registerData = {
              user_name: this.registerForm.username,
              user_pwd: pwd,
              user_email: this.registerForm.email,
              user_pwd_again: rePwd,
            }
            // 发送请求
            userRegister(registerData).then(res => {
              if (res && res.data.success) {
                // 注册成功
                this.$message.success('注册成功');
                // 提交成功返回登录界面
                this.$router.push("Login");
              } else {
                this.$message.error('请求内容有误');
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
       * 点击登录跳转按钮
       */
      onLoginRouteClick() {
        this.$router.push("Login");
      }
    }
  }
</script>

<style lang="less">
  .register {
    background-image: url("../assets/login-bg.jpeg");
    width: 100vw;
    height: 100vh;
    background-size: 100% 100%;
  }

  .register-panel {
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

    .register-header {
      letter-spacing: .5em;
      text-align: center;
      font-size: 18px;
      height: 60px;
      line-height: 60px;
      background: #e1eee2;
    }
  }
</style>