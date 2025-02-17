<template>
    <nav-bar/>
    <div class="pt-10">
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
</template>

<script setup>
import { ref } from 'vue';
import { FloatLabel,Button,InputText } from 'primevue';
import axiosClient from '@/axios/axios';
import * as utils from '@/utils/utils'
const registrationNumber = ref('eb3/34024/23')
const student = ref({
    regNo:null,
    name:null,
    faculty:null,
    department:null,
    course:null,
})

// watch(()=>useStudentStore().student,()=>{
//     registrationNumber.value = useStudentStore().student.regNo
// })
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
</script>