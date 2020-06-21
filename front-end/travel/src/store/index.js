import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    userInfo: {
      DateJoined: "",
      DateLastModified: "",
      Email: "",
      UID: "",
      UserName: ""
    }
  },
  mutations: {
    setUserInfo(state, userInfo) {
      Object.assign(state.userInfo, userInfo)
    }
  },
  actions: {},
  modules: {}
})
