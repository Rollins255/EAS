<script setup>
import { useUserStore } from '@/stores/user';
import { getCourseById, getDepartmentById, getFacultyById } from '@/utils/utils';
import { onMounted, ref, watch } from 'vue';
import { Divider,Button,InputText,Dialog,Toast } from 'primevue';
import { useToast } from 'primevue';
import axiosClient from '@/axios/axios';
const props = defineProps({student:Object})
const student = ref()
const toast = useToast()
const visible = ref(false)
const unit = ref({
    name:'',
    code:'',
})
watch(useUserStore(),()=>{
    student.value = useUserStore().user
})
function addUnit(){
    axiosClient.post('/student/add-unit',unit.value)
    .then(res=>{
        visible.value = false
        show()
        console.log(res.data)
    })
    .catch(err=>{
        console.error(err)
    })
}
function show(){
    toast.add({severity:'success',summary:"Successfully added"})
}
</script>
<template>
    <!-- {{ JSON.parse(student.units) }} -->
    <!-- {{ useUserStore() }} -->
    <div v-if="student">
        <div class="grid grid-cols-2 gap-4">
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
        <div class="flex">
            <div class="my-5 w-3/4 text-center font-bold text-xl font-serif">
                U N I T S
            </div>
            <div class="w-1/4">
                <Button severity="success" @click="visible = true" class="h-fit">
                    <i class="pi pi-plus"></i> Add Unit
                </Button>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-5 text-center">
         <div v-for="item in student.units" :key="item.id" class="bg-blue-600 cursor-pointer rounded-xl shadow-lg p-3 text-white ">
            <p class="font-bold text-2xl">{{ item.name }}</p>
            <p>{{item.code}}</p>
            <p>By. {{item.lecturer.name}}</p>
         </div>
        </div>
        <Dialog v-model:visible="visible" modal header="Add your unit" :style="{ width: '25rem' }">
        <span class="text-surface-500 dark:text-surface-400 block ">Update your units.</span>
        <span class="text-xs mb-8">remember it must be unit that has a lecturer</span>
        <form @submit.prevent="addUnit">
            <div class="flex items-center gap-4 mb-4">
                <label for="name" class="font-semibold w-24">Unit name</label>
                <InputText id="name" v-model="unit.name" class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex items-center gap-4 mb-8">
                <label for="code" class="font-semibold w-24">Unit Code</label>
                <InputText id="code" v-model="unit.code"  class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" ></Button>
                <Button type="submit" label="Save" @click="visible = false"></Button>
            </div>
        </form>
    </Dialog>
    </div>
</template>