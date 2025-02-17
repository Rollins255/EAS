<template>
    <!-- {{ students }} -->
    <div class="card">
        <DataTable :value="data" show-gridlines="true" striped-rows="true" paginator :rows="50" :rowsPerPageOptions="[ 50,100,1000]" sortMode="multiple">
            <Column field="reg" sortable="true" header="Reg. No"></Column>
            <Column field="name" sortable="true"  header="Name">
                <!-- <template #body="slotProps">
                    <p class="text-nowrap">{{ slotProps }}</p>
                </template> -->
            </Column>
            <Column field="time" sortable="true"  header="Time"></Column>
            <Column field="inClass" sortable="true"  header="Attended">
                <template #body="slotProps">
                    <i v-if="slotProps.data.inClass == false" class="pi pi-times-circle text-red-700"></i>
                    <i v-if="slotProps.data.inClass == true" class="pi pi-verified text-green-700 "></i>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted, ref,watch } from 'vue';
import { DataTable,Column } from 'primevue';
const {students} = defineProps({students:Array})
const data =  ref([])
watch(()=>students,()=>{
    data.value = []
    students.forEach(el=>{
        data.value.push({
            name:el.name,
            reg:el.regNo,
            time:el.clockIn,
            inClass:el.present
        })
    })
})
</script>