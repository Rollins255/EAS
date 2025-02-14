<script setup>
import { Tabs, Tab, TabList, TabPanels, TabPanel, Toast,ProgressBar,Skeleton } from 'primevue'
import StudentProfile from '@/components/StudentProfile.vue';
import StudentHistory from '@/components/StudentHistory.vue';
import { onMounted, watch,ref } from 'vue';
import { useUserStore } from '@/stores/user';
import axiosClient from '@/axios/axios';
const student = ref()
onMounted(()=>{
    axiosClient.get('/student')
    .then(res=>{
        console.log(res.data)
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
            <Tab value="0">P R O F I L E</Tab>
            <!-- <Tab value="1">U N I T S</Tab> -->
            <Tab value="1">H I S T O R Y</Tab>
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