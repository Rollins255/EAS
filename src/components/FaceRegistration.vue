
<template>
    <div class="mb-4">
        <form @submit.prevent="getStudent">
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" v-model="registrationNumber" required   autocomplete="off" />
                <label for="on_label">Registration Number</label>
            </FloatLabel>
            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>           
        </form>
        <div class="grid grid-cols-2 font-bold  gap-2" v-if="student.name">
            <p v-for="data in student" class="my-2 border-b ">
                {{ data }}
            </p>
        </div>
    </div>

    <div v-if="student.regNo != null">
        <!-- STEP 1 -->
        <div>
            <p class="text-center  py-5">Step 1. Upload similar face images of the same person atleast 3 images.</p>
        </div>
        <div class="card mx-auto w-3/4" >
            <FileUpload name="demo[]" url="/api/upload" @upload="onTemplatedUpload($event)" :multiple="true" accept="image/*" :maxFileSize="1000000" @select="onSelectedFiles">
                <template #header="{ chooseCallback, uploadCallback, clearCallback, files }">
                    <div class="flex flex-wrap justify-between items-center flex-1 gap-4">
                        <div class="flex gap-2">
                            <Button @click="chooseCallback()" icon="pi pi-images" rounded outlined severity="secondary"></Button>
                            <Button @click="uploadEvent(uploadCallback)" icon="pi pi-cloud-upload" rounded outlined severity="success" :disabled="!files || files.length === 0"></Button>
                            <Button @click="clearCallback()" icon="pi pi-times" rounded outlined severity="danger" :disabled="!files || files.length === 0"></Button>
                        </div>
                        <!-- <ProgressBar :value="totalSizePercent" :showValue="false" class="md:w-20rem h-1 w-full md:ml-auto">
                            <span class="whitespace-nowrap">{{ totalSize }}B / 1Mb</span>
                        </ProgressBar> -->
                    </div>
                </template>
                <template #content="{ files, removeUploadedFileCallback, removeFileCallback }">
                    <div class="flex flex-col gap-8 pt-4">
                        <div v-if="files.length > 0">
                            <h5>Pending</h5>
                            <div class="flex flex-wrap gap-4">
                                <div v-for="(file, index) of files" :key="file.name + file.type + file.size" class="p-8 rounded-border flex flex-col border border-surface items-center gap-4">
                                    <div>
                                        <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" />
                                    </div>
                                    <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file.name }}</span>
                                    <div>{{ formatSize(file.size) }}</div>
                                    <Badge value="Pending" severity="warn" />
                                    <Button icon="pi pi-times" @click="onRemoveTemplatingFile(file, removeFileCallback, index)" outlined rounded severity="danger" />
                                </div>
                            </div>
                        </div>

                        <div v-if="uploadedFiles.length > 0">
                            <h5>Completed</h5>
                            <div class="flex flex-wrap gap-4">
                                <div v-for="(file, index) of uploadedFiles" :key="file.name + file.type + file.size" class="p-8 rounded-border flex flex-col border border-surface items-center gap-4">
                                    <div>
                                        <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" />
                                    </div>
                                    <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file.name }}</span>
                                    <div>{{ formatSize(file.size) }}</div>
                                    <Badge value="Completed" class="mt-4" severity="success" />
                                    <Button icon="pi pi-times" @click="removeUploadedFile(index)" outlined rounded severity="danger" />
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template #empty>
                    <div class="flex items-center justify-center flex-col">
                        <i class="pi pi-cloud-upload !border-2 !rounded-full !p-8 !text-4xl !text-muted-color" />
                        <p class="mt-6 mb-0">Drag and drop files to here to upload.</p>
                    </div>
                </template>
            </FileUpload>
        </div>


        <div v-if="files.length > 0 ||  uploadedFiles.length > 0 " class="border-t border-dashed mt-5">
            <!-- STEP 2 -->
            <div>
                <p class="text-center  py-5">Step 2. Upload the images  for recognition.</p>
            </div>
            <div class="w-4/5 border rounded mx-auto p-5 pt-10" >
                <div  v-if="useLoadingStore().loading != '100%'" class="flex justify-center items-center">
                    <p class="mr-5">
                        Load the model first
                    </p>
                    <Button @click="loadModel">Load model</Button>
                </div>
                <p  class="text-center" v-if="isModelLoading">Loading  . . . . .  .{{useLoadingStore().loading}} </p>
                <div v-if="useLoadingStore().loading == '100%' && !isModelLoading">
                    <p class="text-center font-bold py-5 text-xl">Model loaded <i class="pi pi-thumbs-up" style="font-size:2rem ;"></i> </p>
                    <div class="w-full flex">
                       
                        <Button @click="trainModel" v-if="!isTraining" class="mx-auto">Upload the images</Button>
                        <Button @click="trainModel" v-else class="mx-auto" severity="warn">U p l o a d i n g. . . .</Button>
                    </div>
                </div>
                <p  v-if="successImages.length > 0 || failedImages.length  > 0 " class=" py-5 text-center">Image uplaoded successfull!!</p>


            </div>

            <div v-if="successImages.length > 0 || failedImages.length  > 0 ">
                <!-- STEP 3 -->
                <div>
                    <p class="text-center  py-5">Step 3. Clean the images.</p>
                </div>
                <div class="w-4/5 shadow mx-auto p-5 max-h-[75vh] min-h-[45vh] overflow-auto">
                    <Tabs value="0">
                        <TabList>
                            <Tab value="0">CLEAR IMAGES</Tab>
                            <Tab value="1">UNCLEAR IMAGES</Tab>
                        </TabList>
                        <TabPanels>
                            <TabPanel value="0">
                                <div class="grid grid-cols-3">
                                    <img v-for="image in successImages" class="mx-1 my-2 object-contain w-full h-[30vh]" :src=image alt="">
                                </div>
                            </TabPanel>
                            <TabPanel value="1">
                                <div class="grid grid-cols-3">
                                    <img v-for="image in failedImages" class="mx-1 my-2" :src=image alt="">
                                </div>
                            </TabPanel>
                        </TabPanels>
                    </Tabs>
                    <div class="flex w-full justify-center" v-if="successImages.length != 0 ">
                        <Button @click="cleanData" class="w-3/4" severity="info">CLEAN THE IMAGES</Button>
                    </div>
                </div>

                <!-- STEP 4 -->
                <div v-if="isStep4">
                    <div>
                        <p>Step 4. All done.</p>
                    </div>
                    <div>
                        <p class="text-center py-5">The images are all good</p>
                        <div class="flex justify-center w-full">
                            <Button severity="success" @click="uploadData">ALL GOOD 👍✨</Button>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    
