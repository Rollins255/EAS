<script setup>
import { Tabs, Tab, TabList, TabPanels, TabPanel, Toast,ProgressBar,Skeleton } from 'primevue'
import StudentProfile from '@/components/StudentProfile.vue';
import StudentHistory from '@/components/StudentHistory.vue';
import { onMounted, watch,ref } from 'vue';
import { useUserStore } from '@/stores/user';
import axiosClient from '@/axios/axios';
import { useStudentStore } from '@/stores/student';
const student = ref()
onMounted(()=>{
    axiosClient.get('/student')
    .then(res=>{
        useStudentStore().setStudent(res.data.student)
        useUserStore().setUser(res.data.student)
        sessionStorage.setItem('student',JSON.stringify(res.data.student))
    })
    .catch(err=>{
        console.error(err)
    })
    useUserStore().user = JSON.parse(sessionStorage.getItem('student'))
})


</script>
<template>
    <nav-bar/>
    <div>
        <Tabs value="0">
        <TabList>
            <Tab value="0" as="div" class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="20" stroke-dashoffset="20" d="M12 5c1.66 0 3 1.34 3 3c0 1.66 -1.34 3 -3 3c-1.66 0 -3 -1.34 -3 -3c0 -1.66 1.34 -3 3 -3Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="20;0"/></path><path stroke-dasharray="36" stroke-dashoffset="36" d="M12 14c4 0 7 2 7 3v2h-14v-2c0 -1 3 -3 7 -3Z"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.5s" dur="0.5s" values="36;0"/></path></g></svg>
                <span class="px-1">P R O F I L E</span>
            </Tab>
            <Tab value="1" as="div" class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path fill="currentColor" fill-opacity="0" stroke-dasharray="64" stroke-dashoffset="64" d="M22 3v14c0 0.55 -0.45 1 -1 1h-14c-0.55 0 -1 -0.45 -1 -1v-14c0 -0.55 0.45 -1 1 -1h14c0.55 0 1 0.45 1 1Z"><animate fill="freeze" attributeName="fill-opacity" begin="1.9s" dur="0.15s" values="0;0.3"/><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/></path><path stroke-dasharray="10" stroke-dashoffset="10" d="M10 6h8"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="10;0"/></path><path stroke-dasharray="10" stroke-dashoffset="10" d="M10 10h8"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="10;0"/></path><path stroke-dasharray="6" stroke-dashoffset="6" d="M10 14h5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="6;0"/></path><path stroke-dasharray="36" stroke-dashoffset="36" d="M2 6v15c0 0.55 0.45 1 1 1h15"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.4s" dur="0.5s" values="36;0"/></path></g></svg>
                <span class="px-1">H I S T O R Y</span>
            </Tab>
        </TabList>
        <TabPanels>
            <TabPanel value="0">
                <student-profile></student-profile>
            </TabPanel>
            <TabPanel value="1">
                <student-history></student-history>
            </TabPanel>
        </TabPanels>
    </Tabs>
    </div>
</template>