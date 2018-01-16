var lastusername = '', lastemail = '', stmp = new Array();
var strongpw = new Array();
var passwordlength = 7;

function $(id) {
	return !id ? null : document.getElementById(id);
}
function trim(str) {
	return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
}
function errormessage(id, msg) {
	if ($(id)) {
		showInputTip();
		msg = !msg ? '' : msg;
		if ($('ckp_' + id)) {
			if (msg == 'succeed') {
				msg = '';
				$('ckp_' + id).parentNode.className = $('ckp_' + id).parentNode.className
						.replace(/ p_right/, '');
				$('ckp_' + id).parentNode.className += ' p_right';
			} else if (msg !== '') {
				$('ckp_' + id).parentNode.className = $('ckp_' + id).parentNode.className
						.replace(/ p_right/, '');
			}
		}
		if ($('ckh_' + id)) {
			$('ckh_' + id).innerHTML = msg;
		}
		$(id).className = $(id).className.replace(/ er/, '');
		$(id).className += !msg ? '' : ' er';
	}
}
function addRegister(focus) {
	var username_id = $('username_id');
	username_id.onblur = function() {
		checkusername('username_id');
	};
	var password1 = $('password_id1');
	var password2 = $('password_id2');
	password1.onblur = function() {
		if (password1.value == '') {
			var pwmsg = '请填写密码';
			if (passwordlength > 0) {
				pwmsg += ', 最小长度为 ' + passwordlength + ' 个字符';
			}
			errormessage('password_id1', pwmsg);
		} else {
			errormessage('password_id1', 'succeed');
		}
		checkpassword('password_id1', 'password_id2');
	};
	password1.onkeyup = function() {
		if (passwordlength == 0 || password1.value.length >= passwordlength) {
			var passlevels = new Array('', '弱', '中', '强');
			var passlevel = checkstrongpw('password_id1');
			errormessage('password_id1', '<span class="passlevel passlevel'
					+ passlevel + '">密码强度:' + passlevels[passlevel] + '</span>');
		}
	};
	password2.onblur = function() {
		if (password2.value == '') {
			errormessage('password_id2', '请再次输入密码');
		}
		checkpassword('password_id1', 'password_id2');
	};
	var mail_id = $('mail_id');
	mail_id.onblur = function() {

		checkemail('mail_id');
	};
	try {
		if (focus) {
			$('invitecode').focus();
		} else {
			username_id.focus();
		}
	} catch (e) {
	}
}

function checkusername(id) {

	errormessage(id);
	var username = trim($(id).value);
	if ($('ckp_' + id).parentNode.className.match(/ p_right/)
			&& (username == '' || username == lastusername)) {
		return;
	} else {
		lastusername = username;
	}
	if (username.match(/<|"/ig)) {
		errormessage(id, '用户名包含敏感字符');
		return;
	}
	var unlen = username.replace(/[^\x00-\xff]/g, "**").length;
	if (unlen < 3 || unlen > 15) {
		errormessage(id, unlen < 3 ? '用户名不得小于 3 个字符' : '用户名不得超过 15 个字符');
		return;
	}
	errormessage(id, 'succeed');
}
function checkpassword(id1, id2) {
	if (!$(id1).value && !$(id2).value) {
		return;
	}
	if (passwordlength > 0) {
		if ($(id1).value.length < passwordlength) {
			errormessage(id1, '密码太短，不得少于 ' + passwordlength + ' 个字符');
			return;
		}
	}
	if (strongpw) {
		var strongpw_error = false, j = 0;
		var strongpw_str = new Array();
		for ( var i in strongpw) {
			if (strongpw[i] === 1 && !$(id1).value.match(/\d+/g)) {
				strongpw_error = true;
				strongpw_str[j] = '数字';
				j++;
			}
			if (strongpw[i] === 2 && !$(id1).value.match(/[a-z]+/g)) {
				strongpw_error = true;
				strongpw_str[j] = '小写字母';
				j++;
			}
			if (strongpw[i] === 3 && !$(id1).value.match(/[A-Z]+/g)) {
				strongpw_error = true;
				strongpw_str[j] = '大写字母';
				j++;
			}
			if (strongpw[i] === 4 && !$(id1).value.match(/[^A-Za-z0-9]+/g)) {
				strongpw_error = true;
				strongpw_str[j] = '特殊符号';
				j++;
			}
		}
		if (strongpw_error) {
			errormessage(id1, '密码太弱，密码中必须包含 ' + strongpw_str.join('，'));
			return;
		}
	}
	errormessage(id2);
	if ($(id1).value != $(id2).value) {
		errormessage(id2, '两次输入的密码不一致');
	} else {
		errormessage(id2, 'succeed');
	}
}
function checkstrongpw(id) {
	var passlevel = 0;
	if ($(id).value.match(/\d+/g)) {
		passlevel++;
	}
	if ($(id).value.match(/[a-z]+/ig)) {
		passlevel++;
	}
	if ($(id).value.match(/[^a-z0-9]+/ig)) {
		passlevel++;
	}
	return passlevel;
}
function checkemail(id) {
	errormessage(id);
	var email = trim($(id).value);
	if (email == '') {
		errormessage(id, '请输入邮箱地址');
		return;
	}
	if ($(id).parentNode.className.match(/ p_right/)
			&& (email == '' || email == lastemail)) {
		return;
	} else {
		lastemail = email;
	}
	if (email.match(/<|"/ig)) {
		errormessage(id, 'Email 包含敏感字符');
		return;
	}
	var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
	if (!email.match(reg)) {
		errormessage(id, 'Email 格式不正确');
		return;
	}
	errormessage(id, 'succeed');
}
function showInputTip(id) {
	var p_tips = $('newspaper-b').getElementsByTagName('i');
	for (i = 0; i < p_tips.length; i++) {
		if (p_tips[i].className == 'p_tip') {
			p_tips[i].style.display = 'none';
		}
	}
	if ($('ckp_' + id)) {
		$('ckp_' + id).style.display = 'block';
	}
}
