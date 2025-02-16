<template>
    <div class="card">
        <DataTable :value="data" show-gridlines="true" striped-rows="true" paginator :rows="10" :rowsPerPageOptions="[ 10, 20, 50,100,1000]" sortMode="multiple">
            <Column field="venue" sortable="true" header="Venue"></Column>
            <Column field="time" sortable="true"  header="Time"></Column>
            <Column field="total" sortable="true"  header="Total"></Column>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { DataTable,Column } from 'primevue';
const props = defineProps({history:Object})
const data = ref([])
onMounted(()=>{
    fillTable()
})
watch(()=>props.history,()=>{
    fillTable()
})

function fillTable(){
    if(props.history == null){
        return;
    }
    props.history.forEach(element => {
        data.value.push(element)
    });
}

</script>