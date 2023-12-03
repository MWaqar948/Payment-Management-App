<!-- import Table from '../components/Tasks/Table.vue';
export default {
    name: 'Home',
    components: {
        'task-table': Table
    }
} -->


<template>
    <div class="row">
        <!-- <div class="col-12 mb-2 text-end">
            <router-link :to='{name:"taskAdd"}' class="btn btn-primary" v-if="$store.getters.getToken !== 0">Create</router-link>
        </div> -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Appointments</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-2">Booking Time</th>
                                    <th class="col-5">Client Name</th>
                                    <th class="col-1">Fee Paid</th>
                                    <!-- <th class="col-3" v-if="$store.getters.getToken !== 0">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody v-if="appointments?.data?.length > 0">
                                <tr v-for="(appointment,key) in appointments?.data" :key="key">
                                    <td>{{ appointment.id }}</td>
                                    <td>{{ appointment.booking_time }}</td>
                                    <td>{{ appointment.client_name }}</td>
                                    <td>{{ appointment.doctor_fee_amount }}</td>
                                    <!-- <td v-if="$store.getters.getToken !== 0"> -->
                                        <!-- <router-link :to='{name:"taskEdit",params:{id:task.id}}' class="btn btn-success me-2" >Edit</router-link> -->
                                        <!-- <button type="button" @click="deleteTask(task.id)" class="btn btn-danger" >Delete</button> -->
                                    <!-- </td> -->
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No appointments Found.</td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <Pagination align="center" :data="appointments" @pagination-change-page="getAppointments"></Pagination>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Bootstrap5Pagination as Pagination } from 'laravel-vue-pagination';
export default {
    name:"DoctorDashboard",
    components: {
        Pagination
    },
    data(){
        return {
            appointments:[]
        }
    },
    mounted(){
        this.getAppointments()
    },
    methods:{
        getAppointments(page=1) {
            const config = {
                headers: {
                    Authorization: 'Bearer ' + this.$store.getters.getToken,
                }
            };

            this.axios.get(`/api/appointments?page=${page}`, config).then(response=>{
                this.appointments = response.data.appointments;
            }).catch(error=>{
                console.log(error);
                this.appointments = [];
            })
        },
    }
}
</script>