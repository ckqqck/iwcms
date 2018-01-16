
(function(win, udf) {
    'use strict';
    var prefix = 'weui-toast',
        defaults = {
            // 动画时间
            duration: 1,

            delay: 1000,

            esc: -1,

            // 标题，为空不显示
            title: '',

            // 消息内容
            msg: 'Hi!',
            
            // 消息类型:inverse/warning/error/success/info/muted(默认)
            type: '',

            // 层级
            zIndex: 99999,

            // 消息位置，默认水平垂直居中
            position: null
        },
    // 上一条消息实例对象
        lastMsg,
        timeid;



    $.msg = function(type, msg){
        var options = {};
        if($.type(type)==='object') options = type;
        else if(arguments.length===2){
            options.type = type;
            options.msg = msg;
        }else options.msg = type;

        return new Msg($.extend({}, defaults, options))._init();
    };
    $.msg.defaults = defaults;
    // 鼠标悬停与移开
    $(document)
        .on('mouseenter', '.' + prefix, function(){
            if(timeid) clearTimeout(timeid);
        })
        .on('mouseleave', '.' + prefix, function(){
            if(timeid) clearTimeout(timeid);
            if(lastMsg && !lastMsg.options.buttons){
                timeid = setTimeout(function(){
                    lastMsg.hide();
                }, lastMsg.options.delay);
            }
        })
        .on('click', '.' + prefix + ' button', function(e){
            if(lastMsg) lastMsg.hide(e);
        })
        .keyup(function(e){
            if(e.which==27 && lastMsg) lastMsg.hide();
        });


    function Msg(options){
        this.options = options;
    }

    Msg.prototype = {
        _init: function(){
            var that = this,
                options = that.options,
                width = 100/(options.buttons && options.buttons.length||1) + '%',
                html = '<div style="display:none" class="' + prefix + '">';
            if(options.type)html+='<i class="' + options.type + ' weui-icon_toast"></i>';
            if(options.title)html+='<div class="' + prefix + 'weui-toast">'+options.title+'</div>';
            html  += '<p class="weui-toast__content">' + options.msg + '</p>';


            that.$msg = $(html + '</div>').appendTo('body');
            that._show();

            return that;
        },
        _show: function(){
            var that = this,
                options = that.options,
                $msg = that.$msg;

            if(lastMsg){
                lastMsg.hide(function(){
                    $msg.fadeIn(options.duration);
                    next();
                });
            }
            else{
                $msg.fadeIn(options.duration);
                next();
            }

            function next(){
                lastMsg = that;
                $msg.data(prefix, that);

                if(timeid) clearTimeout(timeid);
                if(!options.buttons){
                    timeid = setTimeout(function(){
                        that.hide();
                    }, options.delay);
                }
            }
        },
        hide: function(callback_event){
            var that = this,
                options = that.options,
                $msg = that.$msg,
                isAutoHide = $.isFunction(callback_event),
                callback = isAutoHide ? callback_event : $.noop,
                e = isAutoHide ? udf: callback_event;

            if(timeid) clearTimeout(timeid);
            timeid = 0;

            $msg.stop(!0, !0).fadeOut(options.duration, function(){
                var index, cb;
                $msg.remove();
                lastMsg = null;
                if(that.$bg) that.$bg.remove();
                callback();
                // 不是自动关闭的 && 有按钮的
                if(!isAutoHide && that.options.buttons){
                    index = e && $(e.target).length ? $(e.target).index() : options.esc;
                    cb = that.callbacks.slice(index);
                    cb = cb.length ? cb[0] : $.noop;
                    cb();
                }
            });
        }
    };
    function _getKeyVal(obj){
        for(var i in obj)
            return {
                key: i,
                val: obj[i]
            };
    }
})(this);