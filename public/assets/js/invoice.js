var billtype = $("#billtype").val();
// fetch accounts
function findaccounts(name) {
    var accountstype = name;
    $.ajax({
        url: "/fetchaccounts",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            accountstype: accountstype,
        },
        cache: false,
        success: function (result) {
            var accounts = "";
            $.each(result, function (index, value) {
                accounts +=
                    "<option value='" +
                    value.id +
                    "'>" +
                    value.name +
                    "</option>";
            });
            $("#accountid").append(accounts);
        },
    });
}
// fetch accounts
// fetch accounts details
$("#accountid").on("change", function () {
    var accounts = this.value;
    console.log(accounts);
    $.ajax({
        url: "/fetchac-details",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            accounts: accounts,
        },
        cache: false,
        success: function (result) {
            var result = result[0];
            var acdetails = "NAME : " + result.name + "<br>";
            acdetails += "Balance : " + result.balance + "<br>";
            $("#accounter_name").html(acdetails);
        },
    });
});
// fetch accounts details
// fetch product details
$("#productgroup").on("change", function () {
    var Category = this.value;
    $.ajax({
        url: "/fetch-product",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            Category: Category,
        },
        cache: false,
        success: function (result) {
            var products = "";
            $.each(result, function (index, value) {
            products +=
                "<option value=" + value.name + ">" + value.name + "</option>";
            });
            $(".product_name").append(products);
        },
    });
});

function getproduct(id, idx) {
    var product_name = id;
    console.log(product_name);
    $.ajax({
        url: "/fetch-productsdetails",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_name: product_name,
        },
        cache: false,
        success: function (response) {
            var price = $("<div />").append(response).find("#p_price").text();
            $("#price-" + idx).val(price);

            var vat = $("<div />").append(response).find("#p_tax_rate").text();
            $("#vat-" + idx).val(vat);

            var discount = $("<div />")
                .append(response)
                .find("#p_discount_rate")
                .text();
            $("#discount-" + idx).val(discount);

            rowTotal(idx);
            billUpyog();
        },
    });
}

// fetch product details
$("#addproduct").on("click", function () {
    var cvalue = parseInt($("#ganak").val()) + 1;
    var nxt = parseInt(cvalue);
    $("#ganak").val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $("#saman-row div").length;
    var pronamelist = $(".product_name").html();
    //product row
    var data =
        '<tr class="table-active"><td class="td"><select id="products-' +
        cvalue +
        '" name="product_name[]" onchange="getproduct(this.value, ' +
        cvalue +
        ')" class="selectpicker product_name form-control">' +
        pronamelist +
        '</select></td><td class="td"><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' +
        cvalue +
        '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' +
        functionNum +
        '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' +
        cvalue +
        '" value=""  name="alert[]"> </td> <td class="td"><input type="text" class="form-control req prc" name="product_price[]" id="price-' +
        cvalue +
        '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' +
        functionNum +
        '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td class="td"> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' +
        cvalue +
        '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' +
        functionNum +
        '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td class="td"><input name="texttaxa[]" class="text-center form-control" value="0" id="texttaxa-' +
        cvalue +
        '" readonly></td> <td class="td"><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' +
        cvalue +
        '" onkeyup="rowTotal(' +
        functionNum +
        '), billUpyog()" autocomplete="off"></td> <td class="td"><strong><input class=\'form-control ttlText\' id="result-' +
        cvalue +
        '" name="ammount[]" value="0" readonly></strong></td> <td class="td" class="text-center"><button type="button" data-rowid="' +
        cvalue +
        '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' +
        cvalue +
        '" value="0"><input type="hidden" name="disca[]" id="disca-' +
        cvalue +
        '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' +
        cvalue +
        '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' +
        cvalue +
        '" value="0"> <input type="hidden" name="unit[]" id="unit-' +
        cvalue +
        '" value=""> <input type="hidden" name="hsn[]" id="hsn-' +
        cvalue +
        '" value=""> <input type="hidden" name="serial[]" id="serial-' +
        cvalue +
        '" value=""> </tr>';
    //ajax request
    // $('#saman-row').append(data);
    $("tr.last-item-row").before(data);
    row = cvalue;
});

//caculations
var precentCalc = function (total, percentageVal) {
    var pr = (total / 100) * percentageVal;
    return parseFloat(pr);
};
//format
var deciFormat = function (minput) {
    if (!minput) minput = 0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + "-" + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == "") {
        return 0;
    } else {
        return inputValue;
    }
};

