<?php
#================================#
#       TorrentTrader 3.00       #
#  http://www.torrenttrader.uk   #
#--------------------------------#
#       Created by M-Jay         #
#       Modified by Botanicar    #
#================================#

require "backend/functions.php";
dbconn(false);
loggedinonly();

stdhead(T_("UP_MANAGER"));

if (get_user_class() < 8)
	show_error_msg(T_("ERROR"), T_("SORRY_NO_RIGHTS_TO_ACCESS"), 1);

#-----------------------------------------------
# ADD
#-----------------------------------------------

if ($_POST['gig'])
{
	$add_upl = $_POST['gig'] * 1073741824;
	if ( !is_numeric($_POST['class']))
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded + ".$add_upl." WHERE status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users");
		$arr1[0] = T_("ALL1");
	}
	else
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded + ".$add_upl." WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res1 = SQL_Query_exec("SELECT level FROM groups WHERE group_id=".$_POST['class']."");
		$arr1 = mysqli_fetch_row($res1);
	}
	
	$sender = ( $_POST["fromsystem"] == "yes" ) ? "0" : $CURUSER["id"];		
	$subject = T_("SUBJECT_ADD");
	$msg = sprintf( T_("MSG_ADD"), "".$_POST['gig']." GB", $arr1[0]);
	
	while($arr = mysqli_fetch_row($res))
	{
		SQL_Query_exec("INSERT INTO messages (sender, receiver, added, subject, msg, poster) VALUES ($sender, $arr[0], '".get_date_time()."', ".sqlesc($subject).", ".sqlesc($msg).", $sender)");
	}

	write_log( sprintf ( T_("UP_ADDED"), class_user($CURUSER["username"]), $_POST['gig'], htmlspecialchars($arr1[0]) ) );
	autolink("upload-bonus.php", T_("UP_UPDATED"));
}

#-----------------------------------------------
# DEDUCT
#-----------------------------------------------
if($_POST['gig2'])
{
	$deduct_upl = $_POST['gig2'] * 1073741824;
	if ( !is_numeric($_POST['class']))
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded - ".$deduct_upl." WHERE status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users");
		$arr1[0] = T_("ALL1");
	}
	else
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded - ".$deduct_upl." WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res1 = SQL_Query_exec("SELECT level FROM groups WHERE group_id=".$_POST['class']."");
		$arr1 = mysqli_fetch_row($res1);
	}
	
	$sender = ( $_POST["fromsystem"] == "yes" ) ? "0" : $CURUSER["id"];
	$subject = T_("SUBJECT_DED");
	$msg = sprintf( T_("MSG_DED"), $_POST['gig2'], $arr1[0]);

	while($arr = mysqli_fetch_row($res))
	{
		SQL_Query_exec("INSERT INTO messages (sender, receiver, added, subject, msg, poster) VALUES ($sender, $arr[0], '".get_date_time()."', ".sqlesc($subject).", ".sqlesc($msg).", $sender)");
	}
	
	write_log( sprintf(T_("UP_DEDUCTED"), class_user($CURUSER["username"]), $_POST['gig2'], htmlspecialchars($arr1[0])) );
	autolink("upload-bonus.php", T_("UP_UPDATED"));
}

#-----------------------------------------------
# MULTIPLY
#-----------------------------------------------
if($_POST['gig3'])
{
	if ( !is_numeric($_POST['class']))
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded * ".$_POST['gig3']." WHERE status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users");
		$arr1[0] = T_("ALL1");
	}
	else
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded * ".$_POST['gig3']." WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res1 = SQL_Query_exec("SELECT level FROM groups WHERE group_id=".$_POST['class']."");
		$arr1 = mysqli_fetch_row($res1);
	}

	$sender = ( $_POST["fromsystem"] == "yes" ) ? "0" : $CURUSER["id"];
	$subject = T_("SUBJECT_MUL");
	$msg = sprintf( T_("MSG_MUL"), $_POST['gig3'], $arr1[0]);

	while($arr = mysqli_fetch_row($res))
	{
		SQL_Query_exec("INSERT INTO messages (sender, receiver, added, subject, msg, poster) VALUES ($sender, $arr[0], '".get_date_time()."', ".sqlesc($subject).", ".sqlesc($msg).", $sender)");
	}
	
	write_log( sprintf(T_("UP_MULTIPLIED"), class_user($CURUSER["username"]), $_POST['gig3'], htmlspecialchars($arr1[0])) );
	autolink("upload-bonus.php", T_("UP_UPDATED"));
}

