<template>
    <div class="edit-page">
        <h2>Edit {{ type === 'cars' ? 'Car' : 'Part' }}</h2>

        <div class="input-fields">
            <label class="form-label" v-if="type === 'cars'">Car Name</label>
            <label class="form-label" v-else>Part Name</label>
            <InputField type="text" :placeholder="type === 'cars' ? 'Car Name' : 'Part Name'" v-model="name"/>

            <label class="form-label" v-if="type === 'cars'">Registration Number</label>
            <label class="form-label" v-else>Serial Number</label>
            <InputField type="text" :placeholder="type === 'cars' ? 'Registration Number' : 'Serial Number'"
                v-model="number"/>

            <div v-if="type === 'cars'" class="d-md-flex flex-row gap-3">
                <label>Is Car Registered</label>
                <input type="checkbox" v-model="isRegistered" />
            </div>

            <div v-else>
                <label class="form-label">Car ID</label>
                <InputField type="text" placeholder="Car ID" v-model="carId" />
            </div>
        </div>

        <div class="button-group">
            <ButtonPrimary @click="saveChanges" label="Save" />
            <ButtonDanger @click="cancelEdit" label="Cancel" />
        </div>

        <div v-if="type === 'cars'">
            <h3>Related Parts</h3>
            <ul>
                <li v-for="(part, index) in relatedParts" :key="index">
                    Name: {{ part.name }} - Serial Number: {{ part.serial_number }}
                </li>
            </ul>
        </div>

        <div v-else>
            <h3>Related Car</h3>
            <ul>
                <li>
                    Name: {{ relatedParts.name }} - Registration Number: {{ relatedParts.registration_number }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import ButtonPrimary from "../../components/ButtonPrimary.vue";
import ButtonDanger from "../../components/ButtonDanger.vue";
import InputField from "../../components/InputField.vue";
import axios from "axios";
import router from "../router.js";

export default defineComponent({
    name: "EditPage",
    components: { ButtonPrimary, ButtonDanger, InputField },
    data() {
        return {
            id: '',
            type: '',
            name: '',
            number: '',
            isRegistered: false,
            carId: '',
            relatedParts: [],
        };
    },
    async mounted() {
        await this.fetchItemDetails();
        await this.fetchRelatedParts();
    },
    methods: {
        async fetchItemDetails() {
            this.id = this.$route.params.id;
            this.type = this.$route.params.type;

            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/${this.type}/show/${this.id}`);
                this.name = response.data.name;

                if (this.type === 'cars') {
                    this.number = response.data.registration_number;
                    this.isRegistered = response.data.is_registered === 1;
                } else {
                    this.number = response.data.serial_number;
                    this.carId = response.data.car_id;
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },

        async fetchRelatedParts() {
            try {
                let response;
                if(this.type === 'cars'){
                    response = await axios.get(`http://127.0.0.1:8000/api/cars/group/${this.id}`);
                }
                else{
                    response = await axios.get(`http://127.0.0.1:8000/api/parts/group/${this.carId}`);
                }
                this.relatedParts = response.data;
            } catch (error) {
                console.error("Error fetching related parts:", error);
            }
        },

        async saveChanges() {
            try {
                if (this.type === 'cars') {
                    await axios.put(`http://127.0.0.1:8000/api/cars/${this.id}`, {
                        name: this.name,
                        registration_number: this.number,
                        is_registered: this.isRegistered
                    });
                } else {
                    await axios.put(`http://127.0.0.1:8000/api/parts/${this.id}`, {
                        name: this.name,
                        serial_number: this.number,
                        car_id: this.carId
                    });
                }
                await router.push('/home');
            } catch (error) {
                console.error("Error saving changes:", error);
            }
        },

        cancelEdit() {
            router.push('/home');
        }
    }
});
</script>

<style scoped>
.edit-page {
    padding: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    min-width: 45rem;
    margin: auto;
}

.input-fields {
    margin-bottom: 1.5rem;
}

.button-group {
    margin-bottom: 1.5rem;
    gap: 5px;
}
</style>
