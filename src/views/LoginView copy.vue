<template>
    <div class="w-screen flex items-center h-screen">
        <form class="w-1/2 mx-auto bg-slate-200 rounded-md" @submit.prevent="onSubmit">
            <div class="my-5">
                <p class="text-4xl font-extrabold font-serif text-center">R E G I S T E R</p>
            </div>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="name_label" class="w-full my-5" required v-model="user.name" autocomplete="off" />
                <label for="name_label">Name</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="staffNo_label" class="w-full my-5" required v-model="user.staffNo" autocomplete="off" />
                <label for="staffNo_label">Staff No</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="idNo_label" class="w-full my-5" required v-model="user.idNo" autocomplete="off" />
                <label for="idNo_label">ID No</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full  my-5" required v-model="user.email"  autocomplete="off" />
                <label for="on_label">Email</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="on_label" class="w-full my-5" required v-model="user.password"  type="password" autocomplete="off" />
                <label for="on_label">Password</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-1/2 mx-auto">
                <InputText id="confirm_password_label" class="w-full my-5" required v-model="user.password_confirmation" type="password" autocomplete="off" />
                <label for="confirm_password_label">Confirm Password</label>
            </FloatLabel>
            <div class="flex justify-center w-4/5  mx-auto">
                <Button type="submit" class=" w-1/4 mx-auto">Register</Button>
            </div>
        </form>
    </div>
</template>


<script setup>
import  {ref} from 'vue'
import FloatLabel from 'primevue/floatlabel'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import axiosClient from '@/axios/axios'
const user = ref({
    name: '',
    staffNo: '',
    idNo: '',
    email: '',
    password: '',
    password_confirmation:''
});
function onSubmit() {
    axiosClient.post('/register-admin',user.value)
}
</script>