#-----------------------------------------------
# DIVIDE
#-----------------------------------------------
if($_POST['gig4'])
{
	if ( !is_numeric($_POST['class']))
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded / (".$_POST['gig4'].") WHERE status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users WHERE status = 'confirmed'");
		$arr1[0] = T_("ALL1");
	}
	else
	{
		SQL_Query_exec("UPDATE users SET uploaded = uploaded / (".$_POST['gig4'].") WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res1 = SQL_Query_exec("SELECT level FROM groups WHERE group_id=".$_POST['class']."");
		$arr1 = mysqli_fetch_row($res1);
	}
	
	$sender = ( $_POST["fromsystem"] == "yes" ) ? "0" : $CURUSER["id"];
	$subject = T_("SUBJECT_DIV");
	$msg = sprintf( T_("MSG_DIV"), $_POST['gig4'], $arr1[0]);

	while($arr = mysqli_fetch_row($res))
	{
		SQL_Query_exec("INSERT INTO messages (sender, receiver, added, subject, msg, poster) VALUES ($sender, $arr[0], '".get_date_time()."', ".sqlesc($subject).", ".sqlesc($msg).", $sender)");
	}
	
	write_log( sprintf(T_("UP_DIVIDED"), class_user($CURUSER["username"]), $_POST['gig4'], htmlspecialchars($arr1[0])) );
	autolink("upload-bonus.php", T_("UP_UPDATED"));
	
}

