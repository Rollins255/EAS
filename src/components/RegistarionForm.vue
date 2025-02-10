<template>
    <Toast/>
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
                <Select  class="w-full  my-5"  v-model="user.faculty" :options="faculties" ></Select>
                <label for="on_label">Faculty</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <Select  class="w-full  my-5"  v-model="user.department" :options="department" ></Select>
                <!-- <InputText id="on_label" class="w-full  my-5" required v-model="user.department"  autocomplete="off" /> -->
                <label for="on_label">Department</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <Select  class="w-full  my-5"  v-model="user.course" :options="courses" ></Select>
                <!-- <InputText id="on_label" class="w-full  my-5" required v-model="user.course"  autocomplete="off" /> -->
                <label for="on_label">Course</label>
            </FloatLabel>
            <div class="flex justify-center w-4/5  mx-auto" v-if="!isSubmitting">
                <Button type="submit" class=" w-1/2 mx-auto">R E G I S T E R</Button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { ref, watch } from 'vue';
import { Toast,Select,Button,InputText,FloatLabel } from 'primevue';
import { useToast } from 'primevue/usetoast';
import axiosClient from '@/axios/axios';
import { useStudentStore } from '@/stores/student';
import { getCourseId, getCourses, getDepartmentId, getDepartments, getFaculties, getFacultyId } from '@/utils/utils';
const toast = useToast();
const emit = defineEmits(['value'])
const isSubmitting = ref(false)
const user = ref({
    name:'',
    regNo:'',
    idNo:'',
    faculty:null,
    department:null,
    course:null
})

const faculties = ref(getFaculties());
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

const courses = ref()

watch(()=>user.value.faculty,()=>{
    user.value.department = null
    department.value = getDepartments(user.value.faculty)
})
watch(()=>user.value.department,()=>{
    user.value.course = null
    courses.value = getCourses(user.value.faculty,user.value.department)
})

const formError = () => {
    toast.add({ severity: 'error', summary: 'Form Error', detail: 'Please fill the form correctly', life: 5000 });
};
function onSubmit(){
    isSubmitting.value = true
    if(
        user.value.faculty == null ||
        user.value.department == null ||
        user.value.course == null
    ){
        formError()
        return;
    }
    let data = {
        name:user.value.name,
        regNo:user.value.regNo.toUpperCase(),
        idNo:user.value.idNo,
        faculty:getFacultyId(user.value.faculty),
        department:getDepartmentId(user.value.faculty,user.value.department),
        course:getCourseId(user.value.faculty,user.value.department,user.value.course),
        units:["c1","c2","c3","c4"]
    }
    axiosClient.post('/register-student',data)
    .then(res=>{
        let student = {
            'name':res.data.student.name,
            'regNo':res.data.student.regNo,
            'idNo':res.data.student.idNo,
            'faculty':res.data.student.faculty,
            'department':res.data.student.department,
            'course':res.data.student.course,
        }
        isSubmitting.value = false
        emit('value')
        useStudentStore().setStudent(student)
        user.value.name = null
        user.value.regNo = null
        user.value.idNo = null
        user.value.faculty = null
        user.value.department = null
        user.value.course = null
    })
    .catch(err=>{
        isSubmitting.value = false
        console.error(err)
    })
}

</script>