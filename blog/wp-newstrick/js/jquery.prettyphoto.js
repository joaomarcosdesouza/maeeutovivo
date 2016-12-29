/* ------------------------------------------------------------------------
  Class: prettyPhoto
  Use: Lightbox clone for jQuery
  Author: Stephane Caron (http://www.no-margin-for-errors.com)
  Version: 3.1.6
------------------------------------------------------------------------- */
!function(a){function b(){var a=location.href;return hashtag=-1!==a.indexOf("#prettyPhoto")?decodeURI(a.substring(a.indexOf("#prettyPhoto")+1,a.length)):!1,hashtag&&(hashtag=hashtag.replace(/<|>/g,"")),hashtag}function c(){"undefined"!=typeof theRel&&(location.hash=theRel+"/"+rel_index+"/")}function d(){-1!==location.href.indexOf("#prettyPhoto")&&(location.hash="prettyPhoto")}function e(a,b){a=a.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var c="[\\?&]"+a+"=([^&#]*)",d=new RegExp(c),e=d.exec(b);return null==e?"":e[1]}a.prettyPhoto={version:"3.1.6"},a.fn.prettyPhoto=function(f){function r(){a(".pp_loaderIcon").hide(),projectedTop=scroll_pos.scrollTop+(o/2-i.containerHeight/2),projectedTop<0&&(projectedTop=0),$ppt.fadeTo(settings.animation_speed,1),$pp_pic_holder.find(".pp_content").animate({height:i.contentHeight,width:i.contentWidth},settings.animation_speed),$pp_pic_holder.animate({top:projectedTop,left:p/2-i.containerWidth/2<0?0:p/2-i.containerWidth/2,width:i.containerWidth},settings.animation_speed,function(){$pp_pic_holder.find(".pp_hoverContainer,#fullResImage").height(i.height).width(i.width),$pp_pic_holder.find(".pp_fade").fadeIn(settings.animation_speed),isSet&&"image"==w(pp_images[set_position])?$pp_pic_holder.find(".pp_hoverContainer").show():$pp_pic_holder.find(".pp_hoverContainer").hide(),settings.allow_expand&&(i.resized?a("a.pp_expand,a.pp_contract").show():a("a.pp_expand").hide()),!settings.autoplay_slideshow||q||j||a.prettyPhoto.startSlideshow(),settings.changepicturecallback(),j=!0}),A(),f.ajaxcallback()}function s(b){$pp_pic_holder.find("#pp_full_res object,#pp_full_res embed").css("visibility","hidden"),$pp_pic_holder.find(".pp_fade").fadeOut(settings.animation_speed,function(){a(".pp_loaderIcon").show(),b()})}function t(b){b>1?a(".pp_nav").show():a(".pp_nav").hide()}function u(a,b){if(resized=!1,v(a,b),imageWidth=a,imageHeight=b,(n>p||m>o)&&doresize&&settings.allow_resize&&!h){for(resized=!0,fitting=!1;!fitting;)n>p?(imageWidth=p-200,imageHeight=b/a*imageWidth):m>o?(imageHeight=o-200,imageWidth=a/b*imageHeight):fitting=!0,m=imageHeight,n=imageWidth;(n>p||m>o)&&u(n,m),v(imageWidth,imageHeight)}return{width:Math.floor(imageWidth),height:Math.floor(imageHeight),containerHeight:Math.floor(m),containerWidth:Math.floor(n)+2*settings.horizontal_padding,contentHeight:Math.floor(k),contentWidth:Math.floor(l),resized:resized}}function v(b,c){b=parseFloat(b),c=parseFloat(c),$pp_details=$pp_pic_holder.find(".pp_details"),$pp_details.width(b),detailsHeight=parseFloat($pp_details.css("marginTop"))+parseFloat($pp_details.css("marginBottom")),$pp_details=$pp_details.clone().addClass(settings.theme).width(b).appendTo(a("body")).css({position:"absolute",top:-1e4}),detailsHeight+=$pp_details.height(),detailsHeight=detailsHeight<=34?36:detailsHeight,$pp_details.remove(),$pp_title=$pp_pic_holder.find(".ppt"),$pp_title.width(b),titleHeight=parseFloat($pp_title.css("marginTop"))+parseFloat($pp_title.css("marginBottom")),$pp_title=$pp_title.clone().appendTo(a("body")).css({position:"absolute",top:-1e4}),titleHeight+=$pp_title.height(),$pp_title.remove(),k=c+detailsHeight,l=b,m=k+titleHeight+$pp_pic_holder.find(".pp_top").height()+$pp_pic_holder.find(".pp_bottom").height(),n=b}function w(a){return a.match(/youtube\.com\/watch/i)||a.match(/youtu\.be/i)?"youtube":a.match(/vimeo\.com/i)?"vimeo":a.match(/\b.mov\b/i)?"quicktime":a.match(/\b.swf\b/i)?"flash":a.match(/\biframe=true\b/i)?"iframe":a.match(/\bajax=true\b/i)?"ajax":a.match(/\bcustom=true\b/i)?"custom":"#"==a.substr(0,1)?"inline":"image"}function x(){if(doresize&&"undefined"!=typeof $pp_pic_holder){if(scroll_pos=y(),contentHeight=$pp_pic_holder.height(),contentwidth=$pp_pic_holder.width(),projectedTop=o/2+scroll_pos.scrollTop-contentHeight/2,projectedTop<0&&(projectedTop=0),contentHeight>o)return;$pp_pic_holder.css({top:projectedTop,left:p/2+scroll_pos.scrollLeft-contentwidth/2})}}function y(){return self.pageYOffset?{scrollTop:self.pageYOffset,scrollLeft:self.pageXOffset}:document.documentElement&&document.documentElement.scrollTop?{scrollTop:document.documentElement.scrollTop,scrollLeft:document.documentElement.scrollLeft}:document.body?{scrollTop:document.body.scrollTop,scrollLeft:document.body.scrollLeft}:void 0}function z(){o=a(window).height(),p=a(window).width(),"undefined"!=typeof $pp_overlay&&$pp_overlay.height(a(document).height()).width(p)}function A(){isSet&&settings.overlay_gallery&&"image"==w(pp_images[set_position])?(itemWidth=57,navWidth="facebook"==settings.theme||"pp_default"==settings.theme?50:30,itemsPerPage=Math.floor((i.containerWidth-100-navWidth)/itemWidth),itemsPerPage=itemsPerPage<pp_images.length?itemsPerPage:pp_images.length,totalPage=Math.ceil(pp_images.length/itemsPerPage)-1,0==totalPage?(navWidth=0,$pp_gallery.find(".pp_arrow_next,.pp_arrow_previous").hide()):$pp_gallery.find(".pp_arrow_next,.pp_arrow_previous").show(),galleryWidth=itemsPerPage*itemWidth,fullGalleryWidth=pp_images.length*itemWidth,$pp_gallery.css("margin-left",-(galleryWidth/2+navWidth/2)).find("div:first").width(galleryWidth+5).find("ul").width(fullGalleryWidth).find("li.selected").removeClass("selected"),goToPage=Math.floor(set_position/itemsPerPage)<totalPage?Math.floor(set_position/itemsPerPage):totalPage,a.prettyPhoto.changeGalleryPage(goToPage),$pp_gallery_li.filter(":eq("+set_position+")").addClass("selected")):$pp_pic_holder.find(".pp_content").unbind("mouseenter mouseleave")}function B(){if(settings.social_tools&&(facebook_like_link=settings.social_tools.replace("{location_href}",encodeURIComponent(location.href))),settings.markup=settings.markup.replace("{pp_social}",""),a("body").append(settings.markup),$pp_pic_holder=a(".pp_pic_holder"),$ppt=a(".ppt"),$pp_overlay=a("div.pp_overlay"),isSet&&settings.overlay_gallery){currentGalleryPage=0,toInject="";for(var c=0;c<pp_images.length;c++)pp_images[c].match(/\b(jpg|jpeg|png|gif)\b/gi)?(classname="",img_src=pp_images[c]):(classname="default",img_src=""),toInject+="<li class='"+classname+"'><a href='#'><img src='"+img_src+"' width='50' alt='' /></a></li>";toInject=settings.gallery_markup.replace(/{gallery}/g,toInject),$pp_pic_holder.find("#pp_full_res").after(toInject),$pp_gallery=a(".pp_pic_holder .pp_gallery"),$pp_gallery_li=$pp_gallery.find("li"),$pp_gallery.find(".pp_arrow_next").click(function(){return a.prettyPhoto.changeGalleryPage("next"),a.prettyPhoto.stopSlideshow(),!1}),$pp_gallery.find(".pp_arrow_previous").click(function(){return a.prettyPhoto.changeGalleryPage("previous"),a.prettyPhoto.stopSlideshow(),!1}),$pp_pic_holder.find(".pp_content").hover(function(){$pp_pic_holder.find(".pp_gallery:not(.disabled)").fadeIn()},function(){$pp_pic_holder.find(".pp_gallery:not(.disabled)").fadeOut()}),itemWidth=57,$pp_gallery_li.each(function(b){a(this).find("a").click(function(){return a.prettyPhoto.changePage(b),a.prettyPhoto.stopSlideshow(),!1})})}settings.slideshow&&($pp_pic_holder.find(".pp_nav").prepend('<a href="#" class="pp_play">Play</a>'),$pp_pic_holder.find(".pp_nav .pp_play").click(function(){return a.prettyPhoto.startSlideshow(),!1})),$pp_pic_holder.attr("class","pp_pic_holder "+settings.theme),$pp_overlay.css({opacity:0,height:a(document).height(),width:a(window).width()}).bind("click",function(){settings.modal||a.prettyPhoto.close()}),a("a.pp_close").bind("click",function(){return a.prettyPhoto.close(),!1}),settings.allow_expand&&a("a.pp_expand").bind("click",function(){return a(this).hasClass("pp_expand")?(a(this).removeClass("pp_expand").addClass("pp_contract"),doresize=!1):(a(this).removeClass("pp_contract").addClass("pp_expand"),doresize=!0),s(function(){a.prettyPhoto.open()}),!1}),$pp_pic_holder.find(".pp_previous, .pp_nav .pp_arrow_previous").bind("click",function(){return a.prettyPhoto.changePage("previous"),a.prettyPhoto.stopSlideshow(),!1}),$pp_pic_holder.find(".pp_next, .pp_nav .pp_arrow_next").bind("click",function(){return a.prettyPhoto.changePage("next"),a.prettyPhoto.stopSlideshow(),!1}),x()}f=jQuery.extend({hook:"rel",animation_speed:"fast",ajaxcallback:function(){},slideshow:5e3,autoplay_slideshow:!1,opacity:.8,show_title:!0,allow_resize:!0,allow_expand:!0,default_width:500,default_height:344,counter_separator_label:"/",theme:"pp_default",horizontal_padding:20,hideflash:!1,wmode:"opaque",autoplay:!0,modal:!1,deeplinking:!0,overlay_gallery:!0,overlay_gallery_max:30,keyboard_shortcuts:!0,changepicturecallback:function(){},callback:function(){},ie6_fallback:!0,markup:'<div class="pp_pic_holder">            <div class="ppt">&nbsp;</div>             <div class="pp_top">              <div class="pp_left"></div>               <div class="pp_middle"></div>               <div class="pp_right"></div>            </div>            <div class="pp_content_container">              <div class="pp_left">               <div class="pp_right">                <div class="pp_content">                  <div class="pp_loaderIcon"></div>                   <div class="pp_fade">                     <a href="#" class="pp_expand" title="Expand the image">Expand</a>                     <div class="pp_hoverContainer">                       <a class="pp_next" href="#">next</a>                      <a class="pp_previous" href="#">previous</a>                    </div>                    <div id="pp_full_res"></div>                    <div class="pp_details">                      <div class="pp_nav">                        <a href="#" class="pp_arrow_previous">Previous</a>                        <p class="currentTextHolder">0/0</p>                        <a href="#" class="pp_arrow_next">Next</a>                      </div>                      <p class="pp_description"></p>                      <div class="pp_social">{pp_social}</div>                      <a class="pp_close" href="#">Close</a>                    </div>                  </div>                </div>              </div>              </div>            </div>            <div class="pp_bottom">               <div class="pp_left"></div>               <div class="pp_middle"></div>               <div class="pp_right"></div>            </div>          </div>          <div class="pp_overlay"></div>',gallery_markup:'<div class="pp_gallery">                <a href="#" class="pp_arrow_previous">Previous</a>                <div>                   <ul>                    {gallery}                   </ul>                 </div>                <a href="#" class="pp_arrow_next">Next</a>              </div>',image_markup:'<img id="fullResImage" src="{path}" />',flash_markup:'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{width}" height="{height}"><param name="wmode" value="{wmode}" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="{path}" /><embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{width}" height="{height}" wmode="{wmode}"></embed></object>',quicktime_markup:'<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="{height}" width="{width}"><param name="src" value="{path}"><param name="autoplay" value="{autoplay}"><param name="type" value="video/quicktime"><embed src="{path}" height="{height}" width="{width}" autoplay="{autoplay}" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/"></embed></object>',iframe_markup:'<iframe src ="{path}" width="{width}" height="{height}" frameborder="no"></iframe>',inline_markup:'<div class="pp_inline">{content}</div>',custom_markup:"",social_tools:'<div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="//www.facebook.com/plugins/like.php?locale=en_US&href={location_href}&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div>'},f);var i,j,k,l,m,n,q,g=this,h=!1,o=a(window).height(),p=a(window).width();return doresize=!0,scroll_pos=y(),a(window).unbind("resize.prettyphoto").bind("resize.prettyphoto",function(){x(),z()}),f.keyboard_shortcuts&&a(document).unbind("keydown.prettyphoto").bind("keydown.prettyphoto",function(b){if("undefined"!=typeof $pp_pic_holder&&$pp_pic_holder.is(":visible"))switch(b.keyCode){case 37:a.prettyPhoto.changePage("previous"),b.preventDefault();break;case 39:a.prettyPhoto.changePage("next"),b.preventDefault();break;case 27:settings.modal||a.prettyPhoto.close(),b.preventDefault()}}),a.prettyPhoto.initialize=function(){return settings=f,"pp_default"==settings.theme&&(settings.horizontal_padding=16),theRel=a(this).attr(settings.hook),galleryRegExp=/\[(?:.*)\]/,isSet=galleryRegExp.exec(theRel)?!0:!1,pp_images=isSet?jQuery.map(g,function(b){return-1!=a(b).attr(settings.hook).indexOf(theRel)?a(b).attr("href"):void 0}):a.makeArray(a(this).attr("href")),pp_titles=isSet?jQuery.map(g,function(b){return-1!=a(b).attr(settings.hook).indexOf(theRel)?a(b).find("img").attr("alt")?a(b).find("img").attr("alt"):"":void 0}):a.makeArray(a(this).find("img").attr("alt")),pp_descriptions=isSet?jQuery.map(g,function(b){return-1!=a(b).attr(settings.hook).indexOf(theRel)?a(b).attr("title")?a(b).attr("title"):"":void 0}):a.makeArray(a(this).attr("title")),pp_images.length>settings.overlay_gallery_max&&(settings.overlay_gallery=!1),set_position=jQuery.inArray(a(this).attr("href"),pp_images),rel_index=isSet?set_position:a("a["+settings.hook+"^='"+theRel+"']").index(a(this)),B(this),settings.allow_resize&&a(window).bind("scroll.prettyphoto",function(){x()}),a.prettyPhoto.open(),!1},a.prettyPhoto.open=function(b){return"undefined"==typeof settings&&(settings=f,pp_images=a.makeArray(arguments[0]),pp_titles=a.makeArray(arguments[1]?arguments[1]:""),pp_descriptions=a.makeArray(arguments[2]?arguments[2]:""),isSet=pp_images.length>1?!0:!1,set_position=arguments[3]?arguments[3]:0,B(b.target)),settings.hideflash&&a("object,embed,iframe[src*=youtube],iframe[src*=vimeo]").css("visibility","hidden"),t(a(pp_images).size()),a(".pp_loaderIcon").show(),settings.deeplinking&&c(),settings.social_tools&&(facebook_like_link=settings.social_tools.replace("{location_href}",encodeURIComponent(location.href)),$pp_pic_holder.find(".pp_social").html(facebook_like_link)),$ppt.is(":hidden")&&$ppt.css("opacity",0).show(),$pp_overlay.show().fadeTo(settings.animation_speed,settings.opacity),$pp_pic_holder.find(".currentTextHolder").text(set_position+1+settings.counter_separator_label+a(pp_images).size()),"undefined"!=typeof pp_descriptions[set_position]&&""!=pp_descriptions[set_position]?$pp_pic_holder.find(".pp_description").show().html(unescape(pp_descriptions[set_position])):$pp_pic_holder.find(".pp_description").hide(),movie_width=parseFloat(e("width",pp_images[set_position]))?e("width",pp_images[set_position]):settings.default_width.toString(),movie_height=parseFloat(e("height",pp_images[set_position]))?e("height",pp_images[set_position]):settings.default_height.toString(),h=!1,-1!=movie_height.indexOf("%")&&(movie_height=parseFloat(a(window).height()*parseFloat(movie_height)/100-150),h=!0),-1!=movie_width.indexOf("%")&&(movie_width=parseFloat(a(window).width()*parseFloat(movie_width)/100-150),h=!0),$pp_pic_holder.fadeIn(function(){switch($ppt.html(settings.show_title&&""!=pp_titles[set_position]&&"undefined"!=typeof pp_titles[set_position]?unescape(pp_titles[set_position]):"&nbsp;"),imgPreloader="",skipInjection=!1,w(pp_images[set_position])){case"image":imgPreloader=new Image,nextImage=new Image,isSet&&set_position<a(pp_images).size()-1&&(nextImage.src=pp_images[set_position+1]),prevImage=new Image,isSet&&pp_images[set_position-1]&&(prevImage.src=pp_images[set_position-1]),$pp_pic_holder.find("#pp_full_res")[0].innerHTML=settings.image_markup.replace(/{path}/g,pp_images[set_position]),imgPreloader.onload=function(){i=u(imgPreloader.width,imgPreloader.height),r()},imgPreloader.onerror=function(){alert("Image cannot be loaded. Make sure the path is correct and image exist."),a.prettyPhoto.close()},imgPreloader.src=pp_images[set_position];break;case"youtube":i=u(movie_width,movie_height),movie_id=e("v",pp_images[set_position]),""==movie_id&&(movie_id=pp_images[set_position].split("youtu.be/"),movie_id=movie_id[1],movie_id.indexOf("?")>0&&(movie_id=movie_id.substr(0,movie_id.indexOf("?"))),movie_id.indexOf("&")>0&&(movie_id=movie_id.substr(0,movie_id.indexOf("&")))),movie="http://www.youtube.com/embed/"+movie_id,movie+=e("rel",pp_images[set_position])?"?rel="+e("rel",pp_images[set_position]):"?rel=1",settings.autoplay&&(movie+="&autoplay=1"),toInject=settings.iframe_markup.replace(/{width}/g,i.width).replace(/{height}/g,i.height).replace(/{wmode}/g,settings.wmode).replace(/{path}/g,movie);break;case"vimeo":i=u(movie_width,movie_height),movie_id=pp_images[set_position];var b=/http(s?):\/\/(www\.)?vimeo.com\/(\d+)/,c=movie_id.match(b);movie="http://player.vimeo.com/video/"+c[3]+"?title=0&amp;byline=0&amp;portrait=0",settings.autoplay&&(movie+="&autoplay=1;"),vimeo_width=i.width+"/embed/?moog_width="+i.width,toInject=settings.iframe_markup.replace(/{width}/g,vimeo_width).replace(/{height}/g,i.height).replace(/{path}/g,movie);break;case"quicktime":i=u(movie_width,movie_height),i.height+=15,i.contentHeight+=15,i.containerHeight+=15,toInject=settings.quicktime_markup.replace(/{width}/g,i.width).replace(/{height}/g,i.height).replace(/{wmode}/g,settings.wmode).replace(/{path}/g,pp_images[set_position]).replace(/{autoplay}/g,settings.autoplay);break;case"flash":i=u(movie_width,movie_height),flash_vars=pp_images[set_position],flash_vars=flash_vars.substring(pp_images[set_position].indexOf("flashvars")+10,pp_images[set_position].length),filename=pp_images[set_position],filename=filename.substring(0,filename.indexOf("?")),toInject=settings.flash_markup.replace(/{width}/g,i.width).replace(/{height}/g,i.height).replace(/{wmode}/g,settings.wmode).replace(/{path}/g,filename+"?"+flash_vars);break;case"iframe":i=u(movie_width,movie_height),frame_url=pp_images[set_position],frame_url=frame_url.substr(0,frame_url.indexOf("iframe")-1),toInject=settings.iframe_markup.replace(/{width}/g,i.width).replace(/{height}/g,i.height).replace(/{path}/g,frame_url);break;case"ajax":doresize=!1,i=u(movie_width,movie_height),doresize=!0,skipInjection=!0,a.get(pp_images[set_position],function(a){toInject=settings.inline_markup.replace(/{content}/g,a),$pp_pic_holder.find("#pp_full_res")[0].innerHTML=toInject,r()});break;case"custom":i=u(movie_width,movie_height),toInject=settings.custom_markup;break;case"inline":myClone=a(pp_images[set_position]).clone().append('<br clear="all" />').css({width:settings.default_width}).wrapInner('<div id="pp_full_res"><div class="pp_inline"></div></div>').appendTo(a("body")).show(),doresize=!1,i=u(a(myClone).width(),a(myClone).height()),doresize=!0,a(myClone).remove(),toInject=settings.inline_markup.replace(/{content}/g,a(pp_images[set_position]).html())}imgPreloader||skipInjection||($pp_pic_holder.find("#pp_full_res")[0].innerHTML=toInject,r())}),!1},a.prettyPhoto.changePage=function(b){currentGalleryPage=0,"previous"==b?(set_position--,set_position<0&&(set_position=a(pp_images).size()-1)):"next"==b?(set_position++,set_position>a(pp_images).size()-1&&(set_position=0)):set_position=b,rel_index=set_position,doresize||(doresize=!0),settings.allow_expand&&a(".pp_contract").removeClass("pp_contract").addClass("pp_expand"),s(function(){a.prettyPhoto.open()})},a.prettyPhoto.changeGalleryPage=function(a){"next"==a?(currentGalleryPage++,currentGalleryPage>totalPage&&(currentGalleryPage=0)):"previous"==a?(currentGalleryPage--,currentGalleryPage<0&&(currentGalleryPage=totalPage)):currentGalleryPage=a,slide_speed="next"==a||"previous"==a?settings.animation_speed:0,slide_to=currentGalleryPage*itemsPerPage*itemWidth,$pp_gallery.find("ul").animate({left:-slide_to},slide_speed)},a.prettyPhoto.startSlideshow=function(){"undefined"==typeof q?($pp_pic_holder.find(".pp_play").unbind("click").removeClass("pp_play").addClass("pp_pause").click(function(){return a.prettyPhoto.stopSlideshow(),!1}),q=setInterval(a.prettyPhoto.startSlideshow,settings.slideshow)):a.prettyPhoto.changePage("next")},a.prettyPhoto.stopSlideshow=function(){$pp_pic_holder.find(".pp_pause").unbind("click").removeClass("pp_pause").addClass("pp_play").click(function(){return a.prettyPhoto.startSlideshow(),!1}),clearInterval(q),q=void 0},a.prettyPhoto.close=function(){$pp_overlay.is(":animated")||(a.prettyPhoto.stopSlideshow(),$pp_pic_holder.stop().find("object,embed").css("visibility","hidden"),a("div.pp_pic_holder,div.ppt,.pp_fade").fadeOut(settings.animation_speed,function(){a(this).remove()}),$pp_overlay.fadeOut(settings.animation_speed,function(){settings.hideflash&&a("object,embed,iframe[src*=youtube],iframe[src*=vimeo]").css("visibility","visible"),a(this).remove(),a(window).unbind("scroll.prettyphoto"),d(),settings.callback(),doresize=!0,j=!1,delete settings}))},!pp_alreadyInitialized&&b()&&(pp_alreadyInitialized=!0,hashIndex=b(),hashRel=hashIndex,hashIndex=hashIndex.substring(hashIndex.indexOf("/")+1,hashIndex.length-1),hashRel=hashRel.substring(0,hashRel.indexOf("/")),setTimeout(function(){a("a["+f.hook+"^='"+hashRel+"']:eq("+hashIndex+")").trigger("click")},50)),this.unbind("click.prettyphoto").bind("click.prettyphoto",a.prettyPhoto.initialize)}}(jQuery);var pp_alreadyInitialized=!1;