// Empty JS for your own code to be here
/*
Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
*/
$(document).ready(function(){

    
    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});

function deleteAPI($url)
{
    debugger;
    console.log("asd");
    // $(document).ready(function() {
    //     $('deleteAPI').click(function(event) {
    //         var id = $(this).attr('href');
    //         if (id == 'yes') {
    //             event.preventDefault();

    //         } else {
    //             //redirect
    //         }
    //     });
    // });​
}

function ajax(url, method, data, datatype)
{

    request = $.ajax({
            url: url,
            method: method,
            data: data
        });
    
    request.done(function( msg ) {
    console.log('deleted');
    });
    
    request.fail(function( jqXHR, textStatus ) {
        console.log('failed delete');
    });
}

function deleteItem(id)
{   
    console.log(id);
    document.getElementById('filter-list-'+id).style.display='none';
}