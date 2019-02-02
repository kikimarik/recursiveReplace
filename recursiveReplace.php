<?php
session_start();

function recursiveStringReplace($pattern, $replacement, $caseSensitive = 'i', $dir = __DIR__) {

	$counter = 0;

	$includes = new FilesystemIterator($dir);

	foreach ($includes as $include) {

		if(is_dir($include) && !is_link($include)) {

			recursiveStringReplace($pattern, $replacement, $caseSensitive, $include);

		}

		else {

			if($include!=__FILE__) {

			$output = file_get_contents($include);

				if(preg_match('/'.$pattern.'/'.$caseSensitive, $output)>0) {

					$counter++;
					$output = preg_replace('/'.$pattern.'/'.$caseSensitive, $replacement, $output);
					file_put_contents($include, $output);
				}
			}
		}
	}

$_SESSION['counter'] = 'Replaced matches in '.$counter.' files';

}

?>

<style type="text/css">
	
input[type="text"] {
        padding: 5px;
        font-size: 15px;
        text-shadow: 0px 1px 0px #fff;
        outline: none;
        background: -webkit-gradient(linear, left top, left bottom, from(#bcbcbe), to(#ffffff));
        background: -moz-linear-gradient(top, #bcbcbe, #ffffff);
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid #717171;
        -webkit-box-shadow: 1px 1px 0px #efefef;
        -moz-box-shadow: 1px 1px 0px #efefef;
        box-shadow: 1px 1px 0px #efefef;
        width: 360px;
        color: #008B8B;
    }

input:focus {
        -webkit-box-shadow: 0px 0px 5px #007eff;
        -moz-box-shadow: 0px 0px 5px #007eff;
        box-shadow: 0px 0px 5px #007eff;
	}

input[type="submit"] {
    background-color: #68b12f;
    background: -webkit-gradient(linear, left top, left bottom, from(#68b12f), to(#50911e));
    background: -webkit-linear-gradient(top, #68b12f, #50911e);
    background: -moz-linear-gradient(top, #68b12f, #50911e);
    background: -ms-linear-gradient(top, #68b12f, #50911e);
    background: -o-linear-gradient(top, #68b12f, #50911e);
    background: linear-gradient(top, #68b12f, #50911e);
    border: 1px solid #509111;
    border-bottom: 1px solid #5b992b;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    -o-border-radius: 3px;
    box-shadow: inset 0 1px 0 0 #9fd574;
    -webkit-box-shadow: 0 1px 0 0 #9fd574 inset ;
    -moz-box-shadow: 0 1px 0 0 #9fd574 inset;
    -ms-box-shadow: 0 1px 0 0 #9fd574 inset;
    -o-box-shadow: 0 1px 0 0 #9fd574 inset;
    color: white;
    font-weight: bold;
    padding: 6px 20px;
    text-align: center;
    text-shadow: 0 -1px 0 #396715;
	}

label {
color: #509111;
text-shadow: #9fd574;
font-weight: bold;
	}

</style>

<center>
<form method="post">
	<label>Pattern: </label><input type="text" name="pattern">
	<label>Replacement: </label><input type="text" name="replacement">
	<input type="submit" name="recursiveReplace" value="Replace">
	<br><br><br>
	<label>Case-sensetive: </label><input type="checkbox" name="caseSensitive">
	<hr>
</form>
</center>

<?php

if(isset($_POST['recursiveReplace'])) { 

	if(!empty($_POST['pattern']) && !empty($_POST['replacement'])) {

		$caseSensitive = 'i';

		if($_POST['caseSensitive'] == 'on') {

			$caseSensitive = '';
		}

		recursiveStringReplace($_POST['pattern'], $_POST['replacement'], $caseSensitive);
	}

	header('Location: '.$_SERVER['REQUEST_URI']);
}

echo $_SESSION['counter'];