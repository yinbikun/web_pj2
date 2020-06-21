import Vue from 'vue'
import VueRouter from 'vue-router'
import Travel from '../views/Travel'
import Login from '../views/Login'
import Register from '../views/Register'
import TravelRouter from './travel'
import Cookies from 'js-cookie'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'index',
    redirect: 'Travel'
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/travel',
    name: 'Travel',
    component: Travel,
    redirect: '/travel/home',
    children: [
      ...TravelRouter
    ]
  },
]

const router = new VueRouter({
  routes
})
// 登录判断
router.beforeEach((to, from, next) => {
  const isLogin = Cookies.get('is_login');
  if ((to.name === "Profile" || to.name === "Detail") && isLogin !== "1") {
    next({name: 'Login'});
  } else {
    next();
  }
});
export default router
