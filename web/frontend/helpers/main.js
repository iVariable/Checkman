define(
    [
        './views/model.show/show',
        './views/model.edit/edit',

        './views/collection.list/list'
    ],
    function(
        View_Model_Show,
        View_Model_Edit,

        View_Collection_List
    ){
        var Helpers = {
            View: {
                Model: {
                    Show: View_Model_Show,
                    Edit: View_Model_Edit
                },
                Collection: {
                    List: View_Collection_List
                }
            }
        };

        return Helpers;
    }
)