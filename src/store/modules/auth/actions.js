export default {
    saveUser({commit}, payload) {
       commit('setUser',payload)
    },
    init({commit}) {
        commit('initializeStore')
     }

}