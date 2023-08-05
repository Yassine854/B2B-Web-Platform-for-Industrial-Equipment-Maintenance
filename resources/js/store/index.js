// store/index.js
import { createStore } from 'vuex';

export default createStore({
  state: {
    user: null,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
  },
  actions: {
    login({ commit }, userData) {
      // Perform login logic and set the user in state
      // For example, after a successful login response:
      const user = response.data.user;
      commit('setUser', user);
    },
  },
});
