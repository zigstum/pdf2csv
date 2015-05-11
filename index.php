<?php
include_once("functions.php");
$path = './bswatch';
foreach (new DirectoryIterator($path) as $file) {
    if ($file->isDot()) continue;

    if ($file->isDir()) {
        $aSwatches[] = $file->getFilename();
    }
}
asort($aSwatches);
//var_dump($aSwatches);
session_start();
//unset($_SESSION['skin']);
if(isset($_GET['skin'])) {
	$_SESSION['skin'] = $_GET['skin'];
	$sDir = $_SESSION['skin'];
}
if(!isset($_SESSION['skin'])){
	$_SESSION['skin'] = "simplex";
	$sDir = $_SESSION['skin'];
}
include("definedFields.php");
$sHeaderHTML = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PDF to CSV :: T r i b e t e c ::</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
	<link href="bswatch/<?php echo $_SESSION['skin'];?>/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/dropzone.css" type="text/css" rel="stylesheet" />
	<link href="css/custom.css" type="text/css" rel="stylesheet" />

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript" src="js/dropzone.js"></script>
	<script type="text/javascript" src="js/validator.js"></script>
	<script src="js/bootstrap-editable.min.js"></script>
	<link href="css/bootstrap-editable.css" rel="stylesheet">
	<script src="js/bootstrap-msg.js"></script>
	<link href="css/bootstrap-msg.css" rel="stylesheet">
	<script src="js/jquery.csvToTable.js"></script>
	<!-- TABLE AND MODAL -->
	<script src="js/bootstrap-table.js"></script>
	<script src="js/bootstrap-modalmanager.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-table-editable.js"></script>
	<link href="css/bootstrap-table.css" rel="stylesheet">
	<link href="css/bootstrap-modal-bs3patch.css" rel="stylesheet">
	<link href="css/bootstrap-modal.css" rel="stylesheet">
	
</head>
<body>
<!-- MAIN OUTER CONTAINER-->
<div class="container">
	<!-- CONTAINER ROW-->
	<div class="row clearfix">
		
<!-- CONFIRM MODAL -- not used yet-->
<div id="confirm" class="modal fade">
  <div class="modal-body">
    Do you want to continue?
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" data-value="1">Continue</button>
    <button type="button" data-dismiss="modal" class="btn" data-value="0">Cancel</button>
  </div>
</div>
<!-- CONFIRM MODAL-->
		

<!-- CSV PREVIEW MODAL-->		
<div id="csv_preview_modal" class="modal container fade" tabindex="-1">
  <div class="modal-header modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5>CSV Preview</h5>
    <span class="sm-pull-right">beta</span>
  </div>
  <div class="modal-body">
	<!-- BEGIN PREVIEW TABLE-->
	<div class="table-respsonsive">
	<div id="demo"> </div>
	</div>
	<!-- END PREVIEW TABLE-->
    </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>
