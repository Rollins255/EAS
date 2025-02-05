export const username = ()=>{
    return "kimani"
}

export const faculty = (value)=>{
    switch (value) {
        case 1:
            return 'FACULTY OF SCIENCE AND TECHNOLOGY'
            break;
        case 2:
            return 'FACULTY OF ENGINEERING'
            break;
        case 3:
            return 'School of Nursing and Public Health'
            break;
        case 4:
            return 'Faculty of Education and Resources Development'
            break;
        case 5:
            return 'Faculty of Business Studies'
            break;
        case 6:
            return 'Faculty of Agriculture and Environmental Studies'
            break;
        default:
            break;
    }
}

export const department = (f,d)=>{
    if(f == 1){
        switch (d) {
            case 1:
                return "Biological Sciences"
                break;
            case 2:
                return  "Physical Sciences"
                break;
            case 3:
                return "Computer Science"
                break;
            default:
                break;
        }
    }else if(f == 2){
        switch (d) {
            case 1:
                return "Electrical engineering"
                break;
        
            default:
                break;
        }
    }else if(f == 3){
        switch (d) {
            case 1:
                return 'Nursing'
                break;
        
            default:
                break;
        }
    }else if(f == 4){
        switch (d) {
            case 1:
                return 'Animal sciences'
                break;
            case 2:
                return 'Plant sciences'
                break;
            case 3:
                return 'Food technology'
                break;
            case 4:
                return 'Agricultural Economics, Agribusiness Management & Agricultural Education'
                break;
        
            default:
                break;
        }
    }else if(f == 5){
        switch (d) {
            case 1:
                return 'Business Adminitration'
                break;
            case 2:
                return 'Management science'
        
            default:
                break;
        }
    }
}