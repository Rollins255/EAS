import { defineStore } from "pinia";

export const useLecturerStore = defineStore('lecturerStore',{
    state:()=>({
        lecturer:null
    }),
    actions:{
        setLecturer(value){
            this.lecturer = value
        }
    }

})