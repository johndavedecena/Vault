$(document).ready(function(){
    $('#employee_search').selectize({
        valueField: 'employee_number',
        labelField: 'employee_number',
        searchField: ['first_name','last_name','employee_number'],
        maxOptions: 10,
        maxItems: 1,
        create: false,
        render: {
            option: function(item, escape) {
                return '<div> ['+escape(item.employee_number)+'] - '+escape(item.first_name)+" "+escape(item.last_name)+' ('+ escape(item.status)+')</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: root+'/api/employees',
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.data);
                }
            });
        }
    });
});