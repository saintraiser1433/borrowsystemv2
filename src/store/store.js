import { createStore } from 'vuex'
import auth from './modules/auth/index'
import sidebar from './modules/sidebar/index'
const store = createStore({
  modules : {
    auth,
    sidebar
  }
})

export default store;
