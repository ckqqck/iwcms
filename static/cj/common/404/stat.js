window.QZFL = window.QZFL || {};
QZFL.pingSender = function(a, b, c) {
    var d = QZFL.pingSender,
    e, f;
    a && (c = c || {},
    e = "sndImg_" + d._sndCount++, f = d._sndPool[e] = new Image, f.iid = e, f.onload = f.onerror = f.ontimeout = function(a) {
        return function(b) {
            b = b || window.event || {
                type: "timeout"
            };
            void("function" == typeof c[b.type] ? setTimeout(function(a, b) {
                return function() {
                    c[a]({
                        type: a,
                        duration: (new Date).getTime() - b
                    })
                }
            } (b.type, a._s_), 0) : 0);
            QZFL.pingSender._clearFn(b, a)
        }
    } (f), "function" == typeof c.timeout && setTimeout(function() {
        f.ontimeout && f.ontimeout({
            type: "timeout"
        })
    },
    "number" == typeof c.timeoutValue ? Math.max(100, c.timeoutValue) : 5E3), void("number" == typeof b ? setTimeout(function() {
        f._s_ = (new Date).getTime();
        f.src = a
    },
    b = Math.max(0, b)) : f.src = a))
};
QZFL.pingSender._sndPool = {};
QZFL.pingSender._sndCount = 0;
QZFL.pingSender._clearFn = function(a, b) {
    var c = QZFL.pingSender;
    b && (c._sndPool[b.iid] = b.onload = b.onerror = b.ontimeout = b._s_ = null, delete c._sndPool[b.iid], c._sndCount--)
};
"undefined" == typeof window.TCISD && (window.TCISD = {});
TCISD.pv = function(a, b, c) {
    setTimeout(function() {
        TCISD.pv.send(a, b, c)
    },
    0)
}; (function() {
    var a = [],
    b = null,
    c,
    d = !1,
    e = {
        send: function(d, h, g, l, k, m, n) {
            a.push({
                dm: d,
                url: h,
                rdm: g || "",
                rurl: l || "",
                arg: n && n.arg || "",
                flashVersion: k
            });
            b || (b = setTimeout(function() {
                e.doSend(m)
            },
            m));
            c || (c = e.onUnload, window.attachEvent ? (window.attachEvent("onbeforeunload", c), window.attachEvent("onunload", c)) : window.addEventListener && (window.addEventListener("beforeunload", c, !1), window.addEventListener("unload", c, !1)))
        },
        onUnload: function() {
            d = !0;
            e.doSend();
            setTimeout(function() {},
            1E3)
        },
        doSend: function(c) {
            b = null;
            if (a.length) {
                for (var h, g = 0; g < a.length && !(h = e.getUrl(a.slice(0, a.length - g)), 2E3 > h.length); g++);
                a = a.slice(Math.max(a.length - g, 1));
                QZFL.pingSender(h);
                0 < g && (d ? e.doSend() : b = setTimeout(e.doSend, "undefined" == typeof c ? 5E3: c))
            }
        },
        getUrl: function(a) {
            for (var b = a[0], b = {
                dm: escape(b.dm),
                url: escape(b.url),
                rdm: escape(b.rdm),
                rurl: escape(b.rurl),
                arg: escape(b.arg),
                flash: b.flashVersion,
                pgv_pvid: e.getId(),
                sds: Math.random()
            },
            c = [], d = 1; d < a.length; d++) {
                var k = a[d];
                c.push([escape(k.dm), escape(k.url), escape(k.rdm), escape(k.rurl)].join(":"))
            }
            c.length && (b.ex_dm = c.join(";"));
            a = [];
            for (k in b) a.push(k + "=" + b[k]);
            return [TCISD.pv.config.webServerInterfaceURL, "?cc=-&ct=-&java=1&lang=-&pf=-&scl=-&scr=-&tt=-&tz=-8&vs=3.3&", a.join("&")].join("")
        },
        getId: function() {
            var a, b; (a = document.cookie.match(TCISD.pv._cookieP)) && a.length && 1 < a.length ? a = a[1] : (a = Math.round(2147483647 * Math.random()) * (new Date).getUTCMilliseconds() % 1E10, document.cookie = "pgv_pvid=" + a + "; path=/; domain=qq.com; expires=Sun, 18 Jan 2038 00:00:00 GMT;");
            document.cookie.match(TCISD.pv._cookieSSID) || (b = Math.round(2147483647 * Math.random()) * (new Date).getUTCMilliseconds() % 1E10, document.cookie = "pgv_info=ssid=s" + b + "; path=/; domain=qq.com;");
            return a
        }
    };
    TCISD.pv.send = function(a, b, c) {
        a = a || location.hostname || "-";
        b = b || location.pathname;
        c = c || {};
        c.referURL = c.referURL || document.referrer;
        var d, k;
        d = c.referURL.split(TCISD.pv._urlSpliter);
        d = d[0];
        d = d.split("/");
        k = d[2] || "-";
        d = "/" + d.slice(3).join("/");
        c.referDomain = c.referDomain || k;
        c.referPath = c.referPath || d;
        c.timeout = "undefined" == typeof c.timeout ? 5E3: c.timeout;
        e.send(a, b, c.referDomain, c.referPath, c.flashVersion || "", c.timeout, c)
    }
})();
TCISD.pv._urlSpliter = /[\?\#]/;
TCISD.pv._cookieP = /(?:^|;+|\s+)pgv_pvid=([^;]*)/i;
TCISD.pv._cookieSSID = /(?:^|;+|\s+)pgv_info=([^;]*)/i;
TCISD.pv.config = {
    webServerInterfaceURL: "http://pingfore.qq.com/pingd"
};
window.TCISD = window.TCISD || {};
TCISD.createTimeStat = function(a, b, c) {
    var d = TCISD.TimeStat,
    e;
    b = b || d.config.defaultFlagArray;
    b = b.join("_");
    a = a || b;
    return (e = d._instances[a]) ? e: new d(a, b, c)
};
TCISD.markTime = function(a, b, c, d) {
    b = TCISD.createTimeStat(b, c);
    b.mark(a, d);
    return b
};
TCISD.TimeStat = function(a, b, c) {
    var d = TCISD.TimeStat;
    this.sName = a;
    this.flagStr = b;
    this.timeStamps = [null];
    this.zero = d.config.zero;
    c && (this.standard = c);
    d._instances[a] = this;
    d._count++
};
TCISD.TimeStat.prototype.getData = function(a) {
    var b = {},
    c, d;
    a && (c = this.timeStamps[a]) ? (d = new Date, d.setTime(this.zero.getTime()), b.zero = d, d = new Date, d.setTime(c.getTime()), b.time = d, b.duration = c - this.zero, this.standard && (d = this.standard.timeStamps[a]) && (b.delayRate = (b.duration - d) / d)) : b.timeStamps = TCISD.TimeStat._cloneData(this.timeStamps);
    return b
};
TCISD.TimeStat._cloneData = function(a) {
    if ("object" == typeof a) {
        var b = a.sort ? [] : {},
        c;
        for (c in a) b[c] = TCISD.TimeStat._cloneData(a[c]);
        return b
    }
    return "function" == typeof a ? Object: a
};
TCISD.TimeStat.prototype.mark = function(a, b) {
    a = a || this.timeStamps.length;
    this.timeStamps[Math.min(Math.abs(a), 99)] = b || new Date;
    return this
};
TCISD.TimeStat.prototype.merge = function(a) {
    var b;
    if (a && "object" == typeof a.timeStamps && a.timeStamps.length) this.timeStamps = a.timeStamps.concat(this.timeStamps.slice(1));
    else return this;
    if (a.standard && (b = a.standard.timeStamps)) {
        this.standard || (this.standard = {}); (a = this.standard.timeStamps) || (a = this.standard.timeStamps = {});
        for (var c in b) a[c] || (a[c] = b[c])
    }
    return this
};
TCISD.TimeStat.prototype.setZero = function(a) {
    if ("object" != typeof a || "function" != typeof a.getTime) a = new Date;
    this.zero = a;
    return this
};
TCISD.TimeStat.prototype.report = function(a) {
    var b = TCISD.TimeStat,
    c = [],
    d;
    if (1 > (d = this.timeStamps).length) return this;
    c.push(a && a.split("?")[0] || b.config.webServerInterfaceURL);
    c.push("?");
    a = this.zero;
    for (var e = 1,
    f = d.length; e < f; ++e) d[e] && c.push(e, "=", d[e].getTime ? d[e] - a: d[e], "&");
    d = this.flagStr.split("_");
    e = 0;
    for (f = b.config.maxFlagArrayLength; e < f; ++e) d[e] && c.push("flag", e + 1, "=", d[e], "&");
    if (b.pluginList && b.pluginList.length) for (e = 0, f = b.pluginList.length; e < f; ++e)"function" == typeof b.pluginList[e] && b.pluginList[e](c);
    c.push("sds=", Math.random());
    QZFL.pingSender && QZFL.pingSender(c.join(""));
    return this
};
TCISD.TimeStat._instances = {};
TCISD.TimeStat._count = 0;
TCISD.TimeStat.config = {
    webServerInterfaceURL: "http://isdspeed.qq.com/cgi-bin/r.cgi",
    defaultFlagArray: [175, 115, 1],
    maxFlagArrayLength: 6,
    zero: window._s_ || new Date
};
window.TCISD = window.TCISD || {};
TCISD.valueStat = function(a, b, c, d) {
    setTimeout(function() {
        TCISD.valueStat.send(a, b, c, d)
    },
    0)
};
TCISD.valueStat.send = function(a, b, c, d) {
    var e = TCISD.valueStat,
    f = e.config,
    h = f.defaultParams,
    g = [];
    a = a || h.statId;
    b = b || h.resultType;
    c = c || h.returnValue;
    d = d || h;
    "number" != typeof d.reportRate && (d.reportRate = 1);
    d.reportRate = Math.round(Math.max(d.reportRate, 1));
    if (d.fixReportRateOnly || TCISD.valueStat.config.reportAll || !(1 < d.reportRate && 1 < Math.random() * d.reportRate)) {
        g.push(d.reportURL || f.webServerInterfaceURL, "?");
        g.push("flag1=", a, "&", "flag2=", b, "&", "flag3=", c, "&", "1=", TCISD.valueStat.config.reportAll ? 1 : d.reportRate, "&", "2=", d.duration, "&");
        "undefined" != typeof d.extendField && g.push("4=", d.extendField, "&");
        if (e.pluginList && e.pluginList.length) for (a = 0, b = e.pluginList.length; a < b; ++a)"function" == typeof e.pluginList[a] && e.pluginList[a](g);
        g.push("sds=", Math.random());
        QZFL.pingSender(g.join(""))
    }
};
TCISD.valueStat.config = {
    webServerInterfaceURL: "http://isdspeed.qq.com/cgi-bin/v.cgi",
    defaultParams: {
        statId: 1,
        resultType: 1,
        returnValue: 11,
        reportRate: 1,
        duration: 1E3
    },
    reportAll: !1
};
"undefined" == typeof window.TCISD && (window.TCISD = {});
TCISD.hotClick = function(a, b, c, d) {
    TCISD.hotClick.send(a, b, c, d)
};
TCISD.hotClick.send = function(a, b, c, d) {
    d = d || {};
    var e = TCISD.hotClick,
    f = d.x || 9999,
    h = d.y || 9999,
    g = d.doc || document,
    g = g.parentWindow || g.defaultView,
    l = g._hotClick_params || {};
    c = c || l.url || g.location.pathname || "-";
    b = b || l.domain || g.location.hostname || "-";
    if (d.abs || e.isReport()) c = [e.config.webServerInterfaceURL, "?dm=", b + ".hot", "&url=", escape(c), "&tt=-", "&hottag=", a, "&hotx=", f, "&hoty=", h, "&rand=", Math.random()],
    QZFL.pingSender(c.join(""))
};
TCISD.hotClick._arrSend = function(a, b) {
    for (var c = 0,
    d = a.length; c < d; c++) TCISD.hotClick.send(a[c].tag, a[c].domain, a[c].url, {
        doc: b
    })
};
TCISD.hotClick.click = function(a, b) {
    var c = TCISD.hotClick,
    d = c.getTags(QZFL.event.getTarget(a), b);
    c._arrSend(d, b)
};
TCISD.hotClick.getTags = function(a, b) {
    for (var c = [], d = (b.parentWindow || b.defaultView)._hotClick_params.rules, e, f = 0, h = d.length; f < h; f++)(e = d[f](a)) && c.push(e);
    return c
};
TCISD.hotClick.defaultRule = function(a) {
    var b; (a = a.getAttribute("hottag")) && -1 < a.indexOf("|") && (b = a.split("|"), a = b[0], b = b[1]);
    return a ? {
        tag: a,
        domain: b
    }: null
};
TCISD.hotClick.config = TCISD.hotClick.config || {
    webServerInterfaceURL: "http://pinghot.qq.com/pingd",
    reportRate: 1,
    domain: null,
    url: null
};
TCISD.hotClick._reportRate = "undefined" == typeof TCISD.hotClick._reportRate ? -1 : TCISD.hotClick._reportRate;
TCISD.hotClick.isReport = function() {
    var a = TCISD.hotClick,
    b;
    if ( - 1 != a._reportRate) return a._reportRate;
    b = Math.round(a.config.reportRate);
    return 1 < b && 1 < Math.random() * b ? a._reportRate = 0 : a._reportRate = 1
};
TCISD.hotClick.setConfig = function(a) {
    a = a || {};
    var b = a.doc || document,
    b = b.parentWindow || b.defaultView;
    a.domain && (b._hotClick_params.domain = a.domain);
    a.url && (b._hotClick_params.url = a.url);
    a.reportRate && (b._hotClick_params.reportRate = a.reportRate)
};
TCISD.hotAddRule = function(a, b) {
    b = b || {};
    var c = b.doc || document,
    c = c.parentWindow || c.defaultView;
    if (c._hotClick_params) return c._hotClick_params.rules.push(a),
    c._hotClick_params.rules
};
TCISD.hotClickWatch = function(a) {
    a = a || {};
    var b = TCISD.hotClick,
    c, d;
    d = a.doc = a.doc || document;
    c = d.parentWindow || d.defaultView;
    d._hotClick_init || (c._hotClick_params || (c._hotClick_params = {},
    c._hotClick_params.rules = [b.defaultRule]), b.setConfig(a), c.QZFL.event.addEvent(d, "click", b.click, [d]))
};
"undefined" == typeof window.TCISD && (window.TCISD = {});
TCISD.stringStat = function(a, b, c) {
    setTimeout(function() {
        TCISD.stringStat.send(a, b, c)
    },
    0)
};
TCISD.stringStat.send = function(a, b, c) {
    var d = TCISD.stringStat.config,
    e = d.defaultParams,
    f = [],
    h = !1;
    a = a || e.dataId;
    c = c || e;
    h = c.method && "post" == c.method ? !0 : !1;
    if ("object" == typeof b) {
        for (var g in b) b[g].length && 1024 < b[g].length && (b[g] = b[g].substring(0, 1024));
        "number" != typeof c.reportRate && (c.reportRate = 1);
        c.reportRate = Math.round(Math.max(c.reportRate, 1));
        1 < c.reportRate && 1 < Math.random() * c.reportRate || (h && QZFL.FormSender ? (b.dataId = a, b.sds = Math.random(), a = new QZFL.FormSender(d.webServerInterfaceURL, "post", b, "UTF-8"), a.send()) : (b = TCISD.stringStat.genHttpParamString(b), f.push(d.webServerInterfaceURL, "?"), f.push("dataId=", a), f.push("&", b, "&"), f.push("ted=", Math.random()), QZFL.pingSender(f.join(""))))
    }
};
TCISD.stringStat.config = {
    webServerInterfaceURL: "http://s.isdspeed.qq.com/cgi-bin/s.fcg",
    defaultParams: {
        dataId: 1,
        reportRate: 1,
        method: "get"
    }
};
TCISD.stringStat.genHttpParamString = function(a) {
    var b = [],
    c;
    for (c in a) b.push(c + "=" + window.encodeURIComponent(a[c]));
    return b.join("&")
};
/* |xGv00|b66887fdf6d9babbf04917474e524afa */
