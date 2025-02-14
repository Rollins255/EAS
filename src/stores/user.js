import { defineStore } from "pinia";

export const useUserStore = defineStore('userStore',{
    state:()=>({
        user:null,
        isLoggedIn:false
    }),
    actions: {
        setLoggedIn(value){
            this.isLoggedIn = value
        },
        setUser(value){
            this.user = value
        }
    }
})