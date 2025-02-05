import { defineStore } from "pinia";

export const useUserStore = defineStore('userStore',{
    state:()=>({
        isLoggedIn:false
    }),
    actions: {
        setLoggedIn(value){
            this.isLoggedIn = value
        }
    }
})