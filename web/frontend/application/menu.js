define([
    "i18n!./nls/menu"
], function (i18n) {
    return {

        dashboard: {
            title: i18n.dashboard,
            icon: 'icon-dashboard',
            url: '/'
        },

        involvement: {
            title: i18n.involvement.title,
            icon: "icon-list-alt",
            url: "involvement",
            children: {
                project: {
                    title: i18n.involvement.perProject,
                    icon: "icon-list-alt",
                    url: "involvement/by-project"
                },
                employee: {
                    title: i18n.involvement.perSpeciality,
                    icon: "icon-list-alt",
                    url: "involvement/by-employee"
                }
            }
        },

        reports: {
            title: i18n.reports.title,
            icon: 'icon-money',
            url: 'reports',
            children: {
                year: {
                    title: i18n.reports.byYear,
                    icon: "icon-table",
                    url: "reports/year"
                },
                project: {
                    title: i18n.reports.byProject,
                    icon: "icon-folder-close",
                    url: "reports/projects"
                },
                fot: {
                    title: i18n.reports.wage,
                    icon: "icon-th",
                    url: "reports/fot"
                },
                regional: {
                    title: i18n.reports.regional,
                    icon: "icon-bar-chart",
                    url: "reports/regional"
                },
                deviations: {
                    title: i18n.reports.deviations,
                    icon: "icon-tasks",
                    url: "reports/deviations"
                }
            }
        },

        admin: {
            title: i18n.admin.title,
            icon: "icon-cog",
            url: "admin",
            children: {
                employees: {
                    title: i18n.admin.employee,
                    icon: "icon-user",
                    url: "admin/employees"
                },
                projects: {
                    title: i18n.admin.projects,
                    icon: "icon-briefcase",
                    url: "admin/projects"
                },
                occupations: {
                    title: i18n.admin.occupation,
                    icon: "icon-user-md",
                    url: "admin/occupations"
                },
                regions: {
                    title: i18n.admin.regions,
                    icon: "icon-map-marker",
                    url: "admin/regions"
                },
                spendingstype: {
                    title: i18n.admin.spendingTypes,
                    icon: "icon-money",
                    url: "admin/spendingstype"
                }
            }
        }

    }
});