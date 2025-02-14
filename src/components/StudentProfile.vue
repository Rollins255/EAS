<script setup>
import { useUserStore } from '@/stores/user';
import { getCourseById, getDepartmentById, getFacultyById } from '@/utils/utils';
import { onMounted, ref, watch } from 'vue';
import { Divider } from 'primevue';
const props = defineProps({student:Object})
const student = ref()
watch(useUserStore(),()=>{
    student.value = useUserStore().user
})

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
        <div class="my-5 text-center font-bold text-xl font-serif">
            U N I T S
        </div>
        <div class="grid grid-cols-4 gap-5 text-center">
         <div v-for="item in student.units" :key="item.id" class="bg-blue-600 cursor-pointer rounded-xl shadow-lg p-3 text-white ">
            <p class="font-bold text-2xl">{{ item.name }}</p>
            <p>{{item.code}}</p>
            <p>By. {{item.lecturer.name}}</p>
         </div>
        </div>
    </div>
</template>