define(
    [
        'bicycle',
        'tpl!./byEmployee.tpl.html',
        'application'
    ],
    function (Bicycle, TPL_List, App) {

        return Bicycle.Core.View.extend({
            template: TPL_List,

            events: {
                'click .j-edit-involvement': 'event_editInvolvement'
            },

            event_editInvolvement: function(e){
                var employeeId = $(e.currentTarget).data('employeeId');
                var employee = App.collection('employees').get(employeeId);
                if(!employee){
                    //@TODO - ОШИБКА БЛЕ
                    return false;
                }
                App.layouts.main.modalWindowContainer.show(employee.view('involvement'));

                return false;
            }
        });

    }
)