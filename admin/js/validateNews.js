var validateNews = {
        newsheading: (inputField) => {
            "use strict";

            var nameVal = $(inputField).val(),
                nameRegex = /^[a-zA-ZÆØÅæøå0-9\s._-]+$/;
            
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
                                .next('.errMsg').html('Overskrift skal udfyldes, og må ikke indholde specialtegn');
                return false;
            }
        }, 
        newscontent: (inputField) => {
            "use strict";

            var newscontentVal =  $(inputField).val(),
                newscontentRegex = /^[a-zA-ZÆØÅæøå0-9\s._-]+$/;

            if(newscontentVal.length !== 0 && newscontentRegex.test(newscontentVal)){
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
                                .next('.errMsg').html('Indhold skal udfyldes, og må ikke specialtegn');
                return false;
            }
        }
    }

$(document).ready( () => {
    // Validate input when user types and releases the key
    $("#newsAddForm").keyup( (objForm) => {
        "use strict";
        if(objForm.target.name === "newstitle"){
            validateNews.newsheading("#newsTitle");
        }else if(objForm.target.name === "newscontent"){
            validateNews.newscontent("#newscontent");
        }
    });

     $("#newsUpdateForm").keyup( (objForm) => {
        "use strict";
        if(objForm.target.name === "newstitle"){
            validateNews.newsheading("#newsTitle");
        }else if(objForm.target.name === "newscontent"){
            validateNews.newscontent("#newscontent");
        }
    });

    // Validate input field if user TAB between fields
    $("#newsAddForm").on('change', (objForm) => {
        "use strict";
       if(objForm.target.name === "newstitle"){
            validateNews.newsheading("#newsTitle");
        }else if(objForm.target.name === "newscontent"){
            validateNews.newscontent("#newscontent");
        }
    });

    $("#newsUpdateForm").on('change', (objForm) => {
        "use strict";
       if(objForm.target.name === "newstitle"){
            validateNews.newsheading("#newsTitle");
        }else if(objForm.target.name === "newscontent"){
            validateNews.newscontent("#newscontent");
        }
    });
});