<template>
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <h4>Register</h4>

                <form @submit.prevent="register">
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Register As:</label>
                        <select class="form-control" id="role" v-model="form.role_id" @change="onChange()" >
                            <option  v-for="(role,key) in state.roles" :value="role.id">{{ role.name }}</option>
                        </select>
                        <span v-if="error.role_id" class="error">{{ error.role_id[0] }}</span>

                    </div>
                    <div class="mb-3 mt-3" v-if="selected.role.name === 'doctor'">
                        <label for="doctor_fee" class="form-label">Doctor Fee:</label>
                        <input type="number" class="form-control" id="doctor_fee" placeholder="Enter doctor fee" v-model="form.doctor_fee_amount">
                        <span v-if="error.doctor_fee_amount" class="error">{{ error.doctor_fee_amount[0] }}</span>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="form.name">
                        <span v-if="error.name" class="error">{{ error.name[0] }}</span>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="form.email">
                        <span v-if="error.email" class="error">{{ error.email[0] }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" v-model="form.password">
                        <span v-if="error.password" class="error">{{ error.password[0] }}</span>
                        <span><strong>Note:</strong> Password should be 8 characters long and it should have atleast an upper and a lower case letter, a number, and a special character.</span>

                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter confirm password" v-model="form.password_confirmation">
                        <span v-if="error.password_confirmation" class="error">{{ error.password_confirmation[0] }}</span>
                    </div>
                    
                    <button type="submit" class="btn btn-dark">Register</button>
                </form>
            </div>
        </div>
   </div>
</template>

<script>
    import { reactive, ref, onMounted, toRaw } from 'vue';
    import { useRouter } from 'vue-router';
    import { useStore } from 'vuex';

    export default{
        setup(){
            const router = useRouter();
            const store = useStore();

            let state = reactive({
                roles: []
            });
            
            onMounted(async () => {
                getRoles();
            });

            const selected = reactive({ 
                role: ''
            });

            const getRoles = async () => {
                await axios.get(`/api/roles`).then(response=>{
                    state.roles = response.data.roles;
                }).catch(error=>{
                    console.log(error);
                });
            };

            let form = reactive({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role_id: '',
                doctor_fee_amount: ''
            });

            let error = ref('');

            const register = async () => {
                await axios.post('/api/auth/register', form).then(res => {
                    error.value='';
                    store.dispatch('setToken', res.data.token);
                    store.dispatch('setUser', res.data.user);

                    if(res.data?.user.role_name === 'admin')
                    {
                        router.push({name: 'AdminDashboard'});
                    }else if(res.data?.user?.role_name === 'doctor')
                    {
                        if(res.data.url)
                        {
                            window.location.href = res.data.url;
                        }
                        else
                        {
                            router.push({name: 'DoctorDashboard'});
                        }
                    }else
                    {
                        router.push({name: 'EmployeeDashboard'});
                    }
                }).catch(err => {
                    console.log(err);
                    if(err?.response?.status === 401){
                        error.value = err?.response?.data?.message;
                    }else if  (err.response.status === 422){
                        error.value = err.response.data.errors;
                    }
                });
            }

            const onChange = () => {
                const roles = toRaw(state.roles);
                const role = roles.find((role) => role.id == form.role_id );
                selected.role = role;
            }

            return {
                form,
                register,
                error,
                state,
                onChange,
                selected
            };
        },

    }
</script>