<template>
<nav-bar></nav-bar> 
<div class="flex justify-around">
    <div class="grid md:grid-cols-2 md:w-3/4 md:mx-auto py-5">
        <p class="font-bold font-serif">UNIT NAME: <span class="font-thin">{{ route.query.unit.toUpperCase()}}</span></p>
        <p class="font-bold font-serif">UNIT CODE: <span  class="font-thin">{{ route.query.code.toUpperCase()}}</span></p>
    </div>
    <Button severity="info" @click="generalSummary(route.query.code.toUpperCase())" outlined class="h-fit bg-red-400 m-auto font-bold"> <i class="pi pi-download"></i> Summary</Button>
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
        <Column header="Actions">
            <template #body="slotProps">
                <Tag severity="warn" style="cursor: pointer;" @click="download(slotProps.data)">
                    <svg v-if="isDownloading && lecture.id == slotProps.data.id" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><rect width="6" height="14" x="1" y="4" fill="#1020ed"><animate id="svgSpinnersBarsScaleFade0" fill="freeze" attributeName="y" begin="0;svgSpinnersBarsScaleFade1.end-0.125s" dur="0.375s" values="1;5"/><animate fill="freeze" attributeName="height" begin="0;svgSpinnersBarsScaleFade1.end-0.125s" dur="0.375s" values="22;14"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsScaleFade1.end-0.125s" dur="0.375s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="#1020ed" opacity="0.4"><animate fill="freeze" attributeName="y" begin="svgSpinnersBarsScaleFade0.begin+0.075s" dur="0.375s" values="1;5"/><animate fill="freeze" attributeName="height" begin="svgSpinnersBarsScaleFade0.begin+0.075s" dur="0.375s" values="22;14"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsScaleFade0.begin+0.075s" dur="0.375s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="#1020ed" opacity="0.3"><animate id="svgSpinnersBarsScaleFade1" fill="freeze" attributeName="y" begin="svgSpinnersBarsScaleFade0.begin+0.15s" dur="0.375s" values="1;5"/><animate fill="freeze" attributeName="height" begin="svgSpinnersBarsScaleFade0.begin+0.15s" dur="0.375s" values="22;14"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsScaleFade0.begin+0.15s" dur="0.375s" values="1;0.2"/></rect></svg>
                    <i v-else class="pi pi-download"></i>
                </Tag>
            </template>
        </Column>
    </DataTable>
</div>
</template>

<script setup>
import axiosClient from '@/axios/axios';
import { DataTable,Column,Tag,Button } from 'primevue';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
let data = ref([])
const isDownloading = ref(false)
const lecture = ref(null)
const route = useRoute()
onMounted(()=>{
    axiosClient.get(`/unit-info/${route.params.staffNo}/${route.query.code}`)
    .then(res=>{
        res.data.units.forEach(element => {
            let obj = {
                id:element.id,
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

const download = (data)=>{
    isDownloading.value = true
    lecture.value = data
    axiosClient.post('/download',{data}, { responseType: 'blob' })
    .then(res=>{
        const blob = new Blob([res.data], { type: 'application/pdf' }); // Assuming PDF
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = route.query.unit.toUpperCase() +" "+route.query.code.toUpperCase(); // Or make it dynamic
        link.click();
        isDownloading.value = false
        lecture.value = null
    })
    .catch(err=>{
        isDownloading.value = false
        lecture.value = null
        console.error(err)
    })
}

const generalSummary = (unit)=>{
    axiosClient.post('/download/general-summary',{unit})
    .then(res=>{
        console.log(res)
        const blob = new Blob([res.data], { type: 'application/pdf' }); // Assuming PDF
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = encodeURIComponent(route.query.unit + " " + route.query.code.toUpperCase()) + ".pdf";
        // link.download = route.query.unit +" "+route.query.code.toUpperCase(); // Or make it dynamic
        link.click();
        window.URL.revokeObjectURL(url)
        document.body.removeChild(link)

    })
    .catch(err=>{
        console.error(err)
    })
}
</script>