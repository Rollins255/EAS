import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { useUserStore } from '@/stores/user';
import { useLecturerStore } from '@/stores/lecturer';
// import DefaultView from '@/views/DefaultView.vue';
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Default',
      component: ()=> import('../views/DefaultView.vue'),
    },
    {
      path: '/home',
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
      path:'/student/login',
      name:'Student Login',
      component:()=> import('@/views/StudentLoginView.vue')
    },
    {
      path:'/register',
      name:'Register',
      component:()=> import('@/views/LoginView copy.vue')
    },
    {
      path:'/dashboard',
      name:'admin-dashboard',
      component:()=>import ('@/views/Admin/Admin/AdminDashboardView.vue')
    },
    {
      path:'/add/new-student',
      name:'new-student',
      component:()=>import ('@/views/Admin/Admin/Learners/NewLearnerView.vue')
    },
    {
      path:'/lecturers',
      name:'lecturers-list',
      component:()=>import('@/views/Admin/Admin/Lecturers/LecturersView.vue')
    },
    {
      path:'/lecturer/:staffNo',
      name:'lecturer-unit-view',
      component:()=>import ('@/views/Admin/Admin/Lecturers/LecturerUnitView.vue')
    },
    {
      path:'/add/new-lecturer',
      name:'new-lecturer',
      component:()=>import ('@/views/Admin/Admin/LecturerRegistrationForm.vue')
    },
    {
      path:'/student/update',
      name:'student-update',
      component:()=>import ('@/views/Admin/Admin/Learners/UpdateLearnerView.vue')
    },
    {
      path:'/dashboard/lecturer',
      name:'lecturer-dashboard',
      component:()=>import ('@/views/Admin/Lecturer/DashboardView.vue')
    },
    {
      path:'/unit/:id',
      name:'unit-view',
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
    },
    {
      path:'/student/dashboard',
      name:'student-dashboard',
      component:()=>import ('@/views/Student/DashboardView.vue')
    }
  ],
})
router.beforeEach((to, from, next) => {
  let user;
  if(sessionStorage.getItem('lecturer')){
    user = "lecturer"
    useUserStore().setUserType = "lecturer"
    useLecturerStore().setLecturer(JSON.parse(sessionStorage.getItem('lecturer')))
  }
  if(sessionStorage.getItem('student')){
    user = "student"
    useUserStore().setUserType = "student"
    useUserStore().setUser(JSON.parse(sessionStorage.getItem('student')))
  }


  const token = sessionStorage.getItem('token');
  const publicPages = [
            '/',
            '/login',
            '/register',
            '/lecturer/login',
            '/student/login',
        ];

  const studentPages = [
    '/student/dashboard',
    '/student/login'
  ]
  const lecturerPages = [
    'lecturer-dashboard',
    'unit-view',
    'class-setup',
    'attendance'
  ]
  const authRequired = !publicPages.includes(to.path);
  if(token != null){
    useUserStore().setLoggedIn(true);
  }
  const isAuthenticated = useUserStore().isLoggedIn && token;

  if (authRequired && !isAuthenticated) {
    return next('/');
  } else if(isAuthenticated){
    if(publicPages.includes(to.path)){
      if(user == "lecturer"){
        return next("/dashboard/lecturer")
      }else if(user == "student"){
        return next("/student/dashboard")
      }else{
        return next('/dashboard');
      }
    }else{
      // checks if the user is actully accessing own routes
      if(user == "lecturer"){
        if(!lecturerPages.includes(to.name)){
          return next("/dashboard/lecturer")
        }else{
            return next()
        }
      }else if(user == "student"){
        if(!studentPages.includes(to.path)){
          return next("/student/dashboard")
        }else{
            return next()
        }
      }
    }

  }

  next()
});
export default router
