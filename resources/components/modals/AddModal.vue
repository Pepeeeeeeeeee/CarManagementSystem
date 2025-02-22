<template>
    <VueFinalModal v-model="show" class="modal-overlay" content-class="modal-container"
                   :lock-scroll="true" @click.self="$emit('update:show', false)">
        <h4 class="mb-3">Add New Item</h4>
        <div class="mb-3">
            <label class="form-label">Select Type</label>
            <select class="form-select" v-model="selectedType">
                <option value="car">Car</option>
                <option value="part">Part</option>
            </select>
        </div>
        <div v-if="selectedType === 'car'">
            <div class="mb-3">
                <label class="form-label">Car Name</label>
                <InputField type="text" placeholder="Car Name" v-model="carName" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Registration Number</label>
                <InputField type="text" placeholder="Car Registration Number" v-model="registrationNumber" :required="isRegistered === true" />
            </div>
            <div class="mb-3">
                <label class="form-label">Registration Status</label>
                <div class="d-md-flex flex-row gap-3">
                    <label>Is Car Registered</label>
                    <input type="checkbox" v-model="isRegistered" />
                </div>
            </div>
        </div>
        <div v-if="selectedType === 'part'">
            <div class="mb-3">
                <label class="form-label">Part Name</label>
                <InputField type="text" placeholder="Part Name" v-model="partName" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Serial Number</label>
                <InputField type="text" placeholder="Serial Number" v-model="serialNumber" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Car Id</label>
                <InputField type="text" placeholder="Car Id" v-model="carId" required />
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <ButtonSecondary class="me-2" @click="$emit('update:show', false)" label="Cancel" />
            <ButtonPrimary @click="handleSave" label="Save" />
        </div>
    </VueFinalModal>
</template>

<script>
import {defineComponent} from 'vue';
import {VueFinalModal} from "vue-final-modal";
import ButtonPrimary from "../../components/ButtonPrimary.vue"
import ButtonSecondary from "../../components/ButtonSecondary.vue"
import InputField from "../../components/InputField.vue"

export default defineComponent({
    components: {VueFinalModal, ButtonPrimary, InputField, ButtonSecondary},
    props: {show: Boolean},
    emits: ['update:show', 'save', 'cancel'],
    data() {
        return {
            selectedType: '',
            carName: '',
            registrationNumber: '',
            isRegistered: false,
            partName: '',
            serialNumber: '',
            carId: ''
        }
    },
    methods:{
        trySaveForm() {
            if (this.selectedType === 'car' && (!this.carName || (this.isRegistered === true && !this.registrationNumber))) {
                alert('Please fill all required fields.');
                return false;
            }
            if (this.selectedType === 'part' && (!this.partName || !this.serialNumber || !this.carId)) {
                alert('Please fill all required fields.');
                return false;
            }
            return true;
        },

        formData(){
            console.log(this.registrationNumber)
            if(this.isRegistered === false){
                this.registrationNumber = null;
                console.log(this.registrationNumber)
            }
            return this.selectedType === 'car'
                ? {
                    type: 'car',
                    carName: this.carName,
                    registrationNumber: this.registrationNumber,
                    isRegistered: this.isRegistered
                }
                : {
                    type: 'part',
                    partName: this.partName,
                    serialNumber: this.serialNumber,
                    carId: this.carId
                };
        },

        handleSave(){
            if(this.trySaveForm()){
                this.$emit('save', this.formData());
            }
        }
    }
});
</script>

<style>
.modal-container {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    z-index: 1001;
}

.modal-overlay{
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
</style>
