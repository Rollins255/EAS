<script setup>
import {onMounted, ref} from 'vue'
import {DataTable,Column} from 'primevue'
import axiosClient from '@/axios/axios';
const data = ref([])
onMounted(()=>{
    axiosClient.post('/student-history')
    .then((res)=>{
        res.data.forEach(element => {
            console.log(element)
            let obj = {
                unit:element.lecture[0].unit,
                time:element.lecture[0].time,
                venue:element.lecture[0].venue,
                clockIn:element.clockIn,
            }
            data.value.push(obj)
        });
        console.log(data.value)
    })
    .catch(err=>{
        console.error(err)
    })
})
</script>
<template>
    <div class="card">
        <DataTable :value="data" showGridlines sortMode="multiple" tableStyle="min-width: 50rem">
            <Column field="unit" header="Unit code"></Column>
            <Column field="time" header="Time"></Column>
            <Column field="clockIn" header="Clock In"></Column>
            <Column field="venue" header="Venue"></Column>
        </DataTable>
    </div>

</template>