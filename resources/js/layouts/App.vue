<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand" href="/">Payment Management App</router-link>
                <div class="collapse navbar-collapse">
                    <div class="navbar-nav">                            
                        <router-link exact-active-class="active" :to="{name: 'Home'}" class="nav-item nav-link">Home</router-link>
                        <router-link exact-active-class="active" :to="{name: 'Login'}" class="nav-item nav-link" v-if="$store.getters.getToken === 0">Login</router-link>
                        <router-link exact-active-class="active" :to="{ name: 'Register'}" class="nav-item nav-link" v-if="$store.getters.getToken === 0">Register</router-link>
                        <router-link exact-active-class="active" :to="{ name: 'Logout'}" class="nav-item nav-link" v-if="$store.getters.getToken !== 0">Logout</router-link>
                        <router-link exact-active-class="active" :to="{ name: 'EmployeeDashboard' }" class="nav-item nav-link" v-if="$store.getters.getToken !== 0 && $store.getters.getUser.role_name === 'client' ">Book an Appointment</router-link>
                        <router-link exact-active-class="active" :to="{ name: 'DoctorDashboard' }" class="nav-item nav-link" v-if="$store.getters.getToken !== 0 && $store.getters.getUser.role_name === 'doctor'">Appointments</router-link>
                        <router-link exact-active-class="active" :to="{ name: 'AdminDashboard'}" class="nav-item nav-link" v-if="$store.getters.getToken !== 0 && $store.getters.getUser.role_name === 'admin' ">Dashboard</router-link>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </main>
</template>
<style>
.error{
    margin-top: 0.25rem;
    font-size: .875em;
    color: #dc3545;

}
</style>
<script>

    export default {}
</script>