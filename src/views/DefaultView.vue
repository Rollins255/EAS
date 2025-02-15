<script setup>
import router from '@/router';

const choices = [
    {
        name:'A d m i n',
        link:'/login'
    },
    {
        name:'L e c t u r e r',
        link:'/lecturer/login'
    },
    {
        name:'S t u d e n t',
        link:'/student/login'
    }
]
</script>

<template>
    <div class="sm:flex justify-around items-center h-screen">
        <div class="bg-blue-500 rounded shadow-lg cursor-pointer" v-for="item in choices" @click.prevent="router.push(`${item.link}`)" >
            <p class="p-10 text-center text-4xl font-bold  m-5">{{item.name.toUpperCase()}}</p>
        </div>
    </div>
</template>