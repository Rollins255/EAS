import { defineStore } from "pinia";

export const useUserStore = defineStore('userStore',{
    state:()=>({
        user_type:null,
        user:null,
        isLoggedIn:false
    }),
    actions: {
        setLoggedIn(value){
            this.isLoggedIn = value
        },
        setUser(value){
            this.user = value
        },
        setUserType(value){
            this.user_type = value
        }
    }
})