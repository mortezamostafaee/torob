(function(d){let b=window.WPD.ajaxsearchpro.helpers;d.fn.extend(window.WPD.ajaxsearchpro.plugin,{openCompact:function(){let a=this;a.n("search").is("[asp-compact-w]")||(a.n("probox").attr("asp-compact-w",a.n("probox").width()),a.n("search").attr("asp-compact-w",a.n("search").width()));a.n("search").css({width:a.n("search").width()+"px"});a.n("probox").css({width:"auto"});setTimeout(function(){a.n("search").find(".probox>div:not(.promagnifier)").removeClass("hiddend")},80);clearTimeout(a.timeouts.compactBeforeOpen);
a.timeouts.compactBeforeOpen=setTimeout(function(){let c;c="phone"==b.deviceType()?a.o.compact.width_phone:"tablet"==b.deviceType()?a.o.compact.width_tablet:a.o.compact.width;c=b.Hooks.applyFilters("asp_compact_width",c,a.o.id,a.o.iid);c=b.wp_hooks_apply_filters("asp_compact_width",c,a.o.id,a.o.iid);c=isNaN(c)?c:c+"px";a.n("search").css({"max-width":c,width:c});1==a.o.compact.overlay&&(a.n("search").css("z-index",999999),a.n("searchsettings").css("z-index",999999),a.n("resultsDiv").css("z-index",
999999),a.n("trythis").css("z-index",999998),d("#asp_absolute_overlay").css({opacity:1,width:"100%",height:"100%","z-index":999990}));a.n("search").attr("asp-compact","open")},50);clearTimeout(a.timeouts.compactAfterOpen);a.timeouts.compactAfterOpen=setTimeout(function(){a.resize();a.n("trythis").css({display:"block"});1==a.o.compact.enabled&&"static"!=a.o.compact.position&&a.n("trythis").css({top:a.n("search").offset().top+a.n("search").outerHeight(!0)+"px",left:a.n("search").offset().left+"px"});
a.o.compact.focus&&a.n("text").get(0).focus();a.n("text").trigger("focus");a.scrolling()},500)},closeCompact:function(){let a=this;clearTimeout(a.timeouts.compactBeforeOpen);clearTimeout(a.timeouts.compactAfterOpen);a.timeouts.compactBeforeOpen=setTimeout(function(){a.n("search").attr("asp-compact","closed")},50);a.n("search").find(".probox>div:not(.promagnifier)").addClass("hiddend");a.n("search").css({width:"auto"});a.n("probox").css({width:a.n("probox").attr("asp-compact-w")+"px"});a.n("trythis").css({left:a.n("search").position().left,
display:"none"});1==a.o.compact.overlay&&(a.n("search").css("z-index",""),a.n("searchsettings").css("z-index",""),a.n("resultsDiv").css("z-index",""),a.n("trythis").css("z-index",""),d("#asp_absolute_overlay").css({opacity:0,width:0,height:0,"z-index":0}))}})})(WPD.dom);
(function(d){d.fn.extend(window.WPD.ajaxsearchpro.plugin,{initCompactEvents:function(){let b=this;b.n("promagnifier").on("click",function(){let a=b.n("search").attr("asp-compact")||"closed";b.hideSettings();b.hideResults();"closed"==a?(b.openCompact(),b.n("text").trigger("focus")):1==b.o.compact.closeOnMagnifier&&(b.closeCompact(),b.searchAbort(),b.n("proloading").css("display","none"))})}})})(WPD.dom);
(function(d){d.fn.extend(window.WPD.ajaxsearchpro.plugin,{initCompact:function(){let b=this;1==b.o.compact.enabled&&"fixed"!=b.o.compact.position&&(b.o.compact.overlay=0);1==b.o.compact.enabled&&b.n("trythis").css({display:"none"});1==b.o.compact.enabled&&"fixed"==b.o.compact.position&&window.WPD.intervalUntilExecute(function(){let a=d("body");b.nodes.container=b.n("search").closest(".asp_w_container");a.append(b.n("search").detach());a.append(b.n("trythis").detach());b.n("search").css({top:b.n("search").position().top+
"px"})},function(){return"fixed"==b.n("search").css("position")})}})})(WPD.dom);
