/**
 * LICENCE[[
 * Version: MPL 2.0/GPL 3.0/LGPL 3.0/CeCILL 2.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 2.0 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * The Original Code is kelis.fr code.
 *
 * The Initial Developer of the Original Code is 
 * samuel.monsarrat@kelis.fr
 *
 * Portions created by the Initial Developer are Copyright (C) 2013-2017
 * the Initial Developer. All Rights Reserved.
 *
 * Contributor(s):
 *
 * Alternatively, the contents of this file may be used under the terms of
 * either of the GNU General Public License Version 3.0 or later (the "GPL"),
 * or the GNU Lesser General Public License Version 3.0 or later (the "LGPL"),
 * or the CeCILL Licence Version 2.1 (http://www.cecill.info/licences.en.html),
 * in which case the provisions of the GPL, the LGPL or the CeCILL are applicable
 * instead of those above. If you wish to allow use of your version of this file
 * only under the terms of either the GPL, the LGPL or the CeCILL, and not to allow
 * others to use your version of this file under the terms of the MPL, indicate
 * your decision by deleting the provisions above and replace them with the notice
 * and other provisions required by the GPL, the LGPL or the CeCILL. If you do not
 * delete the provisions above, a recipient may use your version of this file under
 * the terms of any one of the MPL, the GPL, the LGPL or the CeCILL.
 * ]]LICENCE
 */

