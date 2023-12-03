<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Book Appointment</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="bookAppointment">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Doctor</label>
                                    <select class="form-control" id="role" v-model="appointment.doctor_id" >
                                        <option></option>
                                        <option  v-for="(doctor,key) in doctors" :value="doctor.id">{{ doctor.name }}</option>
                                    </select>
                                    <span v-if="errors.doctor_id" class="error">{{ errors.doctor_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Time:</label>
                                    <input type="date" class="form-control" v-model="appointment.booking_time">
                                    <span v-if="errors.booking_time" class="error">{{ errors.booking_time[0] }}</span>                                          
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Book Appointment</button>
                            </div>
                            <!-- <p class="text-success text-center">{{ message }}</p> -->
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"add-task",
    data(){
        return {
            appointment:{
                doctor_id:"",
                booking_time:"",
            },
            doctors: [],
            errors: {},
            // message: '',
        }
    },
    mounted: function(){
        this.getDoctors();
    },
    methods:{
        getDoctors(){
            const config = {
                headers: {
                    Authorization: 'Bearer ' + this.$store.getters.getToken,
                }
            };
            this.axios.get(`/api/doctors`, config).then(response=>{
                this.doctors = response?.data?.doctors;
            }).catch(error=>{
                console.log(error);
                this.doctors = [];
            })
        },
        
        bookAppointment(){
            const config = {
                headers: {
                    Authorization: 'Bearer ' + this.$store.getters.getToken,
                }
            };
            this.axios.post('/api/appointments',this.appointment, config).then(response=>{
                // this.message = 'Appointment Booked Successfully';
                window.location.href = response.data.url;
            }).catch(error=>{
                console.log(error)
                if (error.response.status === 422){
                  this.errors = error.response.data.errors;
                }
            })
        }
    },
}
</script>