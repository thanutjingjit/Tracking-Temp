<?php
require 'services/dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Temp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">




    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap" rel="stylesheet">

<body style="font-family: 'Kanit', sans-serif;">


    <header>
        <nav class="navbar navbar-light bg-danger">
            <a class="navbar-brand" style="color: white;">TrackingTemp</a>
            <!-- <ul>
                <li><a href="login.php">เข้าสู่ระบบ</a></li>
                <li><a href="register.php">สมัครสมาชิก</a></li>
                
            </ul> -->
        </nav>
    </header>

    <div class="container" style="font-family: 'Kanit', sans-serif;">

        <form action="services/register.php" method="post" enctype='multipart/form-data' id="file-upload-form" class="uploader" style="text-align: center;"><br><br>

            <H3>การลงทะเบียนเข้าใช้ระบบ Tracking-Temp</H3>

            <div class="preview img-wrapper"></div>
            <div class="file-upload-wrapper">
                <input type="file" name="file[]" class="file-upload-native" accept="image/x-png,image/jpeg" required>
                <input type="text" disabled placeholder="อัพโหลดใบหน้าของคุณ" class="file-upload-text">

            </div>



            <div class="group">
                <input type="text" value="" name="firstname" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>ชื่อจริง</label>
            </div>

            <div class="group">
                <input type="text" value="" name="lastname" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>นามสกุล</label>
            </div>

            <div class="group">
                <input type="email" value="" name="email" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>อีเมล</label>
            </div>

            <div class="group">
                <input type="text" value="" pattern="[0-9]+" name="tel" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>เบอร์โทรศัพท์</label>
            </div>


            <style>
                @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

                *,
                *::after,
                *::before {
                    padding: 0;
                    margin: 0;
                    box-sizing: border-box;
                }

                ::-webkit-input-placeholder {
                    opacity: 0.8;
                    color: white;
                }

                ::-moz-placeholder {
                    opacity: 0.8;
                    color: white;
                }

                :-moz-placeholder {
                    opacity: 0.8;
                    color: white;
                }

                :-ms-input-placeholder {
                    opacity: 0.8;
                    color: white;
                }

                .preview {
                    display: block;
                    width: 200px;
                    height: 200px;
                    margin: 20px auto;
                    box-shadow: 0px 0px 0px 2px rgba(33, 122, 105, 1);
                    border-radius: 50%;
                    overflow: hidden;
                }

                .file-upload-wrapper {
                    position: relative;
                    z-index: 5;
                    display: block;
                    width: 250px;
                    height: 30px;
                    margin: 25px auto;
                    border-radius: 0px;
                    border-bottom: 1px dashed rgba(33, 122, 105, 1);
                }

                .file-upload-native,
                .file-upload-text {
                    position: absolute;
                    top: 0;
                    left: 0;
                    display: block;
                    width: 100%;
                    height: 100%;
                    cursor: pointer;
                    color: rgba(255, 255, 255, 0.8);
                }

                input[type="file"]::-webkit-file-upload-button {
                    cursor: pointer;
                }

                .file-upload-native:focus,
                .file-upload-text:focus {
                    outline: none;
                }

                .file-upload-text {
                    z-index: 10;
                    padding: 5px 15px 8px;
                    overflow: hidden;
                    font-size: 14px;
                    line-height: 1.4;
                    cursor: pointer;
                    text-align: center;
                    letter-spacing: 1px;
                    text-overflow: ellipsis;
                    border: 0;
                    background-color: transparent;
                }

                .file-upload-native {
                    z-index: 15;
                    opacity: 0;
                }

                .text1 {
                    color: #ccc;
                }
            </style>



            <div class="group">
                <input type="checkbox" id="confirm-box" style="width: 22px;height: 22px;float: left;">
                <span for="confirm-box" style="margin-left: -10px;">ยินยอมให้นำข้อมูลส่วนตัวไปใช้ในระบบ Tracking-Temp</span>
            </div>


            <!-- <input type="submit" name="submit" value="Upload"> -->
            <button type="submit" id="submit-btn" class="btn btn-danger" name="submit" value="Upload" disabled>Register</button>
        </form>




    </div>

