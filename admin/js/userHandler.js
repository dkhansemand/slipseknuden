var validateUser = {
        username: (inputField) => {
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
                                .next('.errMsg').html('Brugernavn skal udfyldes, og må ikke indholde specialtegn');
                return false;
            }
        }, 
        names: (inputField) => {
            "use strict";

            var namesVal =  $(inputField).val(),
                namesRegex = /^[a-zA-ZÆØÅæøå\s-]+$/;

            if(namesVal.length !== 0 && namesRegex.test(namesVal)){
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
                                .next('.errMsg').html('Fornavn / Efternavn skal udfyldes, og må ikke have specialtegn');
                return false;
            }
        },
        email: (inputField) => {
            "use strict";

            var emailVal =  $(inputField).val(),
                emailRegex = /^[A-Za-zÆØÅæøå0-9_.]+[@]{1}[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

            if(emailVal.length !== 0 && emailRegex.test(emailVal)){
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
                                .next('.errMsg').html('E-mail skal udfyldes og være i korrekt format');
                return false;
            }
        },
        password: (inputField, inputField2) => {
            "use strict";
            var passwordValOne =  $(inputField).val(),
                passwordValTwo = $(inputField2).val();
            
            if(passwordValOne.length !== 0){ 
               $(inputField).parent('div')
                                .removeClass("has-error")
                                .addClass("has-success");
                $(inputField).next()
                                .removeClass("glyphicon-remove")
                                .addClass("glyphicon-ok")
                                .next('.errMsg').html('');
               
                if(passwordValTwo.length !== 0 && passwordValOne === passwordValTwo){
                    $(inputField2).parent('div')
                                .removeClass("has-error")
                                .addClass("has-success");
                    $(inputField2).next()
                                    .removeClass("glyphicon-remove")
                                    .addClass("glyphicon-ok")
                                    .next('.errMsg').html('');
                    return true;
                }else{
                   $(inputField2).parent('div')
                                .removeClass("has-success")
                                .addClass("has-error");
                
                $(inputField2).next()
                                .removeClass("glyphicon-ok")
                                .addClass("glyphicon-remove")
                                .next('.errMsg').html('Passwords stemmer ikke overens');
                return false;
                }
            }else{
               $(inputField).parent('div')
                                .removeClass("has-success")
                                .addClass("has-error");
                
                $(inputField).next()
                                .removeClass("glyphicon-ok")
                                .addClass("glyphicon-remove")
                                .next('.errMsg').html('Begge password felter skal udfyldes.');
                return false;
            }
        }
    }

$(document).ready( () => {
    var files;
    // Add events
    $('#pictureUserForm input[type=file]').on('change', prepareUpload);
    // Grab the files and set them to our variable
    function prepareUpload(event)
    {
        files = event.target.files;
    }
    $('#pictureUserForm').submit( (event) => {
        event.preventDefault();
        if(files !== null){
        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value)
        {
            data.append(key, value);
        });
        var pictureTitle = $('#pictureTitle').val(),
            pictureAssign = $('#pictureAssign option:selected').val();
            
            data.append('pictureTitle', pictureTitle);
            data.append('pictureAssign', pictureAssign);

            $.ajax({
                // Your server script to process the upload
                url: './lib/fileupload.php',
                type: 'POST',

                // Form data
                data: data,
                dataType: 'json',
                // Tell jQuery not to process data or worry about content-type
                // You *must* include these options!
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    //console.log('Success: ', res);
                    if(res.errState === 0){
                        $('#errMsg').hide();
                        $('#successMsg').toggleClass('hidden').html(res.msg);
                        $('#pictureTitle').val('');
                        $('#pictureUserForm input[type=file]').val('');
                        //let imgbase = 'prod_image';
                        
                        if(res.queryResponse.pictureTypeId === '2'){
                            let newOption = `
                            <option value="${res.queryResponse.pictureId}" selected>${res.queryResponse.pictureFilename}</option>
                            `;
                            $('#puserPic').attr({selectedIndex : -1});
                            $('#userPic').append(newOption);
                            $("#showPic").attr("src","../assets/media/employees/" + res.queryResponse.pictureFilename);
                        }
                    }
                    if(res.errState === 1){
                        
                        $('#errMsg').toggleClass('hidden').html(res.msg);
                    }
                },
                error: (res) => {
                    console.log('Error: ', res);
                    $('#errMsg').toggleClass('hidden').html(res.responseText);
                    
                },
                // Custom XMLHttpRequest
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        // For handling the progress of the upload
                        $('progress').toggleClass('hidden');
                        myXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                $('progress').attr({
                                    value: e.loaded,
                                    max: e.total,
                                });
                            }
                        } , false);
                    }
                    return myXhr;
                }
            });

        }
    });

    // Validate input when user types and releases the key
    $("#userAddForm").keyup( (objForm) => {
        "use strict";
        if(objForm.target.name === "username"){
            validateUser.username("#username");
        }else if(objForm.target.name === "firstname"){
            validateUser.names("#firstname");
        }else if(objForm.target.name === "lastname"){
            validateUser.names("#lastname");
        }else if(objForm.target.name === "email"){
            validateUser.email("#email");
        }else if(objForm.target.name === "password"){
            validateUser.password("#password", "#password2");
        }else if( objForm.target.name === "password2"){
            validateUser.password("#password", "#password2");
        }
    });

     $("#userUpdateForm").keyup( (objForm) => {
        "use strict";
         if(objForm.target.name === "username"){
            validateUser.username("#username");
        }else if(objForm.target.name === "firstname"){
            validateUser.names("#firstname");
        }else if(objForm.target.name === "lastname"){
            validateUser.names("#lastname");
        }else if(objForm.target.name === "email"){
            validateUser.email("#email");
        }else if(objForm.target.name === "password"){
            validateUser.password("#password", "#password2");
        }else if( objForm.target.name === "password2"){
            validateUser.password("#password", "#password2");
        }
    });

    // Validate input field if user TAB between fields
    $("#userAddForm").on('change', (objForm) => {
        "use strict";
         if(objForm.target.name === "username"){
            validateUser.username("#username");
        }else if(objForm.target.name === "firstname"){
            validateUser.names("#firstname");
        }else if(objForm.target.name === "lastname"){
            validateUser.names("#lastname");
        }else if(objForm.target.name === "email"){
            validateUser.email("#email");
        }else if(objForm.target.name === "password"){
            validateUser.password("#password", "#password2");
        }else if( objForm.target.name === "password2"){
            validateUser.password("#password", "#password2");
        }
    });

    $("#userUpdateForm").on('change', (objForm) => {
        "use strict";
         if(objForm.target.name === "username"){
            validateUser.username("#username");
        }else if(objForm.target.name === "firstname"){
            validateUser.names("#firstname");
        }else if(objForm.target.name === "lastname"){
            validateUser.names("#lastname");
        }else if(objForm.target.name === "email"){
            validateUser.email("#email");
        }else if(objForm.target.name === "password"){
            validateUser.password("#password", "#password2");
        }else if( objForm.target.name === "password2"){
            validateUser.password("#password", "#password2");
        }
    });

    var userid;
    $('#modalDeleteUser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var username = button.data('username'); 
        userid = button.data('userid');
        var modal = $(this);
        modal.find('#username').text(username);
    });
    $('#btnDeleteUser').on('click', ()=>{
        window.location = './index.php?p=Users&option=Delete&id='+userid;
    });

});