<template>
    <nav-bar></nav-bar>
    <div class="text-center font-serif font-bold text-4xl my-5">YOUR UNITS</div>
    <div class=" w-full grid grid-cols-3">
        <div 
        v-for="unit in 10"
        @click="unitSelect(unit)"
        class="bg-slate-300 w-[95%] py-3 cursor-pointer m-2 rounded shadow-lg mx-auto text-center"
        >
            <p class="text-3xl">COSC 401</p>
            <p class="font-bold my-4">Computational Theory</p>
            <p class="text-sm">FACULTY OF SCIENCE AND TECHNOOGY</p>
        </div>
    </div>
</template>

<script setup>
import router from '@/router';


function unitSelect(code){
    router.push(`/unit/${code}`)
}
</script>