</body>
<style>
    *,
    *::after,
    *::before {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    ::-webkit-input-placeholder {
        opacity: 0.8;
        color: black;
    }

    ::-moz-placeholder {
        opacity: 0.8;
        color: black;
    }

    :-moz-placeholder {
        opacity: 0.8;
        color: black;
    }

    :-ms-input-placeholder {
        opacity: 0.8;
        color: black;
    }

    /* body {
        font-size: 20px;
        line-height: 1.4;
        color: rgba(255, 255, 255, 0.8);
        background: #1d1f20;
    } */

    .preview {
        display: block;
        width: 200px;
        height: 200px;
        margin: 20px auto;
        box-shadow: 0px 0px 0px 2px rgba(255, 0, 0, 1);
        border-radius: 50%;
        overflow: hidden;
    }

    .file-upload-wrapper {
        position: relative;
        z-index: 5;
        display: block;
        width: 250px;
        height: 30px;
        margin: 25px auto;
        border-radius: 0px;
        border-bottom: 1px dashed rgba(255, 0, 0, 1);
    }

    .file-upload-native,
    .file-upload-text {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        height: 100%;
        cursor: pointer;
        color: rgba(255, 0, 0, 0.8);
    }

    input[type="file"]::-webkit-file-upload-button {
        cursor: pointer;
    }

    .file-upload-native:focus,
    .file-upload-text:focus {
        outline: none;
    }

    .file-upload-text {
        z-index: 10;
        padding: 5px 15px 8px;
        overflow: hidden;
        font-size: 14px;
        line-height: 1.4;
        cursor: pointer;
        text-align: center;
        letter-spacing: 1px;
        text-overflow: ellipsis;
        border: 0;
        background-color: transparent;
    }

    .file-upload-native {
        z-index: 15;
        opacity: 0;
    }



    .group {
        position: relative;
        margin-bottom: 45px;
        /* margin-left: 400px; */
        max-width: 300px;
        margin: 20px auto;
    }

    input {
        font-size: 18px;
        padding: 10px 10px 10px 5px;
        display: block;
        width: 300px;
        border: none;
        border-bottom: 1px solid #ccc;
    }

    input:focus {
        outline: none;
    }

    /* LABEL ======================================= */
    label {
        color: #999;
        font-size: 18px;
        font-weight: normal;
        position: absolute;
        pointer-events: none;
        left: 5px;
        top: 10px;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }

    /* active state */
    input:focus~label,
    input:valid~label {
        top: -20px;
        font-size: 14px;
        color: #ccc;
    }

    /* BOTTOM BARS ================================= */
    .bar {
        position: relative;
        display: block;
        width: 300px;
    }

    .bar:before,
    .bar:after {
        content: '';
        height: 2px;
        width: 0;
        bottom: 1px;
        position: absolute;
        background: red;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }

    .bar:before {
        left: 50%;
    }

    .bar:after {
        right: 50%;
    }

    /* active state */
    input:focus~.bar:before,
    input:focus~.bar:after {
        width: 50%;
    }

    /* HIGHLIGHTER ================================== */
    .highlight {
        position: absolute;
        height: 60%;
        width: 100px;
        top: 25%;
        left: 0;
        pointer-events: none;
        opacity: 0.5;
    }

    /* active state */
    input:focus~.highlight {
        -webkit-animation: inputHighlighter 0.3s ease;
        -moz-animation: inputHighlighter 0.3s ease;
        animation: inputHighlighter 0.3s ease;
    }

    /* ANIMATIONS ================ */
    @-webkit-keyframes inputHighlighter {
        from {
            background: #5264AE;
        }

        to {
            width: 0;
            background: transparent;
        }
    }

    @-moz-keyframes inputHighlighter {
        from {
            background: #5264AE;
        }

        to {
            width: 0;
            background: transparent;
        }
    }

    @keyframes inputHighlighter {
        from {
            background: #5264AE;
        }

        to {
            width: 0;
            background: transparent;
        }
    }

    #gallery {
        padding: 20px 0;
    }

    .img-preview {
        width: 100%;
        margin-bottom: 10px;
    }
</style>

</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img class="img-preview">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#gallery-photo-add').on('change', function() {
            $(".img-preview").remove();
            imagesPreview(this, 'div.gallery');
        });

        $('#confirm-box').on('change', function(e) {
            var check = !$('#confirm-box').is(':checked');
            $('#submit-btn').prop('disabled', check);
        });

    });
    $(function() {
        function maskImgs() {
            //$('.img-wrapper img').imagesLoaded({}, function() {
            $.each($('.img-wrapper img'), function(index, img) {
                var src = $(img).attr('src');
                var parent = $(img).parent();
                parent
                    .css('background', 'url(' + src + ') no-repeat center center')
                    .css('background-size', 'cover');
                $(img).remove();
            });
            //});
        }

        var preview = {
            init: function() {
                preview.setPreviewImg();
                preview.listenInput();
            },
            setPreviewImg: function(fileInput) {
                var path = $(fileInput).val();
                var uploadText = $(fileInput).siblings('.file-upload-text');

                if (!path) {
                    $(uploadText).val('');
                } else {
                    path = path.replace(/^C:\\fakepath\\/, "");
                    $(uploadText).val(path);

                    preview.showPreview(fileInput, path, uploadText);
                }
            },
            showPreview: function(fileInput, path, uploadText) {
                var file = $(fileInput)[0].files;

                if (file && file[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var previewImg = $(fileInput).parents('.file-upload-wrapper').siblings('.preview');
                        var img = $(previewImg).find('img');

                        if (img.length == 0) {
                            $(previewImg).html('<img src="' + e.target.result + '" alt=""/>');
                        } else {
                            img.attr('src', e.target.result);
                        }

                        uploadText.val(path);
                        maskImgs();
                    }

                    reader.onloadstart = function() {
                        $(uploadText).val('uploading..');
                    }

                    reader.readAsDataURL(file[0]);
                }
            },
            listenInput: function() {
                $('.file-upload-native').on('change', function() {
                    preview.setPreviewImg(this);
                });
            }
        };
        preview.init();
    });
</script>