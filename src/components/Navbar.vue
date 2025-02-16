<template>
    <ConfirmPopup></ConfirmPopup>
    <div class="w-full flex justify-between h-[80px] bg-black text-white items-center px-10">
            <div class="font-bold md:text-3xl"> <RouterLink to="/">CLASS ATTENDACE</RouterLink> </div>
            <div class="hidden md:block">
                <Button
                    @click="logout"
                    v-if="token != null"
                >Logout</Button>
            </div>
            <div class="md:hidden">
                <Button @click="confirm1($event)"> <i class="pi pi-sign-out"></i> </Button>
            </div>    
    </div>
</template>
<script setup>
import axiosClient from '@/axios/axios';
import router from '@/router';
import ConfirmPopup from 'primevue/confirmpopup';
import { Button,SplitButton } from 'primevue';
import { onMounted,ref } from 'vue';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const confirm = useConfirm();
const toast = useToast();
const token = ref()
onMounted(()=>{
    token.value = sessionStorage.getItem('token')
})
const items = [
    {
        label: 'Logout',
        icon: 'pi pi-power-off',
        command: () => {
            // window.location.href = 'https://vuejs.org/';
            logout()
        }
    }
];
const confirm1 = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Are you sure you want to proceed?',
        icon: 'pi pi-exclamation-triangle',
        severity: "info",
        rejectProps: {
            label: 'Cancel',
            severity: 'info',
            outlined: true
        },
        acceptProps: {
            label: 'Logout'
        },
        accept: () => {
            logout()
            // toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 3000 });
        },
        reject: () => {
            // toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};
const logout = ()=>{
    axiosClient.post('/logout')
    .then((res)=>{
        sessionStorage.removeItem('token')
        sessionStorage.clear()
        router.push('/')
    })
    .catch(err=>{
        console.error(err)
        alert('please logout again')
    })
}
</script>



<style>
p.splitbutton{
    background-color: red;
}
</style>