</template>

<script setup>
import { ref, watch } from 'vue';
import { usePrimeVue } from 'primevue/config';
import * as utils from '@/utils/utils';
// import { useToast } from "primevue/usetoast";
import { FileUpload,Button,Message,Badge,ProgressBar,Tabs,Tab,TabList,TabPanels,TabPanel,FloatLabel,InputText } from 'primevue';
import loadModels from '@/lib/loadModels';
import * as faceapi from 'face-api.js'
import { useLoadingStore } from '@/stores/modelLoad';
import axiosClient from '@/axios/axios';
import RegistarionForm from './RegistarionForm.vue';
import { useStudentStore } from '@/stores/student';
const $primevue = usePrimeVue();
// const toast = useToast();
const registrationNumber = ref(useStudentStore().student == null ? '': useStudentStore().student.regNo )
const isModelLoading = ref(false)
const totalSize = ref(0);
const totalSizePercent = ref(0);
const files = ref([]);
const filesUrls = ref([]);
const uploadedFiles = ref([])
const successImages = ref([])
const failedImages = ref([])
const descriptions = ref([])
const trainedData =  ref()
const isTraining = ref(false)
const isStep4 = ref(false)
const student = ref({
    regNo:null,
    name:null,
    faculty:null,
    department:null,
    course:null,
})

watch(()=>useStudentStore().student,()=>{
    registrationNumber.value = useStudentStore().student.regNo
})
const getStudent = ()=>{
    axiosClient.post('/get-student',{'registrationNumber':registrationNumber.value})
    .then(res=>{
        student.value.regNo = res.data.student.regNo
        student.value.name = res.data.student.name
        student.value.faculty = utils.faculty(res.data.student.faculty)
        student.value.department = utils.department(res.data.student.faculty,res.data.student.department)
        student.value.course ="Course " +res.data.student.course
    })
    .catch(err=>{
        console.error(err)
    })
}

const onRemoveTemplatingFile = (file, removeFileCallback, index) => {
    alert('heh')
    removeFileCallback(index);
    totalSize.value -= parseInt(formatSize(file.size));
    totalSizePercent.value = totalSize.value / 10;
};

const onClearTemplatingUpload = (clear) => {
    clear();
    totalSize.value = 0;
    totalSizePercent.value = 0;
};

