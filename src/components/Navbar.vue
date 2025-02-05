<template>
    <div class="w-full flex justify-between h-[100px] bg-black text-white items-center px-10">
            <div class="font-bold text-3xl"> <RouterLink to="/">CLASS ATTENDACE</RouterLink> </div>
            <Button
                @click="logout"
                v-if="token != null"
            >Logout</Button>
    </div>
</template>
<script setup>
import axiosClient from '@/axios/axios';
import router from '@/router';
import { Button } from 'primevue';
import { onMounted,ref } from 'vue';
const token = ref()
onMounted(()=>{
    token.value = localStorage.getItem('token')
})
const logout = ()=>{
    axiosClient.post('/logout')
    .then((res)=>{
        localStorage.removeItem('token')
        router.push('/login')
    })
    .catch(err=>{
        console.error(err)
        alert('please logout again')
    })
}
</script>