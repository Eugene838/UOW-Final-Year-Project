$(document).ready(function() {
    $(document).on('click', '#checkAll', function() {
        $(".itemRow").prop("checked", this.checked);
    });
    $(document).on('click', '.itemRow', function() {
        if ($('.itemRow:checked').length == $('.itemRow').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });
    var count = $(".itemRow").length;
    $(document).on('click', '#addRows', function() {
        count++;
        var htmlRows = '';
        htmlRows += '<thead>'
        htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
        htmlRows += '<td><input type="text" name="productCode[]" id="productCode_' + count + '" class="form-control" onkeyup="GetDetail(this.value,' + count + ')" autocomplete="off"></td>';
        htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count + '" class="form-control" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" autocomplete="off"></td>';
        htmlRows += '</tr>';
        htmlRows += '</thead>';
        $('#invoiceItem').append(htmlRows);
    });
    $(document).on('click', '#removeRows', function() {
        $(".itemRow:checked").each(function() {
            $(this).closest('tr').remove();
        });
        $('#checkAll').prop('checked', false);
        calculateTotal();
    });
    $(document).on('blur', "[id^=quantity_]", function() {
        calculateTotal();
    });
    $(document).on('blur', "[id^=price_]", function() {
        calculateTotal();
    });
    $(document).on('blur', "[id^=price1_1]", function() {
        calculateTotal();
    });
    $(document).on('blur', "#service_type", function() {
        calculateTotal();
    });
    $(document).on('blur', "#taxRate", function() {
        calculateTotal();
    });
    $(document).on('blur', "#amountPaid", function() {
        var amountPaid = $(this).val();
        var totalAftertax = $('#totalAftertax').val();
        if (amountPaid && totalAftertax) {
            totalAftertax = totalAftertax - amountPaid;
            $('#amountDue').val(totalAftertax);
        } else {
            $('#amountDue').val(totalAftertax);
        }
    });
    $(document).on('click', '.deleteInvoice', function() {
        var id = $(this).attr("id");
        if (confirm("Are you sure you want to remove this?")) {
            $.ajax({
                url: "action.php",
                method: "POST",
                dataType: "json",
                data: {
                    id: id,
                    action: 'delete_invoice'
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#' + id).closest("tr").remove();
                    }
                }
            });
        } else {
            return false;
        }
    });
});

function calculateTotal() {
    var totalAmount = 0;
    var totalAmount1 = 0;
    var price1 = 0;
    $("[id^='price_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("price_", '');
        var price = $('#price_' + id).val();
        var quantity = $('#quantity_' + id).val();
        price1 = $('#price1_1').val();
        if (!quantity) {
            quantity = 1;
        }
        var total = price * quantity;
        $('#total_' + id).val(parseFloat(total));
        totalAmount = total + parseFloat(price1);
        totalAmount1 += totalAmount;

    });

    $('#subTotal').val(parseFloat(totalAmount1));
    var taxRate = $("#taxRate").val();
    var subTotal = $('#subTotal').val();
    if (subTotal) {
        var taxAmount = subTotal * taxRate / 100;
        $('#taxAmount').val(taxAmount);
        subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
        $('#totalAftertax').val(subTotal);
        var amountPaid = $('#amountPaid').val();
        var totalAftertax = $('#totalAftertax').val();
        if (amountPaid && totalAftertax) {
            totalAftertax = totalAftertax - amountPaid;
            $('#amountDue').val(totalAftertax);
        } else {
            $('#amountDue').val(subTotal);
        }
    }
}

function GetDetail(str, value) {
    if (str.length == 0) {
        document.getElementById("productName_" + value + "").value = "";
        document.getElementById("price_" + value + "").value = "";
        return;
    } else {

        // Creates a new XMLHttpRequest object
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            // Defines a function to be called when
            // the readyState property changes
            if (this.readyState == 4 &&
                this.status == 200) {

                // Typical action to be performed
                // when the document is ready
                var myObj = JSON.parse(this.responseText);

                // Returns the response data as a
                // string and store this array in
                // a variable assign the value 
                // received to first name input field

                document.getElementById("productName_" + value + "").value = myObj[0];

                // Assign the value received to
                // last name input field
                document.getElementById(
                    "price_" + value + "").value = myObj[1];
            }
        };

        // xhttp.open("GET", "filename", true);
        xmlhttp.open("GET", "invoice_automate.php?product_id=" + str, true);

        // Sends the request to the server
        xmlhttp.send();
    }
}
$('#service_type').change(function(e) {
    var element = $(this).find('option:selected');
    var desc = element.attr("value");
    $('#price1_1').val(desc);
});