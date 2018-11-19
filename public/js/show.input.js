$("div#syspdv").hide();
$("div#acsn").hide();
$("div#ecletica").hide();

$("select[name=software]").on("click", function() {
    var valor = $("option[value=1]:checked").val();

    if(valor == "syspdv"){
        $("div#syspdv").show();
        $("input[name=venc]").prop('required',true);
    } else if(valor == "Imperecível"){
        $("div#syspdv").hide();
        $("input[name=venc]").val('');
        $("input[name=venc]").prop('required',false);
    }
})
