/*****************************************/
// Name: Javascript Textarea BBCode Editor
// Version: 1.1
// Author: Balakrishnan
// Last Modified Date: 26/12/2008
// License: Free
// URL: http://www.corpocrat.com
/******************************************/

var textarea;
var content;

function Init() {
   	$('<div id="sc_toolbar"></div>').insertBefore('#post-content');
 		
 	$("<img title=\"Paragraph\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_align_justify.png\" name=\"btnBold\" onClick=\"doAddTags('[p]','[/p]')\">").appendTo('#sc_toolbar');
 	$("<img title=\"NewLine\" class=\"button\" src=\"../plugins/gs_shortcodes/images/arrow_down.png\" name=\"btnBold\" onClick=\"doAddTags('<br/>','')\">").appendTo('#sc_toolbar');
 
	$("<img title=\"Bold\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_bold.png\" name=\"btnBold\" onClick=\"doAddTags('[b]','[/b]')\">").appendTo('#sc_toolbar');
    $("<img title=\"Italic\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_italic.png\" name=\"btnItalic\" onClick=\"doAddTags('[i]','[/i]')\">").appendTo('#sc_toolbar');
	$("<img title=\"Underline\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_underline.png\" name=\"btnUnderline\" onClick=\"doAddTags('[u]','[/u]')\">").appendTo('#sc_toolbar');
	
	$("<img title=\"Heading 1\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_heading_1.png\" name=\"btnH1\" onClick=\"doAddTags('[h1]','[/h1]')\">").appendTo('#sc_toolbar');
	$("<img title=\"Heading 2\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_heading_2.png\" name=\"btnH1\" onClick=\"doAddTags('[h2]','[/h2]')\">").appendTo('#sc_toolbar');
	$("<img title=\"Heading 3\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_heading_3.png\" name=\"btnH1\" onClick=\"doAddTags('[h3]','[/h3]')\">").appendTo('#sc_toolbar');
	$("<img title=\"Heading 4\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_heading_4.png\" name=\"btnH1\" onClick=\"doAddTags('[h4]','[/h4]')\">").appendTo('#sc_toolbar');
	$("<img title=\"Heading 5\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_heading_5.png\" name=\"btnH1\" onClick=\"doAddTags('[h5]','[/h5]')\">").appendTo('#sc_toolbar');
	$("<img title=\"Heading 6\" class=\"button\" src=\"../plugins/gs_shortcodes/images/text_heading_6.png\" name=\"btnH1\" onClick=\"doAddTags('[h6]','[/h6]')\">").appendTo('#sc_toolbar');
	
	$("<img title=\"Link3\" class=\"button\" src=\"../plugins/gs_shortcodes/images/link.png\" name=\"btnLink\" onClick=\"doAddTags('[link]','[/link]')\">").appendTo('#sc_toolbar');
	
	$("<img title=\"Link\" class=\"button\" src=\"../plugins/gs_shortcodes/images/image.gif\" name=\"btnLink\" id='getPic' onClick=\"getImage();\">").appendTo('#sc_toolbar');
	
   	textarea = document.getElementById('post-content');
	

}

Init();


function getImage(){
	form="<h2>Insert Image</h2>";
	form=form+"<label>Select Image</label><input type='text' size='50' id='getPicID' onClick='window.open(\"/admin/filebrowser.php?CKEditorFuncNum=1&returnid=getPicID&type=images\",\"mywindow\",\"width=600,height=500\")' />";
	form=form+"<label>Image Width (px)</label><input type='text' size='50' id='getPicWidth' />"; 
	form=form+"<label>Image Height (px)</label><input type='text' size='50' id='getPicHeight' />"; 
	form=form+"<label>Align Image</label><select id='getPicAlign'><option value=''></option><option value='alignleft'>Left</option><option value='alignright'>Right</option><option value='aligncenter'>Center</option></select>";
	form=form+"<input type='button' value='Insert Image' class='submit' onclick='insertImage();' />";
	$.modal(form);
}

function insertImage(){
	src=$('#getPicID').val();
	width=$('#getPicWidth').val();
	height=$('#getPicHeight').val();
	align=$('#getPicAlign').val();
	style="";
	if (width!="" || height!=""){
		style="style='width:"+width+";height:"+height+";'";
	}
	$.modal.close;
	doAddTags('[image src="'+src+'" class="'+align+'" '+style+' /]','');
	
}

function doImage()
{

var url = prompt('Enter the Image URL:','http://');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				sel.text = '[img]' + url + '[/img]';
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		var rep = '[img]' + url + '[/img]';
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
			
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}

}

function doURL()
{

var url = prompt('Enter the URL:','http://');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				
			if(sel.text==""){
					sel.text = '[url]'  + url + '[/url]';
					} else {
					sel.text = '[url=' + url + ']' + sel.text + '[/url]';
					}			

				//alert(sel.text);
				
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
        var sel = textarea.value.substring(start, end);
		
		if(sel==""){
				var rep = '[url]' + url + '[/url]';
				} else
				{
				var rep = '[url=' + url + ']' + sel + '[/url]';
				}
	    //alert(sel);
		
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
			
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
}

function doAddTags(tag1,tag2)
{

	// Code for IE
		if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				//alert(sel.text);
				sel.text = tag1 + sel.text + tag2;
			}
   else 
    {  // Code for Mozilla Firefox
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
		
		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;

		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		var rep = tag1 + sel + tag2;
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
		
		
	}
}

function doList(tag1,tag2){

// Code for IE
		if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				var list = sel.text.split('\n');
		
				for(i=0;i<list.length;i++) 
				{
				list[i] = '[*]' + list[i];
				}
				//alert(list.join("\n"));
				sel.text = tag1 + '\n' + list.join("\n") + '\n' + tag2;
			} else
			// Code for Firefox
			{

		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var i;
		
		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;

		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		
		var list = sel.split('\n');
		
		for(i=0;i<list.length;i++) 
		{
		list[i] = '[*]' + list[i];
		}
		//alert(list.join("<br>"));
        
		
		var rep = tag1 + '\n' + list.join("\n") + '\n' +tag2;
		textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
 }
}