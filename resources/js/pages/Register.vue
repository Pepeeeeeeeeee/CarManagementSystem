<template>
    <router-view>
        <div id="app">
            <div class="login-box">
                <img src="../../assets/logo.jpg" alt="Logo" class="logo">
                <h4 class="mb-3">Register</h4>
                <form @submit.prevent="register">
                    <InputField v-model="email" type="email" placeholder="Email" />
                    <InputField v-model="password" type="password" placeholder="Password" />
                    <InputField v-model="passwordConfirmation" type="password" placeholder="Password Confirmation" @input="matchPasswords"/>
                    <p v-if="!passwordMatch" class="error-message">Passwords do not match!</p>
                    <ButtonPrimary label="Register"/>
                </form>
                <p class="register-link">Already have an account? <a href="/">Login</a></p>
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
            passwordConfirmation: '',
            passwordMatch: false
        };
    },
    methods: {
        async register() {
            try {
                if(this.passwordMatch){
                    let response = await axios.post('http://127.0.0.1:8000/api/register', {
                        email: this.email,
                        password: this.password
                    });
                    alert(response.data);
                    if (response.status === 201) {
                        await router.push('/home');
                    }
                }
                else{
                    alert("Password don't match!")
                }

            } catch (error) {
                if (error.response) {
                    console.error('Error authenticating data:', error.response?.data || error.message);
                }
            }
        },

        matchPasswords(){
            this.passwordMatch = this.password === this.passwordConfirmation;
            console.log(this.passwordMatch)
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
    text-align: left;
}
</style>
