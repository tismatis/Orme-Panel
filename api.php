<?php
if($_GET['e'] == "1")
{
	$json=file_get_contents("http://localhost:8080/daemon?apikey=Dn5RnwJLUDQSbQ56CJTu11R9cKf6r1dQjwF&cmd=start.server&cmd_arg1=testserv1");
}else{	
	$json=file_get_contents("http://localhost:8080/daemon?apikey=Dn5RnwJLUDQSbQ56CJTu11R9cKf6r1dQjwF&cmd=stop.server&cmd_arg1=testserv1");
}



//$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

//var_dump(json_decode($json));
//var_dump(json_decode($json, true));

$obj = json_decode($json);
//print $obj->{'message'}; // 12345
echo $json;
?>