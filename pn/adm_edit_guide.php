<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Edit Guide"; //Set the browser title
$highlight = "adm_edit_guide"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>

    <script type="text/javascript">
        var guide_id = <?php echo(json_encode($_GET['guide_id'])); ?>;
        var elt;

        $( document ).ready(function() {
            //Load the guide content
            if(guide_id != null) {
                $.ajax({
                    type: "POST",
                    url: 'api/admin/guides/get_guide.php',
                    data: {
                        guide_id: guide_id
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.result == "SUCCESS") {
                            $('#guide_name').val(data.guide_data.guide_name);
                            $('#subscription_level').val(data.guide_data.subscription_level);
                            //Summernote onImageUpload Callback
                            $('#summernote').summernote({
                                callbacks: {
                                    onImageUpload: function (files) {
                                        sendFile(files[0]);
                                    }
                                }
                            });
                            //Initialize Summernote Content
                            $('#summernote').summernote('code', data.guide_data.content);
                            $('#thumbnail').val(data.guide_data.thumbnail);
                            $('#thumnailPreview').attr("src", "res/imgs/" + data.guide_data.thumbnail);
                        } else {
                            Swal.fire({
                                title: "Error",
                                html: data.message
                            });
                            return;
                        }
                    }
                });
            }
            else { $('#summernote').summernote('code'); }

            //Get a list of all possible tags
            $.ajax({
                type: "POST",
                url: 'api/admin/guides/get_all_tags.php',
                dataType: 'JSON',
                success: function(data) {
                    if (data.result == "SUCCESS") {
                        $.each(data.data, function( index, value ) {
                            $('#existing_tag_selector').append($("<option></option>").attr("value",index).text(value));
                        });
                    }else{
                        Swal.fire({
                            title: "Error",
                            html: data.message
                        });
                        return;
                    }
                }
            });

            //Get a list of tags associated with this guide
            var elt = $('input');
            $.ajax({
                type: "POST",
                url: 'api/admin/guides/get_tags.php',
                dataType: 'JSON',
                data: {
                    guide_id: guide_id
                },
                success: function(data) {
                    if (data.result == "SUCCESS") {
                        $.each(data.data, function( index, value ) {
                            $('#tags').tagsinput('add', value);
                        });
                    }else{
                        Swal.fire({
                            title: "Error",
                            html: data.message
                        });
                        return;
                    }
                }
            });

            //Save guide content
            $( "#saveBtn" ).click(function() {
                //Save guide content
                if(guide_id != null) {
                    $.ajax({
                        type: "POST",
                        url: 'api/admin/guides/edit_guide.php',
                        data: {
                            guide_id: guide_id,
                            guide_name: $('#guide_name').val(),
                            subscription_level: $('#subscription_level').val(),
                            content: $('#summernote').summernote('code'),
                            thumbnail: $('#thumbnail').val()
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.result == "SUCCESS") {
                                Swal.fire({
                                    title: "Success",
                                    html: data.message
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    html: data.message
                                });
                            }
                        }
                    });
                }
                else {
                    const thumbnail = ($('#thumbnail').val() === "") ? "default_thumb.png" : $('#thumbnail').val();
                    $.ajax({
                        type: "POST",
                        url: 'api/admin/guides/create_guide.php',
                        data: {
                            guide_name: $('#guide_name').val(),
                            subscription_level: $('#subscription_level').val(),
                            content: $('#summernote').summernote('code'),
                            thumbnail: thumbnail
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.result == "SUCCESS") {
                                Swal.fire({
                                    title: "Success",
                                    html: data.message
                                });
                                guide_id = data.guide_id;
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    html: data.message
                                });
                            }
                        }
                    });
                }
            });

            //Add tag button
            $('#addSelectTagBtn').click(function(){
                $('#tags').tagsinput('add', $('#existing_tag_selector option:selected').text());
            });

            //Save Tags Btn
            $('#saveTagsBtn').click(function(){
                //Save tag list
                if(guide_id != null) {
                    $.ajax({
                        type: "POST",
                        url: 'api/admin/guides/set_tags.php',
                        data: {
                            guide_id: guide_id,
                            tags: $("#tags").tagsinput('items')
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            Swal.fire({
                                title: "Success",
                                html: data.message
                            });
                        }
                    });
                }
                else {
                    Swal.fire({
                        title: "Guide does not exist",
                        html: "The guide does not exist, so it cannot have tags added."
                    });
                }
            });

            //Delete Guide Btn
            $('#deleteGuideBtn').click(function(){
                if(guide_id != null) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            //Delete the guide
                            $.ajax({
                                type: "POST",
                                url: 'api/admin/guides/delete_guide.php',
                                data: {
                                    guide_id: guide_id
                                },
                                dataType: 'JSON',
                                success: function (data) {
                                    if (data.result == "SUCCESS") {
                                        Swal.fire({
                                            title: "Success",
                                            html: data.message
                                        });
                                        setTimeout(function () {
                                            window.location.replace("owner_guides.php");
                                        }, 1000);
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            html: data.message
                                        });
                                    }
                                }
                            });
                        }
                    })
                }
                else {
                    Swal.fire({
                        title: "Guide does not exist",
                        html: "The guide does not exist, so it cannot be deleted."
                    });
                }
            });


            //Upload Thumbnail Btn
            $('#uploadThumbnailBtn').on('click', function(){

                var file_data = $('#thumbnailFile').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);

                $.ajax({
                    url: 'api/admin/guides/upload_img.php',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: "POST",
                    success: function(data) {
                        if(data.result == "SUCCESS"){
                            $('#thumbnail').val(data.file_name);
                            $('#thumnailPreview').attr("src", "res/imgs/" + data.file_name);
                            Swal.fire({
                                title: "Success",
                                html: data.message + "</br>" + "Don't forget to hit save."
                            });
                        }else{
                            Swal.fire({
                                title: "Error",
                                html: data.message
                            });
                        }
                    }
                });
            });

            // Update the file label on change
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            //Summernote File Upload
            function sendFile(file, editor, welEditable) {
                console.log("Send file function called");
                data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    dataType: "JSON",
                    type: "POST",
                    url: "api/admin/guides/upload_img.php",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#summernote').summernote('insertImage', "res/imgs/" + data.file_name, data.file_name );
                    }
                });
            }

        });

        var x;

    </script>

    <!-- SweetAlert -->
    <link rel="stylesheet" href="AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <script src="AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- summernote -->
    <link rel="stylesheet" href="AdminLTE/plugins/summernote/summernote-bs4.css">
    <!--  bootstrap-tagsinput-->
    <script src="dist/js/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
    <link rel="stylesheet" href="dist/js/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">Edit Guide</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Edit Guide Content</h5>
                    </div>
                    <div class="card-body">
                        <!-- Place page content here -->

                        <div class="form-group">
                            <label>Guide Name</label>
                            <input type="text" class="form-control" id="guide_name" placeholder="Enter Guide Name...">
                        </div>

                        <div class="form-group">
                            <label>Plan Visibility</label>
                            <select id="subscription_level" class="form-control">
                                <option value="0">FREE</option>
                                <option value="1">BEGINNER</option>
                                <option value="2">PERSONAL</option>
                            </select>
                        </div>

                        <!--                  Hidden input to save thumbanil path on server-->
                        <div class="form-group">
                            <input id="thumbnail" type="hidden">
                        </div>

                        <div class="form-group">
                            <label for="fileInput">Thumbnail Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="thumbnailFile">
                                    <label class="custom-file-label" for="thumbnailFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="uploadThumbnailBtn">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail Preview</label>
                            <div class="product-image-thumb"><img id="thumnailPreview" src="" alt="Thumbnail Image"></div>
                        </div>





                        <label>Guide Content</label>
                        <div class="mb-3">
                  <textarea class="textarea" id="summernote" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                  </textarea>
                        </div>
                        <button type="button" id="saveBtn" class="btn btn-block bg-gradient-info">Save Guide Content</button>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Manage Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">

                            <label>Select Existing Tags</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button id="addSelectTagBtn" class="btn btn-info" type="button">Add Tag</button>
                                </div>
                                <select class="custom-select" id="existing_tag_selector">
                                </select>
                            </div>


                            <label>Tag List (Comma Seperated)</label>
                            <div class="form-group">
                                <input type="text" value="" data-role="tagsinput" id="tags">
                            </div>
                        </div>
                        <button type="button" id="saveTagsBtn" class="btn btn-block bg-gradient-info">Save Tags</button>
                    </div>
                </div>


                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Delete Guide</h5>
                    </div>
                    <div class="card-body">
                        <label>WARNING: THIS CANNOT BE UNDONE!</label>
                        <button type="button" id="deleteGuideBtn" class="btn btn-block bg-gradient-danger"><i class="fas fa-trash"></i> Delete Guide</button>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Summernote -->
    <script src="AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
    </script>


<?php include('structure/bottom.php'); ?>
