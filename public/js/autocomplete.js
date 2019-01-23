$( function() {

    $( "#autocompleteAirline" ).autocomplete({
        minLength: 3,
        source: function( request, response ) {
               $.ajax({
                   url: "/api/searchAirline",
                   type: 'post',
                   dataType: "json",
                   data: {
                       search: request.term
                   },
                   success: function( data ) {
                       response( data.data );
                   }
               });
        },
        select: function (event, ui) {
            $('#autocompleteAirline').val(ui.item.label);
            $('#airlineId').val(ui.item.value);
            return false;
        }
    });


    $( "#autocompleteSourceAirport" ).autocomplete({
        minLength: 3,
        source: function( request, response ) {
            $.ajax({
                url: "/api/searchAirport",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data.data );
                }
            });
        },
        select: function (event, ui) {
            $('#autocompleteSourceAirport').val(ui.item.label);
            $('#sourceAirportId').val(ui.item.value);
            return false;
        }
    });

    $( "#autocompleteDestinationAirport" ).autocomplete({
        minLength: 3,
        source: function( request, response ) {
            $.ajax({
                url: "/api/searchAirport",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data.data );
                }
            });

        },
        select: function (event, ui) {
            $('#autocompleteDestinationAirport').val(ui.item.label);
            $('#destinationAirportId').val(ui.item.value);
            return false;
        }
    });
});