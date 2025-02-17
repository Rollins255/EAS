import { defineStore } from "pinia";

export const useLecturerStore = defineStore('lecturerStore',{
    state:()=>({
        lecturer:null,
        lecturersData:null
    }),
    actions:{
        setLecturer(value){
            this.lecturer = value
        },
        setLecturersData(value){
            this.lecturersData = value
        }
    }

})