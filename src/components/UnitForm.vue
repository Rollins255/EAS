<template>
    <Toast/>
    <form @submit.prevent="saveUnit" >
        <div class="md:flex items-center gap-4 mb-4">
            <label for="username" class="font-semibold w-24">Faculty</label>
            <Select  class="w-full" required  v-model="unit.faculty" :options="faculties" ></Select>
        </div>
        <div class="md:flex items-center gap-4 mb-4">
            <label for="email" class="font-semibold w-24">Department</label>
            <Select  class="w-full" required  v-model="unit.department" :options="department" ></Select>
        </div>
        <div class="md:flex items-center gap-4 mb-4">
            <label for="username" class="font-semibold w-24">Course</label>
            <Select  class="w-full" required  v-model="unit.course" :options="courses" ></Select>
        </div>
        <div class="md:flex items-center gap-4 mb-4">
            <label for="unit_name" class="font-semibold w-24">Unit Name</label>
            <InputText id="unit_name" v-model="unit.unit_name" required="" class="flex-auto" autocomplete="off" />
        </div>
        <div class="md:flex items-center gap-4 mb-4">
            <label for="unit_code" class="font-semibold w-24">Unit code</label>
            <InputText id="unit_code" v-model="unit.unit_code" required="" class="flex-auto" autocomplete="off" />
        </div>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Cancel" severity="secondary" @click="emit('close')"></Button>
            <Button type="submit" label="Save" ></Button>
        </div>
    </form>
</template>

<script setup>
import { onMounted,ref,watch } from 'vue';
import { getCourseId, getCourses, getDepartmentId, getDepartments, getFaculties, getFacultyId } from '@/utils/utils';
import {Button,Dialog,InputText,Select,Toast} from 'primevue'
import { useToast } from 'primevue/usetoast';
import axiosClient from '@/axios/axios';
import { useLecturerStore } from '@/stores/lecturer';
const faculties = ref(getFaculties());
const department = ref()
const courses = ref()
const toast = useToast()
const emit = defineEmits(['close'])
const unit = ref({
    'faculty':null,
    'department':null,
    'course':null,
    'unit_code':null,
    'unit_name':null,
    'lecturer':useLecturerStore().lecturer.staffNo
})
watch(()=>unit.value.faculty,()=>{
    unit.value.department = null
    department.value = getDepartments(unit.value.faculty)
})
watch(()=>unit.value.department,()=>{
    unit.value.course = null
    courses.value = getCourses(unit.value.faculty,unit.value.department)
})

function saveUnit(){
    if (!unit.value.faculty || !unit.value.department || !unit.value.course) {
        toast.add({severity:'warn',summary:'Please fill all the fields',life:5000})
        return;
    }
    let newUnit = {
        'faculty':getFacultyId(unit.value.faculty),
        'department':getDepartmentId(unit.value.faculty,unit.value.department),
        'course':getCourseId(unit.value.faculty,unit.value.department,unit.value.course),
        'unit_code':unit.value.unit_code.toUpperCase(),
        'unit_name':unit.value.unit_name.toUpperCase(),
        'lecturer':useLecturerStore().lecturer.staffNo
    }
    console.log(newUnit)
    axiosClient.post('/add-unit',newUnit)
    .then(res=>{
        toast.add({severity:'success',summary:'Unit added sucessfully',life:5000})
        console.log(res.data)
        useLecturerStore().setLecturer(res.data.lecturer.lecturer[0])
        emit('close')
    })
    .catch(err=>{
        toast.add({severity:'error',summary:'Unit not added',life:5000})
        console.error(err)
    })
}
</script>