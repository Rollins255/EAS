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
            {{ getUnitName(useRoute().params.f, useRoute().params.d, useRoute().params.c, useRoute().params.u) }}
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
                <div class="full" v-if="useLoadingStore().loading == '100%'">
                    <div class="text-center text-xl font-serif py-5">
                        <p>Please face the camera and make sure you can see yourself clearly</p>
                    </div>
                    <div class="flex justify-center" v-if="isLive">
                        Live
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="0" fill="#76cd5d">
                                <animate id="svgSpinnersPulseMultiple0" fill="freeze" attributeName="r"
                                    begin="0;svgSpinnersPulseMultiple2.end" calcMode="spline" dur="1.2s"
                                    keySplines=".52,.6,.25,.99" values="0;11" />
                                <animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulseMultiple2.end"
                                    calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0" />
                            </circle>
                            <circle cx="12" cy="12" r="0" fill="#76cd5d">
                                <animate id="svgSpinnersPulseMultiple1" fill="freeze" attributeName="r"
                                    begin="svgSpinnersPulseMultiple0.begin+0.2s" calcMode="spline" dur="1.2s"
                                    keySplines=".52,.6,.25,.99" values="0;11" />
                                <animate fill="freeze" attributeName="opacity"
                                    begin="svgSpinnersPulseMultiple0.begin+0.2s" calcMode="spline" dur="1.2s"
                                    keySplines=".52,.6,.25,.99" values="1;0" />
                            </circle>
                            <circle cx="12" cy="12" r="0" fill="#76cd5d">
                                <animate id="svgSpinnersPulseMultiple2" fill="freeze" attributeName="r"
                                    begin="svgSpinnersPulseMultiple0.begin+0.4s" calcMode="spline" dur="1.2s"
                                    keySplines=".52,.6,.25,.99" values="0;11" />
                                <animate fill="freeze" attributeName="opacity"
                                    begin="svgSpinnersPulseMultiple0.begin+0.4s" calcMode="spline" dur="1.2s"
                                    keySplines=".52,.6,.25,.99" values="1;0" />
                            </circle>
                        </svg>
                    </div>
                    <div class="relative">
                        <video src="" class="mx-auto w-1/2  shadow-xl" ref="video" autoplay :class="[labels == 'clarity'
                            ? 'shadow-4xl shadow-blue-400'
                            : labels == 'unknown'
                                ? 'shadow-4xl shadow-red-400'
                                : 'shadow-4xl shadow-orange-400'
                        ]"></video>
                        <p v-if="labels == 'clarity'" class="text-center py-4 font-bold text-blue-800">PLEASE MAKE SURE
                            YOU CAN SEE YOURSELF CLEARLY</p>
                        <!-- correct macth -->
                        <div class="absolute top-0 left-0 w-full mx-auto h-full flex flex-col justify-center items-center bg-red-200 bg-opacity-20"
                            v-if="labels != 'unknown' && labels != 'clarity' && labels.length != 0">
                            <div class="bg-blue-300 bg-opacity-45 p-5 m-2 text-center">
                                <p class="text-4xl font-bold ">{{ labels[0].split('-')[0] }}</p>
                                <p class="text-2xl font-bold ">{{ labels[0].split('-')[1] }}</p>
                                <!-- <p>{{ labels[0].split('-') }}</p> -->
                            </div>
                            <i class="pi pi-thumbs-up-fill text-green-600 font-bold  text-sm" style="font-size:12rem;"></i>
                        </div>
                        <!-- false match -->
                        <div class="absolute top-0 left-0 w-full mx-auto h-full flex flex-col justify-center items-center bg-red-200 bg-opacity-20"
                            v-if="labels == 'unknown'">
                            <div class="p-5 m-2  text-center border border-red-600 bg-orange-300">
                                <p class="text-4xl font-bold ">UNIDENTIFIED</p>
                                <p class="text-lg font-bold ">please report to the lecturer as asoon as possible . . .
                                </p>
                            </div>
                            <i class="pi pi-thumbs-down-fill text-red-600 font-bold" style="font-size:13rem;"></i>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-center">loading . . .</p>
                    <!-- <p>loading . . . {{ useLoadingStore().loading }}</p> -->
                    <ProgressBar :value="useLoadingStore().loading.split('%')[0]"></ProgressBar>
                    <div class="w-1/2 mx-auto h-[200px] my-5">
                        <Skeleton  class="mb-2" borderRadius="16px"></Skeleton>
                        <Skeleton class="w-[300px]" height="200px"></Skeleton>
                    </div>
                </div>
            </TabPanel>
            <TabPanel value="1">
                <ClassList :students="studentData" />
            </TabPanel>
        </TabPanels>
    </Tabs>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { Tabs, Tab, TabList, TabPanels, TabPanel, Toast,ProgressBar,Skeleton } from 'primevue'
import { useToast } from 'primevue/usetoast';
import loadModels from '@/lib/loadModels'
import * as faceapi from 'face-api.js'
import { useLoadingStore } from '@/stores/modelLoad';
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
    await loadModels()
    await startStream()
    faceRecognition()
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
        )
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
const startStream = async () => {
    stream.value = await navigator.mediaDevices.getUserMedia(
        {
            video: {
                facingMode: {
                    ideal: camera.value
                }
            }
        }
    );
    video.value.srcObject = stream.value
    console.log('video stream has started')
}

const faceRecognition = async () => {
    if (studentData.value.length > 0) {
        let flaotArr = []
        let arr = []
        labelFaceDescriptors.value = await Promise.all(studentData.value.map(async (element) => { 
            let data = JSON.parse(element.facials.descriptors)
            flaotArr = []
            data.descriptors.forEach((el) => {
                arr = []
                for (let i = 0; i < 128; i++) {
                    arr.push(el[i])
                }
                flaotArr.push(new Float32Array(arr))
                arr = []
            })
            return new faceapi.LabeledFaceDescriptors(data.label, flaotArr)
        }))
    }
    const faceMatcher = new faceapi.FaceMatcher(labelFaceDescriptors.value)
    setInterval(async () => {
        if (video.value == null) {
            clearInterval()
            return;
        }
        isLive.value = true
        console.log('getting the face')
        const detections = await faceapi.detectAllFaces(video.value, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors();

        if (detections.length > 0) {
            labels.value = []
            sure.value = []
            const bestMatch = faceMatcher.findBestMatch(detections[0].descriptor)
            labels.value.push(bestMatch['_label'])
            sure.value.push(bestMatch['_distance'])
            console.log(bestMatch)
            if (bestMatch['_label'] != 'unknown') {
                markAttendance(bestMatch['_label'])
            }
        } else {
            labels.value = []
            sure.value = []
            labels.value.push('clarity')
        }

    }, 2000)
}

const markAttendance = (value) => {
    let user = {
        data: courseData.value,
        regNo: value.split('-')[1],
        lecture: 1
    }
    axiosClient.post('/mark-attendance', user)
        .then(res => {

            if (res.data.message == 'present') {
                show('success','PRESENT',res.data.student[0].name +" "+ res.data.student[0].regNo)
                studentData.value = res.data.list
                useClassListStore().setClassList(res.data.list)
            } else if (res.data.message == 'already present') {
                show('info','ALREADY PRESENT',res.data.student[0].name +" "+ res.data.student[0].regNo)
                studentData.value = res.data.list
                useClassListStore().setClassList(res.data.list)
            }
        })
}

function show(severity,summary,detail) {
    toast.add({ severity: severity, summary: summary, detail: detail, life: 5000 });
}

</script>