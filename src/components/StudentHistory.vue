<script setup>
import {onMounted, ref} from 'vue'
import {DataTable,Column} from 'primevue'
import axiosClient from '@/axios/axios';
const data = ref([])
onMounted(()=>{
    axiosClient.post('/student-history')
    .then((res)=>{
        res.data.forEach(element => {
            let obj = {
                unit_code:element.lecture[0].unit[0].code,
                unit_name:element.lecture[0].unit[0].name,
                lecture_count:element.lecture[0].unit[0].count,
                time:element.lecture[0].time,
                venue:element.lecture[0].venue,
                clockIn:element.clockIn,
            }
            data.value.push(obj)
        });
    })
    .catch(err=>{
        console.error(err)
    })
})
</script>
<template>
    <div class="card">
        <DataTable :value="data" showGridlines sortMode="multiple" tableStyle="min-width: 50rem">
            <Column field="unit_code" header="Unit code"></Column>
            <Column field="unit_name" header="Unit name"></Column>
            <Column field="lecture_count" header="Counts"></Column>
            <Column field="time" header="Time"></Column>
            <Column field="clockIn" header="Clock In"></Column>
            <Column field="venue" header="Venue"></Column>
        </DataTable>
    </div>

</template>