const onSelectedFiles = (event) => {
    files.value = event.files;
    
    files.value.forEach((file) => {
        totalSize.value += parseInt(formatSize(file.size));
        // filesUrls.value.push(file.objectURL)
    });
};

const uploadEvent = (callback) => {
    totalSizePercent.value = totalSize.value / 10;
    files.value.forEach((file) => {
        // totalSize.value += parseInt(formatSize(file.size));
        uploadedFiles.value.push(file)
        filesUrls.value.push(file.objectURL)
    });
    callback();
};

const onTemplatedUpload = () => {
    // toast.add({ severity: "info", summary: "Success", detail: "File Uploaded", life: 3000 });
};

const removeUploadedFile = (index) => {
  files.value = files.value.filter((_, i) => i !== index)
  filesUrls.value = filesUrls.value.filter((_, i) => i !== index)
  uploadedFiles.value = uploadedFiles.value.filter((_, i) => i !== index)
};

const formatSize = (bytes) => {
    const k = 1024;
    const dm = 3;
    const sizes = $primevue.config.locale.fileSizeTypes;

    if (bytes === 0) {
        return `0 ${sizes[0]}`;
    }

    const i = Math.floor(Math.log(bytes) / Math.log(k));
    const formattedSize = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));

    return `${formattedSize} ${sizes[i]}`;
};

const loadModel = async()=>{
    isModelLoading.value =true
    let res = await loadModels()
    if(res == 1){
        isModelLoading.value = false
    }

}

const trainModel = async()=>{
    isTraining.value = true
    filesUrls.value.forEach( async (el)=>{
        const image = await faceapi.fetchImage(el)
        const detections = await faceapi.detectSingleFace(image).withFaceLandmarks().withFaceDescriptor()
        // console.log(detections.descriptor)
        if(detections){
            successImages.value.push(el)
            descriptions.value.push(detections.descriptor);
        }else{
            failedImages.value.push(el)
        }
    })
    console.log(descriptions.value)
    trainedData.value = new faceapi.LabeledFaceDescriptors(`${student.value.name} - ${student.value.regNo}` ,descriptions.value)  
    isTraining.value = false
}

const cleanData = async()=>{
    let maxScore = [0,0]
    let index = 0
    let scores = ref([])
    successImages.value.forEach(async(element)=>{
        const image =   await faceapi.fetchImage(element)
        const detections = await faceapi.detectSingleFace(image).withFaceLandmarks().withFaceDescriptor()
        if (detections && detections.alignedRect) {
            scores.value.push(detections.alignedRect.score)
        }
        index ++
    })
    let faceIndex  = ref(0)
    watch(scores.value,()=>{
        let max = Math.max(...scores.value);
        faceIndex.value = scores.value.indexOf(max); 
    })

    const image =   await faceapi.fetchImage(successImages.value[faceIndex.value])
    const detections = await faceapi.detectSingleFace(image).withFaceLandmarks().withFaceDescriptor()
    let testImg = new  faceapi.LabeledFaceDescriptors('match',[detections.descriptor])
    const faceMatcher = new faceapi.FaceMatcher(testImg)

    successImages.value.forEach(async(el)=>{
        // cleaningData.value = true
        const img = await faceapi.fetchImage(el);
        const detections = await faceapi.detectAllFaces(img).withFaceLandmarks().withFaceDescriptors()
        if (detections.length > 0) {
            detections.forEach((element)=>{
                const bestMatch = faceMatcher.findBestMatch(element.descriptor)
                if(bestMatch['_label'] != 'match'){
                    // step4.value = false
                    console.log('one')
                    // modelError.value = true
                    // cleanData.value = false
                    return; 
                    // alert('your images have different faces making it not suitable for a good model')
                }else{
                    console.log('two')
                    isStep4.value = true
                }
            })
        }else{
            alert('your images have different faces making it not suitable for a good model')
            console.log('none')

        }
    })
}

const uploadData = ()=>{
    axiosClient.post('/facial-data',{'facials':trainedData.value,'student':student.value})
    .then(res=>{
        registrationNumber.value = null
        isModelLoading.value = false
        totalSize.value = 0;
        totalSizePercent.value = 0;
        files.value = [];
        filesUrls.value = [];
        uploadedFiles.value = []
        successImages.value = []
        failedImages.value = []
        descriptions.value = []
        trainedData.value =  null
        isTraining.value = false
        isStep4.value = false
        student.value.regNo = null
        student.value.name = null
        student.value.faculty = null
        student.value.department = null
        student.value.course = null
    })
    .catch(err=>{
        console.error(err)
    })
}
</script>
