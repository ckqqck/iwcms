/**
	[Discuz!] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms, Empower to Www.hhuuu.com

	$Id: common.js 29624 2012-04-23 06:56:28Z monkey $
 */
var stmp = new Array();

function addFormEvent(formid, focus) {

	var si = 0;
	var formNode = $(formid).getElementsByTagName('input');
	for (i = 0; i < formNode.length; i++) {
		stmp[si] = i;
		si++;
	}
	//input 个数减1
	addMailEvent(formNode[stmp[1]]);
}

function addMailEvent(mailObj) {
	mailObj.onkeyup = function(event) {
		emailMenu(event, mailObj.id);
	};
	mailObj.onkeydown = function(event) {
		emailMenuOp(4, event, mailObj.id);
	};
	stmp['email'] = mailObj.id;
}

var emailMenuST = null;
function emailMenuOp(op, e, id) {
	if (op == 3 && BROWSER.ie && BROWSER.ie < 7) {
		checkemail(id);
	}
	if (!$('txt_menu')) {
		return;
	}
	if (op == 1) {
		$('emailmore_menu').style.display = 'none';
	} else if (op == 2) {
		showMenu({
			'ctrlid' : 'txt',
			'top' : '13'
		});
	}
}
function ckinput(val)
{
	$("ckinput").value = val;
}

function emailMenu(e, id) {
	if (BROWSER.ie && BROWSER.ie < 7) {
		return;
	}
	e = e ? e : window.event;
	var obj = $(id);
	var value = e.keyCode;
	var v = obj.value;
	if (!obj.value.length) {
		emailMenuOp(1);
		return;
	}

	if (value == 13) {
		$('txt_menu').style.display = 'none';
		return;
	}
	if (!$('txt_menu')) {
		menu = document.createElement('div');
		menu.id = 'txt_menu';
		menu.style.display = 'none';
		menu.className = 'p_pop';
		menu.setAttribute('disautofocus', true);
		$('append_parent').appendChild(menu);
	}
	var x = new Ajax("HTML");
	x.emailmore = 'txt_menu';
	var url = urljs + 'admin/qsort_menage/yaoming_ajax?str=' + v;
	x.get(url, function(s, x) {
		var result = new Array();  
	    result = eval(s); 
	    var b = '<ul>';
		for ( var i = 0; i < result.length; i++) {
			b += '<li><a href="javascript:;"  onclick="$(stmp[\'email\']).value=this.innerHTML;ckinput(\'' + result[i]['catid'] + '\');display(\'txt_menu\');">'
					+ result[i]['catname'] + '</a></li>';
		}
		b += '</ul>';
		
		changelevel = $(x.emailmore);
		ajaxinnerhtml(changelevel, b);
	});
	emailMenuOp(2);
}

function checkemail(id) {

}