<template>
    <nav-bar></nav-bar>
    <Toast />
    <div class="grid grid-cols-2 w-3/4 mx-auto gap-3 my-4">
        <div>
            <span class="font-bold">Faculty:</span>
            {{ getFaculty(useRoute().params.f) }}
        </div>
        <div>
            <span class="font-bold">Department:</span>
            {{ getDepartment(useRoute().params.f, useRoute().params.d) }}
        </div>
        <div>
            <span class="font-bold">Unit name:</span>
            <!-- {{ getUnitName(useRoute().params.f, useRoute().params.d, useRoute().params.c, useRoute().params.u) }} -->
              {{ useRoute().query.name }}
        </div>
        <div>
            <span class="font-bold">Unit code:</span>
            {{ useRoute().params.u }}
        </div>
    </div>
    <!-- <p v-if="studentData">{{JSON.parse(studentData[0].facials.descriptors).descriptors }}</p> -->
    <Tabs value="0">
        <TabList>
            <Tab value="0">CLASS ATTENDACE CHECK</Tab>
            <Tab value="1">CLASS LIST</Tab>
        </TabList>
        <TabPanels>
            <TabPanel value="0">
                <attendance-recognition @mark-attendance="markAttendance" :student-data="studentData"></attendance-recognition>
            </TabPanel>
            <TabPanel value="1">
                <ClassList :students="studentData" />
            </TabPanel>
        </TabPanels>
    </Tabs>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import AttendanceRecognition from '@/components/AttendanceRecognition.vue';
import { Tabs, Tab, TabList, TabPanels, TabPanel, Toast,ProgressBar,Skeleton } from 'primevue'
import { useToast } from 'primevue/usetoast';
import ClassList from '@/components/ClassList.vue'
import { dtwt } from '@primevue/themes';
import { useRoute } from 'vue-router';
import { department, faculty, getCourse, getCourseId, getDepartment, getDepartmentId, getFaculty, getFacultyId, getUnitName } from '@/utils/utils';
import axiosClient from '@/axios/axios';
import { useClassListStore } from '@/stores/classList';
const toast = useToast();
const video = ref()
const camera = ref('environment')
const stream = ref()
const labels = ref([])
const sure = ref([])
const isLive = ref(false)
const studentData = ref([])
const isDataReady = ref(false)
const courseData = ref()
const labelFaceDescriptors = ref()
onMounted(async () => {
    await getStudents()
})
onUnmounted(() => {
    video.value = null
    stream.value.getTracks().forEach(track => {
        track.stop()
    })
})
const getStudents = async () => {
    courseData.value = {
        faculty: getFacultyId(getFaculty(useRoute().params.f)),
        department: getDepartmentId(
            getFaculty(useRoute().params.f),
            getDepartment(useRoute().params.f, useRoute().params.d)
        ),
        course: getCourseId(
            getFaculty(useRoute().params.f),
            getDepartment(useRoute().params.f, useRoute().params.d),
            getCourse(useRoute().params.f, useRoute().params.d, useRoute().params.c)
        ),
        unitCode:useRoute().params.u,
        lecture: useRoute().query.id
    }
    await axiosClient.post('/get-students', courseData.value)
        .then(res => {
            isDataReady.value = true
            studentData.value = res.data
            useClassListStore().setClassList(res.data)
            // console.log(JSON.parse(res.data[0].facials.descriptors).descriptors)
        })
        .catch(err => {
            isDataReady.value = true
            console.error(err)
        })
}

const markAttendance = (value) => {
    let user = {
        data: courseData.value,
        regNo: value.split('-')[1],
        lecture: useRoute().query.id
    }
    axiosClient.post('/mark-attendance', user)
        .then(res => {
            if (res.data.message == 'present') {
                show('success','PRESENT',res.data.student[0].name +" "+ res.data.student[0].regNo)
                studentData.value = res.data.students
                useClassListStore().setClassList(res.data.students)
            } else if (res.data.message == 'already present') {
                show('info','ALREADY PRESENT',res.data.student[0].name +" "+ res.data.student[0].regNo)
                studentData.value = res.data.students
                useClassListStore().setClassList(res.data.students)
            }
        })
}

function show(severity,summary,detail) {
    toast.add({ severity: severity, summary: summary, detail: detail, life: 5000 });
}

</script>