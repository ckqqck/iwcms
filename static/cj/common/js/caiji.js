function Ajax(recvType, waitId) {

	var aj = new Object();

	aj.loading = '加载中...';
	aj.recvType = recvType ? recvType : 'XML';
	aj.waitId = waitId ? $(waitId) : null;

	aj.resultHandle = null;
	aj.sendString = '';
	aj.targetUrl = '';

	aj.setLoading = function(loading) {
		if (typeof loading !== 'undefined' && loading !== null)
			aj.loading = loading;
	};

	aj.setRecvType = function(recvtype) {
		aj.recvType = recvtype;
	};

	aj.setWaitId = function(waitid) {
		aj.waitId = typeof waitid == 'object' ? waitid : $(waitid);
	};

	aj.createXMLHttpRequest = function() {
		var request = false;
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			if (request.overrideMimeType) {
				request.overrideMimeType('text/xml');
			}
		} else if (window.ActiveXObject) {
			var versions = [ 'Microsoft.XMLHTTP', 'MSXML.XMLHTTP',
					'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0',
					'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0',
					'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0',
					'MSXML2.XMLHTTP' ];
			for ( var i = 0; i < versions.length; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if (request) {
						return request;
					}
				} catch (e) {
				}
			}
		}
		return request;
	};

	aj.XMLHttpRequest = aj.createXMLHttpRequest();
	aj.showLoading = function() {
		if (aj.waitId
				&& (aj.XMLHttpRequest.readyState != 4 || aj.XMLHttpRequest.status != 200)) {
			aj.waitId.style.display = '';
			aj.waitId.innerHTML = '<span><img src="' + IMGDIR
					+ '/loading.gif" class="vm"> ' + aj.loading + '</span>';
		}
	};

	aj.processHandle = function() {
		if (aj.XMLHttpRequest.readyState == 4
				&& aj.XMLHttpRequest.status == 200) {
			if (aj.waitId) {
				aj.waitId.style.display = 'none';
			}
			if (aj.recvType == 'HTML') {
				aj.resultHandle(aj.XMLHttpRequest.responseText, aj);
			} else if (aj.recvType == 'XML') {
				if (!aj.XMLHttpRequest.responseXML
						|| !aj.XMLHttpRequest.responseXML.lastChild
						|| aj.XMLHttpRequest.responseXML.lastChild.localName == 'parsererror') {
					aj.resultHandle('<a href="' + aj.targetUrl
							+ '" target="_blank" style="color:red">加载失败</a>',
							aj);
				} else {
					aj
							.resultHandle(
									aj.XMLHttpRequest.responseXML.lastChild.firstChild.nodeValue,
									aj);
				}
			}
		}
	};

	aj.get = function(targetUrl, resultHandle) {
		targetUrl = hostconvert(targetUrl);
		setTimeout(function() {
			aj.showLoading()
		}, 250);
		aj.targetUrl = targetUrl;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		var attackevasive = isUndefined(attackevasive) ? 0 : attackevasive;
		if (window.XMLHttpRequest) {
			aj.XMLHttpRequest.open('GET', aj.targetUrl);
			aj.XMLHttpRequest.setRequestHeader('X-Requested-With',
					'XMLHttpRequest');
			aj.XMLHttpRequest.send(null);
		} else {
			aj.XMLHttpRequest.open("GET", targetUrl, true);
			aj.XMLHttpRequest.setRequestHeader('X-Requested-With',
					'XMLHttpRequest');
			aj.XMLHttpRequest.send();
		}
	};
	aj.post = function(targetUrl, sendString, resultHandle) {
		targetUrl = hostconvert(targetUrl);
		setTimeout(function() {
			aj.showLoading()
		}, 250);
		aj.targetUrl = targetUrl;
		aj.sendString = sendString;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		aj.XMLHttpRequest.open('POST', targetUrl);
		aj.XMLHttpRequest.setRequestHeader('Content-Type',
				'application/x-www-form-urlencoded');
		aj.XMLHttpRequest
				.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		aj.XMLHttpRequest.send(aj.sendString);
	};
	return aj;
}
function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}
function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}