/* === Dokiel outline manager =============================================== */
var outMgr = {
	fIdMenu : "outline",
	fIdContent : "content",
	fPathRoot : "ide:outline/chi:ul",
	fPathBranches : "des:div.mnu_b",
	fUrlOutline : null,
	fWheelScrollFactor : 6,
	
	fStrings : ["défilement haut","Faire défiler le menu vers le haut",
	/*02*/      "défilement bas","Faire défiler le menu vers le bas",
	/*04*/      "Ouvrir le menu \'%s\'","Fermer le menu \'%s\'"],

/* === Public functions ===================================================== */
	init : function (pPathRoot){
		try{
			this.fIsLocal = window.location.protocol == "file:";
			if (typeof pPathRoot != "undefined") this.fPathRoot = pPathRoot;
			this.fFilterIsClosed = scPaLib.compileFilter(".mnu_sub_c");
			this.fFilterIsBranch = scPaLib.compileFilter(".mnu_b");
			scOnLoads[scOnLoads.length] = this;
		}catch(e){scCoLib.log("ERROR - outMgr.init : "+e)}
	},

	declareOutline : function(pUrl){
		this.fUrlOutline = pUrl;
	},
	
	onLoad : function(){
		try{
			this.fRoot = scPaLib.findNode(this.fPathRoot);
			if (!this.fRoot) return;
			this.fCurrentItem = scPaLib.findNode("des:div.mnu_sel_yes", this.fRoot);
			this.fRoot.style.overflow="hidden";
			this.fRoot.className = this.fRoot.className.replace("mnu_static", "mnu_dynamic");
			var vBranches = scPaLib.findNodes(this.fPathBranches,this.fRoot);
			for (var i=0; i < vBranches.length; i++) {
				var vLbl = vBranches[i];
				this.xAddToggleBtn(vLbl, vLbl.firstChild.textContent, scPaLib.findNode("nsi:ul",vLbl));
			}

			var vRootParent = this.fRoot.parentNode;

			// Add Scroll up button
			this.fSrlUp = scDynUiMgr.addElement("div", vRootParent, "mnuSrlUpFra", this.fRoot);
			this.fSrlUp.onclick = function(){
				outMgr.scrollTask.fSpeed -= 2;
			}
			this.fSrlUp.onmouseover = function(){
				if(outMgr.scrollTask.fSpeed >= 0) {
					outMgr.scrollTask.fSpeed = -2; 
					scTiLib.addTaskNow(outMgr.scrollTask);
				}
			}
			this.fSrlUp.onmouseout = function(){
				outMgr.scrollTask.fSpeed = 0;
			}
			var vSrlUpBtn = this.xAddBtn(this.fSrlUp, this.fCls+"SrlUpBtn", this.fStrings[0], this.fStrings[1]);
			vSrlUpBtn.onclick = function(){
				outMgr.scrollTask.step(-20); 
				return false;
			}
			// Add Scroll down button
			this.fSrlDwn = scDynUiMgr.addElement("div", vRootParent, "mnuSrlDwnFra");
			this.fSrlDwn.onclick = function(){
				outMgr.scrollTask.fSpeed += 2;
			}
			this.fSrlDwn.onmouseover = function(){
				if(outMgr.scrollTask.fSpeed <= 0) {
					outMgr.scrollTask.fSpeed = 2; 
					scTiLib.addTaskNow(outMgr.scrollTask);
				}
			}
			this.fSrlDwn.onmouseout = function(){
				outMgr.scrollTask.fSpeed = 0;
			}
			var vSrlDwnBtn = this.xAddBtn(this.fSrlDwn, this.fCls+"SrlDwnBtn", this.fStrings[2], this.fStrings[3]);
			vSrlDwnBtn.onclick = function(){
				outMgr.scrollTask.step(20);
				return false;
			}
			// Init scroll manager
			this.menuResizer.resize();
			scSiLib.addRule(sc$(outMgr.fIdContent), this.menuResizer);
			this.scrollTask.checkBtn();
			scSiLib.addRule(this.fRoot, this.scrollTask);
			this.fRoot.onscroll = function(){outMgr.scrollTask.checkBtn()};
			this.fRoot.onmousewheel = function(){outMgr.scrollTask.step(Math.round(-event.wheelDelta/(scCoLib.isIE ? 60 : 40)*outMgr.fWheelScrollFactor))}; //IE, Safari, Chrome, Opera.
			if(this.fRoot.addEventListener) this.fRoot.addEventListener('DOMMouseScroll', function(pEvent){outMgr.scrollTask.step(pEvent.detail*outMgr.fWheelScrollFactor)}, false);

		} catch(e){
			scCoLib.log("ERROR - outMgr.onLoad: "+e);
		}
	},
	loadSortKey : "ZZ",

/* === Callback functions =================================================== */
	sToggleItem : function() {
		try{
			outMgr.xToggleItem(this,false);
		} catch(e){}
		return false;
	},

/* === Private functions ==================================================== */
	xToggleItem : function(pBtn) {
		if (!pBtn) return;
		var vStatus = pBtn.className;
		if (!pBtn.fUl) this.xBuildSub(pBtn);
		var vUl = pBtn.fUl;
		if (!vUl) return;
		if(vStatus == "mnu_tgle_c") {
			pBtn.className = "mnu_tgle_o";
			pBtn.innerHTML = "<span>v</span>";
			pBtn.title = this.fStrings[5].replace("%s", pBtn.fLblText);
			vUl.className = vUl.className.replace("mnu_sub_c", "mnu_sub_o");
			vUl.style.display = "";
			vUl.fClosed = false;
		} else {
			pBtn.className = "mnu_tgle_c";
			pBtn.innerHTML = "<span>></span>";
			pBtn.title = this.fStrings[4].replace("%s", pBtn.fLblText);
			vUl.className = vUl.className.replace("mnu_sub_o", "mnu_sub_c");
			vUl.style.display = "none";
			vUl.fClosed = true;
			var vOpendSubMnus = scPaLib.findNodes("des:ul.mnu_sub_o",vUl);
			for (var j=0; j < vOpendSubMnus.length; j++) this.xAutoToggleItem(vOpendSubMnus[j].fTglBtn);
		}
		this.scrollTask.checkBtn();
	},

	xBuildSub : function(pBtn) {
		if (!this.fOutline) this.xInitOutline();
		var vLbl = pBtn.fLbl;
		pBtn.fUl = scDynUiMgr.addElement("ul",vLbl.parentNode,"mnu_sub mnu_sub_o");
		pBtn.fUl.fTglBtn = pBtn;
		var vLi, vDiv, vLnk, vType, vCls;
		var vChildren = vLbl.fSrc.children;
		for (var i=0; i < pBtn.fLbl.fSrc.children.length; i++){
			var vChi =vChildren[i];
			vType = vChi.children ? "b" : "l";
			vCls = "mnu_sel_no mnu_"+vType+" mnu_src_"+vChi.source+" mnu_dpt_"+(scPaLib.findNodes("anc:ul.mnu_sub", pBtn).length + 1)+" "+vChi.className;
			vLi = scDynUiMgr.addElement("li",pBtn.fUl,vCls);
			vDiv = scDynUiMgr.addElement("div",vLi,"mnuLbl "+vCls);
			vDiv.fSrc = vChi;
			vLnk = scDynUiMgr.addElement("a",vDiv,"mnu_i mnu_lnk");
			vLnk.href = scServices.scLoad.getPathFromRoot(vChi.url);
			vLnk.target = "_self";
			vLnk.innerHTML = "<span>"+vChi.label+"</span>";
			if (vType == "b") this.xAddToggleBtn(vDiv, vChi.label);
		}
	},

	xAddToggleBtn : function(pParent, pLabel, pSub) {
		pParent.fTglBtn = this.xAddBtn(pParent,"mnu_tgle_"+(pSub?"o":"c"),(pSub?"v":">"),(pSub?this.fStrings[5].replace("%s",pLabel):this.fStrings[4]).replace("%s",pLabel), pParent.firstChild);
		pParent.fTglBtn.onclick = this.sToggleItem;
		pParent.fTglBtn.fLbl = pParent;
		if(pSub) pParent.fTglBtn.fUl = pSub;
		pParent.fTglBtn.fLblText = pLabel;
	},

	xInitOutline : function() {
		try{
			var vReq = this.xGetHttpRequest();
			vReq.open("GET",this.fUrlOutline+"?id="+scServices.id,false);
			vReq.send();
			this.fOutline = {children:this.xDeserialiseObjJs(vReq.responseText).menu};
			var iOutlineWalker = function (pNode, pSrc) {
				var vChildren = scPaLib.findNodes("chi:li/chi:div.mnuLbl", pNode);
				for (var i=0; i < vChildren.length; i++){
					var vChild = vChildren[i];
					vChild.fSrc = pSrc.children[i];
					if (scPaLib.checkNode(outMgr.fFilterIsBranch,vChild)) iOutlineWalker(scPaLib.findNode("nsi:ul",vChild),pSrc.children[i]);
				}
			}
			iOutlineWalker(this.fRoot,this.fOutline);
		}catch(e){
			scCoLib.log("ERROR - outMgr.xInitOutline : "+e);
		}
	},

	xGetOutline : function() {
		try{
			var vReq = this.xGetHttpRequest();
			vReq.open("GET",this.fUrlOutline,false);
			vReq.send();
			return this.xDeserialiseObjJs(vReq.responseText);
		}catch(e){}
	},

	/* === Utilities ========================================================== */
	/** outMgr.xAddBtn : Add a HTML button to a parent node. */
	xAddBtn : function(pParent, pClassName, pCapt, pTitle, pNxtSib) {
		var vBtn = pParent.ownerDocument.createElement("a");
		vBtn.className = pClassName;
		vBtn.fName = pClassName;
		vBtn.href = "#";
		vBtn.target = "_self";
		if (pTitle) vBtn.setAttribute("title", pTitle);
		if (pCapt) vBtn.innerHTML = "<span>" + pCapt + "</span>"
		if (pNxtSib) pParent.insertBefore(vBtn,pNxtSib)
		else pParent.appendChild(vBtn);
		return vBtn;
	},

	xGetHttpRequest: function(){
		if (window.XMLHttpRequest && (!this.fIsLocal || !window.ActiveXObject)) return new XMLHttpRequest();
		else if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
	},

	xDeserialiseObjJs : function(pStr){
		if(!pStr) return {};
		var vVal;
		eval("vVal="+pStr);
		return vVal;
	},

	/* === Tasks ============================================================== */
	/** outMgr.scrollTask : menu scroll timer & size task */
	scrollTask : {
		fClassOffUp : "btnOff",
		fClassOffDown : "btnOff",
		fSpeed : 0,
		execTask : function(){
			try {
				if(this.fSpeed == 0) return false;
				outMgr.fRoot.scrollTop += this.fSpeed;
				return true;
			}catch(e){
				this.fSpeed = 0;
				return false;
			}
		},
		step: function(pPx) {
			try { outMgr.fRoot.scrollTop += pPx; }catch(e){}
		},
		checkBtn: function(){
			var vScrollTop = outMgr.fRoot.scrollTop;
			var vBtnUpOff = outMgr.fSrlUp.className.indexOf(this.fClassOffUp);
			if(vScrollTop <= 0) {
				if(vBtnUpOff < 0) outMgr.fSrlUp.className+= " "+this.fClassOffUp;
			} else {
				if(vBtnUpOff >= 0) outMgr.fSrlUp.className = outMgr.fSrlUp.className.substring(0, vBtnUpOff);
			}
		
			var vContentH = scSiLib.getContentHeight(outMgr.fRoot);
			var vBtnDownOff = outMgr.fSrlDwn.className.indexOf(this.fClassOffDown);
			if( vContentH - vScrollTop <= outMgr.fRoot.offsetHeight){
				if(vBtnDownOff < 0) outMgr.fSrlDwn.className+= " "+this.fClassOffDown;
			} else {
				if(vBtnDownOff >=0) outMgr.fSrlDwn.className = outMgr.fSrlDwn.className.substring(0, vBtnDownOff);
			}
		},
		onResizedDes:function(pOwnerNode, pEvent){
		},
		onResizedAnc:function(pOwnerNode, pEvent){
			if(pEvent.phase==2) this.checkBtn();
		},
		ruleSortKey : "checkBtn"
	},

	menuResizer : {
		fHeight:0,
		resize: function(){
			try{
				var vHeight = sc$(outMgr.fIdContent).clientHeight;
				if (this.fHeight != vHeight) {
					if (window.getComputedStyle(sc$(outMgr.fIdMenu)).display!= "flex") sc$(outMgr.fIdMenu).style.height = sc$(outMgr.fIdContent).clientHeight + "px";
					var vCurrItem = outMgr.fCurrentItem;
					if (!vCurrItem) return;
					var vRoot = outMgr.fRoot
					var vParent = vCurrItem.offsetParent;
					if( !vParent) return;
					var vOffset = vCurrItem.offsetTop;
					while(vParent != vRoot) {
						var vNewParent = vParent.offsetParent;
						vOffset += vParent.offsetTop;
						vParent = vNewParent;
					}
					if (vOffset < vRoot.scrollTop) vRoot.scrollTop = vOffset;
					else if (vOffset > vRoot.scrollTop + vRoot.clientHeight) vRoot.scrollTop = vOffset - vRoot.clientHeight + vCurrItem.offsetHeight;
					outMgr.scrollTask.checkBtn();
					this.fHeight = vHeight;
				}
			} catch(e) {scCoLib.log("ERROR: menuResizer.resize : "+e)}
		},
		onResizedDes:function(pOwnerNode, pEvent){
			if(pEvent.phase==2) this.resize();
		},
		onResizedAnc:function(pOwnerNode, pEvent){
			if(pEvent.phase==2) this.resize();
		},
		ruleSortKey : "aaa"
	}
}
