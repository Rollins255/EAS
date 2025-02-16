<template>
    <div class="w-screen flex items-center h-screen">
        <form class="md:w-1/2 w-[90%] mx-auto  md:p-0 p-2 bg-slate-200 rounded-md" @submit.prevent="onSubmit">
            <div class="flex justify-center">
                <i class="pi pi-home" @click="router.push('/')"></i>
            </div>
            <div class="my-5">
                <p class="text-4xl font-extrabold font-serif text-center">L O G I N</p>
            </div>
            <FloatLabel variant="on" class="md:w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" required v-model="user.staffNo"  autocomplete="off" />
                <label for="on_label">Staff No.</label>
            </FloatLabel>
            <FloatLabel variant="on" class="md:w-1/2 mx-auto">
                <InputText id="on_label" class="w-full my-5" required v-model="user.password"  type="password" autocomplete="off" />
                <label for="on_label">Password</label>
            </FloatLabel>
            <p v-if="isError" class="text-xs text-red-400 text-center pb-4">Credentials don't match our records</p>
            <div class="flex justify-center md:w-4/5  mx-auto">
                <Button v-if="!isSubmitting" type="submit" class=" w-1/4 mx-auto">Login</Button>
                <Button v-else type="button" class=" w-1/4 mx-auto text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="white"><circle cx="12" cy="3.5" r="2"><animateTransform attributeName="transform" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="0 12 12;90 12 12;180 12 12;270 12 12"/><animate attributeName="opacity" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(30 12 12)"><animateTransform attributeName="transform" begin="0.2s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="30 12 12;120 12 12;210 12 12;300 12 12"/><animate attributeName="opacity" begin="0.2s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(60 12 12)"><animateTransform attributeName="transform" begin="0.4s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="60 12 12;150 12 12;240 12 12;330 12 12"/><animate attributeName="opacity" begin="0.4s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle></g></svg>
                </Button>
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
import { useLecturerStore } from '@/stores/lecturer'
import router from '@/router'
const isSubmitting = ref(false)
const isError = ref(false)
const user = ref({
    staffNo:'',
    password:'',
})
function onSubmit() {
    isSubmitting.value = true
    axiosClient.post('/lecturer-login',user.value)
    .then(res=>{
        sessionStorage.setItem('token',res.data.token)
        useUserStore().setLoggedIn(true)
        useLecturerStore().setLecturer(res.data.user)
        sessionStorage.setItem('lecturer',JSON.stringify(useLecturerStore().lecturer))
        isSubmitting.value = false
        router.push('/dashboard/lecturer')
    })
    .catch(err=>{
        isSubmitting.value = false
        isError.value = true
        user.value.password = ''
        setTimeout(()=>{
            isError.value = false
        },8000)
    })
}
</script>