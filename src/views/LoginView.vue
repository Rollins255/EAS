<template>
    <div class="w-screen flex items-center h-screen">
        <form class="w-1/2 mx-auto bg-slate-200 rounded-md" @submit.prevent="onSubmit">
            <div class="my-5">
                <p class="text-4xl font-extrabold font-serif text-center">L O G I N</p>
            </div>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" required v-model="user.email"  autocomplete="off" />
                <label for="on_label">Email</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full my-5" required v-model="user.password"  type="password" autocomplete="off" />
                <label for="on_label">Password</label>
            </FloatLabel>
            <div class="flex justify-center w-4/5  mx-auto">
                <Button type="submit" class=" w-1/4 mx-auto">Login</Button>
            </div>
        </form>
    </div>
</template>


<script setup>
import  {ref} from 'vue'
import FloatLabel from 'primevue/floatlabel'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import axiosClient from '@/axios/axios'
import { useUserStore } from '@/stores/user'
import router from '@/router'
const user = ref({
    email:'',
    password:'',
})
function onSubmit() {
    axiosClient.post('/login',user.value)
    .then(res=>{
        console.log(res.data)
        localStorage.setItem('token',res.data)
        useUserStore().setLoggedIn(true)
        router.push('/dashboard')
    })
    .catch(err=>{
        alert('credentials are not matching with our records')
    })
}
</script>