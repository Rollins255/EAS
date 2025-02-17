<template>
    <nav-bar/>
    <div class="h-[90vh] w-full">
        
        <div class="card flex justify-center">
            <Breadcrumb :home="home" :model="items">
                <template #item="{ item,props }">
                    <i @click="navPress('h')" v-if="item.icon" :class="[item.icon]"></i>
                    <p  v-if="item.label" class="cursor-pointer" @click="navPress(item.tag)">{{ item.label.label }}</p>
                </template>
            </Breadcrumb>
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
        <div class="grid md:grid-cols-3 gap-3 m-5" v-if="courses && units.length == 0">
            <div class="bg-green-200 hover:bg-green-400 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="courseSelect(course)"
                v-for="course in courses"
            >
                <p class="font-bold text-xl ">{{ course.label }}</p>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-3 m-5" v-if="units">
            <div class="bg-green-400 hover:bg-green-600 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="unitSelect(unit.unit[0])"
                v-for="unit in units"
            >
            <!-- {{ unit.unit }} -->
                <div>
                    <p>Time:{{ unit.time }}</p>
                    <p class="font-bold text-3xl ">{{ unit.unit[0].code }}</p>
                    <p class="text-xl ">{{ unit.unit[0].name  }}</p>
                    <p>{{ unit.venue }}</p>
                    <!-- <p>lecture:{{ unit.unit[0].count }}</p> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
const departments = ref()
const courses = ref()
const units = ref([])
import { Breadcrumb } from 'primevue'
import router from '@/router';
import * as utils from '@/utils/utils'
import axiosClient from '@/axios/axios'
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
        res.data.lectures.forEach(element=>{
            if(element.unit.length != 0){
                units.value.push(element)
            }
        })
        // units.value = res.data.units
    })
    .catch(err=>{
        console.error(err)
    })
    

    // router.replace('/class/attendance/'+items.value[0].label.label_tag+"/"+items.value[1].label.label_tag+"/"+value)
}
function unitSelect(value){
    console.log(value)
    router.push('/class/attendance/'+items.value[0].label.label_tag+"/"+items.value[1].label.label_tag+"/"+items.value[2].label.label_tag+"/"+value.code+"?name="+value.name+"&id="+value.id)
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

</script>