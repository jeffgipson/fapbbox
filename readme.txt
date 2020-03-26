ContentBox.js ver. 4.0.7


*** USAGE ***

1. Include the required css:

    <link href="box/box.css" rel="stylesheet" type="text/css" />
	<link href="assets/minimalist-blocks/content.css" rel="stylesheet" type="text/css" />
	
	Note:
	box.css is a required css for section structure.
	content.css is for snippets (content blocks).
    These two css are required in production.


2. Include JQuery

	<script src="contentbuilder/jquery.min.js" type="text/javascript"></script>  


3. Include ContentBuilder.js plugin

    <link href="contentbuilder/contentbuilder.css" rel="stylesheet" type="text/css" />
	<script src="contentbuilder/contentbuilder.min.js" type="text/javascript"></script>


	Note:
	ContentBox.js package includes ContentBuilder.min.js which can only be used within ContentBox.js. 
	For more flexibility, you can get ContentBuilder.js full package, available at:	http://innovastudio.com/content-builder.aspx


4. Include ContentBox.js plugin

    <link href="contentbox/contentbox.css" rel="stylesheet" type="text/css" />
	<script src="contentbox/contentbox.min.js" type="text/javascript"></script>


5. Run:

        //Enable editing
        $(".is-wrapper").contentbox({
            coverImageHandler: 'savecover.php', /* for uploading image background */
            largerImageHandler: 'saveimage-large.php', /* for uploading larger image */
            moduleConfig: [{
                "moduleSaveImageHandler": "saveimage-module.php" /* for module purpose image saving (ex. slider usage) */
            }],
            onChange: function () {
                //Auto Save
                var timeoutId;
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    save();                    
                }, 1000);
            }
        });

	Or if you are using Bootstrap framework, set framework parameter:

        $(".is-wrapper").contentbox({
            framework: 'bootstrap', 
            ...
        });

	
	NOTE: 
    ContentBox.js runs fully on client side (server independent). 
    The php files used in this example are only for saving image files on the server. 
    You can use other server side platform and create your own handler for saving image files. 
    Saving files on the server is outside the ContentBox.js functions.
    The saving image handler used:
        - savecover.php => for uploading section background image.
        - saveimage-large.php => for uploading used in image link dialog
        - saveimage-module.php => for uploading used in slider image dialog
        - saveimage.php => for uploading embedded base64 image on content (explained below)
    You can create your own image upload handler based on these files. In these files we add additional image resizing. 
    You may not need it. Start by creating a simple saving image.


	PARAMETERS:
	- framework: framework used (ex. 'bootstrap', 'foundation')
	- coverImageHandler: server side handler for saving background images.
	- largerImageHandler: server side handler for saving larger images.
	- moduleConfig: Containing params for future use. Now only one param is needed ("moduleSaveImageHandler") that is used for slider image upload. 
	

	OTHER USEFUL PARAMETER:
	- customval: Optional custom parameter if you want to pass custom value to the image handler (can be used to specify custom upload folder)


6. To get HTML:

    var sHTML = $('.is-wrapper').data('contentbox').html();


7. For Saving content, all embedded base64 images will be saved first (with the help of a simple handler on the server). 
	Then after all images are saved, get the HTML content and you're ready to submit it to the server for saving purpose (eg. in your database, etc).
	To save all embedded images, use saveimages method. 

    $('.is-wrapper').data('contentbox').saveImages('saveimage.php', function(){

        //Saving images done

        //Get HTML content
        var sHTML = $('.is-wrapper').data('contentbox').html();

        //Get styles (needed by the content). There are two styles:
        var sMainCss = $('.is-wrapper').data('contentbox').mainCss(); //mainCss() returns css that defines typography style for the body/entire page.
        var sSectionCss = $('.is-wrapper').data('contentbox').sectionCss(); //sectionCss returns css that define typography styles for certan section(s) on the page
        
        //Here, you're ready to submit the content and styles to the server for saving.
        //Both content and styles should be saved into your database. 
        //For viewing, content and styles should be displayed together.

    });

	PARAMETERS for saveimages.js plugin:
	- handler: server side handler for saving embedded base64 images. Here we use saveimage.php (can be changed with your own handler)
	- onComplete: Event triggered after all images are saved.	