function strlen(str) {
	return (str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length
			: str.length;
}

function mb_strlen(str) {
	var len = 0;
	for ( var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3
				: 2)
				: 1;
	}
	return len;
}

function mb_cutstr(str, maxlen, dot) {
	var len = 0;
	var ret = '';
	var dot = !dot ? '...' : dot;
	maxlen = maxlen - dot.length;
	for ( var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3
				: 2)
				: 1;
		if (len > maxlen) {
			ret += dot;
			break;
		}
		ret += str.substr(i, 1);
	}
	return ret;
}

function hostconvert(url) {

	if (!url.match(/^https?:\/\//))
		url = SITEURL + url;
	var url_host = getHost(url);
	var cur_host = getHost().toLowerCase();
	if (url_host && cur_host != url_host) {
		url = url.replace(url_host, cur_host);
	}
	return url;
}

function getHost(url) {
	var host = "null";
	if (typeof url == "undefined" || null == url) {
		url = window.location.href;
	}
	var regex = /^\w+\:\/\/([^\/]*).*/;
	var match = url.match(regex);
	if (typeof match != "undefined" && null != match) {
		host = match[1];
	}
	return host;
}
function showWindow(url,title, mode) {
	mode = isUndefined(mode) ? 'get' : mode;
	if (mode == 'get') {
		url += (url.search(/\?/) > 0 ? '&' : '?')
				+ 'infloat=yes';
		ajaxget(url,title);
	} else if (mode == 'post') {
		menuObj.act = $(url).action;
		ajaxpost(url, 'fwin_content_' + k, '', '', '', function() {
			
		});
	}
}

function ajaxget(url,title) {
	var x = new Ajax();
	x.display = typeof display == 'undefined' || display == null ? '' : display;
	if (url.substr(strlen(url) - 1) == '#') {
		url = url.substr(0, strlen(url) - 1);
		x.autogoto = 1;
	}
	x.get(url, function(s, x) {
		layer.open({
	        title:title,
	        type: 1,
	        area: ['520px', '440px'], //宽高
	        fix: false, //不固定
	        maxmin: true,
	        content: s,
	        success:function(layero,index){
	        },
	        end:function(){
	        }
	    });
	});
}

function ajaxpost(formid, showid, waitid, showidclass, submitbtn, recall) {
	var waitid = typeof waitid == 'undefined' || waitid === null ? showid
			: (waitid !== '' ? waitid : '');
	var showidclass = !showidclass ? '' : showidclass;
	var ajaxframeid = 'ajaxframe';
	var ajaxframe = $(ajaxframeid);
	var formtarget = $(formid).target;

	var handleResult = function() {
		var s = '';
		var evaled = false;

		showloading('none');
		try {
			s = $(ajaxframeid).contentWindow.document.XMLDocument.text;
		} catch (e) {
			try {
				// s =
				// $(ajaxframeid).contentWindow.document.documentElement.firstChild.wholeText;
				s = $(ajaxframeid).contentWindow.document.documentElement.textContent;
			} catch (e) {
				try {
					s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue;
				} catch (e) {
					s = 'dfssssssssssss';
				}
			}
		}
		if (s != '' && s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if (showidclass) {
			if (showidclass != 'onerror') {
				$(showid).className = showidclass;
			} else {
				showError(s);
				ajaxerror = true;
			}
		}
		if (submitbtn) {
			submitbtn.disabled = false;
		}
		if (!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
			ajaxinnerhtml($(showid), s);
		}
		ajaxerror = null;
		if ($(formid))
			$(formid).target = formtarget;
		if (typeof recall == 'function') {
			recall();
		} else {
			eval(recall);
		}
		if (!evaled)
			evalscript(s);
		ajaxframe.loading = 0;
		$('append_parent').removeChild(ajaxframe.parentNode);
	};
	if (!ajaxframe) {
		var div = document.createElement('div');
		div.style.display = 'none';
		div.innerHTML = '<iframe name="' + ajaxframeid + '" id="' + ajaxframeid
				+ '" loading="1"></iframe>';
		$('append_parent').appendChild(div);
		ajaxframe = $(ajaxframeid);
	} else if (ajaxframe.loading) {
		return false;
	}

	_attachEvent(ajaxframe, 'load', handleResult);

	showloading();
	$(formid).target = ajaxframeid;
	var action = $(formid).getAttribute('action');
	action = hostconvert(action);
	$(formid).action = action.replace(/\&inajax\=1/g, '') + '&inajax=1';
	$(formid).submit();
	if (submitbtn) {
		submitbtn.disabled = true;
	}
	doane();
	return false;
}

function dc() {
	var num = parseInt(document.getElementById("a_chanum").value);
	if( num > 20)
	{
		num = 20;
	}
	var common = parseInt(document.getElementById("a_chacommon").value);
	var one = parseInt(document.getElementById("a_chaone").value);
	//alert( num + "----" +common+ "----" + one);
	var y = document.getElementById("a_www").value;
	var A, B;
	A = one;
	B = formatStr(y, one) + '<br>';
	for ( var i = 1; i <= num - 1; i++) {
		A += common;
		var v = formatStr(y, A);
		B += v + '<br>';
	}
	return B;
}
function db() {
	var num = parseInt(document.getElementById("a_binum").value);
	if( num > 20)
	{
		num = 20;
	}
	var common = parseInt(document.getElementById("a_bicommon").value);
	var one = parseInt(document.getElementById("a_bione").value);
	// alert( num + "----" +common+ "----" + one);
	var y = document.getElementById("a_www").value;
	var A;
	A = one;
	B = formatStr(y, one) + '<br>';
	for ( var i = 1; i <= num - 1; i++) {
		A = common * A;
		var v = formatStr(y, A);
		B += v + '<br>';
	}
	return B;
}

function cj_test(title) {
	msg = '<ul class="tb tb_s cl">';
		
	if(document.getElementById("optype_1").checked)
	{
		msg += dc();
	}else{
		msg += db();
	}		
	msg += '</ul>';
	//页面层
    layer.open({
        type: 1,
        area: ['420px', '240px'], //宽高
        content: msg
    });
}
var id;
function cj_del_db(id,title) {
	this.id = id;
	msg = '<ul class="tb tb_s cl">';		
	msg += '<li>你真的要清空数据吗？</li>';		
	msg += '<li>删除后不可恢复!!</li>';		
	msg += '</ul>';
	// 'confirm', 'notice', 'info', 'right','alert'
	showDialog(msg, 'confirm', title,cktest,'','','','是的','取消');
}
function cktest()
{

	var temp=this.id;
    var x = new Ajax("HTML");
	var url = SITEURL + 'admin/cj/article/del_db';
	 x.post(url,'id='+temp,function(s){ 
		 window.location.href = SITEURL + 'admin/cj/article';
	 }); 
}
var ids;
function cj_del_img_db(id,title) {
	this.id = id;
	msg = '<ul class="tb tb_s cl">';		
	msg += '<li>你真的要清空数据吗？</li>';		
	msg += '<li>删除后不可恢复!!</li>';		
	msg += '</ul>';
	// 'confirm', 'notice', 'info', 'right','alert'
	showDialog(msg, 'confirm', title,cktestimg,'','','','是的','取消');
}
function cktestimg()
{

	var temp=this.id;
    var x = new Ajax("HTML");
	var url = SITEURL + 'admin/cj/img/del_db';
	 x.post(url,'id='+temp,function(s){ 
		 window.location.href = SITEURL + 'admin/cj/img';
	 }); 
}
function uper(str) {
	if (IsURL(str) == false) {
		alert("输入的URL格式错误");
	} else {
		var listconment = $("code");
		listconment.value = str;
	}
}

function upperCase() {
	var y = $("#www").value;
	if (y == "" || IsURL(y) == false) {
		alert("输入的URL格式错误");
	} else {
		var chkObjs = document.getElementsByName("a_bi");
		for ( var i = 0; i < chkObjs.length; i++) {
			if (chkObjs[i].checked) {
				var v = chkObjs[i].value;
				if (v == "1") {
					dc();
				} else {
					db();
				}
				break;
			}
		}
	}
}
function IsURL(str_url) {
	var strRegex = "^((https|http|ftp|rtsp|mms)?://)";
	var re = new RegExp(strRegex);
	// re.test()
	if (re.test(str_url)) {
		return (true);
	} else {
		return (false);
	}
}
function Isture(str) {
	var regex = /\(\*\)/ig; // 创建正则表达式对象
	var array = regex.exec(str);
	if (array) {
		return (true);
	} else {
		return (false);
	}
}
function formatStr(str, A) {
	str = str.replace(/\(\*\)/ig, A);
	return str + "\n";
}
function insertAtCursor(myField, myValue) {
	var myField = document.getElementById(myField);
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
		sel.select();
	} else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		// save scrollTop before insert
		var restoreTop = myField.scrollTop;
		myField.value = myField.value.substring(0, startPos) + myValue
				+ myField.value.substring(endPos, myField.value.length);
		if (restoreTop > 0) {
			// restore previous scrollTop
			myField.scrollTop = restoreTop;
		}
		myField.focus();
		myField.selectionStart = startPos + myValue.length;
		myField.selectionEnd = startPos + myValue.length;
	} else {
		myField.value += myValue;
		myField.focus();
	}
}
function insertAtCursordate(myField, myValue) {
	var myField = $(myField);
	myField.value = myValue;
	myField.focus();
}
function sortsubmit() {
	var temp = document.getElementById("myform");
	var sort = document.getElementById("sort");
	var sort_start = document.getElementById("sort_start");
	var sort_end = document.getElementById("sort_end");
	if (sort.value == "") {
		alert('请选择字段');
		return;
	}
	if (sort_start.value == "") {
		alert('替换前不能为空');
		return;
	}
	temp.submit();
}
function onsubmitz() {
	var temp = document.getElementById("myform");
	var listconment = document.getElementById("listconment");
	var www = document.getElementById("www");
	var uid = document.getElementsByName("uid");
	for ( var i = 0; i < uid.length; i++) {
		if (uid[i].checked) {
			var uidv = uid[i].value;
			break;
		}
	}
	if (uidv == 1) {
		if (listconment.value == "") {
			alert('单条网址输入不符合要求');
			return;
		}
	} else if (uidv == 3) {
		y = www.value;
		if (y == "" || IsURL(y) == false || Isture(y) == false) {
			alert('地址格式输入不符合要求');
			return;
		}
	}
	temp.submit();
}
/** *******tab 类 start********************** */
var tabLinks = new Array();
var contentDivs = new Array();

function init() {

	var tabListItems = document.getElementById('tabs').childNodes;
	for ( var i = 0; i < tabListItems.length; i++) {
		if (tabListItems[i].nodeName == "LI") {
			var tabLink = getFirstChildWithTagName(tabListItems[i], 'A');
			var id = getHash(tabLink.getAttribute('href'));
			tabLinks[id] = tabLink;
			contentDivs[id] = document.getElementById(id);
		}
	}

	var i = 0;

	for ( var id in tabLinks) {
		tabLinks[id].onclick = showTab;
		tabLinks[id].onfocus = function() {
			this.blur()
		};
		if (i == 0)
			tabLinks[id].className = 'j_tab  current_tab';
		i++;
	}
	var i = 0;

	for ( var id in contentDivs) {
		if (i != 0)
			contentDivs[id].className = 'tabContent hide';
		i++;
	}
}

function showTab() {
	var selectedId = getHash(this.getAttribute('href'));

	// Highlight the selected tab, and dim all others.
	// Also show the selected content div, and hide all others.
	for ( var id in contentDivs) {
		if (id == selectedId) {
			tabLinks[id].className = 'j_tab  current_tab';
			contentDivs[id].className = 'tabContent';
		} else {
			tabLinks[id].className = '';
			contentDivs[id].className = 'tabContent hide';
		}
	}
	return false;
}

function getFirstChildWithTagName(element, tagName) {
	for ( var i = 0; i < element.childNodes.length; i++) {
		if (element.childNodes[i].nodeName == tagName)
			return element.childNodes[i];
	}
}

function getHash(url) {
	var hashPos = url.lastIndexOf('#');
	return url.substring(hashPos + 1);
}
/** *******tab 类 end********************** */
