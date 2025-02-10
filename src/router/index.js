import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { useUserStore } from '@/stores/user';
import { useLecturerStore } from '@/stores/lecturer';
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    {
      path:'/login',
      name:'Login',
      component:()=> import('@/views/LoginView.vue')
    },
    {
      path:'/lecturer/login',
      name:'Lecturer Login',
      component:()=> import('@/views/LecturerLoginView.vue')
    },
    {
      path:'/register',
      name:'Register',
      component:()=> import('@/views/LoginView copy.vue')
    },
    {
      path:'/dashboard',
      name:'admin-dashboard',
      component:()=>import ('@/views/Admin/AdminDashboardView.vue')
    },
    {
      path:'/add/new-student',
      name:'new-student',
      component:()=>import ('@/views/Admin/Learners/NewLearnerView.vue')
    },
    {
      path:'/add/new-lecturer',
      name:'new-lecturer',
      component:()=>import ('@/views/Admin/LecturerRegistrationForm.vue')
    },
    {
      path:'/student/update',
      name:'student-update',
      component:()=>import ('@/views/Admin/Learners/UpdateLearnerView.vue')
    },
    {
      path:'/dashboard/lecturer',
      name:'lecturer-dashboard',
      component:()=>import ('@/views/Admin/Lecturer/DashboardView.vue')
    },
    {
      path:'/unit/:id',
      name:'/unit',
      component:()=>import ('@/views/Admin/Lecturer/UnitView.vue')
    },
    {
      path:'/class/setup',
      name:'class-setup',
      component:()=>import ('@/views/Class/SetUpView.vue')
    },
    // {
    //   path:'/class/attendance',
    //   name:'attendance',
    //   component:()=>import ('@/views/Class/RecognitionView.vue')
    // },
    {
      path:'/class/attendance/:f/:d/:c/:u',
      name:'attendance',
      component:()=>import ('@/views/Class/RecognitionView.vue')
    }
  ],
})
router.beforeEach((to, from, next) => {
  if(sessionStorage.getItem('lecturer')){
    useLecturerStore().setLecturer(JSON.parse(sessionStorage.getItem('lecturer')))
  }


  const token = localStorage.getItem('token');
  const publicPages = ['/login', '/register','/lecturer/login'];
  const authRequired = !publicPages.includes(to.path);
  if(token != null){
    useUserStore().setLoggedIn(true);
  }
  const isAuthenticated = useUserStore().isLoggedIn && token;

  if (authRequired && !isAuthenticated) {
    return next('/login');
  } else if (isAuthenticated && publicPages.includes(to.path)) {
    return next('/dashboard');
  }

  next()
});
export default router
