
<template>
    <Toast/>
    <div class="mb-4">
        <form @submit.prevent="getStudent">
            <FloatLabel variant="on" class="sm:w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" v-model="registrationNumber" required   autocomplete="off" />
                <label for="on_label">Registration Number</label>
            </FloatLabel>
            <div class="flex justify-center">
                <Button v-if="!isSubmitting" type="submit">Submit</Button>
                <Button v-else type="button" class=" w-1/4 mx-auto text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="white"><circle cx="12" cy="3.5" r="2"><animateTransform attributeName="transform" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="0 12 12;90 12 12;180 12 12;270 12 12"/><animate attributeName="opacity" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(30 12 12)"><animateTransform attributeName="transform" begin="0.2s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="30 12 12;120 12 12;210 12 12;300 12 12"/><animate attributeName="opacity" begin="0.2s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(60 12 12)"><animateTransform attributeName="transform" begin="0.4s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="60 12 12;150 12 12;240 12 12;330 12 12"/><animate attributeName="opacity" begin="0.4s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle></g></svg>
                </Button>
            </div>           
        </form>
        <div class="grid sm:grid-cols-2 grid-cols-1 font-bold  gap-2" v-if="student.name">
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
        <div class="card mx-auto" >
            <FileUpload name="demo[]" url="/api/upload" @upload="onTemplatedUpload($event)" :multiple="true" accept="image/*" :maxFileSize="1000000" @select="onSelectedFiles">
                <template #header="{ chooseCallback, uploadCallback, clearCallback, files }">
                    <div class="flex flex-wrap justify-between items-center flex-1 gap-4">
                        <div class="flex gap-2">
                            <Button @click="chooseCallback()" icon="pi pi-images" rounded outlined severity="secondary"></Button>
                            <Button @click="uploadEvent(uploadCallback),scrollToBottom()" icon="pi pi-cloud-upload" rounded outlined severity="success" :disabled="!files || files.length === 0"></Button>
                            <Button @click="clearCallback()" icon="pi pi-times" rounded outlined severity="danger" :disabled="!files || files.length === 0"></Button>
                        </div>
                        <!-- <ProgressBar :value="totalSizePercent" :showValue="false" class="md:w-20rem h-1 w-full md:ml-auto">
                            <span class="whitespace-nowrap">{{ totalSize }}B / 1Mb</span>
                        </ProgressBar> -->
                    </div>
                </template>
                <template #content="{ files, removeUploadedFileCallback, removeFileCallback }">
                    <div class="flex flex-col gap-8 pt-4" >
                        <div v-if="readyFiles.length >  0">
                            <h5>Pending</h5>
                            <div class="flex flex-wrap gap-4">
                                <div v-for="(file, index) of readyFiles" :key="file.name + file.type + file.size" class="p-4 rounded-border flex flex-col border border-surface items-center gap-4">
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
                                <div v-for="(file, index) of uploadedFiles" :key="file.name + file.type + file.size" class="p-4 rounded-border flex flex-col border border-surface items-center gap-4">
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
            <div class=" border rounded mx-auto p-5 pt-10" >
                <div  v-if="useLoadingStore().loading != '100%'" class="md:flex justify-center items-center text-center">
                    <p class="md:mr-5 ">
                        Load the model first
                    </p>
                    <Button @click="loadModel">Load model</Button>
                </div>
                <p  class="text-center" v-if="isModelLoading">Loading  . . . . .  .{{useLoadingStore().loading}} </p>
                <div v-if="useLoadingStore().loading == '100%' && !isModelLoading">
                    <p class="text-center font-bold py-5 text-xl">Model loaded <i class="pi pi-thumbs-up" style="font-size:2rem ;"></i> </p>
                    <div class="w-full flex">
                  
                        <Button @click="trainModel" v-if="!isTraining" class="mx-auto">Upload the images</Button>
                        <Button v-else class="mx-auto" severity="warn">U p l o a d i n g. . . .</Button>
                    </div>
                </div>
                <p  v-if="successImages.length > 0 || failedImages.length  > 0 " class=" py-5 text-center">Image uplaoded successfull!!</p>


            </div>

            <div v-if="successImages.length > 0 || failedImages.length  > 0 ">
                <!-- STEP 3 -->
                <div>
                    <p class="text-center  py-5">Step 3. Clean the images.</p>
                </div>
                <div class="shadow mx-auto p-5 max-h-[75vh] min-h-[45vh] overflow-auto">
                    <Tabs value="0">
                        <TabList>
                            <Tab value="0">CLEAR IMAGES</Tab>
                            <Tab value="1">UNCLEAR IMAGES</Tab>
                        </TabList>
                        <TabPanels>
                            <TabPanel value="0">
                                <div class="grid md:grid-cols-3">
                                    <img v-for="image in successImages" class="mx-1 my-2 object-contain w-full h-[30vh]" :src=image alt="">
                                </div>
                            </TabPanel>
                            <TabPanel value="1">
                                <div class="grid md:grid-cols-3">
                                    <img v-for="image in failedImages" class="mx-1 my-2" :src=image alt="">
                                </div>
                            </TabPanel>
                        </TabPanels>
                    </Tabs>
                    <div class="flex w-full justify-center" v-if="successImages.length != 0 ">
                        <Button @click="cleanData" v-if="!isCleaningImages" class="w-3/4 my-5 " severity="info">CLEAN THE IMAGES</Button>
                        <Button  v-else class="w-3/4 my-5 " severity="info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><rect width="6" height="14" x="1" y="4" fill="currentColor"><animate id="svgSpinnersBarsFade0" fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsFade1.end-0.425s" dur="1.275s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="currentColor" opacity="0.4"><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.255s" dur="1.275s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="currentColor" opacity="0.3"><animate id="svgSpinnersBarsFade1" fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.51s" dur="1.275s" values="1;0.2"/></rect></svg>
                        </Button>
                    </div>
                </div>

                <!-- STEP 4 -->
                <div v-if="isStep4">
                    <div>
                        <p class="text-center  py-5">Step 4. All done.</p>
                    </div>
                    <div>
                        <p class="text-center py-5">The images are all good</p>
                        <div class="flex justify-center w-full py-10">
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
import {Toast} from 'primevue'
import { useToast } from 'primevue/usetoast';
import * as utils from '@/utils/utils';
import { FileUpload,Button,Message,Badge,ProgressBar,Tabs,Tab,TabList,TabPanels,TabPanel,FloatLabel,InputText } from 'primevue';
import loadModels from '@/lib/loadModels';
import * as faceapi from 'face-api.js'
import { useLoadingStore } from '@/stores/modelLoad';
import axiosClient from '@/axios/axios';
import { useStudentStore } from '@/stores/student';
const $primevue = usePrimeVue();
const toast = useToast();
const registrationNumber = ref(useStudentStore().student == null ? '': useStudentStore().student.regNo )
const isModelLoading = ref(false)
const isSubmitting = ref(false)
const totalSize = ref(0);
const totalSizePercent = ref(0);
const files = ref([]);
const filesUrls = ref([]);
const uploadedFiles = ref([])
const readyFiles = ref([])
const successImages = ref([])
const failedImages = ref([])
const descriptions = ref([])
const trainedData =  ref()
const isTraining = ref(false)
const isCleaningImages = ref(false)
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
    isSubmitting.value = true
    axiosClient.post('/get-student',{'registrationNumber':registrationNumber.value})
    .then(res=>{
        isSubmitting.value = false
        if(res.data.student  == null){
            toast.add({severity:"error",summary:"STUDENT ERROR",detail:"The registration number is invalid.",life:8000})
            return;
        }
        student.value.regNo = res.data.student.regNo.toUpperCase()
        student.value.name = res.data.student.name
        student.value.faculty = utils.getFacultyById(res.data.student.faculty)
        student.value.department = utils.getDepartmentById(res.data.student.faculty,res.data.student.department)
        student.value.course = utils.getCourseById(res.data.student.faculty,res.data.student.department,res.data.student.course)
        student.value.facials = res.data.student.facials == null ? "Facail registration not done" : "Total images used: "+JSON.parse(res.data.student.facials).descriptors.length
        scrollToBottom()
    })
    .catch(err=>{
        isSubmitting.value = false
        console.error(err)
    })
}