8. Specify upload folder in saving image handler.

	Open savecover.php, saveimage-large.php, saveimage.php & saveimage-module.php. 
    
    Change $path variable if needed. The default upload folder is "uploads"
		

*** OTHERS ***


ContentBox needs some assets that are located in assets folder.  If you need to change the location, use:

	$(".is-wrapper").contentbox({      
        modulePath: 'assets/modules/',
        assetPath: 'assets/',
        fontAssetPath: 'assets/fonts/',
        designPath: 'assets/designs/',
        contentStylePath: 'assets/styles/',
        snippetData: 'assets/minimalist-blocks/snippetlist.html',
        ...
    });

    If you find broken images, you need to check these parameters' values. 
    For more safe, use 'relative to root' path (use '/' on start), for example:
    
	$(".is-wrapper").contentbox({   
        modulePath: '/assets/modules/',
        assetPath: '/assets/',
        fontAssetPath: '/assets/fonts/',
        designPath: '/assets/designs/',
        contentStylePath: '/assets/styles/',
        snippetData: '/assets/minimalist-blocks/snippetlist.html',
        ...
    });


One category of section templates is a footer section. In case you want to disable this category, use:

	$(".is-wrapper").contentbox({      
            disableStaticSection: true,
			...
        });


*** Language File ***

	With language file you can translate ContentBox.js interface into another language. To include the language file:

		<script src="contentbox/lang/en.js" type="text/javascript"></script>

	Here is the language file content as seen on lang/en.js:

		var _txt = new Array();
		_txt['Bold'] = 'Bold';
		_txt['Italic'] = 'Italic';
		...

	You can create your own language file (by copying/modifying the lang/en.js) and include it on the page where contentbox.js is included.
	This will automatically translate the ContentBox.js interface.



*** Customizing Snippets (Content Blocks) ***

	Snippet data is stored in a json file located in:

		assets/minimalist-blocks/content.js

	This json file is processed and displayed nicely by snippetlist.html, and it is specified by parameter snippetData:
	
		snippetData: 'assets/minimalist-blocks/snippetlist.html'
		
	To customize the snippets, open the content.js and make the changes. Here are some attributes you can use on the snippets:

	1) To make an image not replaceable, add data-fixed attribute to the <img> element, for example:

		<img src=".." data-fixed />

	2) To make a column not editable, add data-noedit attribute on the column, for example:

		<div class="row clearfix">
			<div class="column full" data-noedit>

			</div>
		</div>
		
	3) To make a column not editable and cannot be deleted, moved or duplicated, add data-protected attribute on the column, for example:

		<div class="row clearfix">
			<div class="column full" data-protected>

			</div>
		</div>

	4) You can put snippet folder not on its default location. Path adjustment will be needed using snippetPathReplace parameter, for example:

		$(".is-wrapper").contentbox({  
			snippetPathReplace: ['assets/minimalist-blocks/', 'mycustomfolder/assets/minimalist-blocks/'],
			...
		});


*** Lightbox extension ***

You can disable this if you want.
Lightbox plugin allows users to embed image with option to enlarge image on click. The implementation is as follows: (already implemented in the examples)

1. Include the required lightbox plugin script:
	<link href="assets/scripts/simplelightbox/simplelightbox.css" rel="stylesheet" type="text/css" />
	<script src="assets/scripts/simplelightbox/simple-lightbox.min.js" type="text/javascript"></script>

2. Initiate the lightbox plugin within contentbox using onRender param and specify upload handler for uploading image:

	
        $(".is-wrapper").contentbox({
            ...
            largerImageHandler: 'saveimage-large.php',
            onRender: function () {
                $('a.is-lightbox').simpleLightbox({ closeText: '<i style="font-size:35px" class="icon ion-ios-close-empty"></i>', navText: ['<i class="icon ion-ios-arrow-left"></i>', '<i class="icon ion-ios-arrow-right"></i>'], disableScroll: false });
            }
        });



*** OPTIONS ***

- snippetData
	Default value: 'assets/minimalist-blocks/snippetlist.html'
	Location of content block view/selection.

