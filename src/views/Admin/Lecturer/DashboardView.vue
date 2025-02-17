<template>
    <Toast></Toast>
    <nav-bar></nav-bar>
    <div class="flex justify-between w-[90%] mx-auto">
       <div class="text-center font-serif font-bold md:text-4xl text-2xl my-5">YOUR UNITS</div> 
       <Button severity="info" class="h-fit my-auto text-xs" @click="visible = true" > 
        <i class="pi pi-plus"></i>
        Add Unit</Button>
    </div>
    
    <div class=" w-full grid md:grid-cols-2 lg:grid-cols-3">
        <div 
        v-if="useLecturerStore().lecturer"
        v-for="unit in useLecturerStore().lecturer.units"
       
        class="bg-blue-300 w-[95%] pt-3  m-2 rounded shadow-lg mx-auto text-center"
        >
            <div class="flex justify-between w-[90%] mb-2">
                <p class="ml-3">Lecture: {{ unit.count }}</p>
                <Button @click="confirm2($event,unit.code)" severity="danger">
                    <i class="pi pi-trash"></i>
                </Button>
            </div>
            <div class="cursor-pointer bg-slate-600/10" @click="unitSelect(unit)" >
                <p class="text-4xl font-bold">{{unit.code}}</p>
                <p class="font-bold  text-lg my-4">{{unit.name}}</p>
                <p class="text-sm">{{getFacultyById(unit.faculty)}}</p>
            </div>
        </div>
        
    </div>
    <div class="w-3/4 h-[40vh]  mx-auto flex justify-center items-center"  v-if="useLecturerStore().lecturer != null && useLecturerStore().lecturer.units ==  null">
        <div class="text-center">
            <p>No units found</p>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-40 mx-auto" viewBox="0 0 24 24"><path fill="currentColor" d="M17 9V7h-2V5h2V3h2v2h2v2h-2v2zM5 21V3h9q-.5.75-.75 1.438T13 6q0 1.8 1.138 3.175T17 10.9q.575.075 1 .075t1-.075V21l-7-3z"/></svg>
            <p>add units by pressing the blue add unit button</p>
        </div>
    </div>
    
    <div class="card flex justify-center">
        <Dialog v-model:visible="visible" modal header="Unit information" class="md:w-fit w-[95%]" >
            <!-- <span class="text-surface-500 dark:text-surface-400 block mb-8">Unit information</span> -->
            <unit-form @close="visible = false"></unit-form>
        </Dialog>
    </div>

</template>

<script setup>
import router from '@/router';
import { useLecturerStore } from '@/stores/lecturer';
import { onMounted,ref,watch } from 'vue';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';
import {Button,Dialog,InputText,Select,Toast} from 'primevue'
import UnitForm from '@/components/UnitForm.vue';
import axiosClient from '@/axios/axios';
import { getFacultyById, slugCreator } from '@/utils/utils';
const data = ref()
const visible = ref(false)
const isLoading = ref(false)
const confirm = useConfirm()
const toast = useToast()
onMounted(()=>{
    isLoading.value = true
    data.value = JSON.parse(sessionStorage.getItem('lecturer'))
    axiosClient.post('/lecturer-data',{staffNo:useLecturerStore().lecturer.staffNo})
    .then(res=>{
        useLecturerStore().setLecturer(res.data.lecturer[0])
        isLoading.value = false
    })
    .catch(err=>{
        console.error(err)
    })
})

function unitSelect(value){
   router.replace(`/unit/${value.id}?unit=${value.name.toLowerCase()}&code=${value.code.toLowerCase()}&f=${value.faculty}&d=${value.department}&c=${value.course}`)
}
const confirm2 = (event,code) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Do you want to delete this unit?',
        icon: 'pi pi-info-circle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity: 'danger'
        },
        accept: () => {
            axiosClient.post('/remove-unit',{unit:code})
            .then(res=>{
                toast.add({ severity: 'info', summary: 'Confirmed', detail: 'Record deleted', life: 3000 });
                useLecturerStore().setLecturer(res.data.lecturer.lecturer[0])
                emit('close')
            })
            .catch(err=>{
                toast.add({severity:'error',summary:'Unit not added',life:5000})
                console.error(err)
            })
        },
        reject: () => {
            // toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}
</script>