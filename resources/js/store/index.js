// store.js
import { createStore } from 'vuex';

const store = createStore({
  state: {
    initialSearchValue: null,
  },
  mutations: {
    setInitialSearchValue(state, value) {
      state.initialSearchValue = value;
    },
  },
});

export default store;
