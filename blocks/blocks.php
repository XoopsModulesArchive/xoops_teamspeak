<?php

function xoopstslisting(){
global $xoopsUser, $xoopsConfig, $xoops_url, $HTTP_COOKIE_VARS;
global $xoopsDB;

include_once(XOOPS_ROOT_PATH."/class/module.errorhandler.php");
include_once(XOOPS_ROOT_PATH."/include/xoopscodes.php");
//$uname = $xoopsUser->getVar("uname");
//$uid = $xoopsUser->getVar('uid');
	$block = array();
	$block['title'] = "Xoops Teamspeak";
    $r = "SELECT * FROM ".$xoopsDB->prefix("ts2_weblist")."";
	$result = $xoopsDB->query($r) or die("");
	$totalRows_xoops_teamspeak_servers = mysql_num_rows($result);
	$m = "SELECT * FROM ".$xoopsDB->prefix("ts2_admin")."";
    $m_result = $xoopsDB->query($m) or die("");
	$message = $xoopsDB->fetchArray($m_result);
	$admin_message = $message['message'];
	$block['content'].=  "$admin_message<br>";

	
	
if ($totalRows_xoops_teamspeak_servers > 0) {
if (is_object($xoopsUser)) {
		$uid = $xoopsUser->getVar('uid');
		$uname = $xoopsUser->getVar('uname');
} else {
		$uid = 0;
		$uname = '';
}
// line queries the db for active servers and arrays the result
	 while ($myrow_xts = $xoopsDB->fetchArray($result)){
	 $server_id = $myrow_xts['server_id'];
	 $server_ip = $myrow_xts['server_ip'];
	 $detailport = $myrow_xts['server_port'];
	 $ts_server_name = $myrow_xts['server_name'];
	 $c = "SELECT * FROM ".$xoopsDB->prefix("ts2_channel")." WHERE server_port = '$detailport'";
	 $myrow_channels = $xoopsDB->query($c) or die("");
	 if ($xoopsUser){
     $block['content'].=  "<br><img src=$xoops_url/modules/xoops_teamspeak/images/bullet_server.gif align=absmiddle><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=$xoops_url/modules/xoops_teamspeak/listing.php?detail=$server_ip&detailport=$detailport&page=1&sort=server_name&direction=asc&showgroup=all><strong>$ts_server_name</a></font></strong><br>";
	 }else{
     $block['content'].=  "<br><img src=$xoops_url/modules/xoops_teamspeak/images/bullet_server.gif align=absmiddle><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>$ts_server_name</font></strong><br>";
     }
	 $block['content'].=  "<table width=100%>";
	 $block['content'].=  "<tr>";
	 $block['content'].=  "<td>";
     while ($myrow_xts_channel = $xoopsDB->fetchArray($myrow_channels)){
	 $cl_name = $myrow_xts_channel['cl_name'];
	 $channel_id = $myrow_xts_channel['cl_number'];
	 $p = "SELECT * FROM ".$xoopsDB->prefix("ts2_user")." WHERE server_port = '$detailport' AND pl_channelid = '$channel_id'";
	 $myrow_users = $xoopsDB->query($p) or die("");
	 $totalRows_xoops_teamspeak_users = mysql_num_rows($myrow_users);
     $block['content'].=  "<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>";
// lines 42 thru 52 handle the listing of the channels on the server and the listing of the users on the server
     if ($xoopsUser){
	 $cl_name_encoded = urlencode($cl_name);
	 $block['content'].=  "	 <a href=$xoops_url/modules/xoops_teamspeak/login.php?detail=$server_id&channel=$cl_name_encoded&xoops_user=$uname title='Click to join $server_ip:$detailport | This opens in a popup window.' onClick=\"MM_openBrWindow(this.href,'Login','width=230,height=400');return false\"><img src=$xoops_url/modules/xoops_teamspeak/images/bullet_channel.gif align=absmiddle><strong><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$cl_name</a></font></strong><br>";
}else{
	 $block['content'].=  "<strong><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$cl_name</font></strong><br>";

}
	 if ($totalRows_xoops_teamspeak_users > 0) {
	 while ($myrow_xts_users = $xoopsDB->fetchArray($myrow_users)){
	 $pl_users = $myrow_xts_users['pl_nickname'];
	 $pl_users_bytes_sent = $myrow_xts_users['pl_bytessend'];
	 $pl_users_bytes_rcvd = $myrow_xts_users['pl_bytesrecv'];
	 $pl_users_ping = $myrow_xts_users['pl_ping'];
	 
	 $block['content'].=  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:;\" onMouseOver=\"MM_popupMsg('Bytes Sent:$pl_users_bytes_sent | Bytes Received: $pl_users_bytes_rcvd | Ping:$pl_users_ping')\"><img src='$xoops_url/modules/xoops_teamspeak/images/xoops_teamspeak/online.gif' alt='Bytes Sent:$pl_users_bytes_sent | Bytes Received: $pl_users_bytes_rcvd | Ping:$pl_users_ping'></a><strong><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$pl_users</font></strong><br>";
	 }
	 }else{
	 $block['content'].=  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color=\"#999999\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">No Users Online<br></font></strong>";
	 }
	 } 
     $block['content'].=  "</td></tr></table>";
	 }
	 }else{
	  $block['content'].=  "<strong><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Our Teamspeak Servers are currently down, please try again later.</font></strong><br>";
	 }
	 return $block;
	 }
?>
