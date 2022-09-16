<style>
    #search {
        border: 1px solid black;
        width: 40%;
        padding: 5px 15px 5px 15px;
    }

    thead input {
        width: 100%;
    }

    /* .dataTables_filter {
        float: left;
    } */

    #searchTable thead th:nth-last-child(1) input {
        visibility: hidden;
    }

    #searchTable #dist input {
        visibility: hidden;
    }

    #searchTable #view input {
        visibility: hidden;
    }
    #searchTable #password input {
        visibility: hidden;
    }
    
    #searchTable #print input {
        visibility: hidden;
    }
    #searchTable #emercontact input {
        visibility: visible;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
<script>
    //}
    $(document).ready(function() {

        //console.log($('#val-range').length);
        if ($('#val-range').length != 0) {
            var val_range = $('#val-range');
            var live_range_val = $("#live_range_val");

            val_range.slider({
                range: true,
                min: 0,
                max: 35,
                step: 1,
                values: [0, 35],
                slide: function(event, ui) {
                    live_range_val.val(ui.values[0] + " - " + ui.values[1]);
                },
                stop: function(event, ui) {
                    table.draw();
                }
            });
            live_range_val.val(val_range.slider("values", 0) + " - " + val_range.slider("values", 1));

            $('#searchTable thead tr')
                .clone(true).addClass('filters').appendTo('#searchTable thead');

            // Datatable
            var table = $('#searchTable').DataTable({
                orderCellsTop: true,
                fixedHeader: false,
                "bFilter": true,
                "bLengthChange": false,
                "bPaginate": false,
                "bInfo": false,
                "bAutoWidth": false,

                initComplete: function() {
                    var api = this.api();

                    // for each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // set header cell to contain input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            // console.log(title);

                            if ($(api.column(colIdx).header()).index() >= 0) {
                                $(cell).html('<input type="text" placeholder="Search ' + title + '"/>');
                            }
                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value + ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0];
                                    //.setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
            var val_range;
            //console.log(val_range);
            if (val_range != null) {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var min = parseFloat(val_range.slider("values", 0));
                        var max = parseFloat(val_range.slider("values", 1));
                        var col = parseFloat(data[5]) || 0; // data[number] = column number
                        if ((isNaN(min) && isNaN(max)) ||
                            (isNaN(min) && col <= max) ||
                            (min <= col && isNaN(max)) ||
                            (min <= col && col <= max) ||
                            (min == 0 && max == 0)) {
                            return true;
                        }
                        return false;
                    }
                );
            }
        } else {
            $('#searchTable thead tr')
                .clone(true).addClass('filters').appendTo('#searchTable thead');

            // Datatable
            table = $('#searchTable').DataTable({
                orderCellsTop: true,
                fixedHeader: false,
                "bFilter": true,
                "bLengthChange": false,
                "bPaginate": false,
                "bInfo": false,
                "bAutoWidth": false,

                initComplete: function() {
                    var api = this.api();

                    // for each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // set header cell to contain input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            // console.log(title);

                            if ($(api.column(colIdx).header()).index() >= 0) {
                                $(cell).html('<input type="text" placeholder="Search ' + title + '"/>');
                            }
                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value + ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0];
                                        //.setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        }
    });

    /*function searchFunction(event) {
        // working version
        var filter, rows, i, j, tdArr;
        filter = event.target.value.toUpperCase();
        rows = document.querySelector("#searchTable tbody").rows;
        for (var i = 0; i < rows.length; i++) {
            var firstCol = rows[i].cells[0].textContent.toUpperCase();
            var secondCol = rows[i].cells[1].textContent.toUpperCase();
            if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            } 
        }


        // console.log(tdArr);
    }
    document.querySelector('#search').addEventListener('keyup', searchFunction, false);*/

    // test multiple columns (working)
    /*
     function searchFunction(event) {
        var input, filter, table, tr, td, i, txtValue;
        filter = event.target.value.toUpperCase();

        rows = document.querySelector("#searchTable tbody").rows;
        for (i = 0; i < rows.length; i++) {
            tds = rows[i].getElementsByTagName("td");
            var matches = false;
            for (j = 0; j < tds.length - 1; j++) {
                if (tds[j]) {
                    txtValue = tds[j].textContent || tds[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        matches = true;
                    }
                }
            }
            if (matches == true) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
    document.querySelector('#search').addEventListener('keyup', searchFunction, false);

    */
</script>