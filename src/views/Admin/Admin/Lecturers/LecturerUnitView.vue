<template>
<nav-bar></nav-bar> 
<div>
    <div class="grid md:grid-cols-2 md:w-3/4 md:mx-auto py-5">
        <p class="font-bold font-serif">UNIT NAME: <span class="font-thin">{{ route.query.unit.toUpperCase()}}</span></p>
        <p class="font-bold font-serif">UNIT CODE: <span  class="font-thin">{{ route.query.code.toUpperCase()}}</span></p>
    </div>
</div>
<div class="card md:w-3/4 md:mx-auto">
    <DataTable :value="data" size="small" showGridlines stripedRows  >
        <Column  field="venue" header="Venue"></Column>
        <Column field="time" header="Time"></Column>
        <Column field="attendance" header="Attendance"></Column>
        <Column field="total" header="Total"></Column>
        <Column field="total"  header="Rate">
            <template #body="slotProps">
                <p>{{ (slotProps.data.attendance / slotProps.data.total)*100 }}%</p>
            </template>
        </Column>
    </DataTable>
</div>
</template>

<script setup>
import axiosClient from '@/axios/axios';
import { DataTable,Column } from 'primevue';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
let data = ref([])
const route = useRoute()
onMounted(()=>{
    axiosClient.get(`/unit-info/${route.params.staffNo}/${route.query.code}`)
    .then(res=>{
        console.log(res.data)
        // data.value = 0
        res.data.units.forEach(element => {
            console.log(element)
            let obj = {
                venue:element.venue,
                time:element.time,
                total:element.students,
                attendance:element.attendance,
            }
            data.value.push(obj)
        });
    })
    .catch(err=>{
        console.error(err)
    })
})
</script>