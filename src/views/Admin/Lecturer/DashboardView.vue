<template>
    <nav-bar></nav-bar>
    <div class="flex justify-between w-[90%] mx-auto">
       <div class="text-center font-serif font-bold text-4xl my-5">YOUR UNITS</div> 
       <Button severity="info" class="h-fit my-auto" @click="visible = true" > 
        <i class="pi pi-plus"></i>
        Add Unit</Button>
    </div>
    
    <div class=" w-full grid grid-cols-3">
        <div 
        v-if="useLecturerStore().lecturer"
        v-for="unit in useLecturerStore().lecturer.units"
        @click="unitSelect(unit)"
        class="bg-slate-300 w-[95%] py-3 cursor-pointer m-2 rounded shadow-lg mx-auto text-center"
        >
        {{ unit }}
            <p class="text-3xl">{{unit.code}}</p>
            <p class="font-bold my-4">{{unit.name}}</p>
            <p class="text-sm">{{getFacultyById(unit.faculty)}}</p>
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
        <Dialog v-model:visible="visible" modal header="Unit information" class="w-fit" >
            <!-- <span class="text-surface-500 dark:text-surface-400 block mb-8">Unit information</span> -->
            <unit-form @close="visible = false"></unit-form>
        </Dialog>
    </div>

</template>

<script setup>
import router from '@/router';
import { useLecturerStore } from '@/stores/lecturer';
import { onMounted,ref,watch } from 'vue';
import {Button,Dialog,InputText,Select} from 'primevue'
import UnitForm from '@/components/UnitForm.vue';
import axiosClient from '@/axios/axios';
import { getFacultyById, slugCreator } from '@/utils/utils';
const data = ref()
const visible = ref(false)
const isLoading = ref(false)
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
   router.push(`/unit/${value.id}?unit=${value.name.toLowerCase()}&code=${value.code.toLowerCase()}&f=${value.faculty}&d=${value.department}&c=${value.course}`)
//    router.push(`/unit/${value.id}?unit=${value}`)
}
</script>