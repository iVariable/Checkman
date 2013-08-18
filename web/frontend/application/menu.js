define([],function(){
    return {

        dashboard: {
            title: 'Дэшборд',
            icon: 'icon-dashboard',
            url: '/dashboard/'
        },

        reports: {
            title: "Финансовые отчеты",
            icon: 'icon-bar-chart',
            url: '/reports/',
            children: {
                year: {
                    title: "Годовой сводный отчет"
                },
                deviations: {
                    title: "Отклонения"
                }
            }
        },

        involvement: {
            title: "Занятость персонала",
            icon: "icon-list-alt",
            url: "/involvement/"
        },

        admin: {
            title: "Администрирование",
            icon: "icon-cog",
            url: "/admin/"
        }

    }
});