- scriptPath: 
    Default value: '' (means use default location)
    Path for contentbuilder/ folder.

- pluginPath: 
    Default value: '' (means use default location)
    Path for plugins folder: plugins/
    Specify this parameter if you want to move the plugins/ folder anywhere else. This will overide scriptPath parameter.

- assetPath: 
    Default value: 'assets/'
    Specify this parameter if you want to move assets files into different location.

- fontAssetPath: 
    Default value: 'assets/fonts/'
    Specify this parameter if you want to move font image files from assets/fonts/ into different location.

- largerImageHandler: 
    Default value: '' 
    Specify additional server side handler for uploading actual image.
    If specified, a browse icon will be displayed on image link dialog.
    We provide a PHP and ASP.NET example in the package. To try, here is an example setting:

        largerImageHandler: 'saveimage-large.php' // or saveimage-large.ashx if you're using ASP.NET
  
    By default, image is saved in "uploads" folder. You can change the upload folder by editing the saveimage-large.php or saveimage-large.ashx. 
    Open the file and see commented line where you can change the upload folder.
	
- columnTool: true | false
	Default value: true
	To show/hide column tool.

- elementTool: true | false
	Default value: true
	To show/hide element tool.

- imageEmbed: true | false
	Default value: true
	To enable/disable image embed feature.
	
- elementEditor: true | false
	Default value: true
	To enable/disable element styles editing feature.

- colors
	Default value: ["#ff8f00", "#ef6c00", "#d84315", "#c62828", "#58362f", "#37474f", "#353535",
                "#f9a825", "#9e9d24", "#558b2f", "#ad1457", "#6a1b9a", "#4527a0", "#616161",
                "#00b8c9", "#009666", "#2e7d32", "#0277bd", "#1565c0", "#283593", "#9e9e9e"]
	To specify custom color selection.

- animateModal: true | false
	Default value: true
	To enable/disable animation when a modal dialog displayed.

- customval
	Default value: ''
	Custom paramater can be used to pass any value. The value will be passed when an image is submitted on the server for saving. 
	In a CMS application, you can pass (for example) a user id or session id, etc. On the server, image handler can use this value to decide where to save the image for each user.
	This is more of an option to your custom application.

- imageQuality
	Default value: 0.92
	To specify image embed quality.
	
- columnHtmlEditor: true | false
	Default value: true
	To show/hide HTML button on column tool

- rowHtmlEditor: true | false
	Default value: false
	To show/hide HTML button on row tool

- htmlSyntaxHighlighting: true | false
	Default value: false
	To enable/disable syntax highlighting HTML editor

- toolbar: 'top' | 'left' | 'right'
	Default value: 'top'
	To specify the editing toolbar placement

- toolbarDisplay: 'auto' | 'always'
	Default value: 'auto'
	To set editing toolbar visibility

- toolbarAddSnippetButton: true | false
	Default value: false
	To show/hide 'Add Snippet' button on the editing toolbar

- buttons
	Default value: ['bold', 'italic', 'underline', 'formatting', 'color', 'align', 'textsettings', 'createLink', 'tags', 'more' , '|', 'undo', 'redo'],  
    To configure rich text editor buttons.

- buttonsMore
	Default value: ['icon', 'image', '|', 'list', 'font', 'formatPara', '|', 'html', 'preferences'], 
	To configure buttons on 'More' popup. 

	The "More" button will be displayed only if it has popup with buttons.

	You can move some buttons from the toolbar into the popup. However, not all buttons can be moved. Only the non popup buttons, such as: 
	"createLink", "icon", "image", "removeFormat", "html", "addSnippet", "html" & "preferences"
	
	If you don't want to use the "More" button, set:

		buttonsMore: []

	and make sure that there is no buttons from installed plugins, by editing the contentbuilder/config.js:

		_cb.settings.plugins = [];

- builderMode: '' | 'minimal' | 'clean'
	Default value: ''
	To set builder mode. 
	Minimal and clean mode simplify the builder interface (less visible buttons).

- rowcolOutline: true | false
	Default value: true
	Show/hide active row/column outline.

