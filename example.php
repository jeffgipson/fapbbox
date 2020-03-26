<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Default Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="shortcut icon" href="#" /> 
    
    <!-- Required css for production -->    
    <link href="box/box.css" rel="stylesheet" type="text/css" /> <!-- Box Framework css include (contains a simple css for sections) -->
    <link href="assets/minimalist-blocks/content.css" rel="stylesheet" type="text/css" /> <!-- Snippets css include (contains a simple css for content blocks/snippets) -->
    <!-- Render save styles needed by the content - also required for production -->
    <?php
	if(!empty($_SESSION['mainCss'])) {
		echo $_SESSION['mainCss'];
	}
	if(!empty($_SESSION['sectionCss'])) {
		echo $_SESSION['sectionCss'];
	}
    ?>

    <!-- Lightbox css include (optional) -->
    <link href="assets/scripts/simplelightbox/simplelightbox.css" rel="stylesheet" type="text/css" /> 
    
    <!-- Required css for editing (not needed in production) -->   
    <link href="contentbuilder/contentbuilder.css" rel="stylesheet" type="text/css" />
    <link href="contentbox/contentbox.css" rel="stylesheet" type="text/css" />

</head>
<body>

<div class="is-wrapper">
    <?php
	if(empty($_SESSION['mainContent'])) {
		/* This is a sample content. You can load existing content from a database and place it in this area */	
		echo '<div class="is-section is-section-100 is-shadow-1 is-bg-grey">
            <div class="is-boxes">
                <div class="is-box-img is-box is-box-5">
                    <div class="is-boxes ">
                        <div class="is-overlay">
                            <div class="is-overlay-bg" style="background-image: url(\'assets/designs/images/AYIZz231214.jpg\'); background-position: 0% 60%; transform: translateY(-13.8583px) scale(1.05);" data-bottom-top="transform:translateY(-120px) scale(1.05);" data-top-bottom="transform:translateY(120px) scale(1.05)"></div>
                        </div>
                    </div>
                </div>
                <div class="is-box is-dark-text is-bg-light is-box-7">
                    <div class="is-boxes">
                        <div class="is-box-centered">
                            <div class="is-container container" style="max-width: 480px;">
                                <div class="row clearfix">
                                    <div class="column full">
                                        <h1 style="text-align: left;" class="">Give.</h1>
                                        <p style="text-align: left;" class=""><i><span style="color: rgb(136, 136, 136);">"Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s."<br>Sarah Williams</span></i></p>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="column full">
                                        <div class="spacer height-40"></div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="column full">
                                        <p style="text-align: justify;" class="">Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, sit amet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
	} else {
		echo $_SESSION['mainContent'];
	}
    ?>
</div>

<!-- Required js for production -->  
<script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>  
<script src="assets/scripts/simplelightbox/simple-lightbox.min.js" type="text/javascript"></script>

<!-- Required js for editing (not needed in production) -->  
<script src="contentbuilder/contentbuilder.min.js" type="text/javascript"></script>
<script src="contentbox/contentbox.min.js" type="text/javascript"></script>
<script src="assets/minimalist-blocks/content.js" type="text/javascript"></script>

<script type="text/javascript">
	
    var timeoutId; //Used for Auto Save
    
    jQuery(document).ready(function ($) {

        //Enable editing
        $(".is-wrapper").contentbox({
            coverImageHandler: 'savecover.php', /* for uploading section background */
            largerImageHandler: 'saveimage-large.php', /* for uploading larger image */
            moduleConfig: [{
                "moduleSaveImageHandler": "saveimage-module.php" /* for module purpose image saving (ex. slider) */
            }],
            onRender: function () {
                //Add lightbox script (This is optional. If used, lightbox js & css must be included)
                $('a.is-lightbox').simpleLightbox({ closeText: '<i style="font-size:35px" class="icon ion-ios-close-empty"></i>', navText: ['<i class="icon ion-ios-arrow-left"></i>', '<i class="icon ion-ios-arrow-right"></i>'], disableScroll: false });
            },
            onChange: function () {
                //Auto Save
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    console.log('call');
                    save();                    
                }, 1000);
            }
        });

        $('a.is-lightbox').simpleLightbox({ closeText: '<i style="font-size:35px" class="icon ion-ios-close-empty"></i>', navText: ['<i class="icon ion-ios-arrow-left"></i>', '<i class="icon ion-ios-arrow-right"></i>'], disableScroll: false });

    });

    function save() {
        //Save all base64 images into files on the server
        $('.is-wrapper').data('contentbox').saveImages('saveimage.php', function(){

            //Get content
            var sHTML = $('.is-wrapper').data('contentbox').html();
                
            //Get styles needed by the content
            var sMainCss = $('.is-wrapper').data('contentbox').mainCss(); //mainCss() returns css include that defines typography style for the body/entire page.
            var sSectionCss = $('.is-wrapper').data('contentbox').sectionCss(); //sectionCss returns css includes that define typography styles for certan section(s) on the page
          
            //Save
            $.ajax({
                url: "savecontent.php",
                type: "post",
                data: {
                    content: sHTML,
                    mainCss: sMainCss,
                    sectionCss: sSectionCss
                },
                success: function (result) {
                    // alert(result);
                },
                error: function () {
                    alert('Failure');
                }
            });
            
        });
    }
</script>

<!-- Required js for production --> 
<script src="box/box.js" type="text/javascript"></script> <!-- Box Framework js include -->

</body>
</html>
