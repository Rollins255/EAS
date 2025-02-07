/**
 * GENERAL LAYOUT OF THE FACULTIES
 * (id => value)
 * 1 => School of Nursing and Public Health
 *      1 => Department of Nursing
 *          1 => Bachelor of Science in Nursing (Upgrading)
 *          2 => Bachelor of Science in Nursing (Basic)
 *      2 => Department of Public Health
 *          1 => Bachelor of Public Health (Pre-Service)
 *          2 => Bachelor of Public Health (Upgrading)
 * 2 => Faculty of Science and Technology
 *      1 => Department of Computer Science
 *          1 => Bachelor of Science in Applied Computer Science
 *          2 => Bachelor of Science in Computer Science
 *          3 => Bachelor of Science in Business Information Technology
 *      2 => Department of Mathematics and Statistics
 *          1 => Bachelor of Science in Actuarial Science
 *          2 => Bachelor of Science in Applied Statistics
 *          3 => Bachelor of Science in Mathematics
 *      3 => Department of Biological Sciences
 *          1 => Bachelor of Science in Biology
 *          2 => Bachelor of Science in Microbiology and Biotechnology
 *          3 => Bachelor of Science in Biomedical Science and Technology
 *          4 => Bachelor of Science in Fisheries & Aquaculture
 *      4 => Department of Physical Sciences
 *          1 => Bachelor of Science in Chemistry
 *          2 => Bachelor of Science in Industrial Chemistry
 *          3 => Bachelor of Science in Physics
 *          4 => Bachelor of Science in Mining Physics (Geophysics)
 *          5 => Bachelor of Science in Engineering Physics
 *      5 => Department of Biochemistry
 *          1 => Bachelor of Science in Biochemistry
 * 3 => Faculty of Engineering
 *      1 => Department of Electrical and Electronics Engineering
 *          1 => Bachelor of Science in Electrical and Electronics Engineering
 *      2 => Department of Aeronautical Engineering
 *          1 => Bachelor of Science in Aeronautical Engineering
 * 4 => Faculty of Business Studies
 *      1 => Department of Commerce
 *          1 => Bachelor of Commerce
 *      2 => Department of Entrepreneurship and Enterprise Development
 *          1 => Bachelor of Entrepreneurship and Enterprise Management
 *      3 => Department of Procurement and Logistics Management
 *          1 => Bachelor of Procurement and Logistics Management
 *      4 => Department of Cooperatives Management
 *          1 => Bachelor of Cooperatives Management
 *      5 => Department of Accounting and Finance
 *          1 => Bachelor of Science in Accounting
 *          2 => Bachelor of Science in Finance
 *      6 => Department of Human Resource Management
 *          1 => Bachelor of Science in Human Resource Management
 * 5 => Faculty of Education and Resources Development
 *      1 => Department of Primary Education
 *          1 => Bachelor of Education (Primary)
 *      2 => Department of Arts Education
 *          1 => Bachelor of Education (Arts)
 *      3 => Department of Science Education
 *          1 => Bachelor of Education (Science)
 *      4 => Department of Early Childhood Development Education (ECDE)
 *          1 => Bachelor of Education (Early Childhood Development)
 * 6 => Faculty of Agriculture
 *      1 => Department of Agribusiness and Agricultural Economics
 *          1 => Bachelor of Agribusiness Management
 *          2 => Bachelor of Science in Agricultural Economics
 *      2 => Department of Agricultural Extension and Education
 *          1 => Bachelor of Science in Agricultural Education & Extension
 *      3 => Department of Animal Sciences
 *          1 => Bachelor of Science in Animal Science
 *          2 => Bachelor of Science in Animal Products Technology
 *      4 => Department of Crop Sciences
 *          1 => Bachelor of Science in Agriculture
 *          2 => Bachelor of Science in Horticulture
 *          3 => Bachelor of Science in Crop Protection and Management
 *      5 => Department of Food Sciences
 *          1 => Bachelor of Science in Food Science and Technology
 */