<!-- /CSV PREVIEW MODAL-->	
		<!--NAV BAR CONTAINER 12 COL-->	
		<div class="col-md-12 column">
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
						 <span class="sr-only">Toggle navigation</span>
						 <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> 
						 <a class="navbar-brand" href="#">Tribetec &copy;</a>
				</div>
				<!-- RIGHT NAV BAR CONTAINER 12 COL-->	
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
					<a class="navbar-brand" href="#">pdf2csv</a>
					<!--SKIN CHOOSER-->
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo ucfirst($sDir); ?>  <span class="glyphicon glyphicon-cog"></span></a>
					  <ul class="dropdown-menu dropdown-cart" role="menu">
						  <?php foreach($aSwatches as $sDir){ ?>
						  <li>
							  <span class="item">
								<span class="item-left">
									<img class="drop-down-image" src="./bswatch/<?php echo $sDir;?>/thumbnail.png" alt="<?php echo $sDir; ?>" />
								</span>
								<span class="item-right">
									<button onclick="location.assign('?skin=<?php echo $sDir; ?>')" class="btn btn-xs btn-primary pull-right">apply</button>
								</span>
							</span>
						  </li>
						<?php } ?> 
						  <li class="divider"></li>
						  <li><a class="text-center" href="">themes by bootswatch</a></li>
					  </ul>
					</li>
					<!--end skin chooser-->
					</ul>
				</div>
			</nav>
			<!--NAV BAR FINISHES-->	
			
			<!--CONTENT BEGINS-->	
			<div class="container-fluid">
					<div class="row">
						<!-- DROPBOX 6 COL-->
						<div class="col-md-6 col-sm-6">
							<form role="form" action="upload.php" class="dropzone" id="my-awesome-dropzone">
								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>
						</div>
						<!-- CONTRoL / FORM PANEL 6 COL-->
						<div class="col-md-6 col-sm-6">
							
			<!-- CONTROL PANEL TABS -->
            <ul class="nav nav-tabs faq-cat-tabs">
                <li class="active"><a href="#faq-cat-1" data-toggle="tab">Basic</a></li>
                <li><a href="#faq-cat-2" data-toggle="tab">Advanced</a></li>
            </ul>
            <!-- TAB PANES -->
            <div class="tab-content faq-cat-content">
			<!-- Pane 1 -->
            <div class="tab-pane active in fade" id="faq-cat-1">
			<div class="form-group">		  
			<button type="button" onclick="javascript: doTheThing();" id="doItButton" class="btn btn-sm btn-success">Get CSV</button>
			<button type="button" onclick="javascript: location.assign('./');" class="btn btn-sm btn-primary">Reset</button>  		    
            </div>
            <div class="form-group">
			<input type="text" class="form-control" id="des_name" placeholder="Designer Name.">
			<div id="des_name_help" class="help-block with-errors">Text is automatically CAPITALISED</div>
			</div>
			<!-- Button Area -->
            </div>
            <!--/pane 1 -->
             <!--/pane 2 -->
                <div class="tab-pane fade" id="faq-cat-2">
					<!-- Button Area -->
					<div class="form-group">			  
					<button type="button" onclick="javascript: doTheThing();" id="doItButton" class="btn btn-sm btn-success">Get CSV</button>
					<button type="button" onclick="javascript: doPreview();" id="doPreviewButton" class="btn btn-sm btn-warning">Preview</button>
					<button type="button" onclick="javascript: location.assign('./');" class="btn btn-sm btn-primary">Reset</button>    
					<button type="button" class="btn btn btn-sm btn-default launchConfirm">Button</button>
                    </div>
					
					
					<!--PREDEFINED FIELDS ACCORDIAN-->
                    <div class="panel-group" id="accordion-cat-2">
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading active-faq">
                                <a data-toggle="collapse" data-parent="#accordion-cat-2" href="#faq-cat-2-sub-1">
                                    <h4 class="panel-title">
                                        Predefined Fields.
                                        <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="faq-cat-2-sub-1" class="panel-collapse collapse open">
                                <div class="panel-body">
             <div class="panel panel-default">
            <!--table data TODO: change to table-editable-->
            <table class="table table-striped">
                <thead>
                    <tr class="filters">
                        <th>Field Name</th>
                        <th>Current Value</th>
                </thead>
                <tbody>
                    <?php // loop through predefined fields 
					foreach($aFieldsDefined as $iKey => $sHeaderStr){
						echo "<tr><td>{$iKey}</td>";
						echo "<td><a data-title=\"Field Title\" data-type=\"text\"  class=\"field_editable\" data-pk=\"1\" href=\"#\" id=\"{$iKey}\"> {$sHeaderStr}</a></td></tr>";
					}
					?>    
                </tbody>
            </table>
        </div>
                                   <!--/table data-->
                                </div>
                            </div>
                        </div>
                        <!--ALL HEADERS ACCORDIAN-->
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-cat-2" href="#faq-cat-2-sub-2">
                                    <h4 class="panel-title">
                                        All Fields
                                        <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="faq-cat-2-sub-2" class="panel-collapse collapse">
								 <!--table data-->
								<div class="panel-body">
                                 <table id="headers_table" 
                                 class="table table-striped" 
                                 data-sort-order="asc" 
                                 data-toggle="table" 
                                 data-sort-name="name" 
                                 data-url="headers.php?json=1"
                                 data-query-params="queryParams"
								 data-pagination="true"
								 data-search="true">
									<thead>
										<tr>
											<th class="col-md-6 col-xs-6" data-sortable="true" data-field="name">Field Name</th>
											<th class="col-md-6 col-xs-6" data-sortable="true" data-editable="true" data-field="value">Value</th>
										</tr>
									</thead>
								</table>   
                                 <!--TABLE ENDS-->   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
						<!-- END CONTROL PANEL -->
						</div><!--./col-->
						
					</div><!--./row-->
					
			</div><!--container-->
			</form>
		</div>
		
		
		
		

		
		
		
		
		
	</div><!--/row-->
</div><!--/outer container-->
<!--end normal page content-->






<script>	
	
