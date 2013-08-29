define(
    [
        './views/model.show/show',

        './views/collection.list/list'
    ],
    function(
        View_Model_Show,

        View_Collection_List
    ){
        var Helpers = {
            View: {
                Model: {
                    Show: View_Model_Show
                },
                Collection: {
                    List: View_Collection_List
                }
            }
        };

        return Helpers;
    }
)