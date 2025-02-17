<template>
<nav-bar></nav-bar> 
<div class="card">
    <DataTable :value="data" size="small" showGridlines stripedRows  >
        <Column  field="venue" header="Code"></Column>
        <Column field="time" header="Name"></Column>
        <Column field="attendance" header="Course">
            <!-- <template #body="{data}" >
                <p class="text-nowrap">{{ utils.getCourseById(items[0].label.id,items[1].label.id,data.course) }}</p>
            </template> -->
        </Column>
        <Column field="total" header="Total"></Column>
    </DataTable>
</div>
</template>

<script setup>
import axiosClient from '@/axios/axios';
import { DataTable,Column } from 'primevue';
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
let data = [
   {
    venue:'one',
    time:"11-1",
    total:100,
    attendance:20,
   }
]
const route = useRoute()
onMounted(()=>{
    axiosClient.get(`/unit-info/${route.params.staffNo}/${route.query.code}`)
    .then(res=>{
        console.log(res.data)
        // data.value = 0
        res.data.forEach(element => {
            c
            let obj = {
                venue:element.unit.venue,
                time:element.unit.time,
                total:element.total,
                attendance:element.attendance,
            }
            data.value = obj
        });
    })
    .catch(err=>{
        console.error(err)
    })
})
</script>