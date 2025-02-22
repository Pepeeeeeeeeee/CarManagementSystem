<template>
    <router-view>
        <div id="app">
            <div class="login-box">
                <img src="../../assets/logo.jpg" alt="Logo" class="logo">
                <h4 class="mb-3">Login</h4>
                <form @submit.prevent="login">
                    <InputField v-model="email" type="email" placeholder="Email" />
                    <InputField v-model="password" type="password" placeholder="Password" />
                    <p v-if="!auth" class="error-message">Wrong credentials!</p>
                    <ButtonPrimary label="Login"/>
                </form>
                <p class="register-link">Don't have an account? <a href="/register">Register</a></p>
            </div>
        </div>
    </router-view>
</template>

<script>
import {defineComponent} from "vue";
import InputField from "../../components/InputField.vue";
import ButtonPrimary from "../../components/ButtonPrimary.vue";
import router from "../router.js";
import axios from "axios"

export default defineComponent({
    components: {ButtonPrimary, InputField},
    data() {
        return {
            email: '',
            password: '',
            auth: true
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: this.email,
                    password: this.password
                });

                if (response.status === 200) {
                    await router.push('/home');
                }
            } catch (error) {
                if (error.response) {
                    this.auth = false;
                    console.error('Error authenticating data:', error.response?.data || error.message);
                }
            }
        }
    }
})
</script>

<style>
body {
    background-color: #E7E6F7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.login-box {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 350px;
}
.logo {
    width: 80px;
    margin-bottom: 1rem;
}

.register-link {
    margin-top: 1rem;
    color: #827081;
}

.error-message {
    color: red;
    font-size: 0.85rem;
    margin-top: -10px;
    margin-bottom: 10px;
    text-align: center;
}
</style>
