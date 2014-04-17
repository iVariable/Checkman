define(
    [
        'bicycle',
        'tpl!./byEmployee.tpl.html',
        'tpl!./byEmployee-search.tpl.html',
        'application'
    ],
    function (Bicycle, TPL_List, TPL_Search, App) {

        return Bicycle.Core.View.extend({
            template: TPL_List,

            events: {
                'click .j-edit-involvement': 'event_editInvolvement',
                'keyup .j-search': 'event_search',
                'click a[data-toggle=tab]': 'event_setActiveTab'
            },

            event_setActiveTab: function (e) {
                this.activeTabIndex($(e.currentTarget).data('tabIndex'));
            },

            event_editInvolvement: function (e) {
                var employeeId = $(e.currentTarget).data('employeeId');
                var employee = App.collection('employees').get(employeeId);
                if (!employee) {
                    //@TODO - ОШИБКА БЛЕ
                    return false;
                }
                App.layouts.main.modalWindowContainer.show(employee.view('involvement'));

                return false;
            },

            _activeTabIndex: 0,
            activeTabIndex: function (activeTabIndex) {
                if (!_(activeTabIndex).isUndefined()) {
                    this._activeTabIndex = activeTabIndex;
                }
                return this._activeTabIndex;
            },

            event_search: function (e) {
                var searchString = $(e.currentTarget).val().toLowerCase();
                if (searchString == '') {
                    this.$('.a-all').show();
                    this.$('.a-search-pane').hide();
                } else {
                    var employees = App.collection('employees').filter(function (employee) {
                        var index = employee.toString() + " " + employee.involvements().reduce(function (memo, value) {
                            return memo + " " + value.project().toString();
                        }, '');
                        index = index.toLowerCase();
                        return index.indexOf(searchString) !== -1;
                    });
                    this.$('.a-all').hide();
                    this.$('.a-search-pane').html(TPL_Search({employees: employees}));
                    this.$('.a-search-pane').show();
                }
            }
        });

    }
)