$( document ).ready(function() {
	
$.fn.modal.defaults.maxHeight = function(){
    // subtract the height of the modal header and footer
    return $(window).height() - 200; 
}
$.fn.modal.defaults.modalOverflow = "true";
$.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
    '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
        '<div class="progress progress-striped active">' +
            '<div class="progress-bar" style="width: 100%;"></div>' +
        '</div>' +
    '</div>';
    
    
	<!-- x-editable -->
	$.fn.editable.defaults.mode = 'inline';
	$('.field_editable').editable({
		success: function(response, newValue) {
		pre_def_arr[$(this).attr('id')] = newValue;
        //userModel.set('username', newValue); //update backbone model
		console.log(pre_def_arr);
		}
		
		});
	<!-- end x-editable -->
		
$('#headers_table').bootstrapTable({
//some code.
})
.on('editable-init.bs.table', function(e){
	$('.editable').on('save',function(e, params){
		try {
			var changedValue = params.newValue;
			var data_index = (e.currentTarget.parentElement.parentElement.attributes['data-index'].nodeValue); 
			var index = parseInt(data_index)+1;
			var changed_field = document.getElementById('headers_table').rows[index].cells[0].innerHTML;
			pre_def_arr[changed_field] = changedValue;
			console.log(pre_def_arr);
		} catch(error){
			console.log(error);
		}
	});
});

	
	Dropzone.options.myAwesomeDropzone = {
		accept: function(file, done){
			gotPdf = true;
			fileName = file.name;
			pos = (fileName.length)-3;
			src = fileName.substring(0, pos)+"jpg";
			console.log(src);
			done();
			setTimeout(function() {
				$('.dz-image').html("<img src='uploads/"+src+"' alt='"+fileName+"' data-dz-thumbnail=''>");
				},1250);
		},
		
		init: function() {
			this.on("addedfile", function() {
				if (this.files[1]!=null){
				this.removeFile(this.files[0]);
				}
			});
		}
	};
	
	
	<!--accordians-->
	    $('.collapse').on('show.bs.collapse', function() {
        var id = $(this).attr('id');
        $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
        $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-minus"></i>');
    });
    $('.collapse').on('hide.bs.collapse', function() {
        var id = $(this).attr('id');
        $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
        $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-plus"></i>');
    });
    $('#faq-cat-2-sub-1').collapse('show');
    //$( "#faq-cat-2-sub-1" ).show.bs.collapse();
    <!--end accordians-->

});
//DECLARE VARIABLES
var gotPdf = false;
var fileName = "";
var urlBit = "";
var pre_def_url_str = "";
var pre_def_arr = [];


$('.launchConfirm').on('click', function (e) {
    $('#confirm')
        .modal({ backdrop: 'static', keyboard: false })
        .one('click', '[data-value]', function (e) {
            if($(this).data('value')) {
                alert('confirmed');
            } else {
                alert('canceled');
            }
        });
});


function doPreview(){
	var des_name_val = $("#des_name").val();
	if(!gotPdf){
		Msg.show("You had one thing to bring... the PDF.", "danger", 2000);return false;
	}
	for (var prop in pre_def_arr) {
		pre_def_url_str += "&"+prop+"="+pre_def_arr[prop];
	}
	urlBit = 'des_name_val='+des_name_val+'&fileName='+fileName+pre_def_url_str;
	pre_def_url_str=[];
	url = "process.php?"+urlBit+"&preview=true";
	len = fileName.length - 3;
	preview_fileName = fileName.substring(0, len)+"csv";
	//Th first url call is to get the csv file made...
	$.get(url)
	  .done(function() {
		//the second url call is to check if the csv file is ready
		//it is supposed to wait untill it is ready before releasing viewport.
		$.get(url)
			.done(function() {
				/* CSV to Tabe init/options TODO: Replace with table editable */
				$(function() {	
					$('#demo').CSVToTable(decodeURI("uploads/"+preview_fileName),{
						tableClass: "table-striped table-bordered table-hover table-condensed",
						theadClass: "",
						thClass: "",
						tbodyClass: "",
						trClass: "",
						tdClass: "",
						loadingImage: "",
						loadingText: "Loading CSV data...",
						separator: ",",
						startLine: 0
					});
				});
				$('#csv_preview_modal').modal('show');
				
				
				
				
			}).fail(function() { 
				alert('the file is not there, try again in a mo');
		})
	});
	
	
}//end do preview

//Get the CSV
//TODO Make functions of repeat operations
function doTheThing(){
	var des_name_val = $("#des_name").val();
	if(!gotPdf){
		/* Available types: info, warn, danger, success */
		Msg.show("You had one thing to bring... the PDF.", "danger", 2000);
		return false;
	}
	if(!des_name_val){
		Msg.show("Let me guess... The designer that cannot be named?", "danger", 2000);
		return false;
	}
	for (var prop in pre_def_arr) {
		pre_def_url_str += "&"+prop+"="+pre_def_arr[prop];
	}
	urlBit = 'des_name_val='+des_name_val+'&fileName='+fileName+pre_def_url_str;
	pre_def_url_str=[];
	url = "process.php?"+urlBit;
	location.assign(url);
}
</script>

 
</body>
</html>
