import {defineStore} from 'pinia'
export const useStudentStore = defineStore('studentStore',{
    state:()=>({
        student:null
    }),
    actions:{
        setStudent(value){
            this.student = value
        }
    }

})