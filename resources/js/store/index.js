import rootMutations from "./mutations.js";
import rootActions from "./actions.js";
import rootGetters from "./getters.js";
import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex)

const store = new Vuex.Store({
  state : {
      overlay: false,
      currentData: null,
      lists: [],
      cards: [],
    
  },
  mutations: rootMutations,
  actions: rootActions,
  getters: rootGetters,
});

export default store;