export const faculties = [
    // Faculty of Nursing and Public Health
    {
        "id": 1,
        "tag": "f",
        "label": "School of Nursing and Public Health",
        "label_tag": "school-of-nursing-and-public-health",
        "departments": [
            {
                "id": 1,
                "tag": "d",
                "label": "Department of Nursing",
                "label_tag": "department-of-nursing",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Nursing (Upgrading)",
                        "label_tag": "bachelor-of-science-in-nursing-upgrading",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Nursing (Basic)",
                        "label_tag": "bachelor-of-science-in-nursing-basic",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 2,
                "tag": "d",
                "label": "Department of Public Health",
                "label_tag": "department-of-public-health",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Public Health (Pre-Service)",
                        "label_tag": "bachelor-of-public-health-pre-service",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Public Health (Upgrading)",
                        "label_tag": "bachelor-of-public-health-upgrading",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            }
        ]
    },
    // Faculty of Science and Technology
    {
        "id": 2,
        "tag": "f",
        "label": "Faculty of Science and Technology",
        "label_tag": "faculty-of-science-and-technology",
        "departments": [
            {
                "id": 1,
                "tag": "d",
                "label": "Department of Computer Science",
                "label_tag": "department-of-computer-science",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Applied Computer Science",
                        "label_tag": "bachelor-of-science-in-applied-computer-science",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Computer Science",
                        "label_tag": "bachelor-of-science-in-computer-science",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 3,
                        "tag": "c",
                        "label": "Bachelor of Science in Business Information Technology",
                        "label_tag": "bachelor-of-science-in-business-information-technology",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 2,
                "tag": "d",
                "label": "Department of Mathematics and Statistics",
                "label_tag": "department-of-mathematics-and-statistics",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Actuarial Science",
                        "label_tag": "bachelor-of-science-in-actuarial-science",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Applied Statistics",
                        "label_tag": "bachelor-of-science-in-applied-statistics",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 3,
                        "tag": "c",
                        "label": "Bachelor of Science in Mathematics",
                        "label_tag": "bachelor-of-science-in-mathematics",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                ]
            },
            {
                "id": 3,
                "tag": "d",
                "label": "Department of Biological Sciences",
                "label_tag": "department-of-biological-sciences",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Biology",
                        "label_tag": "bachelor-of-science-in-biology",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Microbiology and Biotechnology",
                        "label_tag": "bachelor-of-science-in-microbiology-and-biotechnology",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 3,
                        "tag": "c",
                        "label": "Bachelor of Science in Biomedical Science and Technology",
                        "label_tag": "bachelor-of-science-in-biomedical-science-and-technology",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 4,
                        "tag": "c",
                        "label": "Bachelor of Science in Fisheries & Aquaculture",
                        "label_tag": "bachelor-of-science-in-fisheries-and-aquaculture",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 4,
                "tag": "d",
                "label": "Department of Physical Sciences",
                "label_tag": "department-of-physical-sciences",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Chemistry",
                        "label_tag": "bachelor-of-science-in-chemistry",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Industrial Chemistry",
                        "label_tag": "bachelor-of-science-in-industrial-chemistry",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 3,
                        "tag": "c",
                        "label": "Bachelor of Science in Physics",
                        "label_tag": "bachelor-of-science-in-physics",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 4,
                        "tag": "c",
                        "label": "Bachelor of Science in Mining Physics (Geophysics)",
                        "label_tag": "bachelor-of-science-in-mining-physics-geophysics",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 5,
                        "tag": "c",
                        "label": "Bachelor of Science in Engineering Physics",
                        "label_tag": "bachelor-of-science-in-engineering-physics",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 5,
                "tag": "d",
                "label": "Department of Biochemistry",
                "label_tag": "department-of-biochemistry",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Biochemistry",
                        "label_tag": "bachelor-of-science-in-biochemistry",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            }
        ]
    },
    // Faculty of Engineering
    {
        "label_tag": "faculty-of-engineering",
        "id": 3,
        "tag": "f",
        "label": "Faculty of Engineering",
        "departments": [
            {
                "id": 1,
                "tag": "d",
                "label": "Department of Electrical and Electronics Engineering",
                "label_tag": "department-of-electrical-and-electronics-engineering",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Electrical and Electronics Engineering",
                        "label_tag": "bachelor-of-science-in-electrical-and-electronics-engineering",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 2,
                "tag": "d",
                "label": "Department of Aeronautical Engineering",
                "label_tag": "department-of-aeronautical-engineering",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Aeronautical Engineering",
                        "label_tag": "bachelor-of-science-in-aeronautical-engineering",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            }
        ]
    },
    // Faculty of Business Studies
    {
        "id": 4,
        "tag": "f",
        "label": "Faculty of Business Studies",
        "label_tag": "faculty-of-business-studies",
        "departments": [
            {
                "id": 1,
                "tag": "d",
                "label": "Department of Commerce",
                "label_tag": "department-of-commerce",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Commerce (Specializations: Accounting, Banking & Finance, Cooperative Management, Insurance & Risk Management, Human Resource Management, Marketing, Procurement & Logistics Management)",
                        "label_tag": "bachelor-of-commerce",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 2,
                "tag": "d",
                "label": "Department of Entrepreneurship and Enterprise Development",
                "label_tag": "department-of-entrepreneurship-and-enterprise-development",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Entrepreneurship and Enterprise Management",
                        "label_tag": "bachelor-of-entrepreneurship-and-enterprise-management",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 3,
                "tag": "d",
                "label": "Department of Procurement and Logistics Management",
                "label_tag": "department-of-procurement-and-logistics-management",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Procurement and Logistics Management",
                        "label_tag": "bachelor-of-procurement-and-logistics-management",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 4,
                "tag": "d",
                "label": "Department of Cooperatives Management",
                "label_tag": "department-of-cooperatives-management",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Cooperatives Management",
                        "label_tag": "bachelor-of-cooperatives-management",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 5,
                "tag": "d",
                "label": "Department of Accounting and Finance",
                "label_tag": "department-of-accounting-and-finance",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Accounting",
                        "label_tag": "bachelor-of-science-in-accounting",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Finance",
                        "label_tag": "bachelor-of-science-in-finance",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 6,
                "tag": "d",
                "label": "Department of Human Resource Management",
                "label_tag": "department-of-human-resource-management",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Human Resource Management",
                        "label_tag": "bachelor-of-science-in-human-resource-management",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            }
        ]
    },
    //Faculty of Education and Resources Development
    {
        "id": 5,
        "tag": "f",
        "label": "Faculty of Education and Resources Development",
        "label_tag": "faculty-of-education-and-resources-development",
        "departments": [
            {
                "id": 1,
                "tag": "d",
                "label": "Department of Primary Education",
                "label_tag": "department-of-primary-education",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Education (Primary)",
                        "label_tag": "bachelor-of-education-primary",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 2,
                "tag": "d",
                "label": "Department of Arts Education",
                "label_tag": "department-of-arts-education",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Education (Arts)",
                        "label_tag": "bachelor-of-education-arts",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 3,
                "tag": "d",
                "label": "Department of Science Education",
                "label_tag": "department-of-science-education",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Education (Science)",
                        "label_tag": "bachelor-of-education-science",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 4,
                "tag": "d",
                "label": "Department of Early Childhood Development Education (ECDE)",
                "label_tag": "department-of-early-childhood-development-education",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Education (Early Childhood Development)",
                        "label_tag": "bachelor-of-education-early-childhood-development",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            }
        ]
    },
    // Faculty of Agriculture
    {
        "id": 6,
        "tag": "f",
        "label": "Faculty of Agriculture",
        "label_tag": "faculty-of-agriculture",
        "departments": [
            {
                "id": 1,
                "tag": "d",
                "label": "Department of Agribusiness and Agricultural Economics",
                "label_tag": "department-of-agribusiness-and-agricultural-economics",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Agribusiness Management",
                        "label_tag": "bachelor-of-agribusiness-management",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Agricultural Economics",
                        "label_tag": "bachelor-of-science-in-agricultural-economics",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 2,
                "tag": "d",
                "label": "Department of Agricultural Extension and Education",
                "label_tag": "department-of-agricultural-extension-and-education",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Agricultural Education & Extension",
                        "label_tag": "bachelor-of-science-in-agricultural-education-extension",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 3,
                "tag": "d",
                "label": "Department of Animal Sciences",
                "label_tag": "department-of-animal-sciences",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Animal Science",
                        "label_tag": "bachelor-of-science-in-animal-science",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Animal Products Technology",
                        "label_tag": "bachelor-of-science-in-animal-products-technology",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 4,
                "tag": "d",
                "label": "Department of Crop Sciences",
                "label_tag": "department-of-crop-sciences",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Agriculture",
                        "label_tag": "bachelor-of-science-in-agriculture",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 2,
                        "tag": "c",
                        "label": "Bachelor of Science in Horticulture",
                        "label_tag": "bachelor-of-science-in-horticulture",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    },
                    {
                        "id": 3,
                        "tag": "c",
                        "label": "Bachelor of Science in Crop Protection and Management",
                        "label_tag": "bachelor-of-science-in-crop-protection-and-management",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            },
            {
                "id": 5,
                "tag": "d",
                "label": "Department of Food Sciences",
                "label_tag": "department-of-food-sciences",
                "courses": [
                    {
                        "id": 1,
                        "tag": "c",
                        "label": "Bachelor of Science in Food Science and Technology",
                        "label_tag": "bachelor-of-science-in-food-science-and-technology",
                        "units": [
                            { "id": 1, "name": "Course 1", "code": "c1" },
                            { "id": 2, "name": "Course 2", "code": "c2" },
                            { "id": 3, "name": "Course 3", "code": "c3" },
                            { "id": 4, "name": "Course 4", "code": "c4" }
                        ]
                    }
                ]
            }
        ]
    }
]



