<!-- // hide script

// Zoom In/Zoom Out zxcPart1 (15-04-2006)
// by Vic Phillips http://www.vicsjavascripts.org.uk
//
// Click or MouseOver the Thumbnail or any element to progressively Zoom In.
// Click again or MouseOut to progressively Zoom Out.
// The Thumbnail Image may be swapped for the Large Image while Zooming.
//
// The Zoom may be applied to Elements other than Images.
//
// The Zoom can be applied concurrently to any number of Thumbnails on the same page.
// The Zoom In size is specified in the Zoom function call.
//
//
// Application Notes
//
// **** Calling the Zoom Function
//
// Typical application to Zoom onMouseOver/onMouseOut
//    <img "Img1" src="One.gif" width="75"  height="56" border="0"
//     onmouseover="zxcZoom(this,'Two.gif',200,200,1,'C');"
//     onmouseout="javascript:zxcZoom(this);"
//    >
// Typical application to Zoom onClick
//    <input type="button" value="Zoom Img1"
//    onclick="zxcZoom('Img1','http://www.vicsjavascripts.org.uk/StdImages/Two.gif',200,200,1,'C');"
//    >
// where
// parameter 0 = the image object or unique ID name                      (object or string)
// parameter 1 = optional, the large image file name to zoom.            (string or null if the origninal image is to be used )
// parameter 2 = the maximum zoom width.                                 (digits)
// parameter 3 = the maximum zoom height or null to retain aspect ratio. (digits or null)
// parameter 4 = optional, the zoom speed.                               (digits, delaults to 1 if omitted or null)
// parameter 5 = optional, 'C' to center the Zoom Image.                 (string, delaults zoom down and right if omitted or null)

// Parameters 1 on are only required for the first call, subsequent calls will toggle the zoom.

// ****  General

// All variable, function etc. names are prefixed with 'zxc' to minimise conflicts with other JavaScripts

// The Functional Code(about 3K) is best as an External JavaScript

// Tested with IE6 and Mozilla FireFox


// **** Customising Variables

var zxcZIndex=0;         // the base Z-Index for the images
var zxcDelay=10;         //  the global zoom speed may be specified in addition to the call
var zxcAddCursor=true;   // true to add a 'hand'/'pointer' cursor to the Zoom Image, false for no cursor
//-->


<!--
// Zoom In/Zoom Out zxcPart2 (15-04-2006)
// by Vic Phillips http://www.vicsjavascripts.org.uk
//

// Functional Code - N0 NEED to Change

var zxcOOPCnt=0;
var zxcCursor=document.all?'hand':'pointer';
zxcZIndex=zxcZIndex||1;
var zxcZIndx=zxcZIndex;
zxcDelay=zxcDelay||10;

function zxcZoom(zxcobj,zxcph,zxcmw,zxcmh,zxcspd,zxcopt){
 if (typeof(zxcobj)=='string'){ zxcobj=document.getElementById(zxcobj); }
 var zxcphoto;
 if (zxcobj.tagName.toUpperCase()=='IMG'){
  zxcphoto=zxcph||zxcobj.src;
  if (zxcphoto.length<5){ zxcphoto=zxcobj.src; }
 }
 var zxcspd=zxcspd||1;
 var zxcopt=zxcopt||null;
 if (!zxcobj.zxcoop){ zxcobj.zxcoop=new zxcOOPZoom(zxcobj,zxcphoto,zxcmw,zxcmh,zxcspd,zxcopt,zxcopt); }
 clearTimeout(zxcobj.zxcoop.to);
 zxcobj.zxcoop.inc*=-1
 if (zxcobj.zxcoop.large.load){ zxcobj.src=zxcobj.zxcoop.large.src; }
 zxcZIndx++;
 zxcStyle(zxcobj,{zIndex:(zxcZIndx+'')});
 zxcobj.zxcoop.zoom();
}

function zxcOOPZoom(zxcobj,zxcph,zxcmw,zxcmh,zxcspd,zxcopt){
 this.obj=zxcobj;
 this.objS=zxcobj.style;
 this.clone=zxcobj.cloneNode(true);
 this.zxcspd=zxcspd;
 this.zxct=zxcPos(zxcobj)[1];
 this.zxcl=zxcPos(zxcobj)[0];
 zxcStyle(this.obj,{position:'absolute',zIndex:(zxcZIndex*1+1+''),width:zxcobj.offsetWidth+'px',height:zxcobj.offsetHeight+'px',left:this.zxcl+'px',top:this.zxct+'px'});
 if (zxcAddCursor){ zxcStyle(this.obj,{cursor:zxcCursor}); }
 this.minw=zxcobj.offsetWidth;
 this.minh=zxcobj.offsetHeight;
 this.center=zxcopt;
 this.maxw=zxcmw;
 this.maxh=zxcmh||zxcmw*this.minh/this.minw;
 this.thumb=zxcobj.src;
 this.large=new Image();
 this.large.obj=this.obj;
 if (zxcph){ this.large.onload=function(){ this.load=true; this.obj.src=this.src; }; this.large.src=zxcph; }
 zxcobj.parentNode.insertBefore(this.clone,zxcobj);
 this.inc=((this.maxw-this.minw)/100);
 this.inc=-this.inc*this.zxcspd;
 this.ratio=(this.maxh/this.maxw);
 this.ref='zxc'+zxcOOPCnt;
 window[this.ref]=this;
 this.to=null;
 zxcOOPCnt++;
}

zxcOOPZoom.prototype.setTimeOut=function(zxcf,zxcd){
 this.to=setTimeout("window."+this.ref+"."+zxcf,zxcd);
}

zxcOOPZoom.prototype.zoom=function(){
 this.w=parseInt(this.objS.width)+this.inc; this.h=parseInt(this.objS.width)*this.ratio;
 zxcStyle(this.obj,{width:(this.w)+'px',height:(this.h)+'px'});
 this.w=parseInt(this.objS.width); this.h=parseInt(this.objS.height);
 if (this.center){ zxcStyle(this.obj,{top:(this.zxct-(this.h-this.minh)/2)+'px',left:(this.zxcl-(this.w-this.minw)/2)+'px'}); }
 if ((this.inc>0&&this.w<this.maxw)||(this.inc<0&&this.w>this.minw)){ this.setTimeOut('zoom();',zxcDelay); }
 else {
  if (this.inc>0){ zxcStyle(this.obj,{width:this.maxw+'px',height:this.maxh+'px'}); }
  else {
   zxcStyle(this.obj,{zIndex:zxcZIndex,width:this.minw+'px',height:this.minh+'px',top:(this.zxct)+'px',left:(this.zxcl)+'px'});
   zxcZIndx--;
   this.obj.src=this.thumb;
  }
 }
}

function zxcStyle(zxcele,zxcstyle){
 for (key in zxcstyle){ zxcele.style[key]=zxcstyle[key]; }
}

function zxcPos(zxc){
 zxcObjLeft=zxc.offsetLeft;
 zxcObjTop=zxc.offsetTop;
 while(zxc.offsetParent!=null){
  zxcObjParent=zxc.offsetParent;
  zxcObjLeft+=zxcObjParent.offsetLeft;
  zxcObjTop+=zxcObjParent.offsetTop;
  zxc=zxcObjParent;
 }
 return [zxcObjLeft,zxcObjTop];
}

// finish hiding script -->

