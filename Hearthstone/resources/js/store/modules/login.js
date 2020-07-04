const state = {
    user: {
        email: "",
        password: ""
    }
}

const getters = {};
const mutations = {};
const actions = {
    userLogin({}, user) {
        axios.post("/api/user/login", {
            email: user.email,
            password: user.password
        }).then(response => {
            console.log(response.data)
            localStorage.setItem("token", response.data.accessToken)
            axios.default.headers.common["Authorization"] = "Bearer " + localStorage.getItem("token");
            window.location.replace('/');
        })
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}