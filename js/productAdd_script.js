$(document).ready(function () {
  $("#productType").change(function () {
      $(this).find("option:selected").each(function () {
          var optionValue = $(this).attr("value");
          if (optionValue) {
            $(".hideObj").not("#" + optionValue).addClass("d-none");
            $(".reqInput").not("." + optionValue).attr("required",false);
            $("."+optionValue).attr("required",true);
            $("#" + optionValue).removeClass("d-none");
          } else {
            $(".hideObj").addClass("d-none");
          }
        });
    }).change();

    var validSKU =false;
    $("#product_form").submit(function(event){
        event.preventDefault();
        var sku = $("#sku").val(); 
        $request = $.ajax({
          url: "getSKU",
          type: "post",
          data: {'skuID':sku},
          success:(function(result){
            console.log(result);
            validSKU = JSON.parse(result)['skuUnique'];
            console.log(validSKU);
            if (validSKU)
              event.currentTarget.submit();
            else{
                alert("This SKU already exists");
            }
          })
        });

        
        
    })
});
