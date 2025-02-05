<template>
    <nav-bar/>
    <div class="h-[90vh] w-full">
        <div class="card flex justify-center">
            <Breadcrumb :home="home" :model="items">
                <template #item="{ item,props }">
                    <i @click="navPress('h')" v-if="item.icon" :class="[item.icon]"></i>
                    <p class="cursor-pointer" @click="navPress(item.tag)">{{ item.label }}</p>
                </template>
            </Breadcrumb>
        </div>
        <div class="grid grid-cols-3 gap-3 m-5"  v-if="!departments">
            <div class="bg-blue-200 hover:bg-blue-400 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="facultySelect(faculty)"
                v-for="faculty in faculties"
            >
                <p class="font-bold text-xl ">{{ faculty.name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 m-5" v-if="departments && !courses">
            <div class="bg-cyan-200 hover:bg-cyan-400 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="departmentSelect(department)"
                v-for="department in departments"
            >
                <p class="font-bold text-xl ">{{ department.name }}</p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3 m-5" v-if="courses">
            <div class="bg-green-200 hover:bg-green-400 rounded cursor-pointer h-[30vh] flex items-center justify-center
             text-center"
                @click="courseSelect(course)"
                v-for="course in courses"
            >
                <p class="font-bold text-xl ">{{ course }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
const departments = ref()
const courses = ref()
import { Breadcrumb } from 'primevue'
import router from '@/router';

const home = ref({
    icon: 'pi pi-home'
});
const items = ref([

]);
const faculties = [
    {
        name:'Faculty of science and technology',
        departments : [
            {
                name: 'Department of Computer Science',
                courses: ['Introduction to Programming', 'Data Structures', 'Algorithms']
            },
            {
                name: 'Department of Information Technology',
                courses: ['Network Security', 'Database Management', 'Web Development']
            },
            {
                name: 'Department of Mathematics',
                courses: ['Calculus', 'Linear Algebra', 'Statistics']
            },
            {
                name: 'Department of Physics',
                courses: ['Classical Mechanics', 'Quantum Physics', 'Electromagnetism']
            },
            {
                name: 'Department of Chemistry',
                courses: ['Organic Chemistry', 'Inorganic Chemistry', 'Physical Chemistry']
            },
            {
                name: 'Department of Biology',
                courses: ['Genetics', 'Microbiology', 'Biochemistry']
            }
            
        ]
    },
    {
        name:'Faculty of engineering',
        departments:[
            {
                name: 'Department of Civil Engineering',
                courses: ['Structural Analysis', 'Geotechnical Engineering', 'Transportation Engineering']
            },
            {
                name: 'Department of Electrical Engineering',
                courses: ['Circuit Analysis', 'Electromagnetic Fields', 'Power Systems']
            },
            {
                name: 'Department of Mechanical Engineering',
                courses: ['Thermodynamics', 'Fluid Mechanics', 'Heat Transfer']
            },
            {
                name: 'Department of Chemical Engineering',
                courses: ['Chemical Reaction Engineering', 'Process Control', 'Thermodynamics']
            },
            {
                name: 'Department of Petroleum Engineering',
                courses: ['Reservoir Engineering', 'Drilling Engineering', 'Petroleum Production']
            }
            
        ]
    },
    {
        name:'School of Nursing and Public Health',
        departments: [
            {
                name: 'Department of Nursing',
                courses: ['Fundamentals of Nursing', 'Medical-Surgical Nursing', 'Pediatric Nursing']
            },
            {
                name: 'Department of Public Health',
                courses: ['Epidemiology', 'Biostatistics', 'Health Policy']
            }
        ]
    },
    {
        name:'Faculty of Education and Resources Development',
        departments: [
            {
                name: 'Department of Educational Technology',
                courses: ['Instructional Design', 'Educational Media', 'E-Learning']
            },
            {
                name: 'Department of Educational Foundations',
                courses: ['Philosophy of Education', 'Sociology of Education', 'Comparative Education']
            },
            {
                name: 'Department of Curriculum and Instruction',
                courses: ['Curriculum Development', 'Instructional Strategies', 'Assessment and Evaluation']
            },
            {
                name: 'Department of Educational Administration',
                courses: ['School Management', 'Educational Leadership', 'Policy Studies']
            },
            {
                name: 'Department of Educational Psychology',
                courses: ['Learning Theories', 'Child Development', 'Motivation in Education']
            },
            {
                name: 'Department of Special Education',
                courses: ['Inclusive Education', 'Assistive Technology', 'Behavioral Disorders']
            }
        ]
    },
    {
        name:'Faculty of Business Studies',
        departments: [
            {
                name: 'Department of Accounting',
                courses: ['Financial Accounting', 'Managerial Accounting', 'Auditing']
            },
            {
                name: 'Department of Business Administration',
                courses: ['Principles of Management', 'Organizational Behavior', 'Business Ethics']
            },
            {
                name: 'Department of Marketing',
                courses: ['Marketing Management', 'Consumer Behavior', 'Digital Marketing']
            },
            {
                name: 'Department of Finance',
                courses: ['Corporate Finance', 'Investment Analysis', 'Financial Markets']
            },
            {
                name: 'Department of Human Resource Management',
                courses: ['Human Resource Planning', 'Employee Relations', 'Compensation Management']
            }
        ]
    },
    {
        name:'Faculty of Agriculture and Environmental Studies',
        departments: [
            {
                name: 'Department of Agricultural Economics',
                courses: ['Agricultural Marketing', 'Farm Management', 'Agricultural Policy']
            },
            {
                name: 'Department of Agricultural Science',
                courses: ['Crop Production', 'Animal Husbandry', 'Soil Fertility']
            },
            {
                name: 'Department of Environmental Science',
                courses: ['Environmental Impact Assessment', 'Sustainable Development', 'Climate Change']
            },
            {
                name: 'Department of Soil Science',
                courses: ['Soil Chemistry', 'Soil Physics', 'Soil Microbiology']
            },
            {
                name: 'Department of Animal Science',
                courses: ['Animal Nutrition', 'Animal Breeding', 'Veterinary Science']
            },
            {
                name: 'Department of Crop Science',
                courses: ['Plant Pathology', 'Crop Physiology', 'Weed Science']
            }
        ]
    }
]

function facultySelect(value){
    faculties.forEach(el=>{
        if(value.name == el.name){
            items.value[0] = {label:el.name,tag:'f'}
            items.value[1] = {label:null}
            items.value.pop()
            departments.value = el.departments
        }
    })
}

function departmentSelect(value){
    departments.value.forEach(el=>{
        if(value.name == el.name){
            items.value[1] = {label:el.name,tag:'d'}
            courses.value = el.courses
        }
    })
}

function courseSelect(value){
    // pass the course code
    router.replace('/class/attendance/'+value)
}

function navPress(value){
    if(value == 'f'){        
        courses.value = null
        if(items.value.length > 1){
            items.value.pop()
        }
       
    }else if(value == 'd'){

    }else if(value == 'h'){
        courses.value = null
        departments.value = null
        items.value = []
    }
    
}

</script>