import {defineStore} from 'pinia'

export const useClassListStore = defineStore('classList',{
    state:()=>({
        classList:null
    }),
    actions:{
        setClassList(list){
            this.classList = list
        }
    }

})