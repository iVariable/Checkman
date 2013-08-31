define([],function(){
    return {

        dashboard: {
            title: 'Дэшборд',
            icon: 'icon-dashboard',
            url: '/'
        },

        reports: {
            title: "Финансовые отчеты",
            icon: 'icon-money',
            url: 'reports',
            children: {
                year: {
                    title: "Годовой сводный отчет",
                    icon: "icon-table",
                    url: "reports/year"
                },
                deviations: {
                    title: "Отклонения",
                    icon: "icon-tasks",
                    url: "reports/deviations"
                }
            }
        },

        involvement: {
            title: "Занятость персонала",
            icon: "icon-list-alt",
            url: "involvement"
        },

        admin: {
            title: "Администрирование",
            icon: "icon-cog",
            url: "admin",
            children: {
                occupations: {
                    title: "Специализация",
                    icon: "icon-user-md",
                    url: "admin/occupations"
                },
                projects: {
                    title: "Проекты",
                    icon: "icon-briefcase",
                    url: "admin/projects"
                },
                employees: {
                    title: "Сотрудники",
                    icon: "icon-user",
                    url: "admin/employees"
                }
            }
        }

    }
});