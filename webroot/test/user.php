<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>测试用户</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<p center>添加用户</p>
<form method="GET" action="http://kaedezyf.com/webroot/friend/createFriend.php" name="createFriend" target="_blank">

<input align="left" id="user_id" name="user_id" value="">用户ID
<input align="left" id="friend_id" name="friend_id" value="">好友ID

<input type="submit" value="提交">
</form>


<p center>更新用户信息</p>
<form method="GET" action="http://kaedezyf.com/webroot/friend/deteleFriend.php" name="deteleFriend" target="_blank">

<input align="left" id="user_id" name="user_id" value="">用户ID
<br>
<input align="left" id="experience" name="experience" value="">经验
<input align="left" id="ingot" name="ingot" value="">元宝
<input align="left" id="money" name="money" value="">金币
<br>
<input align="left" id="user_level" name="user_level" value="">等级
<input align="left" id="skil_point" name="skil_point" value="">技能点
<input align="left" id="pack_num" name="pack_num" value="">背包数

<input type="submit" value="提交">
</form>

<p center>获取用户信息</p>
<form method="GET" action="http://kaedezyf.com/webroot/friend/listFriend.php" name="listFriend" target="_blank">

<input align="left" id="user_id" name="user_id" value="">用户ID

<input type="submit" value="提交">
</form>