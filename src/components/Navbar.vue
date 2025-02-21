<template>
    <ConfirmPopup></ConfirmPopup>
    <div class="w-full flex justify-between h-[80px] bg-black text-white items-center px-10">
            <div class="font-bold md:text-3xl"> <RouterLink to="/">CLASS ATTENDACE</RouterLink> </div>
            <div class="hidden md:block">
                <Button v-if="user !== null" @click="router.push('/class/setup')" class="text-sm font-bold mx-5">C l a s s</Button>
                <Button
                    @click="logout"
                    class="text-sm font-bold"
                    v-if="token != null && !isLogOut"
                >Logout</Button>
                <Button v-else  type="button" class="my-auto text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="white"><circle cx="12" cy="3.5" r="2"><animateTransform attributeName="transform" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="0 12 12;90 12 12;180 12 12;270 12 12"/><animate attributeName="opacity" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(30 12 12)"><animateTransform attributeName="transform" begin="0.2s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="30 12 12;120 12 12;210 12 12;300 12 12"/><animate attributeName="opacity" begin="0.2s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(60 12 12)"><animateTransform attributeName="transform" begin="0.4s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="60 12 12;150 12 12;240 12 12;330 12 12"/><animate attributeName="opacity" begin="0.4s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle></g></svg>
                </Button>
            </div>
            <div class="md:hidden">
                <!-- {{ user == null }} -->
                <Button v-if="user == null" @click="confirm1($event)"> <i class="pi pi-sign-out"></i> </Button>
                <div v-else>
                    <!-- {{ sessionStorage.getItem('lecturer') }} -->
                    <Button @click="visible = true"><i class="pi pi-bars"></i></Button>
                    <Drawer v-model:visible="visible" header="Menu">
                        <div class="h-full">
                            <RouterLink to="/class/setup">
                                <div class="font-bold h-[90%]">
                                    CLASS SETUP
                                </div>
                            </RouterLink>
                            
                            <Button v-if="!isLogOut" @click="logout" class="mx-auto" severity="danger">L O G O U T</Button>
                            <Button v-else severity="danger" class=" w-1/4 mx-auto text-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="white"><circle cx="12" cy="3.5" r="2"><animateTransform attributeName="transform" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="0 12 12;90 12 12;180 12 12;270 12 12"/><animate attributeName="opacity" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(30 12 12)"><animateTransform attributeName="transform" begin="0.2s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="30 12 12;120 12 12;210 12 12;300 12 12"/><animate attributeName="opacity" begin="0.2s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(60 12 12)"><animateTransform attributeName="transform" begin="0.4s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="60 12 12;150 12 12;240 12 12;330 12 12"/><animate attributeName="opacity" begin="0.4s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle></g></svg>
                            </Button>
                        </div>
                    </Drawer>
                </div>
                
            </div>    
    </div>
</template>
<script setup>
import axiosClient from '@/axios/axios';
import router from '@/router';
import ConfirmPopup from 'primevue/confirmpopup';
import { Button,SplitButton,Drawer } from 'primevue';
import { onMounted,ref } from 'vue';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
const user = sessionStorage.getItem('lecturer')
const confirm = useConfirm();
const toast = useToast();
const isLoggingOut = ref(false)
const token = ref()
const isLogOut = ref(false)
const visible = ref(false)
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
    isLogOut.value = true
    axiosClient.post('/logout')
    .then((res)=>{
        sessionStorage.removeItem('token')
        sessionStorage.clear()
        router.push('/')
        isLogOut.value = false
    })
    .catch(err=>{
        console.error(err)
        isLogOut.value = false
        // alert('please logout again')
    })
}

function classSetup(){
    router.push('/class/setup')
}
</script>



<style>
p.splitbutton{
    background-color: red;
}
</style>