const onRemoveTemplatingFile = (file, removeFileCallback, index) => {
  
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
    readyFiles.value = event.files;
    files.value.forEach((file) => {
        totalSize.value += parseInt(formatSize(file.size));
        // filesUrls.value.push(file.objectURL)
    });
};

const uploadEvent = (callback) => {
    totalSizePercent.value = totalSize.value / 10;
    readyFiles.value.forEach((file) => {
        // totalSize.value += parseInt(formatSize(file.size));
        uploadedFiles.value.push(file)
        filesUrls.value.push(file.objectURL)
        readyFiles.value = readyFiles.value.filter(item => item !== file)
    });
    // callback();
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
    if(filesUrls.value.length == 0){
        update('warn','IMAGES ERROR','please make sure the images are uploaded')
        isTraining.value = false;
        return;
    }
    update('info','RECOGNITION','Uploading images for recognition...this may take a while')
    isTraining.value = true
    let totalItems = filesUrls.value.length
    let count = ref(0)
    watch(count.value,()=>{
        console.log(count.value)
    })
    setTimeout(() => {
        filesUrls.value.forEach( async (el)=>{
            const image = await faceapi.fetchImage(el)
            const detections = await faceapi.detectSingleFace(image).withFaceLandmarks().withFaceDescriptor()
            if(detections){
                successImages.value.push(el)
                console.log(el)
                descriptions.value.push(detections.descriptor);
                scrollToBottom()
            }else{
                failedImages.value.push(el)
                scrollToBottom()
            }
            count.value++
            if(totalItems == count.value){
                isTraining.value = false
                scrollToBottom()
                update('success','SUCCESS','Images uploaded sucessfully')
                setTimeout(() => {
                    update('info','','Proceed to image confirmation')
                }, 2500);
            }
        })
        trainedData.value = new faceapi.LabeledFaceDescriptors(`${student.value.name} - ${student.value.regNo}` ,descriptions.value)  
        
        scrollToBottom()
    }, 2000);
}

const cleanData = async()=>{
    isCleaningImages.value = true
    toast.removeAllGroups()
    update('info','CONFIRMATION','Image cofirmation in progress . . .')
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
                    return; 
                }else{
                    isStep4.value = true
                }
            })
            toast.removeAllGroups()
            // update('success','SUCCESS','Image confirmation Done!')
            scrollToBottom()
            setTimeout(()=>{
                toast.removeAllGroups()
                update('info','FINAL STEP','Press the "ALL GOOD👍✨" button to save the data')
                isCleaningImages.value = false
            },1000)
        }else{
            toast.add({severity:"error",summary:"IMAGES ERROR",detail:"your images have different faces making it not suitable for a good model",life:7000})
            return;
        }
    })
    scrollToBottom()
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
        toast.removeAllGroups()
        toast.add({severity:'success',summary:'REGISTRATION DONE!',detail:'Student is enrolled',life:5000,closable:false})
    })
    .catch(err=>{
        console.error(err)
    })
}

function scrollToBottom(){
    window.scrollTo({
        top:document.body.scrollHeight,
        behavior:"smooth"
    })
}
function update(severity,summary,message){
    toast.add({severity:severity,summary:summary,detail:message,life:5000})
}
</script>
