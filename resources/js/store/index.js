import { createStore } from "vuex";

const store = createStore({
    state: {
        token: localStorage.getItem('token') || 0,
        user: JSON.parse(localStorage.getItem('user')) || null,
    },
    mutations: {
        UPDATE_TOKEN(state, payload){
            state.token = payload;
        },
        UPDATE_USER(state, payload){
            state.user = payload;
        }
    },
    actions: {
        setToken(context, payload){
            localStorage.setItem('token', payload);
            context.commit('UPDATE_TOKEN', payload);
        },
        removeToken(context){
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN', 0);
        },

        setUser(context, payload){
            localStorage.setItem('user', JSON.stringify(payload));
            context.commit('UPDATE_USER', payload);
        },
        removeUser(context){
            localStorage.removeItem('user');
            context.commit('UPDATE_USER', 0);
        }
        
    },
    getters: {
        getToken: function(state){
            return state.token;
        },
        getUser: function(state){
            return state.user;
        }
    }
});

export default store;