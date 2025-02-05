<template>
    <nav-bar/>
    <div>
        <h1 class="font-bold text-center text-3xl py-4 font-serif">REGISTER LEARNER</h1>
    </div>
    <div class="w-2/3 mx-auto">
        <Stepper value="1">
            <StepList>
                <Step value="1">REGISTARTION FORM</Step>
                <Step value="2">FACIALS REGISTARTION</Step>
            </StepList>
            <StepPanels>
                <StepPanel v-slot="{ activateCallback }" value="1">
                    <RegistarionForm/>
                    <div class="flex pt-6 justify-end">
                        <Button label="Next" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback('2')" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="2">
                    <FaceRegistration/>
                    <div class="pt-6">
                        <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('2')" />
                    </div>
                </StepPanel>
            </StepPanels>
        </Stepper>
       
        
    </div>

</template>
<script setup>
import { Stepper,StepList,StepPanels,StepItem,Step,StepPanel } from 'primevue';
import RegistarionForm from '@/components/RegistarionForm.vue';
import FaceRegistration from '@/components/FaceRegistration.vue';
import { useStudentStore } from '@/stores/student';
</script>