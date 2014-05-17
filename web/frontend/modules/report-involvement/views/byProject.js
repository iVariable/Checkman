define(
    [
        'bicycle',
        'tpl!./byProject.tpl.html',
        'application',
        'i18n!./../nls/general'
    ],
    function (Bicycle, TPL_List, App, i18n) {

        return Bicycle.Core.View.extend({
            template: TPL_List,
            _serializeAdditionalData: {
                i18n: i18n
            },

            events: {
                'keyup .j-filter-projects': 'event_filterProjects',
                'click .j-toggle-project-details': 'event_toggleDetails',
                'click .j-edit-project-involvement': 'event_editProjectInvolvement'
            },

            event_toggleDetails: function (e) {
                $(e.currentTarget).toggleClass('b-project__state_full');
                $(e.currentTarget).find('.j-folder-icon').toggleClass('icon-folder-close').toggleClass('icon-folder-open');
            },

            event_filterProjects: function (e) {
                var project = this.$(e.currentTarget).val();
                if (project == '') {
                    this.$('.b-project[data-title]').show();
                } else {
                    this.$('.b-project[data-title]').hide();
                    this.$('.b-project[data-title*="' + project + '"]').show();
                }
            },

            event_editProjectInvolvement: function (e) {
                var involvementId = $(e.currentTarget).data('projectInvolvementId');
                var employeeId = $(e.currentTarget).data('employeeId');
                var employee = App.collection('employees').get(employeeId);
                if(!employee){
                    //@TODO - ОШИБКА БЛЕ
                    return false;
                }
                App.layouts.main.modalWindowContainer.show(employee.view('involvement'));
                //e.cancelBubble();
                return false;
            }
        });

    }
)