- snippetAddTool: true | false
	Default value: true
	Show/hide add snippet (+) orange line.

- outlineStyle: '' | 'grayoutline'
	Default value: '' (colored)
    To set outline color.
	
- elementSelection: true | false
	Default value: true.
	When enabled (set true), Pressing CTRL-A will select current element (not all elements).

- snippetCategories: 
	Default value: [
        [120,"Basic"],
        [118,"Article"],
        [101,"Headline"],
        [119,"Buttons"],
        [102,"Photos"],
        [103,"Profile"],
        [116,"Contact"],
        [104,"Products"],
        [105,"Features"],
        [106,"Process"],
        [107,"Pricing"],
        [108,"Skills"],
        [109,"Achievements"],
        [110,"Quotes"],
        [111,"Partners"],
        [112,"As Featured On"],
        [113,"Page Not Found"],
        [114,"Coming Soon"],
        [115,"Help, FAQ"]
        ]
	To configure snippets' categories.

- defaultSnippetCategory: 
	Default value: 120
	To specify default snippet category.

- outlineMode: '' | 'row'
	Default value: '' (outline will be applied on both row and column).
	If set 'row', outline will be applied on row only.
	 
- elementHighlight: true | false
	Default value: true
	To enable/disable active element highlight.
	
- rowTool: 'right' | 'left'
	Default value: 'right'
	To specify Row Tool position.

- toolStyle: '' | 'gray'
	Default value: '' (colored)
    To set tool color.
	
- clearPreferences: true | false
	Default value: false
	If set true, will clear the editing Preferences on page load.


*** EVENTS ***


- onRender
	Triggered when new snippet added (or content changed). If there are custom extensions/plugins within the content, re-init the plugins here.

- onChange
	Triggered when content changed.

- onImageBrowseClick
	Triggered when image browse icon is clicked.

- onImageSettingClick
	Triggered when image link icon is clicked.

- onImageSelectClick
	Triggered when custom image select button is clicked.
	If onImageSelectClick event is used, custom image select button will be displayed on the image link dialog.

- onFileSelectClick
	Triggered when custom file select button is clicked.
	If onFileSelectClick event is used, custom file select button will be displayed on the link dialog.

- onAdd(html)
	Triggered when a snippet (block) is added or dropped into content.
	You can use it to modify the snippet's HTML before it is added or dropped into content. Set the modified html as a return, for example:

		$(".is-wrapper").contentbox({  
            onAdd: function (html) {
                html = html.replace('{custom tag}', 'your content');
                return html;
            }
            ...
        });

- onContentClick(event)
	Triggered when content is clicked.


*** METHODS ***

- html()
    To get HTML
    Example:

        var sHTML = $('.is-wrapper').data('contentbox').html();

- saveImages(handler, callback)
    To call server side handler to save all embedded base64 images to the server.

    Example:

    $('.is-wrapper').data('contentbox').saveImages('saveimage.php', function(){
        
        console.log('image saving done!');

    });

    Use saveimage.ashx if you're using ASP.NET.
	
- loadHtml(html)
	To load HTML at runtime.

- destroy()
	To disable/destroy the plugin.

- undo()
    Perform undo.
    Example:
    
        $('.is-wrapper').data('contentbox').undo();

- redo()
    Perform redo.
    Example:

        $('.is-wrapper').data('contentbox').redo();

*** EXAMPLES ***


- example.html (Basic example. Content is saved in browser's Local Storage)

- example.php (Complete example in PHP. Content is saved in session)

- example-bootstrap.html (Using Bootstrap framework)

- example-foundation.html (Using Foundation framework)


*** UPGRADING FROM PREVIOUS VERSION ***

Just copy & replace the following folders:

- assets/
- box/
- contentbox/
- contentbuilder/



*** SUPPORT ***

Email us at: support@innovastudio.com



---- IMPORTANT NOTE : ---- 
1. Custom Development is beyond of our support scope.
Once you get the HTML content, then it is more of to user's custom application (eg. posting it to the server for saving into a file, database, etc).
Programming or server side implementation is beyond of our support scope.

2. Our support doesn't cover custom integration into users' applications. It is users' responsibility.
------------------------------------------
