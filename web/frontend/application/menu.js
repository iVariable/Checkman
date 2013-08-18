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
                    url: "reports/year"
                },
                deviations: {
                    title: "Отклонения",
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
                    url: "admin/occupations"
                }
            }
        }

    }
});