export const faculty = (value) => {
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

export const department = (f, d) => {
    if (f == 1) {
        switch (d) {
            case 1:
                return "Biological Sciences"
                break;
            case 2:
                return "Physical Sciences"
                break;
            case 3:
                return "Computer Science"
                break;
            default:
                break;
        }
    } else if (f == 2) {
        switch (d) {
            case 1:
                return "Electrical engineering"
                break;

            default:
                break;
        }
    } else if (f == 3) {
        switch (d) {
            case 1:
                return 'Nursing'
                break;

            default:
                break;
        }
    } else if (f == 4) {
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
    } else if (f == 5) {
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

export const username = ()=>{
    return "kimani"
}

export const getFaculty = (value)=>{
    let f_name
    faculties.forEach(element => {
        if(element.label_tag == value){
            f_name =  element.label
        }
    });
    return f_name;
}

export const getDepartment = (f,d)=>{
    let d_name
    faculties.forEach(element => {
        if(element.label_tag == f){
            element.departments.forEach(el=>{
                if(el.label_tag == d){
                    d_name = el.label
                }
            })
        }
    });
    return d_name;
}

export const getCourse = (f,d,c)=>{
    
    let c_name
    faculties.forEach(element => {
        if(element.label_tag == f){
            element.departments.forEach(el=>{
                if(el.label_tag == d){
                    el.courses.forEach(course=>{
                        if(course.label_tag == c){
                            // course.units.forEach(unit=>{
                                // if(unit.code == u){
                                    c_name = course.label
                                // }
                            // })
                        }
                    })
                }
            })
        }
    });
    return c_name;
}

export const getUnitName = (f,d,c,u)=>{
    let u_name
    faculties.forEach(element => {
        if(element.label_tag == f){
            element.departments.forEach(el=>{
                if(el.label_tag == d){
                    el.courses.forEach(course=>{
                        if(course.label_tag == c){
                            course.units.forEach(unit=>{
                                if(unit.code == u){
                                    u_name = unit.name
                                }
                            })
                        }
                    })
                }
            })
        }
    });
    return u_name;
}

export const getFaculties = ()=>{
    let f = [];
    faculties.forEach(element=>{
        f.push(element.label)
    })
    return f;
}

export const getDepartments = (f,d)=>{
    let departments = []
    faculties.forEach(element => {
        if(element.label == f){
            element.departments.forEach(el=>{
                departments.push(el.label)
            })
        }
    });
    return departments;
}

export const getCourses = (f,d)=>{
    let courses = []
    faculties.forEach(element => {
        if(element.label == f){
            element.departments.forEach(el=>{
                if(el.label == d){
                    el.courses.forEach(c=>{
                        courses.push(c.label)
                    })
                }
            })
        }
    });
    return courses;
}

export const getFacultyId = (value)=>{
    let f 
    faculties.forEach(element=>{
        if(element.label == value){
            f = element.id
        }
    })
    return f;
}

export const getDepartmentId = (f,d)=>{
    let department
    faculties.forEach(element => {
        if(element.label == f){
            element.departments.forEach(el=>{
                if(el.label == d){
                    department = el.id
                }
            })
        }
    });
    return department;
}

export const getCourseId = (f,d,c)=>{
    let course
    faculties.forEach(element => {
        if(element.label == f){
            element.departments.forEach(el=>{
                if(el.label == d){
                    el.courses.forEach(cs=>{
                        if(cs.label == c){
                            course = cs.id
                        }
                    })
                }
            })
        }
    });
    return course;
}