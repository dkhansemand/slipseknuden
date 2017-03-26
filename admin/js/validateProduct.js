var validateProduct = {
        productname: (inputField) => {
            "use strict";

            var nameVal = $(inputField).val(),
                nameRegex = /\w+$/;
            
            if(nameVal.length !== 0 && nameRegex.test(nameVal)){
                $(inputField).parent('div')
                                .removeClass("has-error")
                                .addClass("has-success");
                $(inputField).next()
                                .removeClass("glyphicon-remove")
                                .addClass("glyphicon-ok")
                                .next('.errMsg').html('');
                return true;
            }else{
                $(inputField).parent('div')
                                .removeClass("has-success")
                                .addClass("has-error");
                
                $(inputField).next()
                                .removeClass("glyphicon-ok")
                                .addClass("glyphicon-remove")
                                .next('.errMsg').html('Produktnavn skal udfyldes, og må ikke indholde specialtegn');
                return false;
            }
        }, 
        productdetail: (inputField) => {
            "use strict";

            var productdetailVal =  $(inputField).val(),
                productdetailRegex = /^[a-zA-ZÆØÅæøå0-9\s._-]+$/;

            if(productdetailVal.length !== 0 && productdetailRegex.test(productdetailVal)){
                $(inputField).parent('div')
                                .removeClass("has-error")
                                .addClass("has-success");
                $(inputField).next()
                                .removeClass("glyphicon-remove")
                                .addClass("glyphicon-ok")
                                .next('.errMsg').html('');
                return true;
            }else{
                $(inputField).parent('div')
                                .removeClass("has-success")
                                .addClass("has-error");
                
                $(inputField).next()
                                .removeClass("glyphicon-ok")
                                .addClass("glyphicon-remove")
                                .next('.errMsg').html('Produkt beskrivelse skal udfyldes, og må ikke specialtegn');
                return false;
            }
        },
        productprice: (inputField) => {
            "use strict";
            var priceVal = $(inputField).val(),
                priceRegex = /^([0-9]\d*|0)(\,[0-9]{2})?$/;
            if(priceVal.length !== 0 && priceRegex.test(priceVal)){
                $(inputField).parent('div')
                                .removeClass("has-error")
                                .addClass("has-success");
                $(inputField).next()
                                .removeClass("glyphicon-remove")
                                .addClass("glyphicon-ok")
                                .next('.errMsg').html('');
                return true;
            }else{
                $(inputField).parent('div')
                                .removeClass("has-success")
                                .addClass("has-error");
                
                $(inputField).next()
                                .removeClass("glyphicon-ok")
                                .addClass("glyphicon-remove")
                                .next('.errMsg').html('Pris skal være i korrekt format 00,00.');
                return false;
            }
        }
    }

$(document).ready( () => {
    // Validate input when user types and releases the key
    $("#productAddForm").keyup( (objForm) => {
        "use strict";
        if(objForm.target.name === "productNameA"){
            validateProduct.productname("#productNameA");
        }else if(objForm.target.name === "productDetails"){
            validateProduct.productdetail("#productDetails");
        }else if(objForm.target.name === "productPrice"){
            validateProduct.productprice("#productPrice");
        }
    });

     $("#productUpdateForm").keyup( (objForm) => {
        "use strict";
        if(objForm.target.name === "productName"){
            validateProduct.productname("#productNameU");
        }else if(objForm.target.name === "productDetails"){
            validateProduct.productdetail("#productDetails");
        }else if(objForm.target.name === "productPrice"){
            validateProduct.productprice("#productPrice");
        }
    });

    // Validate input field if user TAB between fields
    $("#productAddForm").on('change', (objForm) => {
        "use strict";
        if(objForm.target.name === "productNameA"){
            validateProduct.productname("#productNameA");
        }else if(objForm.target.name === "productDetails"){
            validateProduct.productdetail("#productDetails");
        }else if(objForm.target.name === "productPrice"){
            validateProduct.productprice("#productPrice");
        }
    });

    $("#productUpdateForm").on('change', (objForm) => {
        "use strict";
        if(objForm.target.name === "productName"){
            validateProduct.productname("#productNameU");
        }else if(objForm.target.name === "productDetails"){
            validateProduct.productdetail("#productDetails");
        }else if(objForm.target.name === "productPrice"){
            validateProduct.productprice("#productPrice");
        }
    });
});