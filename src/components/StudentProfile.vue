<script setup>
import { useUserStore } from '@/stores/user';
import { getCourseById, getDepartmentById, getFacultyById } from '@/utils/utils';
import { onMounted, ref, watch } from 'vue';
import { Divider,Button,InputText,Dialog,Toast,ConfirmPopup } from 'primevue';
import { useToast } from 'primevue';
import axiosClient from '@/axios/axios';
import { useConfirm } from "primevue/useconfirm";
import { useStudentStore } from '@/stores/student';
const props = defineProps({student:Object})
const student = ref()
const toast = useToast()
const visible = ref(false)
const unit = ref({
    name:'',
    code:'',
})
const confirm = useConfirm();
watch(useUserStore(),()=>{
    student.value = useUserStore().user
})
function addUnit(){
    if(unit.name == null || unit.code == null){
        toast.add({severity:"error",summary:"Fill the form correctly",life:7000})
        return;
    }
    unit.value.code = unit.value.code.toUpperCase()
    axiosClient.post('/student/add-unit',unit.value)
    .then(res=>{
        show(unit.value.code)
        useUserStore().setUser(res.data.student)
        unit.value.code = ''
        unit.value.name = ''
        visible.value = false
    })
    .catch(err=>{
        console.error(err)
    })
}
function show(code){
    toast.add({severity:'success',summary:code + " Successfully added",life:5000})
}
const confirm1 = (event,unit) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Are you sure you want to remove this unit?',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Remove',
            severity: 'danger'
        },
        accept: () => {
            console.log(unit.code)
            axiosClient.post('/student/remove-unit',{code:unit.code})
            .then(res=>{
                useStudentStore().setStudent(res.data.student)
                useUserStore().setUser(res.data.student)
                sessionStorage.setItem('student',JSON.stringify(res.data.student))
                visible.value = false
            })
            .catch(err=>{
                console.error(err)
            })
            toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted the removed action', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected the remove action', life: 3000 });
        }
    });
};
</script>
<template>
    <ConfirmPopup></ConfirmPopup>
    <Toast></Toast>
    <div v-if="student">
        <div class="grid sm:grid-cols-2  md:gap-4 gap-1">
            <div>
                <p>
                    <span class="font-bold font-serif">Name:</span>
                    {{student.name.toUpperCase()}}
                </p>
            </div>
            <div>
                <p>
                    <span class="font-bold font-serif">Reg No.:</span>
                    {{student.regNo.toUpperCase()}}
                </p>
            </div>
            <div>
                <p>
                    <span class="font-bold font-serif">ID NO.:</span>
                    {{student.idNo.toUpperCase()}}
                </p>
            </div>
            <div>
                <p>
                    <span class="font-bold font-serif">Faculty:</span>
                    {{ getFacultyById(student.faculty).toUpperCase()}}
                </p>
            </div>
            <div>
                <p>
                    <span class="font-bold font-serif">Department:</span>
                    {{ getDepartmentById(student.faculty,student.department).toUpperCase()}} 
                </p>
            </div>
            <div>
                <p>
                    <span class="font-bold font-serif">Course:</span>
                    {{ getCourseById(student.faculty,student.department,student.course).toUpperCase()}} 
                </p>
            </div>
        </div>
        <Divider></Divider>
        <div class="flex justify-between items-center">
            <div class="my-5 md:w-3/4 text-center font-bold text-xl font-serif">
                U N I T S
            </div>
            <div class="md:w-1/4">
                <Button severity="success" @click="visible = true" class="h-fit text-nowrap">
                    <i class="pi pi-plus"></i> Add Unit
                </Button>
            </div>
        </div>
        <div class="grid sm:grid-cols-4  gap-5 text-center">
         <div v-for="item in student.units" :key="item.id" class="bg-slate-600 cursor-pointer rounded-xl shadow-lg p-3 text-white ">
            <div class="flex justify-end h-10 ">
                <Button severity="danger" class="w-10" @click="confirm1($event,item)" > <i  class="pi pi-trash"></i>  </Button>
            </div>
            <p class="font-bold text-2xl">{{ item.name }}</p>
            <p>{{item.code}}</p>
            <p>By. {{item.lecturer.name}}</p>
         </div>
        </div>
        <Dialog v-model:visible="visible" modal header="Add your unit" :style="{ width: '25rem' }">
        <span class="text-surface-500 dark:text-surface-400 block ">Update your units.</span>
        <span class="text-xs mb-8">remember it must be unit that has a lecturer</span>
        <form @submit.prevent="addUnit">
            <div class="md:flex items-center gap-4 mb-4">
                <label for="name" class="font-semibold w-24">Unit name</label>
                <InputText id="name" required v-model="unit.name" class="flex-auto" autocomplete="off" />
            </div>
            <div class="md:flex items-center gap-4 mb-8">
                <label for="code" class="font-semibold w-24">Unit Code</label>
                <InputText id="code" required v-model="unit.code"  class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" ></Button>
                <Button type="submit" label="Save" ></Button>
            </div>
        </form>
    </Dialog>
    </div>
</template>


<style>
.p-toast {
  width: 90% !important; /* Default width for small screens */
  max-width: 400px; /* Ensures it doesn't get too large */
}

/* Medium screens (tablets) */
@media (min-width: 768px) {
  .p-toast {
    width: 50% !important;
    max-width: 500px;
  }
}

/* Large screens (desktops) */
@media (min-width: 1024px) {
  .p-toast {
    width: 30% !important;
    max-width: 600px;
  }
}
</style>