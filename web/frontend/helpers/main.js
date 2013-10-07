define(
    [
        './views/model.show/show',
        './views/model.edit/edit',
        './views/model.new/new',

        './views/collection.list/list',

        './mixins/formatters'
    ],
    function(
        View_Model_Show,
        View_Model_Edit,
        View_Model_New,

        View_Collection_List
    ){
        var Helpers = {
            View: {
                Model: {
                    Show: View_Model_Show,
                    Edit: View_Model_Edit,
                    New: View_Model_New
                },
                Collection: {
                    List: View_Collection_List
                }
            }
        };

        return Helpers;
    }
)