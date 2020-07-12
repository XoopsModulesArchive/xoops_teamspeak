<?php
//////////////////////////////////////////XOOOPS ADMIN HEADER INFORMATION////////////////////////////////////////
include("admin_header.php");
include("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
include_once(XOOPS_ROOT_PATH."/class/module.errorhandler.php");
	global $xoopsDB;
	xoops_cp_header();
	openTable();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
********************************************************************************
********************************************************************************
*                                                                              *
*        **************************************************************        *
*        * gllcTS2 for TeamSpeak 2 (c) Gryphon, LLC                   *        *
*        * www.gryphonllc.com                                         *        *
*        *                                                            *        *
*        * (c) Copyright TeamCom Team, Ralf Ludwig, Niels Werensteijn *        *
*        * All rights are reserved.                                   *        *
*        * Copying or other reproduction of this                      *        *
*        * program except for archival purposes is prohibited without *        *
*        * the prior written consent of TC-Team.                      *        *
*        **************************************************************        *
*                                                                              *
********************************************************************************
********************************************************************************
*/
  include("./db_inc.php");
  include("../tpl_style.php");

if (!isset($HTTP_GET_VARS["step"])) {
  $step = '1';
?>

<form action="install.php">
<b><u>Step 1</u></b><br><br>
Welcome to the gllcTS2 install script.  Please make sure that the following information is correct.  If it is not, please open the config.php file in a text editor and enter the correct information. Please do not change the prefix, as it will break the block if you do.  Make sure that the prefix is <i>xoops_ts2_</i><hr><br>

Host: <b><?php echo ''.$dblink.''; ?></b><br>
Username: <b><?php echo ''.$dbuser.''; ?></b><br>
Password: <b><?php echo ''.$dbpw.''; ?></b><br>
Database: <b><?php echo ''.$dbname.''; ?></b><br>

<br><hr><input type="hidden" name="step" value="2"><input type="submit" value="To Step 2"></form>

<?php
}
else if ($HTTP_GET_VARS["step"] == '2') {
?>
<form action="install.php">
<b><u>Step 2</u></b><br><br>
We will install the following tables into the <b><?php echo ''.$dbname.''; ?></b> database.<hr><br>

Table 1: <b><?php echo ''.$dbtable1.''; ?></b><br>
Table 2: <b><?php echo ''.$dbtable2.''; ?></b><br>
Table 3: <b><?php echo ''.$dbtable3.''; ?></b><br>
Table 4: <b><?php echo ''.$dbtable4.''; ?></b><br>

<br><hr><input type="hidden" name="step" value="3"><input type="submit" value="To Step 3"></form>

<?
}
else if ($HTTP_GET_VARS["step"] == '3') {

mysql_query("DROP TABLE IF EXISTS $dbtable3");
mysql_query("CREATE TABLE $dbtable3 (
  channel_id int(11) NOT NULL auto_increment,
  server_ip varchar(255) NOT NULL default '',
  server_port varchar(255) NOT NULL default '',
  cl_number int(255) NOT NULL default '0',
  cl_codec varchar(255) NOT NULL default '',
  cl_parent varchar(255) NOT NULL default '',
  cl_order int(255) NOT NULL default '0',
  cl_maxuser varchar(255) NOT NULL default '',
  cl_name varchar(255) NOT NULL default '',
  cl_flags varchar(255) NOT NULL default '',
  cl_private varchar(255) NOT NULL default '',
  cl_topic varchar(255) NOT NULL default '',
  server_timestamp varchar(255) NOT NULL default '',
  PRIMARY KEY  (channel_id)
)");

mysql_query("DROP TABLE IF EXISTS $dbtable4");
mysql_query("CREATE TABLE $dbtable4 (
  group_id int(11) NOT NULL auto_increment,
  group_ispname varchar(255) NOT NULL default '',
  group_ispurl varchar(255) NOT NULL default '',
  group_servers int(255) NOT NULL default '0',
  group_users int(255) NOT NULL default '0',
  server_timestamp int(255) NOT NULL default '0',
  KEY id (group_id)
)");

mysql_query("DROP TABLE IF EXISTS $dbtable2");
mysql_query("CREATE TABLE $dbtable2 (
  user_id int(11) NOT NULL auto_increment,
  server_ip varchar(255) NOT NULL default '',
  server_port varchar(255) NOT NULL default '',
  pl_id varchar(255) NOT NULL default '',
  pl_channelid varchar(255) NOT NULL default '',
  pl_pktssend varchar(255) NOT NULL default '',
  pl_bytessend varchar(255) NOT NULL default '',
  pl_pktsrecv varchar(255) NOT NULL default '',
  pl_bytesrecv varchar(255) NOT NULL default '',
  pl_pktloss varchar(255) NOT NULL default '',
  pl_ping varchar(255) NOT NULL default '',
  pl_logintime varchar(255) NOT NULL default '',
  pl_idletime varchar(255) NOT NULL default '',
  pl_channelprivileges varchar(255) NOT NULL default '',
  pl_playerprivileges int(255) NOT NULL default '0',
  pl_playerflags varchar(255) NOT NULL default '',
  pl_ipaddress varchar(255) NOT NULL default '',
  pl_nickname varchar(255) NOT NULL default '',
  pl_loginname varchar(255) NOT NULL default '',
  server_timestamp varchar(255) NOT NULL default '',
  PRIMARY KEY  (user_id,user_id),
  KEY detail_id (user_id)
)");

mysql_query("DROP TABLE IF EXISTS $dbtable1");
mysql_query("CREATE TABLE $dbtable1 (
  server_id int(11) NOT NULL auto_increment,
  server_adminemail varchar(255) NOT NULL default '',
  server_isplinkurl varchar(255) NOT NULL default '',
  server_ispname varchar(255) NOT NULL default '',
  server_ispcountry varchar(255) NOT NULL default '',
  server_platform varchar(255) NOT NULL default '',
  server_version_major int(255) NOT NULL default '0',
  server_version_minor int(255) NOT NULL default '0',
  server_version_release int(255) NOT NULL default '0',
  server_version_build int(255) NOT NULL default '0',
  server_ip varchar(255) NOT NULL default '',
  server_port varchar(255) NOT NULL default '',
  server_name varchar(255) NOT NULL default '',
  server_uptime varchar(255) NOT NULL default '',
  server_password varchar(255) NOT NULL default '',
  server_type1 varchar(255) NOT NULL default '',
  server_type2 varchar(255) NOT NULL default '',
  clients_current int(255) NOT NULL default '0',
  clients_maximum int(255) NOT NULL default '0',
  channels_current varchar(255) NOT NULL default '',
  server_linkurl varchar(255) NOT NULL default '',
  server_queryport varchar(255) NOT NULL default '',
  server_timestamp varchar(255) NOT NULL default '',
  PRIMARY KEY  (server_id,server_id),
  KEY id (server_id)
)");
?>
<form action="install.php">
<b><u>Step 3</u></b><br><br>
Now we will install the admin table.  Please enter a password you would like to use to access the admin panel.<br>
<b>This password is not encrypted, the admin section is not highly secure. It is suggested that you do not use a password that you use for anything else.</b><hr><br>

Table 5: <b><?php echo ''.$dbtable5.''; ?></b><br>
<input type="hidden" name="adminname" value="admin"><br>
Password: <input type="text" name="adminpass"><br>

<br><hr><input type="hidden" name="step" value="4"><input type="submit" value="To Step 4"></form>

<?
}
else if ($HTTP_GET_VARS["step"] == '4') {

mysql_query("DROP TABLE IF EXISTS $dbtable5");
mysql_query("CREATE TABLE $dbtable5 (
  admin_id varchar(255) NOT NULL default '',
  admin_pass varchar(255) NOT NULL default '',
  bodybgcolor varchar(255) NOT NULL default '',
  bodytxtcolor varchar(255) NOT NULL default '',
  bodylnkcolor varchar(255) NOT NULL default '',
  bodyvlnkcolor varchar(255) NOT NULL default '',
  bodyalnkcolor varchar(255) NOT NULL default '',
  lsttxtcolor varchar(255) NOT NULL default '',
  lstlnkcolor varchar(255) NOT NULL default '',
  lstvlnkcolor varchar(255) NOT NULL default '',
  lstalnkcolor varchar(255) NOT NULL default '',
  lsthvrcolor varchar(255) NOT NULL default '',
  catrowcolor1 varchar(255) NOT NULL default '',
  cattxtcolor varchar(255) NOT NULL default '',
  catlnkcolor varchar(255) NOT NULL default '',
  cathvrcolor varchar(255) NOT NULL default '',
  pagetitle varchar(255) NOT NULL default '',
  listadmin varchar(255) NOT NULL default '',
  tablewidth varchar(255) NOT NULL default '',
  refresh varchar(255) NOT NULL default '',
  refreshtime varchar(255) NOT NULL default '',
  perpage varchar(255) NOT NULL default '',
  ispperpage varchar(255) NOT NULL default '',
  popupwidth varchar(255) NOT NULL default '',
  popupheight varchar(255) NOT NULL default '',
  bordercolor varchar(255) NOT NULL default '',
  rowcolor1 varchar(255) NOT NULL default '',
  rowcolor2 varchar(255) NOT NULL default '',
  imgbg varchar(255) NOT NULL default '',
  message text NOT NULL,
  serverremove varchar(255) NOT NULL default '',
  showgroups varchar(255) NOT NULL default '',
  homepage varchar(255) NOT NULL default '',
  updatecheck varchar(255) NOT NULL default '',
  KEY admin_id (admin_id)
)");

mysql_query("INSERT INTO $dbtable5 VALUES ('$HTTP_GET_VARS[adminname]', '$HTTP_GET_VARS[adminpass]', '#D1D7DB', '#000000', '#005C8C', '#ffffff', '#ffffff', '#000000', '#000000', '#000000', '#000000', '#005C8C', '#1C7DC6', '#ffffff', '#ffffff', '#ffffff', 'gllcTS2', 'admin@yoursite.com', '700', 'off', '60', '15', '10', '220', '380', '#000000', '#DCE8EE', '#C9DCE5', 'light', 'Set your PostUrl in the Server settings to<br>http://php.gryphonllc.com/gllcts2/webpost.php<br>to help development.<br><br>Download available <a href=\"http://www.thzclan.com/files/index.php?cat=29&file=53\" target=\"_blank\">here</a>.', '900', 'no', 'index.php', 'yes')");
?>
<form action="index.php">
<b><u>Step 4</u></b><br><br>
Thanks for installing gllcTS2. Please delete the install.php file.<hr><br>

If you find this script usefull, please make a donation. Thank you.<br>

<br><hr><input type="submit" value="To Admin"></form>
<?
}
//////////////////////////////////////////XOOPS ADMIN FOOTER INFORMATION/////////////////////////////////////////
closeTable();
xoops_cp_footer();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


</body>
</html>