#-----------------------------------------------
# REPLACE
#-----------------------------------------------
if ($_POST['gig5'])
{
	$replace_upl = $_POST['gig5'] * 1073741824;
	if ( !is_numeric($_POST['class']))
	{
		SQL_Query_exec("UPDATE users SET uploaded = ".$replace_upl." WHERE status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users");
		$arr1[0] = T_("ALL1");
	}
	else
	{
		SQL_Query_exec("UPDATE users SET uploaded = ".$replace_upl." WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res = SQL_Query_exec("SELECT id FROM users WHERE class=".$_POST['class']." AND status = 'confirmed'");
		$res1 = SQL_Query_exec("SELECT level FROM groups WHERE group_id=".$_POST['class']."");
		$arr1 = mysqli_fetch_row($res1);
	}
	
	$sender = ( $_POST["fromsystem"] == "yes" ) ? "0" : $CURUSER["id"];		
	$subject = T_("SUBJECT_REP");
	$msg = sprintf( T_("MSG_REP"), $_POST['gig5'], $arr1[0]);
	
	while($arr = mysqli_fetch_row($res))
	{
		SQL_Query_exec("INSERT INTO messages (sender, receiver, added, subject, msg, poster) VALUES ($sender, $arr[0], '".get_date_time()."', ".sqlesc($subject).", ".sqlesc($msg).", $sender)");
	}

	write_log( sprintf ( T_("UP_REPLACED"), class_user($CURUSER["username"]), $_POST['gig5'], htmlspecialchars($arr1[0]) ) );
	autolink("upload-bonus.php", T_("UP_UPDATED"));
}

#-----------------------------------------------
# END
#-----------------------------------------------
	
begin_frame(T_("UP_MANAGER"));

echo "<div class='forumInfo'> ". T_("INFO_UP_BONUS") . " </div>";
?>

<form method="POST" action="upload-bonus.php">
	<table align="center" border="0" width='100%'>
		<tr>
			<td class='css'>
				<table class="table table-bordered"  border="0" width='100%' cellpadding="4">
					<tr class='Tcom'>
						<td class="table_head">  <?php echo T_("USER"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="2"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("POWER_USER"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="3"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("VIP"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="4"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("UPLOADER"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="5"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("MODERATOR"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="6"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("SUPER_MODERATOR"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="7"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("ADMINISTRATOR"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="8"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("TEAM_LEADER"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="9"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("CODER"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="10"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("OWNER"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="11"></td>
					</tr>
					<tr class='Tcom'>
						<td class="table_head"> <?php echo T_("TO_ALL_MEMBERS"); ?> </td>
						<td class="table_col2" align="center"><input name="class" type="radio" value="A" checked></td>
					</tr>
				</table>
			</td>
			
			<td align='left' class='css-right'>
				<table class="table table-bordered2" border="0" cellpadding="4">
					<tr class='b-title'>
						<td class="table_head" align="center"><?php echo T_("UP_ADD"); ?></td>
					</tr>
					<tr>
						<td class="table_col1" align="center"><input type="text" name="gig" class="btnSmall2" /> GB
						&nbsp;&nbsp; <input type="checkbox" name="fromsystem" value="yes" /> System &nbsp;&nbsp;
						<input type="submit" name="submit" class="btn btn-success" value="<?php echo T_("SUBMIT"); ?>" /></td>
					</tr>
				</table>
				<br />
				<table class="table table-bordered2" border="0" cellpadding="4">
					<tr class='b-title'>
						<td class="table_head" align="center"><?php echo T_("UP_DED"); ?></td>
					</tr>
					<tr>
						<td class="table_col1" align="center"><input type="text" name="gig2" class="btnSmall2" /> GB
						&nbsp;&nbsp; <input type="checkbox" name="fromsystem" value="yes" /> System &nbsp;&nbsp;
						<input type="submit" name="submit" class="btn btn-success" value="<?php echo T_("SUBMIT"); ?>" /></td>
					</tr>
				</table>
				<br />
				<table class="table table-bordered2" border="0" cellpadding="4">
					<tr class='b-title'>
						<td class="table_head" align="center"><?php echo T_("UP_REP"); ?></td>
					</tr>
					<tr>
						<td class="table_col1" align="center"><input type="text" name="gig5" class="btnSmall2" /> GB
						&nbsp;&nbsp; <input type="checkbox" name="fromsystem" value="yes" /> System &nbsp;&nbsp;
						<input type="submit" name="submit" class="btn btn-success" value="<?php echo T_("SUBMIT"); ?>" /></td>
					</tr>
				</table>
				<br />
				<table class="table table-bordered2" border="0" cellpadding="4">
					<tr class='b-title'>
						<td class="table_head" align="center"><?php echo T_("UP_MUL"); ?></td>
					</tr>
					<tr>
						<td class="table_col1" align="center"><input type="text" name="gig3" class="btnSmall2" />
						&nbsp;&nbsp; <input type="checkbox" name="fromsystem" value="yes" /> System &nbsp;&nbsp;
						<input type="submit" name="submit" class="btn btn-success" value="<?php echo T_("SUBMIT"); ?>" /></td>
					</tr>
				</table>
				<br />
				<table class="table table-bordered2" border="0" cellpadding="4">
					<tr class='b-title'>
						<td class="table_head" align="center"><?php echo T_("UP_DIV"); ?></td>
					</tr>
					<tr>
						<td class="table_col1" align="center"><input type="text" name="gig4" class="btnSmall2" />
						&nbsp;&nbsp; <input type="checkbox" name="fromsystem" value="yes" /> System &nbsp;&nbsp;
						<input type="submit" name="submit" class="btn btn-success" value="<?php echo T_("SUBMIT"); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<br />

<?php 
end_frame(); 
stdfoot(); 
?>