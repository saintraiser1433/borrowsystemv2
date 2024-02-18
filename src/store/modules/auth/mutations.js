export default {
  setUser(state, data) {
    state.name = data.username
    state.isAuthenticated = true
    state.role = data.role
    localStorage.setItem('name',data.username),
    localStorage.setItem('isAuthenticated',true),
    localStorage.setItem('role',data.role)
  },


  logout(state) {
    state.name = '';
    state.isAuthenticated = false,
    state.role = '',
    localStorage.removeItem('name'),
    localStorage.removeItem('isAuthenticated'),
    localStorage.removeItem('role')
  },

  initializeStore(state){
    if(localStorage.getItem('isAuthenticated')){
        state.isAuthenticated = localStorage.getItem('isAuthenticated')
    }
    if(localStorage.getItem('name')){
        state.name = localStorage.getItem('name')
    }
    if(localStorage.getItem('role')){
        state.role = localStorage.getItem('role')
    }
  }
};
