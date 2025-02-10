<template>
    <nav-bar/>
    {{ useRoute() }}
    <div class="w-full">
        <div class="w-4/5 mx-auto">
            <div class="bg-blue-200 m-4 rounded grid grid-cols-2">
                <p><span class="font-bold text-lg m-2">UNIT NAME:</span> {{useRoute().query.unit.toUpperCase()}}</p>
                <p><span class="font-bold text-lg m-2">UNIT CODE:</span> {{useRoute().query.code.toUpperCase()}}</p>
                <p><span class="font-bold text-lg m-2">FACULTY:</span>{{getFacultyById(useRoute().query.f).toUpperCase()}}</p>
                <p><span class="font-bold text-lg m-2">DEPARTMENT:</span> {{ getDepartmentById(useRoute().query.f,useRoute().query.d).toUpperCase() }}</p>
                <p><span class="font-bold text-lg m-2">COURSE:</span> {{ getCourseById(useRoute().query.f,useRoute().query.d,useRoute().query.c).toUpperCase() }}</p>
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
                                <FloatLabel variant="on" class="w-1/2 mx-auto">
                                    <Select  class="w-full my-5" required  v-model="lecture.class_time"  :options="class_time" optionLabel="name"></Select>
                                    <label for="on_label">Time</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-1/2 mx-auto">
                                    <Select  class="w-full my-5" required  v-model="lecture.venue"  :options="venue" optionLabel="name"></Select>
                                    <label for="on_label">Venue</label>
                                </FloatLabel>
                                <div class="mx-auto flex justify-center">
                                    <Button type="submit">SET</Button>
                                </div>
                            </form>
                        </TabPanel>
                        <TabPanel value="1">
                            <UnitsHistory></UnitsHistory>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
                
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref } from 'vue';
import UnitsHistory from '@/components/UnitsHistory.vue'
import { FloatLabel,Select,Button,Tabs,Tab,TabList,TabPanels,TabPanel } from 'primevue';
import axiosClient from '@/axios/axios';
import { useRoute, useRouter } from 'vue-router';
import { getCourseById, getCourses, getDepartmentById, getFacultyById } from '@/utils/utils';
import { useLecturerStore } from '@/stores/lecturer';
import router from '@/router';
const lecture = ref({
    venue:null,
    class_time:null
})
console.log(useRoute().query.f)
// faculty getFacultyById(useRoute().query.f)
// department getDepartmentById(useRoute().query.f,useRoute().query.d)
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
let route = useRoute()
const onSubmit = ()=>{
    let lect = {
        // 'course':lecture.value.course.name,
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
        console.log(res)
    })
    .catch(err=>{
        console.error(err)
    })
}


</script>