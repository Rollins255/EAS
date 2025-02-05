<template>
    <div class="card">
        <DataTable :value="data" show-gridlines="true" striped-rows="true" paginator :rows="10" :rowsPerPageOptions="[ 10, 20, 50,100,1000]" sortMode="multiple">
            <Column field="course" sortable="true" header="Course"></Column>
            <Column field="time" sortable="true"  header="Time"></Column>
            <Column field="total" sortable="true"  header="Total"></Column>
        </DataTable>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { DataTable,Column } from 'primevue';
const data =  ref([
    {
        course: 'Mathematics',
        time: '10am-12pm',
        total: 30
    },
    {
        course: 'Physics',
        time: '1pm-3pm',
        total: 25
    },
    {
        course: 'Chemistry',
        time: '9am-11am',
        total: 20
    },
    {
        course: 'Biology',
        time: '11am-1pm',
        total: 22
    },
    {
        course: 'History',
        time: '2pm-4pm',
        total: 18
    },
    {
        course: 'Geography',
        time: '8am-10am',
        total: 15
    },
    {
        course:'Computer science',
        time:'3pm-5pm',
        total:23
    }
])
</script>