<template>
    <Toast></Toast>
    <nav-bar/>
    <div>
        <h1 class="font-bold text-center md:text-3xl text-xl py-4 font-serif">REGISTER LEARNER</h1>
    </div>
    <div class="md:w-2/3 w-[97%] mx-auto">
        <Stepper v-model:value="tab_value">
            <StepList>
                <Step value="1">REGISTARTION FORM</Step>
                <Step value="2">FACIALS REGISTARTION</Step>
            </StepList>
            <StepPanels>
                <StepPanel v-slot="{ activateCallback }" value="1">
                    <RegistarionForm @value = setValue />
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
import { Stepper,StepList,StepPanels,StepItem,Step,StepPanel,Toast } from 'primevue';
import RegistarionForm from '@/components/RegistarionForm.vue';
import FaceRegistration from '@/components/FaceRegistration.vue';
import { useStudentStore } from '@/stores/student';
import { useToast } from 'primevue/usetoast';
import {ref} from 'vue'
const toast = useToast()
const tab_value  = ref("1")
function setValue(){
    tab_value.value = "2"
    show('success','Registration Done!!','Students details saved,proceed to face registration',5000)
    setTimeout(() => {
        show(
            'info',
            'How to proceed??',
            'Press submit to to finish on facial registartion for the student',
            8000)

    }, 2000);
}

function show(severity,summary,detail,life){
    toast.add({severity:severity,summary:summary,detail:detail,life:life})
}
</script>