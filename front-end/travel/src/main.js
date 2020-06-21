import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import http from "axios";
import Cookies from 'js-cookie'

Vue.config.productionTip = false;
Vue.use(ElementUI);
Vue.prototype.$http = http;
Vue.prototype.$cookie = Cookies;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
