/**
	[Discuz!] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms, Empower to Www.hhuuu.com

	$Id: common.js 29624 2012-04-23 06:56:28Z monkey $
 */
//dz flash焦点图片轮换
function slideshow(el) {	
	var obj = this;
	if(!el.id) el.id = Math.random();
	if(typeof slideshow.entities == 'undefined') {
		slideshow.entities = {};
	}
	this.id = el.id;
	if(slideshow.entities[this.id]) return false;
	slideshow.entities[this.id] = this;

	this.slideshows = [];
	this.slidebar = [];
	this.slideother = [];
	this.slidebarup = '';
	this.slidebardown = '';
	this.slidenum = 0;
	this.slidestep = 0;

	this.container = el;
	this.imgs = [];
	this.imgLoad = [];
	this.imgLoaded = 0;
	this.imgWidth = 0;
	this.imgHeight = 0;

	this.getMEvent = function(ele, value) {
		value = !value ? 'mouseover' : value;
		var mevent = !ele ? '' : ele.getAttribute('mevent');
		mevent = (mevent == 'click' || mevent == 'mouseover') ? mevent : value;
		return mevent;
	};
	
	this.slideshows = $C('slideshow', el);
	this.slideshows = this.slideshows.length>0 ? this.slideshows[0].childNodes : null;
	this.slidebar = $C('slidebar', el);
	this.slidebar = this.slidebar.length>0 ? this.slidebar[0] : null;
	this.barmevent = this.getMEvent(this.slidebar);
	this.slideother = $C('slideother', el);
	this.slidebarup = $C('slidebarup', el);
	this.slidebarup = this.slidebarup.length>0 ? this.slidebarup[0] : null;
	this.barupmevent = this.getMEvent(this.slidebarup, 'click');
	this.slidebardown = $C('slidebardown', el);
	this.slidebardown = this.slidebardown.length>0 ? this.slidebardown[0] : null;
	this.bardownmevent = this.getMEvent(this.slidebardown, 'click');
	this.slidenum = parseInt(this.container.getAttribute('slidenum'));
	this.slidestep = parseInt(this.container.getAttribute('slidestep'));
	this.timestep = parseInt(this.container.getAttribute('timestep'));
	this.timestep = !this.timestep ? 2500 : this.timestep;

	this.index = this.length = 0;
	this.slideshows = !this.slideshows ? filterTextNode(el.childNodes) : filterTextNode(this.slideshows);
	
	this.length = this.slideshows.length;
	for(i=0; i<this.length; i++) {
		this.slideshows[i].style.display = "none";
		_attachEvent(this.slideshows[i], 'mouseover', function(){obj.stop();});
		_attachEvent(this.slideshows[i], 'mouseout', function(){obj.goon();});
	}

	for(i=0, L=this.slideother.length; i<L; i++) {
		for(var j=0;j<this.slideother[i].childNodes.length;j++) {
			if(this.slideother[i].childNodes[j].nodeType == 1) {
				this.slideother[i].childNodes[j].style.display = "none";
			}
		}
	}

	if(!this.slidebar) {
		if(!this.slidenum && !this.slidestep) {
			this.container.parentNode.style.position = 'relative';
			this.slidebar = document.createElement('div');
			this.slidebar.className = 'slidebar';
			this.slidebar.style.position = 'absolute';
			this.slidebar.style.top = '5px';
			this.slidebar.style.left = '4px';
			this.slidebar.style.display = 'none';
			var html = '<ul>';
			for(var i=0; i<this.length; i++) {
				html += '<li on'+this.barmevent+'="slideshow.entities[' + this.id + '].xactive(' + i + '); return false;">' + (i + 1).toString() + '</li>';
			}
			html += '</ul>';
			this.slidebar.innerHTML = html;
			this.container.parentNode.appendChild(this.slidebar);
			this.controls = this.slidebar.getElementsByTagName('li');
		}
	} else {
		this.controls = filterTextNode(this.slidebar.childNodes);
		for(i=0; i<this.controls.length; i++) {
			if(this.slidebarup == this.controls[i] || this.slidebardown == this.controls[i]) continue;
			_attachEvent(this.controls[i], this.barmevent, function(){slidexactive()});
			_attachEvent(this.controls[i], 'mouseout', function(){obj.goon();});
		}
	}
	if(this.slidebarup) {
		_attachEvent(this.slidebarup, this.barupmevent, function(){slidexactive('up')});
	}
	if(this.slidebardown) {
		_attachEvent(this.slidebardown, this.bardownmevent, function(){slidexactive('down')});
	}
	this.activeByStep = function(index) {
		var showindex = 0,i = 0;
		if(index == 'down') {
			showindex = this.index + 1;
			if(showindex > this.length) {
				this.runRoll();
			} else {
				for (i = 0; i < this.slidestep; i++) {
					if(showindex >= this.length) showindex = 0;
					this.index = this.index - this.slidenum + 1;
					if(this.index < 0) this.index = this.length + this.index;
					this.active(showindex);
					showindex++;
				}
			}
		} else if (index == 'up') {
			var tempindex = this.index;
			showindex = this.index - this.slidenum;
			if(showindex < 0) return false;
			for (i = 0; i < this.slidestep; i++) {
				if(showindex < 0) showindex = this.length - Math.abs(showindex);
				this.active(showindex);
				this.index = tempindex = tempindex - 1;
				if(this.index <0) this.index = this.length - 1;
				showindex--;
			}
		}
		return false;
	};
	this.active = function(index) {
		this.slideshows[this.index].style.display = "none";
		this.slideshows[index].style.display = "block";
		if(this.controls && this.controls.length > 0) {
			this.controls[this.index].className = '';
			this.controls[index].className = 'on';
		}
		for(var i=0,L=this.slideother.length; i<L; i++) {
			this.slideother[i].childNodes[this.index].style.display = "none";
			this.slideother[i].childNodes[index].style.display = "block";
		}
		this.index = index;
	};
	this.xactive = function(index) {
		if(!this.slidenum && !this.slidestep) {
			this.stop();
			if(index == 'down') index = this.index == this.length-1 ? 0 : this.index+1;
			if(index == 'up') index = this.index == 0 ? this.length-1 : this.index-1;
			this.active(index);
		} else {
			this.activeByStep(index);
		}
	};
	this.goon = function() {
		this.stop();
		var curobj = this;
		this.timer = setTimeout(function () {
			curobj.run();
		}, this.timestep);
	};
	this.stop = function() {
		clearTimeout(this.timer);
	};
	this.run = function() {
		var index = this.index + 1 < this.length ? this.index + 1 : 0;
		if(!this.slidenum && !this.slidestep) {
			this.active(index);
		} else {
			this.activeByStep('down');
		}
		var ss = this;
		this.timer = setTimeout(function(){
			ss.run();
		}, this.timestep);
	};

	this.runRoll = function() {
		for(var i = 0; i < this.slidenum; i++) {
			if(this.slideshows[i] && typeof this.slideshows[i].style != 'undefined') this.slideshows[i].style.display = 'block';
			for(var j=0,L=this.slideother.length; j<L; j++) {
				this.slideother[j].childNodes[i].style.display = 'block';
			}
		}
		this.index = this.slidenum - 1;
	};
	var imgs = this.slideshows.length ? this.slideshows[0].parentNode.getElementsByTagName('img') : [];
	for(i=0, L=imgs.length; i<L; i++) {
		this.imgs.push(imgs[i]);
		this.imgLoad.push(new Image());
		this.imgLoad[i].onerror = function (){obj.imgLoaded ++;};
		this.imgLoad[i].src = this.imgs[i].src;
	}

	this.getSize = function () {
		if(this.imgs.length == 0) return false;
		var img = this.imgs[0];
		this.imgWidth = img.width ? parseInt(img.width) : 0;
		this.imgHeight = img.height ? parseInt(img.height) : 0;
		var ele = img.parentNode;
		while ((!this.imgWidth || !this.imgHeight) && !hasClass(ele,'slideshow') && ele != document.body) {
			this.imgWidth = ele.style.width ? parseInt(ele.style.width) : 0;
			this.imgHeight = ele.style.height ? parseInt(ele.style.height) : 0;
			ele = ele.parentNode;
		}
		return true;
	};

	this.getSize();

	this.checkLoad = function () {
		var obj = this;
		this.container.style.display = 'block';
		for(i = 0;i < this.imgs.length;i++) {
			if(this.imgLoad[i].complete && !this.imgLoad[i].status) {
				this.imgLoaded++;
				this.imgLoad[i].status = 1;
			}
		}
		var percentEle = $(this.id+'_percent');
		if(this.imgLoaded < this.imgs.length) {
			if (!percentEle) {
				var dom = document.createElement('div');
				dom.id = this.id+"_percent";
				dom.style.width = this.imgWidth ? this.imgWidth+'px' : '150px';
				dom.style.height = this.imgHeight ? this.imgHeight+'px' : '150px';
				dom.style.lineHeight = this.imgHeight ? this.imgHeight+'px' : '150px';
				dom.style.backgroundColor = '#ccc';
				dom.style.textAlign = 'center';
				dom.style.top = '0';
				dom.style.left = '0';
				dom.style.marginLeft = 'auto';
				dom.style.marginRight = 'auto';
				this.slideshows[0].parentNode.appendChild(dom);
				percentEle = dom;
			}
			el.parentNode.style.position = 'relative';
			percentEle.innerHTML = (parseInt(this.imgLoaded / this.imgs.length * 100)) + '%';
			setTimeout(function () {obj.checkLoad();}, 100);
		} else {
			if (percentEle) percentEle.parentNode.removeChild(percentEle);
			if(this.slidebar) this.slidebar.style.display = '';
			this.index = this.length - 1 < 0 ? 0 : this.length - 1;
			if(this.slideshows.length > 0) {
				if(!this.slidenum || !this.slidestep) {
					this.run();
				} else {
					this.runRoll();
				}
			}
		}
	};
	this.checkLoad();
}
function filterTextNode(list) {
	var newlist = [];
	for(var i=0; i<list.length; i++) {
		if (list[i].nodeType == 1) {
			newlist.push(list[i]);
		}
	}
	return newlist;
}
function _runslideshow() {	
	var slideshows = $C('slidebox');	
	for(var i=0,L=slideshows.length; i<L; i++) {
		
	
		new slideshow(slideshows[i]);
		
	}	
}

function runslideshow() {	
	_runslideshow();
}
