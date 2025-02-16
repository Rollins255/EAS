<template>
    <nav-bar></nav-bar>
    <Toast/>
    <div class="w-screen flex items-center h-fit overflow-auto">
        <form class="sm:w-1/2 w-[90%] mx-auto bg-slate-200 rounded-md" @submit.prevent="onSubmit">
            <div class="my-5">
                <p class="text-4xl font-extrabold font-serif text-center">R E G I S T E R</p>
            </div>
            <div class="grid sm:grid-cols-2 grid-cols-1">
                <FloatLabel variant="on" class="sm:w-1/2 mx-auto">
                    <InputText id="name_label" class="w-full my-5" required v-model="user.name" autocomplete="off" />
                    <label for="name_label">Name</label>
                </FloatLabel>
                <FloatLabel variant="on" class="sm:w-1/2 mx-auto">
                    <InputText id="staffNo_label" class="w-full my-5" required v-model="user.staffNo" autocomplete="off" />
                    <label for="staffNo_label">Staff No</label>
                </FloatLabel>
                <FloatLabel variant="on" class="sm:w-1/2 mx-auto">
                    <InputText id="idNo_label" class="w-full my-5" required v-model="user.idNo" autocomplete="off" />
                    <label for="idNo_label">ID No</label>
                </FloatLabel>
                <FloatLabel variant="on" class="sm:w-1/2 mx-auto">
                    <InputText id="on_label" class="w-full  my-5" required v-model="user.email"  autocomplete="off" />
                    <label for="on_label">Email</label>
                </FloatLabel>
                <FloatLabel variant="on" class="sm:w-1/2 w-[80%] mx-auto ">
                    <Select  class="w-full  my-5"  v-model="user.faculty" :options="faculties" ></Select>
                    <label for="on_label">Faculty</label>
                </FloatLabel>
                <FloatLabel variant="on" class="sm:w-1/2  w-[80%] mx-auto">
                    <Select  class="w-full  my-5"  v-model="user.department" :options="department" ></Select>
                    <label for="on_label">Department</label>
                </FloatLabel>
            </div>
            <div class="flex justify-center md:w-4/5  mx-auto">
                <Button v-if="!isSubmitting" type="submit" class=" md:w-1/4 mx-auto">R E G I S T E R</Button>
                <Button v-else type="button" class=" w-1/4 mx-auto text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="white"><circle cx="12" cy="3.5" r="2"><animateTransform attributeName="transform" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="0 12 12;90 12 12;180 12 12;270 12 12"/><animate attributeName="opacity" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(30 12 12)"><animateTransform attributeName="transform" begin="0.2s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="30 12 12;120 12 12;210 12 12;300 12 12"/><animate attributeName="opacity" begin="0.2s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle><circle cx="12" cy="3.5" r="1.5" transform="rotate(60 12 12)"><animateTransform attributeName="transform" begin="0.4s" calcMode="discrete" dur="2.4s" repeatCount="indefinite" type="rotate" values="60 12 12;150 12 12;240 12 12;330 12 12"/><animate attributeName="opacity" begin="0.4s" dur="0.6s" repeatCount="indefinite" values="1;1;0"/></circle></g></svg>
                </Button>
            </div>
        </form>
    </div>
</template>


<script setup>
import  {ref,watch} from 'vue'
import FloatLabel from 'primevue/floatlabel'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import Select from 'primevue/select'
import { Toast } from 'primevue'
import { useToast } from 'primevue/usetoast'
import axiosClient from '@/axios/axios'
import {getFaculties,getDepartments, faculty, getFacultyId, getDepartmentId} from '@/utils/utils'
import router from '@/router'
const user = ref({
    name: '',
    staffNo: '',
    idNo: '',
    email: '',
    faculty: '',
    department: '',
});
const toast = useToast()
const faculties = ref(getFaculties());
const department = ref()
const isSubmitting = ref(false)
watch(()=>user.value.faculty,()=>{
    user.value.department = null
    department.value = getDepartments(user.value.faculty)
})
function onSubmit() {
    isSubmitting.value = true
    let data = {
        name:user.value.name,
        staffNo:user.value.staffNo,
        idNo:user.value.idNo,
        email:user.value.email,
        faculty:getFacultyId(user.value.faculty),
        department:getDepartmentId(user.value.faculty,user.value.department),
    }
    axiosClient.post('/register-lecturer',data)
    .then(res=>{
        user.value.name = null
        user.value.staffNo = null
        user.value.idNo = null
        user.value.email = null
        user.value.faculty = null
        user.value.department = null
        show('success','Confirmation','Successfully Registered')
        router.push('/dashboard')
        isSubmitting.value = false
    })
    .catch(err=>{
        isSubmitting.value = false
        console.error(err)
        show('error','E R R O R','Registarion failed!!')
    })
}
function show(severity,summary,detail) {
    toast.add({ severity: severity, summary: summary, detail: detail, life: 7000 });
}

</script>