const state = () => ({
    auth: {
        login: false,
        user: [],
    }
});

const getters = {
    isLoggedIn(state) {
        return state.auth.login;
    },
    user(state) {
        return state.auth.user;
    }
};

const mutations = {
    LOGIN(state, status) {
        state.auth.login = status;
        state.auth.user = [];
    },

    AUTH_USER(state, user) {
        state.auth.user = user;
    }
};

const actions = {
    login({commit}, form) {
        axios.post('/api/user/login', {
            email: form.email,
            password: form.password
        }).then(response => {
            localStorage.setItem("token", response.data.accessToken);
            commit("LOGIN", true);
            commit("AUTH_USER", response.data.user);
        })
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}