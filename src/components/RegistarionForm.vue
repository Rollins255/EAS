<template>
    <div>
        <form @submit.prevent="onSubmit">
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" required v-model="user.name"  autocomplete="off" />
                <label for="on_label">Name</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" required v-model="user.regNo"  autocomplete="off" />
                <label for="on_label">Registration No.</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" required v-model="user.idNo"  autocomplete="off" />
                <label for="on_label">ID No.</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <Select  class="w-full  my-5"  v-model="user.faculty" :options="faculties" optionLabel="name"></Select>
                <label for="on_label">Faculty</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <Select  class="w-full  my-5"  v-model="user.department" :options="department" optionLabel="name"></Select>
                <!-- <InputText id="on_label" class="w-full  my-5" required v-model="user.department"  autocomplete="off" /> -->
                <label for="on_label">Department</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <Select  class="w-full  my-5"  v-model="user.course" :options="courses" optionLabel="name"></Select>
                <!-- <InputText id="on_label" class="w-full  my-5" required v-model="user.course"  autocomplete="off" /> -->
                <label for="on_label">Course</label>
            </FloatLabel>
            <div class="flex justify-center w-4/5  mx-auto">
                <Button type="submit" class=" w-1/2 mx-auto">R E G I S T E R</Button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { ref, watch } from 'vue';
import FloatLabel from 'primevue/floatlabel'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import Select from 'primevue/select';
import axiosClient from '@/axios/axios';
import { useStudentStore } from '@/stores/student';
const user = ref({
    name:'',
    regNo:'',
    idNo:'',
    faculty:'',
    department:'',
    course:''
})

const faculties = ref([
    { name: 'FACULTY OF SCIENCES AND TECHNOLOGY', code: 'FST', id: 1 },
    { name: 'FACULTY OF ENGINEERING', code: 'FET', id: 2 },
    { name: 'School of Nursing and Public Health', code: 'SNPH', id: 3 },
    { name: 'Faculty of Education and Resources Development', code: 'FERD', id: 4 },
    { name: 'Faculty of Business Studies', code: 'FBUS', id: 5 },
    { name: 'Faculty of Agriculture and Environmental Studies', code: 'FAGRI', id: 6 },
]);
const department = ref()
const dept_FST = ref([
    { name: 'biological sciences', code: 'bio', id: 1 },
    { name: 'physical sciences', code: 'phy', id: 2 },
    { name: 'Computer Science', code: 'comp', id: 3 },
]);
const dept_FET = ref([
    { name: 'Electrical engineering', code: 'eee',id:1 },
]);
const dept_SNPH = ref([
    { name: 'Nursing', code: 'nrs',id:1 },
]);
const dept_FAGRI = ref([
    { name: 'Animal sciences', code: 'aniSci', id: 1 },
    { name: 'Plant sciences', code: 'pltSci', id: 2 },
    { name: 'Food technology', code: 'Ftech', id: 3 },
    { name: 'Agricultural Economics, Agribusiness Management & Agricultural Education', code: 'agriBs', id: 4 },
]);
const dept_FBUS = ref([
    { name: 'Business Adminitration', code: 'bussAdmin', id: 1 },
    { name: 'Management science', code: 'manSci', id: 2 },

])

const courses = ref([
    {name:'Course 1',code:'C1',id:1},
    {name:'Course 2', code:'C2', id:2},
    {name:'Course 3', code:'C3', id:3},
    {name:'Course 4', code:'C4', id:4},
    {name:'Course 5', code:'C5', id:5}
    
])



watch(user.value,()=>{
    switch (user.value.faculty.code) {
        case 'FST':
            department.value = [
                { name: 'biological sciences', code: 'bio', id: 1 },
                { name: 'physical sciences', code: 'phy', id: 2 },
                { name: 'Computer Science', code: 'comp', id: 3 },
                
            ]
            break;
        case 'FET':
            department.value = [
                { name: 'Electrical engineering', code: 'eee',id:1 },
            ]
            break;
        case 'SNPH':
            department.value = [
                { name: 'Nursing', code: 'nrs',id:1 },
            ]
            break;
        case 'FAGRI':
            department.value = [
                { name: 'Animal sciences', code: 'aniSci', id: 1 },
                { name: 'Plant sciences', code: 'pltSci', id: 2 },
                { name: 'Food technology', code: 'Ftech', id: 3 },
                { name: 'Agricultural Economics, Agribusiness Management & Agricultural Education', code: 'agriBs', id: 4 },
            ]
            break;
        case 'FBUS':
            department.value = [
                { name: 'Business Adminitration', code: 'bussAdmin', id: 1 },
                { name: 'Management science', code: 'manSci', id: 2 },
            ]
            break;
        default:
            break;
    }
})

function onSubmit(){
    
    user.value.faculty = user.value.faculty.id
    user.value.department = user.value.department.id
    user.value.course = user.value.course.id
    axiosClient.post('/register-student',user.value)
    .then(res=>{
        let student = {
            'name':res.data.student.name,
            'regNo':res.data.student.regNo,
            'idNo':res.data.student.idNo,
            'faculty':res.data.student.faculty,
            'department':res.data.student.department,
            'course':res.data.student.course,
        }
        useStudentStore().setStudent(student)
    })
    .catch(err=>{
        console.error(err)
    })
}

</script>