<template>
    <div id="app">
        <div class="buttons">
            <div class="left-items">
                <ButtonPrimary @click="openModal" label="Add"/>
                <ButtonDanger @click="deleteSelectedRows" label="Delete" />
            </div>
            <div class="middle-items">
                <ButtonPrimary :class="{ 'btn-selected': view === 'cars' }" @click="toggleView('cars')" label="Cars" />
                <ButtonPrimary :class="{ 'btn-selected': view === 'parts' }" @click="toggleView('parts')" label="Parts" />
            </div>
            <div class="right-items">
                <InputField type="text" placeholder="Search" v-model="searchVal" @input="search" />
            </div>
        </div>
        <AddModal v-model:show="showModal" @save="handleSave" @close="showModal = false" />
        <div class="table-container">
            <h4 class="mb-3">{{ viewTitle }}</h4>
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="select-header-col"></th>
                        <th v-for="(header, index) in headers" :key="index">{{ header }}</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="rows.length === 0">
                        <td :colspan="headers.length + 2" class="text-center">Nothing to display</td>
                    </tr>
                    <tr v-else v-for="(row, index) in rows" :key="index">
                        <td>
                            <input
                                type="checkbox"
                                @change="toggleRowSelection(index)"
                                :checked="rowsSelected.includes(index)"
                            >
                        </td>
                        <td v-for="(value, key) in row" :key="key">
                            <span>{{ value }}</span>
                        </td>
                            <td>
                                <ButtonPrimary class="btn-sm me-2" @click="edit(row.id)" label="Edit" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import ButtonPrimary from "../../components/ButtonPrimary.vue"
import ButtonDanger from "../../components/ButtonDanger.vue"
import InputField from "../../components/InputField.vue"
import AddModal from "../../components/modals/AddModal.vue"
import axios from "axios"
import router from "../router.js";

export default defineComponent({
    name: "home",
    components: {AddModal, ButtonPrimary, ButtonDanger, InputField},
    data() {
        return {
            view: 'cars',
            headers: [],
            rows: [],
            showModal: false,
            rowsSelected: [],
            searchVal: ''
        };
    },
    computed: {
        viewTitle() {
            return this.view === 'cars' ? 'cars' : 'parts';
        }
    },
    mounted() {
        this.fetchData();
    },

    methods: {
        search() {
            this.fetchData();
        },

        edit(id){
            router.push({ name: 'editPage', params: { type: this.view, id: id } });
        },

        toggleView(view) {
            this.view = view;
            this.fetchData();
        },

        openModal(){
            this.showModal = true;
        },

        async fetchData() {
            try {
                let destination;
                let endpoint = this.view === 'cars' ? "/api/cars" : "/api/parts";

                if (this.searchVal.trim() !== '') {
                    destination = this.view === 'cars' ? 'cars' : 'parts'
                    endpoint = `/api/${destination}/search?query=${this.searchVal}`;
                }

                const response = await axios.get(`http://127.0.0.1:8000${endpoint}`);

                if (Array.isArray(response.data) && response.data.length > 0) {
                    this.headers = Object.keys(response.data[0]).filter(
                        key => key !== "created_at" && key !== "updated_at"
                    );

                    this.rows = response.data.map(item => {
                        if(item.is_registered !== undefined){
                            item.is_registered = item.is_registered ? 'Yes' : 'No';

                        }

                        delete item.created_at;
                        delete item.updated_at;
                        return item;
                    });
                } else {
                    this.headers = [];
                    this.rows = [];
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },

        async handleSave(formData) {
            try {
                if (formData.type === 'car') {
                    await axios.post('http://127.0.0.1:8000/api/cars', {
                        name: formData.carName,
                        registration_number: formData.registrationNumber,
                        is_registered: formData.isRegistered
                    });
                } else if (formData.type === 'part') {
                    await axios.post('http://127.0.0.1:8000/api/parts', {
                        car_id: formData.carId,
                        name: formData.partName,
                        serial_number: formData.serialNumber
                    });
                }

                this.showModal = false;
                await this.fetchData();
            } catch (error) {
                console.error('Error saving data:', error.response?.data || error.message);
            }
        },

        toggleRowSelection(index) {
            if (this.rowsSelected.includes(index)) {
                this.rowsSelected = this.rowsSelected.filter(i => i !== index);
            } else {
                this.rowsSelected.push(index);
            }
        },

        async deleteSelectedRows() {
            if (this.rowsSelected.length === 0) {
                alert("Please select at least one row to delete.");
                return;
            }

            const confirmed = confirm("Are you sure you want to delete the selected items?");
            if (!confirmed) return;

            try {
                for (const index of this.rowsSelected) {
                    const id = this.rows[index].id;
                    let destination = this.view === 'cars' ? 'cars' : 'parts';
                    await axios.delete(`http://127.0.0.1:8000/api/${destination}/${id}`);
                }

                await this.fetchData();
                this.rowsSelected = [];
            } catch (error) {
                console.error('Error deleting rows:', error);
            }
        }
    },
})
</script>


<style scoped>
body {
    background-color: #E7E6F7;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100vh;
    padding: 20px;
    overflow: hidden;
}

.table-container {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    height: 70vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-width: 60rem;
}
.table-wrapper {
    flex-grow: 1;
    overflow-y: auto;
}

.select-header-col{
    max-width: 1rem;
}

.buttons{
    display: flex;
    flex-direction: row;
}

.left-items{
    display: flex;
    justify-content: left;
    align-content: baseline;
    gap: 5px;
    margin-bottom: 20px;
    top: 20px;
    width: 100%;
}

.middle-items {
    display: flex;
    justify-content: center;
    align-content: center;
    gap: 5px;
    margin-bottom: 20px;
    top: 20px;
    width: 100%;
}

.right-items {
    display: flex;
    justify-content: right;
    align-content: end;
    margin-bottom: 20px;
    top: 20px;
    width: 100%;
}

.btn-selected {
    background-color: #C2D2ED !important;
    color: black;
}
</style>
