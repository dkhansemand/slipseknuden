$(document).ready( () => {
     var pid;
    $('#modalDeleteProd').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var productName = button.data('productname'); 
        pid = button.data('pid');
        var modal = $(this);
        modal.find('#productName').text(productName);
    });
        $('#btnDeleteProd').on('click', ()=>{
            window.location = './index.php?p=Products&option=Delete&id='+pid;
        });

        $('#modalDeletePic').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var pictureName = button.data('filename'); 
            pid = button.data('pid');
            var modal = $(this);
            modal.find('#pictureFilename').text(pictureName);
        });
        $('#btnDeletePic').on('click', ()=>{
            window.location = './index.php?p=Pictures&option=Delete&id='+pid;
        });

    // Variable to store your files
    var files;
    // Add events
    $('#pictureUploadForm input[type=file]').on('change', prepareUpload);
    $('#pictureProductForm input[type=file]').on('change', prepareUpload);
    // Grab the files and set them to our variable
    function prepareUpload(event)
    {
        files = event.target.files;
    }
    $('#pictureProductForm').submit( (event) => {
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
                        $('#pictureProductForm input[type=file]').val('');
                        //let imgbase = 'prod_image';
                        
                        if(res.queryResponse.pictureIsProduct == 1){
                            let newOption = `
                            <option value="${res.queryResponse.pictureId}" selected>${res.queryResponse.pictureFilename}</option>
                            `;
                            $('#productPic').attr({selectedIndex : -1});
                            $('#productPic').append(newOption);
                            $("#showPic").attr("src","../prod_image/" + res.queryResponse.pictureFilename);
                        }
                    }
                    if(res.errState === 1){
                        
                        $('#errMsg').toggleClass('hidden').html(res.msg);
                    }
                },
                error: (res) => {
                    console.log('Error: ', res);
                    $('#errMsg').toggleClass('hidden').html(res);
                    
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

    $('#pictureUploadForm').submit( (event) => {
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
                        $('#pictureUploadForm input[type=file]').val('');
                        let imgbase = res.queryResponse.pictureIsProduct == 1 ? 'prod_image' : 'img';
                        let productImg = `
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    - <small>${res.queryResponse.pictureTitle}</small>
                                </div>
                                <div class="panel-body">
                                    <img src="../${imgbase}/${res.queryResponse.pictureFilename}" height="85" width="125" alt="${res.queryResponse.pictureTitle}">
                                </div>
                            <div class="panel-footer">
                                <a href="./index.php?p=Pictures&option=Delete&id=${res.queryResponse.pictureId}" class="btn btn-danger" role="button">Slet</a>
                            </div>
                        </div>
                        </div>
                        `;
                        if(res.queryResponse.pictureIsProduct == 1){
                            imgbase = 'prod_image';
                            $('#productPictures .row').append(productImg);
                        }else{
                            imgbase = 'img';
                            $('#OtherPictures .row').append(productImg);
                        }
                    }
                    if(res.errState === 1){
                        
                        $('#errMsg').toggleClass('hidden').html(res.msg);
                    }
                },
                error: (res) => {
                    console.log('Error: ', res);
                    $('#errMsg').toggleClass('hidden').html(res);
                    
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
});