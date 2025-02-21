<template>
    <nav-bar/>
    <div class="h-[90vh] w-full">
        <div class="card md:flex justify-center">
            <Breadcrumb class="w-3/4" :home="home" :model="items">
                <template #item="{ item,props }">
                    <i @click="navPress('h')" v-if="item.icon" :class="[item.icon]"></i>
                    <p  v-if="item.label" class="cursor-pointer" @click="navPress(item.tag)">{{ item.label.label }}</p>
                </template>
            </Breadcrumb>
            <Button class="h-fit my-auto" @click="router.push('/add/new-lecturer')">
                <i class="pi pi-plus"> NEW LECTURER</i>
            </Button>
        </div>
        <div class="grid md:grid-cols-3 gap-3 m-5"  v-if="!departments">
            <div class="bg-blue-200 hover:bg-blue-400 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="facultySelect(faculty)"
                v-for="faculty in faculties"
            >
                <p class="font-bold text-xl ">{{ faculty.label }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-3 m-5" v-if="departments && !courses">
            <div class="bg-cyan-200 hover:bg-cyan-400 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="departmentSelect(department)"
                v-for="department in departments"
            >
                <p class="font-bold text-xl ">{{ department.label }}</p>
            </div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-3 m-5" v-if="lecturers">
            <div class="bg-green-400 hover:bg-green-600 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
               @click="visible = true,dialogData = lecturer"
                v-for="lecturer in lecturers"
            >
                <div>
                    <p class="font-bold text-3xl ">{{lecturer.name.toUpperCase()}}</p>
                    <p class="text-xl ">{{ lecturer.staffNo.toUpperCase() }}</p>
                    <p class="text-lg ">No of units: {{ lecturer.units.length }}</p>
                </div>
            </div>
        </div>
    </div>

    <Dialog v-model:visible="visible" modal header="Lecturer Units" class="md:w-fit w-[95%] md:min-w-[40%]" >
        <!-- <span class="text-surface-500 dark:text-surface-400 block mb-8">Update your information.</span> -->
        
        <div class="flex bg-slate-100 rounded-lg mb-3 justify-around">
            <p class="font-bold">{{ dialogData.name.toUpperCase() }}</p>
            <p class="font-bold">{{ dialogData.staffNo.toUpperCase() }}</p>
        </div>
        <div class="card" v-if="dialogData.units.length == 0">
            <p class="text-center text-sm font-serif">Lecturer has no units teaching.</p>
        </div>
        <div class="card" v-else>
            <DataTable :value="dialogData.units" size="small" showGridlines stripedRows  >
                <Column class="cursor-pointer hover:bg-blue-200" field="code" header="Code">
                    <template #body="{data}">
                        <p @click="unitView(data)" >{{ data.code }}</p>
                    </template>
                </Column>
                <Column field="name" header="Name"></Column>
                <Column field="course" header="Course">
                    <template #body="{data}" >
                        <p class="text-nowrap">{{ utils.getCourseById(items[0].label.id,items[1].label.id,data.course) }}</p>
                    </template>
                </Column>
            </DataTable>
        </div>
    </Dialog>
</template>

<script setup>
import { onMounted, ref } from 'vue'
const departments = ref()
const courses = ref()
const units = ref()
const visible = ref(false)
const dialogData = ref()
import { Breadcrumb } from 'primevue'
import router from '@/router';
import * as utils from '@/utils/utils'
import axiosClient from '@/axios/axios'
import { useLecturerStore } from '@/stores/lecturer'
import {Dialog,DataTable,Column,Button} from 'primevue'
const lecturers = ref()
const home = ref({
    icon: 'pi pi-home'
});
const items = ref([

]);
const faculties = ref([])

onMounted(()=>{
    faculties.value = utils.faculties
})
function facultySelect(value){
    faculties.value.forEach(el=>{
        if(value.label == el.label){
            items.value[0] = {label:el,tag:'f'}
            items.value[1] = {label:null}
            items.value.pop()
            departments.value = el.departments
        }
    })
}

function departmentSelect(value){
    departments.value.forEach(el=>{
        if(value.label == el.label){
            items.value[1] = {label:el,tag:'d'}
            courses.value = el.courses
        }
        
    })
    getLecturers()
}

function courseSelect(value){
    courses.value.forEach(el=>{
        if(value.label == el.label){
            items.value[2] = {label:el,tag:'c'}
        }
    })
    let data = {
       'f':items.value[0].label.id,
       'd':items.value[1].label.id,
       'c':items.value[2].label.id,
    }
    axiosClient.post('/units/',data)
    .then(res=>{
        console.log(res.data)
        units.value = res.data.units
    })
    .catch(err=>{
        console.error(err)
    })
}
function unitSelect(value){
    // console.log(value)
    router.push('/class/attendance/'+items.value[0].label.label_tag+"/"+items.value[1].label.label_tag+"/"+items.value[2].label.label_tag+"/"+value.code+"?name="+value.name)
}

function navPress(value){
    if(value == 'f'){        
        courses.value = null
        units.value = null
        if(items.value.length > 1){
            items.value.pop()
        }
       
    }else if(value == 'd'){
        units.value = null
        if(items.value.length > 2){
            items.value.pop()
        }
    }else if(value == 'h'){
        courses.value = null
        units.value = null
        departments.value = null
        items.value = []
    }
    
}

function getLecturers(){
    let data = 11
    console.log(items.value[0].label.id)
    console.log(items.value[1].label.id)
    axiosClient.get(`/lecturers/${items.value[0].label.id}/${items.value[1].label.id}`)
    .then(res=>{
        useLecturerStore().setLecturersData(res.data.lecturers)
        // console.log(res.data.lecturers)
        lecturers.value = res.data.lecturers
    })
    .catch(err=>{
        console.error(err)
    })
}
function unitView(value){
    router.push(`/lecturer/${dialogData.value.staffNo}?code=${value.code}&unit=${value.name.toLowerCase()}`)
}
</script>