<template>
    <Toast></Toast>
    <nav-bar/>
    <div class="w-full">
        <p class="w-fit pl-2 pr-5 bg-black-200 rounded m-2" @click="router.push('/')">
            <i class="pi pi-angle-left px-2"></i>
            <i class="pi pi-home"></i> 
            Dashboard
        </p>
        <div class="md:w-4/5 mx-auto">
            <div class="bg-blue-200 m-4 rounded grid md:grid-cols-2">
                <p><span class="font-bold md:text-lg  m-2">UNIT NAME:</span> {{useRoute().query.unit.toUpperCase()}}</p>
                <p><span class="font-bold md:text-lg m-2">UNIT CODE:</span> {{useRoute().query.code.toUpperCase()}}</p>
                <p><span class="font-bold md:text-lg m-2">FACULTY:</span>{{getFacultyById(useRoute().query.f).toUpperCase()}}</p>
                <p><span class="font-bold md:text-lg m-2">DEPARTMENT:</span> {{ getDepartmentById(useRoute().query.f,useRoute().query.d).toUpperCase() }}</p>
                <p><span class="font-bold md:text-lg m-2">COURSE:</span> {{ getCourseById(useRoute().query.f,useRoute().query.d,useRoute().query.c).toUpperCase() }}</p>
            </div>
            <div>
                
                <Tabs value="0">
                    <TabList>
                        <Tab value="0">SET CLASS</Tab>
                        <Tab value="1">VIEW HISTORY</Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel value="0">
                            <form @submit.prevent="onSubmit">
                                <!-- <FloatLabel variant="on" class="w-1/2 mx-auto">
                                    <Select  class="w-full my-5" required  v-model="lecture.course"  :options="classes" ></Select>
                                    <label for="on_label">Class</label>
                                </FloatLabel> -->
                                <FloatLabel variant="on" class="md:w-1/2 mx-auto">
                                    <Select  class="w-full my-5" required  v-model="lecture.class_time"  :options="class_time" optionLabel="name"></Select>
                                    <label for="on_label">Time</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="md:w-1/2 mx-auto">
                                    <Select  class="w-full my-5" required  v-model="lecture.venue"  :options="venue" optionLabel="name"></Select>
                                    <label for="on_label">Venue</label>
                                </FloatLabel>
                                <div class="mx-auto flex justify-center">
                                    <Button v-if="!isSubmitting" type="submit" class="w-1/2">S U B M I T</Button>
                                    <Button v-else type="button" class=" w-1/4 mx-auto text-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="white"><circle cx="12" cy="3.5" r="2"><animateTransform attributeName="transform" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="0 12 12;90 12 12;180 12 12;270 12 12"/><animate attributeName="opacity" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(30 12 12)"><animateTransform attributeName="transform" begin="0.2s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="30 12 12;120 12 12;210 12 12;300 12 12"/><animate attributeName="opacity" begin="0.2s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(60 12 12)"><animateTransform attributeName="transform" begin="0.4s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="60 12 12;150 12 12;240 12 12;330 12 12"/><animate attributeName="opacity" begin="0.4s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle></g></svg>
                                    </Button>
                                </div>
                            </form>
                        </TabPanel>
                        <TabPanel value="1">
                            <UnitsHistory :history="history"></UnitsHistory>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
                
            </div>
        </div>

    </div>
</template>
<script setup>
import { onMounted,watch, ref } from 'vue';
import UnitsHistory from '@/components/UnitsHistory.vue'
import { FloatLabel,Select,Button,Tabs,Tab,TabList,TabPanels,TabPanel,Toast } from 'primevue';
import axiosClient from '@/axios/axios';
import { useToast } from 'primevue/usetoast';
import { useRoute, useRouter } from 'vue-router';
import { getCourseById, getCourses, getDepartmentById, getFacultyById } from '@/utils/utils';
import { useLecturerStore } from '@/stores/lecturer';
import router from '@/router';
const toast = useToast()
const route = useRoute()
const history = ref()
const isSubmitting = ref(false)
const lecture = ref({
    venue:null,
    class_time:null
})
const classes = getCourses(getFacultyById(useRoute().query.f),getDepartmentById(useRoute().query.f,useRoute().query.d))
const class_time = ref([
    { name: '7am-9am', code: '1' },
    { name: '9am-11am', code: '2' },
    { name: '11am-1pm', code: '3' },
    { name: '1pm-3pm', code: '5' },
    { name: '3pm-5pm', code: '6' },
    { name: '5pm-7pm', code: '7' },
]);
const venue = ref([
    {name:'Room 1'},
    {name:'Room 2'},
    {name:'Room 3'},
    {name:'Room 4'},
])

setTimeout(()=>{
    axiosClient.get('/unit-history/'+route.query.code.toUpperCase())
    .then(res=>{
        history.value = res.data.history
    })
    .catch(err=>{
        consosle.error(err)
    })
},2000)

const onSubmit = ()=>{
    isSubmitting.value = true
    if(lecture.value.venue == null || lecture.value.class_time ==null){
        toast.add({severity:"warn",summary:"Fill the form correctly",life:6000})
        return;
    }
    let lect = {
        'venue':lecture.value.venue.name,
        'time':lecture.value.class_time.name,
        'lecturer':useLecturerStore().lecturer.staffNo,
        'unit':route.params.id,
        // 'department':route.query.d,
        // 'course':route.query.c,
        // 'unitCode':route.query.code,
        // 'unitName':route.params.id,
    }
    axiosClient.post('/set-class',lect)
    .then(res=>{
        isSubmitting.value = false
        toast.add({severity:"success",summary:"Lecture set successfully",life:5000})
        lecture.value.venue = null
        lecture.value.class_time = null
        router.push('/')
    })
    .catch(err=>{
        isSubmitting.value = false
        console.error(err)
    })
}


</script>