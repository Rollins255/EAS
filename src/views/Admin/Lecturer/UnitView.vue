<template>
    <nav-bar/>
    <div class="w-full">
        <div class="w-4/5 mx-auto">
            <div class="bg-blue-200 m-4 rounded grid grid-cols-2">
                <p><span class="font-bold text-lg m-2">UNIT NAME:</span> COMPUTATIONAL THEORY</p>
                <p><span class="font-bold text-lg m-2">UNIT CODE:</span> COSC 401</p>
                <p><span class="font-bold text-lg m-2">DEPARTMENT:</span> SCIENCE DEPARTMENT</p>
                <p><span class="font-bold text-lg m-2">FACULTY:</span>FACULTY OF SCIENCE AND TECHNOLOGY</p>
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
                                <FloatLabel variant="on" class="w-1/2 mx-auto">
                                    <Select  class="w-full my-5" required  v-model="lecture.course"  :options="classes" optionLabel="name"></Select>
                                    <label for="on_label">Class</label>
                                </FloatLabel>
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
const lecture = ref({
    course:null,
    venue:null,
    class_time:null
})
const classes = ref([
    { name: 'Course 1', code: 'eb1' },
    { name: 'Course 2', code: 'eb2' },
    { name: 'Course 3', code: 'eb3' },
    { name: 'Course 4', code: 'eb4' },
]);
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

const onSubmit = ()=>{
    

    let lect = {
        'course':lecture.value.course.name,
        'venue':lecture.value.venue.name,
        'time':lecture.value.class_time.name,
        'lecturer':1,
        'faculty':1,
        'department':1,
        'course':1,
        'unitCode':'COSC 401',
        'unitName':'COMPUTATIONAL THEORY',
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