//product total
var samanYog = function () {
    var itempriceList = [];
    var idList = [];
    var r = 0;
    $(".ttInput").each(function () {
        var vv = accounting.unformat(
            $(this).val(),
            accounting.settings.number.decimal
        );
        var vid = $(this).attr("id");
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    for (var z = 0; z < idList.length; z++) {
        var x = idList[z];
        if (itempriceList[z] > 0) {
            sum += itempriceList[z];
        }
        var t1 = accounting.unformat(
            $("#taxa-" + x).val(),
            accounting.settings.number.decimal
        );
        var d1 = accounting.unformat(
            $("#disca-" + x).val(),
            accounting.settings.number.decimal
        );
        if (t1 > 0) {
            taxc += t1;
        }
        if (d1 > 0) {
            discs += d1;
        }
    }
    var discsval = accounting.formatNumber(discs);
    var taxcval = accounting.formatNumber(taxc);
    $("#discs").val(discsval);
    $("#taxr").val(taxcval);
    return accounting.unformat(sum, accounting.settings.number.decimal);
};

//actions
var deleteRow = function (num) {
    var totalSelector = $("#subttlform");
    var prodttl = accounting.unformat(
        $("#total-" + num).val(),
        accounting.settings.number.decimal
    );
    var subttl = accounting.unformat(
        totalSelector.val(),
        accounting.settings.number.decimal
    );
    var totalSubVal = subttl - prodttl;
    totalSelector.val(totalSubVal);
    $("#subttlid").html(accounting.formatNumber(totalSubVal));
    var totalBillVal = totalSubVal;
    //final total
    var clean = accounting.formatNumber(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#bigtotal").html(clean);
};

var billUpyog = function () {
    var out = 0;
    var disc_val = accounting.unformat(
        $(".discVal").val(),
        accounting.settings.number.decimal
    );
    if (disc_val) {
        $("#subttlform").val(accounting.formatNumber(samanYog()));
        var disc_rate = $("#discountFormat").val();

        switch (disc_rate) {
            case "%":
                out = precentCalc(
                    accounting.unformat(
                        $("#subttlform").val(),
                        accounting.settings.number.decimal
                    ),
                    disc_val
                );
                break;
            case "b_p":
                out = precentCalc(
                    accounting.unformat(
                        $("#subttlform").val(),
                        accounting.settings.number.decimal
                    ),
                    disc_val
                );
                break;
            case "flat":
                out = accounting.unformat(
                    disc_val,
                    accounting.settings.number.decimal
                );
                break;
            case "bflat":
                out = accounting.unformat(
                    disc_val,
                    accounting.settings.number.decimal
                );
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $("#disc_final").html(accounting.formatNumber(out));
        $("#after_disc").val(accounting.formatNumber(out));
    } else {
        $("#disc_final").html(0);
        $("#after_disc").val(0);
    }
    var totalBillVal = accounting.formatNumber(samanYog() - out);
    $("#mahayog").html(totalBillVal);
    $("#subttlform").val(accounting.formatNumber(samanYog()));
    $("#invoiceyoghtml").val(totalBillVal);
    $("#bigtotal").html(totalBillVal);
};

var o_rowTotal = function (numb) {
    //most res
    var result;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
    if (discountVal == "") {
        $("#discount-" + numb).val(0);
        discountVal = 0;
    }
    var vatVal = formInputGet("#vat", numb);
    if (vatVal == "") {
        $("#vat-" + numb).val(0);
        vatVal = 0;
    }
    var taxo = 0;
    var disco = 0;
    var totalPrice = parseFloat(amountVal).toFixed(2) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();

    //tax after bill

    if (tax_status == "gst") {
        if (disFormat == "%" || disFormat == "flat") {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);

            if (disFormat == "flat") {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == "%") {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        } else {
            //before tax
            if (disFormat == "bflat") {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == "b_p") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);
        }
    } else if (tax_status == "igst") {
        if (disFormat == "%" || disFormat == "flat") {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);
            if (disFormat == "flat") {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == "%") {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        } else {
            //before tax
            if (disFormat == "bflat") {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == "b_p") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == "%" || disFormat == "flat") {
            //tax

            //  totalValue = deciFormat(totalPrice);

            if (disFormat == "flat") {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == "%") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        } else {
            //before tax
            if (disFormat == "bflat") {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == "b_p") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        }
    }
    $("#result-" + numb).val(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).val(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var rowTotal = function (numb) {
    //most res
    var result;
    var page = "";
    var totalValue = 0;
    var amountVal = accounting.unformat(
        $("#amount-" + numb).val(),
        accounting.settings.number.decimal
    );
    var priceVal = accounting.unformat(
        $("#price-" + numb).val(),
        accounting.settings.number.decimal
    );
    var discountVal = accounting.unformat(
        $("#discount-" + numb).val(),
        accounting.settings.number.decimal
    );
    var vatVal = accounting.unformat(
        $("#vat-" + numb).val(),
        accounting.settings.number.decimal
    );
    var taxo = 0;
    var disco = 0;
    var totalPrice = amountVal.toFixed(two_fixed) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == "new_i" && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat(
            $("#alert-" + numb).val(),
            accounting.settings.number.decimal
        );
        if (alertVal <= +amountVal) {
            var aqt = alertVal - amountVal;
            alert("Low Stock! " + accounting.formatNumber(aqt));
        }
    }
    //tax after bill
    if (tax_status == "gst") {
        if (disFormat == "%" || disFormat == "flat") {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == "flat") {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == "%") {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
            //before tax
            if (disFormat == "bflat") {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == "b_p") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else if (tax_status == "igst") {
        if (disFormat == "%" || disFormat == "flat") {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == "flat") {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == "%") {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
            //before tax
            if (disFormat == "bflat") {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == "b_p") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == "%" || disFormat == "flat") {
            if (disFormat == "flat") {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == "%") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
            //before tax
            if (disFormat == "bflat") {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == "b_p") {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    $("#result-" + numb).val(accounting.formatNumber(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).val(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
};
var changeTaxFormat = function (getSelectv) {
    if (getSelectv == "gst") {
        var tformat = $("#taxformat option:selected").data("tformat");
        var trate = $("#taxformat option:selected").data("trate");
        $("#tax_status").val(tformat);
        $("#tax_format").val("gst");
    } else if (getSelectv == "igst") {
        var tformat = $("#taxformat option:selected").data("tformat");
        var trate = $("#taxformat option:selected").data("trate");
        $("#tax_status").val(tformat);
        $("#tax_format").val("igst");
    } else {
        $("#tax_status").val("no");
        $("#tax_format").val("off");
    }
    var discount_handle = $("#discountFormat").val();
    var tax_handle = $("#tax_format").val();
    formatRest(tax_handle, discount_handle, trate);
};

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != "0") {
        $(".disCol").show();
        $("#discount_handle").val("yes");
        $("#discount_format").val(getSelectv);
    } else {
        $("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val("no");
    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, getSelectv);
};

function formatRest(taxFormat, disFormat, trate = "") {
    var amntArray = [];
    var idArray = [];
    $(".amnt").each(function () {
        var v = accounting.unformat(
            $(this).val(),
            accounting.settings.number.decimal
        );
        var id_e = $(this).attr("id");
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    var prcArray = [];
    $(".prc").each(function () {
        var v = accounting.unformat(
            $(this).val(),
            accounting.settings.number.decimal
        );
        prcArray.push(v);
    });
    var vatArray = [];
    $(".vat").each(function () {
        if (trate) {
            var v = accounting.unformat(
                trate,
                accounting.settings.number.decimal
            );
            $(this).val(v);
        } else {
            var v = accounting.unformat(
                $(this).val(),
                accounting.settings.number.decimal
            );
        }
        vatArray.push(v);
    });

    var discountArray = [];
    $(".discount").each(function () {
        var v = accounting.unformat(
            $(this).val(),
            accounting.settings.number.decimal
        );
        discountArray.push(v);
    });

    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];
        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == "") {
            vatVal = 0;
        }
        if (discountVal == "") {
            discountVal = 0;
        }
        if (taxFormat == "gst") {
            if (disFormat == "%" || disFormat == "flat") {
                var Inpercentage = precentCalc(result, vatVal);
                var result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).val(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == "%") {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == "flat") {
                    result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == "b_p") {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == "bflat") {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = precentCalc(result, vatVal);
                result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).val(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));
            }
        } else if (taxFormat == "igst") {
            if (disFormat == "%" || disFormat == "flat") {
                var Inpercentage = precentCalc(result, vatVal);
                var result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).val(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == "%") {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == "flat") {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == "b_p") {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == "bflat") {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = precentCalc(result, vatVal);
                result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).val(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));
            }
        } else {
            if (disFormat == "%" || disFormat == "flat") {
                var result =
                    accounting.unformat(
                        $("#amount-" + x).val(),
                        accounting.settings.number.decimal
                    ) *
                    accounting.unformat(
                        $("#price-" + x).val(),
                        accounting.settings.number.decimal
                    );
                $("#texttaxa-" + x).val("Off");
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == "%") {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == "flat") {
                    var result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == "b_p") {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == "bflat") {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
                $("#texttaxa-" + x).val("Off");
                $("#taxa-" + x).val(0);
                taxr += 0;
            }
        }

        $("#total-" + x).val(accounting.formatNumber(result));
        $("#result-" + x).val(accounting.formatNumber(result));
    }
    var sum = accounting.formatNumber(samanYog());
    $("#subttlid").html(sum);
    $("#taxr").html(accounting.formatNumber(taxr));
    $("#discs").html(accounting.formatNumber(discsr));
    billUpyog();
}

//remove productrow

$("#saman-row").on("click", ".removeProd", function () {
    var pidd = $(this).closest("tr").find(".pdIn").val();
    var pqty = $(this).closest("tr").find(".amnt").val();
    pqty = pidd + "-" + pqty;
    $("<input>")
        .attr({
            type: "hidden",
            id: "restock",
            name: "restock[]",
            value: pqty,
        })
        .appendTo("form");
    $(this).closest("tr").remove();
    $("#d" + $(this).closest("tr").find(".pdIn").attr("id"))
        .closest("tr")
        .remove();
    $(".amnt").each(function (index) {
        rowTotal(index);
        billUpyog();
    });

    return false;
});
$(document).on("click", ".select_pos_item", function (e) {
    var pid = $(this).attr("data-pid");
    var stock = accounting.unformat(
        $(this).attr("data-stock"),
        accounting.settings.number.decimal
    );
    var flag = true;
    var discount = $(this).attr("data-discount");
    var custom_discount = accounting.unformat(
        $("#custom_discount").val(),
        accounting.settings.number.decimal
    );
    if (custom_discount > 0)
        discount = accounting.formatNumber(custom_discount);

    $(".pdIn").each(function () {
        if (pid == $(this).val()) {
            var pi = $(this).attr("id");
            var arr = pi.split("-");
            pi = arr[1];
            $("#discount-" + pi).val(discount);
            var stotal =
                accounting.unformat(
                    $("#amount-" + pi).val(),
                    accounting.settings.number.decimal
                ) + 1;

            if (stotal <= stock) {
                $("#amount-" + pi).val(accounting.formatNumber(stotal));
                $("#search_bar").val("").focus();
            } else {
                $("#stock_alert").modal("toggle");
            }
            rowTotal(pi);
            billUpyog();
            $("#amount-" + pi).focus();
            flag = false;
        }
    });
    var t_r = $(this).attr("data-tax");
    if ($("#taxformat option:selected").attr("data-trate")) {
        var t_r = $("#taxformat option:selected").attr("data-trate");
    }
    if (flag) {
        var ganak = $("#ganak").val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $("#saman-row div").length;
        var data =
            '<tr id="ppid-' +
            cvalue +
            '" class="mb-1"><td colspan="7" ><input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' +
            cvalue +
            '" value="' +
            $(this).attr("data-name") +
            "-" +
            $(this).attr("data-pcode") +
            '"><input type="hidden" id="alert-' +
            cvalue +
            '" value="' +
            $(this).attr("data-stock") +
            '"  name="alert[]"></td></tr><tr><td class="td"><input type="text" inputmode="numeric" class="form-control p-mobile p-width req amnt" name="product_qty[]" id="amount-' +
            cvalue +
            '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' +
            functionNum +
            '), billUpyog()" autocomplete="off" value="1" ></td> <td class="td"><input type="text" class="form-control p-width p-mobile req prc" name="product_price[]"  inputmode="numeric" id="price-' +
            cvalue +
            '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' +
            functionNum +
            '), billUpyog()" autocomplete="off"  value="' +
            $(this).attr("data-price") +
            '"></td><td class="td"> <input type="text" class="form-control p-mobile p-width vat" inputmode="numeric" name="product_tax[]" id="vat-' +
            cvalue +
            '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' +
            functionNum +
            '), billUpyog()" autocomplete="off"  value="' +
            t_r +
            '"></td>  <td class="td"><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" inputmode="numeric" onkeypress="return isNumber(event)" id="discount-' +
            cvalue +
            '" onkeyup="rowTotal(' +
            functionNum +
            '), billUpyog()" autocomplete="off"  value="' +
            discount +
            '" inputmode="numeric"></td> <td class="td"><span class="currenty">' +
            currency +
            "</span> <strong><span class='ttlText' id=\"result-" +
            cvalue +
            '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' +
            cvalue +
            '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' +
            cvalue +
            '" value="0"><input type="hidden" name="disca[]" id="disca-' +
            cvalue +
            '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' +
            cvalue +
            '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' +
            cvalue +
            '" value="' +
            $(this).attr("data-pid") +
            '"> <input type="hidden" name="unit[]" id="unit-' +
            cvalue +
            '" value="' +
            $(this).attr("data-unit") +
            '"> <input type="hidden" name="hsn[]" id="hsn-' +
            cvalue +
            '" value="' +
            $(this).attr("data-pcode") +
            '"> <input type="hidden" name="serial[]" id="serial-' +
            cvalue +
            '" value="' +
            $(this).attr("data-serial") +
            '"></tr>';

        //ajax request
        // $('#saman-row').append(data);
        $("#pos_items").append(data);
        rowTotal(cvalue);
        billUpyog();
        $("#ganak").val(cvalue + 1);
        $("#amount-" + cvalue).focus();
    }
});

$("#saman-pos2").on("click", ".removeItem", function () {
    var pidd = $(this).attr("data-rowid");
    var pqty = accounting.unformat(
        $("#amount-" + pidd).val(),
        accounting.settings.number.decimal
    );
    var old_amnt = $("#amount_old-" + pidd).val();
    if (old_amnt) {
        pqty = pidd + "-" + pqty;
        $("<input>")
            .attr({
                type: "hidden",
                name: "restock[]",
                value: pqty,
            })
            .appendTo("form");
    }
    $("#ppid-" + pidd).remove();
    $(".amnt").each(function (index) {
        rowTotal(index);
    });
    billUpyog();
    return false;
});

$("#saman-row-pos").on("click", ".removeItem", function () {
    var pidd = $(this).closest("tr").find(".pdIn").val();
    var pqty = accounting.unformat(
        $(this).closest("tr").find(".amnt").val(),
        accounting.settings.number.decimal
    );
    var old_amnt = accounting.unformat(
        $(this).closest("tr").find(".old_amnt").val(),
        accounting.settings.number.decimal
    );
    if (old_amnt) {
        pqty = pidd + "-" + pqty;
        $("<input>")
            .attr({
                type: "hidden",
                name: "restock[]",
                value: pqty,
            })
            .appendTo("form");
    }
    $(this).closest("tr").remove();
    $("#d" + $(this).closest("tr").find(".pdIn").attr("id"))
        .closest("tr")
        .remove();
    $("#p" + $(this).closest("tr").find(".pdIn").attr("id")).remove();
    $(".amnt").each(function (index) {
        rowTotal(index);
    });
    billUpyog();

    return false;
});

$(document).on("click", ".quantity-up", function (e) {
    var spinner = $(this);
    var input = spinner
        .closest(".quantity")
        .find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(
        input.val(),
        accounting.settings.number.decimal
    );

    var newVal = oldValue + 1;
    spinner
        .closest(".quantity")
        .find('input[name="product_qty[]"]')
        .val(accounting.formatNumber(newVal));
    spinner
        .closest(".quantity")
        .find('input[name="product_qty[]"]')
        .trigger("change");
    var id_arr = $(input).attr("id");
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});

$(document).on("click", ".quantity-down", function (e) {
    var spinner = $(this);
    var input = spinner
        .closest(".quantity")
        .find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(
        input.val(),
        accounting.settings.number.decimal
    );
    var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
    spinner
        .closest(".quantity")
        .find('input[name="product_qty[]"]')
        .val(accounting.formatNumber(newVal));
    spinner
        .closest(".quantity")
        .find('input[name="product_qty[]"]')
        .trigger("change");
    var id_arr = $(input).attr("id");
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});
