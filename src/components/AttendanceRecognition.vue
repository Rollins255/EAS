<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import {  Toast,ProgressBar,Skeleton } from 'primevue'
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
// const studentData = ref([])
const isDataReady = ref(false)
const courseData = ref()
const labelFaceDescriptors = ref()
const emit = defineEmits(['mark-attendance'])
const props = defineProps({studentData:Object})
onMounted(async () => {
    // await getStudents()
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
    if (props.studentData.length > 0) {
        let flaotArr = []
        let arr = []
        labelFaceDescriptors.value = await Promise.all(props.studentData.map(async (element) => { 
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
    
        const faceMatcher = new faceapi.FaceMatcher(labelFaceDescriptors.value)
        setInterval(async () => {
            if (video.value == null) {
                clearInterval()
                return;
            }
            isLive.value = true
            // console.log('getting the face')
            const detections = await faceapi.detectAllFaces(video.value, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors();

            if (detections.length > 0) {
                labels.value = []
                sure.value = []
                const bestMatch = faceMatcher.findBestMatch(detections[0].descriptor)
                labels.value.push(bestMatch['_label'])
                sure.value.push(bestMatch['_distance'])
                if (bestMatch['_label'] != 'unknown') {
                    // markAttendance(bestMatch['_label'])
                    emit('mark-attendance',bestMatch['_label'])
                }
            } else {
                labels.value = []
                sure.value = []
                labels.value.push('clarity')
            }

        }, 2000)

    }
}

// const markAttendance = (value) => {
//     let user = {
//         data: courseData.value,
//         regNo: value.split('-')[1],
//         lecture: 1
//     }
//     axiosClient.post('/mark-attendance', user)
//         .then(res => {

//             if (res.data.message == 'present') {
//                 show('success','PRESENT',res.data.student[0].name +" "+ res.data.student[0].regNo)
//                 studentData.value = res.data.list
//                 useClassListStore().setClassList(res.data.list)
//             } else if (res.data.message == 'already present') {
//                 show('info','ALREADY PRESENT',res.data.student[0].name +" "+ res.data.student[0].regNo)
//                 studentData.value = res.data.list
//                 useClassListStore().setClassList(res.data.list)
//             }
//         })
// }

// function show(severity,summary,detail) {
//     toast.add({ severity: severity, summary: summary, detail: detail, life: 5000 });
// }

</script>

<template>
<div>
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
            <video src="" class="mx-auto md:w-1/2  shadow-xl" ref="video" autoplay :class="[labels == 'clarity'
                ? 'shadow-4xl shadow-blue-400'
                : labels == 'unknown'
                    ? 'shadow-4xl shadow-red-400'
                    : 'shadow-4xl shadow-orange-400'
            ]"></video>
            <p v-if="labels == 'clarity'" class="text-center py-4 font-bold text-blue-800">PLEASE MAKE SURE
                YOU CAN SEE YOURSELF CLEARLY</p>
            <!-- correct match -->
            <div class="absolute top-0 left-0 w-full mx-auto h-full flex flex-col justify-center items-center bg-red-200 bg-opacity-20"
                v-if="labels != 'unknown' && labels != 'clarity' && labels.length != 0">
                <div class="bg-blue-300 bg-opacity-45 p-5 m-2 text-center">
                    <p class="md:text-4xl text-2xl font-bold ">{{ labels[0].split('-')[0] }}</p>
                    <p class="md:text-2xl font-bold ">{{ labels[0].split('-')[1] }}</p>
                </div>
                <svg class=" w-[200px] text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m20.27 16.265l.705-4.08a1.666 1.666 0 0 0-1.64-1.95h-5.181a.833.833 0 0 1-.822-.969l.663-4.045a4.8 4.8 0 0 0-.09-1.973a1.64 1.64 0 0 0-1.092-1.137l-.145-.047a1.35 1.35 0 0 0-.994.068c-.34.164-.588.463-.68.818l-.476 1.834a7.6 7.6 0 0 1-.656 1.679c-.415.777-1.057 1.4-1.725 1.975l-1.439 1.24a1.67 1.67 0 0 0-.572 1.406l.812 9.393A1.666 1.666 0 0 0 8.597 22h4.648c3.482 0 6.453-2.426 7.025-5.735"/><path fill="currentColor" fill-rule="evenodd" d="M2.968 9.485a.75.75 0 0 1 .78.685l.97 11.236a1.237 1.237 0 1 1-2.468.107V10.234a.75.75 0 0 1 .718-.749" clip-rule="evenodd"/></svg>
            </div>
            <!-- false match -->
            <div class="absolute top-0 left-0 w-full mx-auto h-full flex flex-col justify-center items-center bg-red-200 bg-opacity-20"
                v-if="labels == 'unknown'">
                <div class="p-5 m-2  text-center border border-red-600 bg-orange-300">
                    <p class="text-4xl font-bold ">UNIDENTIFIED</p>
                    <p class="text-lg font-bold ">please report to the lecturer as asoon as possible . . .
                    </p>
                </div>
                <svg class=" w-[200px] text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m20.27 8.485l.705 4.08a1.666 1.666 0 0 1-1.64 1.95h-5.181a.833.833 0 0 0-.822.969l.663 4.045a4.8 4.8 0 0 1-.09 1.974c-.139.533-.55.962-1.092 1.136l-.145.047c-.328.105-.685.08-.994-.068a1.26 1.26 0 0 1-.68-.818l-.476-1.834a7.6 7.6 0 0 0-.656-1.679c-.415-.777-1.057-1.4-1.725-1.975l-1.439-1.24a1.67 1.67 0 0 1-.572-1.406l.812-9.393A1.666 1.666 0 0 1 8.597 2.75h4.648c3.482 0 6.453 2.426 7.025 5.735"/><path fill="currentColor" fill-rule="evenodd" d="M2.968 15.265a.75.75 0 0 0 .78-.685l.97-11.236a1.237 1.237 0 1 0-2.468-.107v11.279a.75.75 0 0 0 .718.75" clip-rule="evenodd"/></svg>
            </div>
        </div>
    </div>
    <div v-else>
        <p class="text-center">loading . . .</p>
        <ProgressBar :value="useLoadingStore().loading.split('%')[0]"></ProgressBar>
        <div class="w-1/2 mx-auto h-[200px] my-5">
            <Skeleton  class="mb-2" borderRadius="16px"></Skeleton>
            <Skeleton class="w-[300px]" height="200px"></Skeleton>
        </div>
    </div>
</div>
</template>