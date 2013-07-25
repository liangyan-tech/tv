(function(e){function t(){return new Date(Date.UTC.apply(Date,arguments))}function n(){var e=new Date;return t(e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate())}function s(t,n){var r=e(t).data(),i={},s,o=new RegExp("^"+n.toLowerCase()+"([A-Z])"),n=new RegExp("^"+n.toLowerCase());for(var u in r)if(n.test(u)){s=u.replace(o,function(e,t){return t.toLowerCase()});i[s]=r[u]}return i}function o(t){var n={};if(!l[t]){t=t.split("-")[0];if(!l[t])return}var r=l[t];e.each(f,function(e,t){if(t in r)n[t]=r[t]});return n}var r=function(t,n){var r=this;this._process_options(n);this.element=e(t);this.isInline=false;this.isInput=this.element.is("input");this.component=this.element.is(".date")?this.element.find(".add-on, .btn"):false;this.hasInput=this.component&&this.element.find("input").length;if(this.component&&this.component.length===0)this.component=false;this.picker=e(c.template);this._buildEvents();this._attachEvents();if(this.isInline){this.picker.addClass("datepicker-inline").appendTo(this.element)}else{this.picker.addClass("datepicker-dropdown dropdown-menu")}if(this.o.rtl){this.picker.addClass("datepicker-rtl");this.picker.find(".prev i, .next i").toggleClass("icon-arrow-left icon-arrow-right")}this.viewMode=this.o.startView;if(this.o.calendarWeeks)this.picker.find("tfoot th.today").attr("colspan",function(e,t){return parseInt(t)+1});this._allow_update=false;this.setStartDate(this.o.startDate);this.setEndDate(this.o.endDate);this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);this.fillDow();this.fillMonths();this._allow_update=true;this.update();this.showMode();if(this.isInline){this.show()}};r.prototype={constructor:r,_process_options:function(t){this._o=e.extend({},this._o,t);var n=this.o=e.extend({},this._o);var r=n.language;if(!l[r]){r=r.split("-")[0];if(!l[r])r=a.language}n.language=r;switch(n.startView){case 2:case"decade":n.startView=2;break;case 1:case"year":n.startView=1;break;default:n.startView=0}switch(n.minViewMode){case 1:case"months":n.minViewMode=1;break;case 2:case"years":n.minViewMode=2;break;default:n.minViewMode=0}n.startView=Math.max(n.startView,n.minViewMode);n.weekStart%=7;n.weekEnd=(n.weekStart+6)%7;var i=c.parseFormat(n.format);if(n.startDate!==-Infinity){n.startDate=c.parseDate(n.startDate,i,n.language)}if(n.endDate!==Infinity){n.endDate=c.parseDate(n.endDate,i,n.language)}n.daysOfWeekDisabled=n.daysOfWeekDisabled||[];if(!e.isArray(n.daysOfWeekDisabled))n.daysOfWeekDisabled=n.daysOfWeekDisabled.split(/[,\s]*/);n.daysOfWeekDisabled=e.map(n.daysOfWeekDisabled,function(e){return parseInt(e,10)})},_events:[],_secondaryEvents:[],_applyEvents:function(e){for(var t=0,n,r;t<e.length;t++){n=e[t][0];r=e[t][1];n.on(r)}},_unapplyEvents:function(e){for(var t=0,n,r;t<e.length;t++){n=e[t][0];r=e[t][1];n.off(r)}},_buildEvents:function(){if(this.isInput){this._events=[[this.element,{focus:e.proxy(this.show,this),keyup:e.proxy(this.update,this),keydown:e.proxy(this.keydown,this)}]]}else if(this.component&&this.hasInput){this._events=[[this.element.find("input"),{focus:e.proxy(this.show,this),keyup:e.proxy(this.update,this),keydown:e.proxy(this.keydown,this)}],[this.component,{click:e.proxy(this.show,this)}]]}else if(this.element.is("div")){this.isInline=true}else{this._events=[[this.element,{click:e.proxy(this.show,this)}]]}this._secondaryEvents=[[this.picker,{click:e.proxy(this.click,this)}],[e(window),{resize:e.proxy(this.place,this)}],[e(document),{mousedown:e.proxy(function(e){if(!(this.element.is(e.target)||this.element.find(e.target).size()||this.picker.is(e.target)||this.picker.find(e.target).size())){this.hide()}},this)}]]},_attachEvents:function(){this._detachEvents();this._applyEvents(this._events)},_detachEvents:function(){this._unapplyEvents(this._events)},_attachSecondaryEvents:function(){this._detachSecondaryEvents();this._applyEvents(this._secondaryEvents)},_detachSecondaryEvents:function(){this._unapplyEvents(this._secondaryEvents)},_trigger:function(t,n){var r=n||this.date,i=new Date(r.getTime()+r.getTimezoneOffset()*6e4);this.element.trigger({type:t,date:i,format:e.proxy(function(e){var t=e||this.o.format;return c.formatDate(r,t,this.o.language)},this)})},show:function(e){if(!this.isInline)this.picker.appendTo("body");this.picker.show();this.height=this.component?this.component.outerHeight():this.element.outerHeight();this.place();this._attachSecondaryEvents();if(e){e.preventDefault()}this._trigger("show")},hide:function(e){if(this.isInline)return;if(!this.picker.is(":visible"))return;this.picker.hide().detach();this._detachSecondaryEvents();this.viewMode=this.o.startView;this.showMode();if(this.o.forceParse&&(this.isInput&&this.element.val()||this.hasInput&&this.element.find("input").val()))this.setValue();this._trigger("hide")},remove:function(){this.hide();this._detachEvents();this._detachSecondaryEvents();this.picker.remove();delete this.element.data().datepicker;if(!this.isInput){delete this.element.data().date}},getDate:function(){var e=this.getUTCDate();return new Date(e.getTime()+e.getTimezoneOffset()*6e4)},getUTCDate:function(){return this.date},setDate:function(e){this.setUTCDate(new Date(e.getTime()-e.getTimezoneOffset()*6e4))},setUTCDate:function(e){this.date=e;this.setValue()},setValue:function(){var e=this.getFormattedDate();if(!this.isInput){if(this.component){this.element.find("input").val(e)}}else{this.element.val(e)}},getFormattedDate:function(e){if(e===undefined)e=this.o.format;return c.formatDate(this.date,e,this.o.language)},setStartDate:function(e){this._process_options({startDate:e});this.update();this.updateNavArrows()},setEndDate:function(e){this._process_options({endDate:e});this.update();this.updateNavArrows()},setDaysOfWeekDisabled:function(e){this._process_options({daysOfWeekDisabled:e});this.update();this.updateNavArrows()},place:function(){if(this.isInline)return;var t=parseInt(this.element.parents().filter(function(){return e(this).css("z-index")!="auto"}).first().css("z-index"))+10;var n=this.component?this.component.parent().offset():this.element.offset();var r=this.component?this.component.outerHeight(true):this.element.outerHeight(true);this.picker.css({top:n.top+r,left:n.left,zIndex:t})},_allow_update:true,update:function(){if(!this._allow_update)return;var e,t=false;if(arguments&&arguments.length&&(typeof arguments[0]==="string"||arguments[0]instanceof Date)){e=arguments[0];t=true}else{e=this.isInput?this.element.val():this.element.data("date")||this.element.find("input").val();delete this.element.data().date}this.date=c.parseDate(e,this.o.format,this.o.language);if(t)this.setValue();if(this.date<this.o.startDate){this.viewDate=new Date(this.o.startDate)}else if(this.date>this.o.endDate){this.viewDate=new Date(this.o.endDate)}else{this.viewDate=new Date(this.date)}this.fill()},fillDow:function(){var e=this.o.weekStart,t="<tr>";if(this.o.calendarWeeks){var n='<th class="cw"> </th>';t+=n;this.picker.find(".datepicker-days thead tr:first-child").prepend(n)}while(e<this.o.weekStart+7){t+='<th class="dow">'+l[this.o.language].daysMin[e++%7]+"</th>"}t+="</tr>";this.picker.find(".datepicker-days thead").append(t)},fillMonths:function(){var e="",t=0;while(t<12){e+='<span class="month">'+l[this.o.language].monthsShort[t++]+"</span>"}this.picker.find(".datepicker-months td").html(e)},setRange:function(t){if(!t||!t.length)delete this.range;else this.range=e.map(t,function(e){return e.valueOf()});this.fill()},getClassNames:function(t){var n=[],r=this.viewDate.getUTCFullYear(),i=this.viewDate.getUTCMonth(),s=this.date.valueOf(),o=new Date;if(t.getUTCFullYear()<r||t.getUTCFullYear()==r&&t.getUTCMonth()<i){n.push("old")}else if(t.getUTCFullYear()>r||t.getUTCFullYear()==r&&t.getUTCMonth()>i){n.push("new")}if(this.o.todayHighlight&&t.getUTCFullYear()==o.getFullYear()&&t.getUTCMonth()==o.getMonth()&&t.getUTCDate()==o.getDate()){n.push("today")}if(s&&t.valueOf()==s){n.push("active")}if(t.valueOf()<this.o.startDate||t.valueOf()>this.o.endDate||e.inArray(t.getUTCDay(),this.o.daysOfWeekDisabled)!==-1){n.push("disabled")}if(this.range){if(t>this.range[0]&&t<this.range[this.range.length-1]){n.push("range")}if(e.inArray(t.valueOf(),this.range)!=-1){n.push("selected")}}return n},fill:function(){var n=new Date(this.viewDate),r=n.getUTCFullYear(),i=n.getUTCMonth(),s=this.o.startDate!==-Infinity?this.o.startDate.getUTCFullYear():-Infinity,o=this.o.startDate!==-Infinity?this.o.startDate.getUTCMonth():-Infinity,u=this.o.endDate!==Infinity?this.o.endDate.getUTCFullYear():Infinity,a=this.o.endDate!==Infinity?this.o.endDate.getUTCMonth():Infinity,f=this.date&&this.date.valueOf(),h;this.picker.find(".datepicker-days thead th.datepicker-switch").text(l[this.o.language].months[i]+" "+r);this.picker.find("tfoot th.today").text(l[this.o.language].today).toggle(this.o.todayBtn!==false);this.picker.find("tfoot th.clear").text(l[this.o.language].clear).toggle(this.o.clearBtn!==false);this.updateNavArrows();this.fillMonths();var p=t(r,i-1,28,0,0,0,0),d=c.getDaysInMonth(p.getUTCFullYear(),p.getUTCMonth());p.setUTCDate(d);p.setUTCDate(d-(p.getUTCDay()-this.o.weekStart+7)%7);var v=new Date(p);v.setUTCDate(v.getUTCDate()+42);v=v.valueOf();var m=[];var g;while(p.valueOf()<v){if(p.getUTCDay()==this.o.weekStart){m.push("<tr>");if(this.o.calendarWeeks){var y=new Date(+p+(this.o.weekStart-p.getUTCDay()-7)%7*864e5),b=new Date(+y+(7+4-y.getUTCDay())%7*864e5),w=new Date(+(w=t(b.getUTCFullYear(),0,1))+(7+4-w.getUTCDay())%7*864e5),E=(b-w)/864e5/7+1;m.push('<td class="cw">'+E+"</td>")}}g=this.getClassNames(p);g.push("day");var S=this.o.beforeShowDay(p);if(S===undefined)S={};else if(typeof S==="boolean")S={enabled:S};else if(typeof S==="string")S={classes:S};if(S.enabled===false)g.push("disabled");if(S.classes)g=g.concat(S.classes.split(/\s+/));if(S.tooltip)h=S.tooltip;g=e.unique(g);m.push('<td class="'+g.join(" ")+'"'+(h?' title="'+h+'"':"")+">"+p.getUTCDate()+"</td>");if(p.getUTCDay()==this.o.weekEnd){m.push("</tr>")}p.setUTCDate(p.getUTCDate()+1)}this.picker.find(".datepicker-days tbody").empty().append(m.join(""));var x=this.date&&this.date.getUTCFullYear();var T=this.picker.find(".datepicker-months").find("th:eq(1)").text(r).end().find("span").removeClass("active");if(x&&x==r){T.eq(this.date.getUTCMonth()).addClass("active")}if(r<s||r>u){T.addClass("disabled")}if(r==s){T.slice(0,o).addClass("disabled")}if(r==u){T.slice(a+1).addClass("disabled")}m="";r=parseInt(r/10,10)*10;var N=this.picker.find(".datepicker-years").find("th:eq(1)").text(r+"-"+(r+9)).end().find("td");r-=1;for(var C=-1;C<11;C++){m+='<span class="year'+(C==-1?" old":C==10?" new":"")+(x==r?" active":"")+(r<s||r>u?" disabled":"")+'">'+r+"</span>";r+=1}N.html(m)},updateNavArrows:function(){if(!this._allow_update)return;var e=new Date(this.viewDate),t=e.getUTCFullYear(),n=e.getUTCMonth();switch(this.viewMode){case 0:if(this.o.startDate!==-Infinity&&t<=this.o.startDate.getUTCFullYear()&&n<=this.o.startDate.getUTCMonth()){this.picker.find(".prev").css({visibility:"hidden"})}else{this.picker.find(".prev").css({visibility:"visible"})}if(this.o.endDate!==Infinity&&t>=this.o.endDate.getUTCFullYear()&&n>=this.o.endDate.getUTCMonth()){this.picker.find(".next").css({visibility:"hidden"})}else{this.picker.find(".next").css({visibility:"visible"})}break;case 1:case 2:if(this.o.startDate!==-Infinity&&t<=this.o.startDate.getUTCFullYear()){this.picker.find(".prev").css({visibility:"hidden"})}else{this.picker.find(".prev").css({visibility:"visible"})}if(this.o.endDate!==Infinity&&t>=this.o.endDate.getUTCFullYear()){this.picker.find(".next").css({visibility:"hidden"})}else{this.picker.find(".next").css({visibility:"visible"})}break}},click:function(n){n.preventDefault();var r=e(n.target).closest("span, td, th");if(r.length==1){switch(r[0].nodeName.toLowerCase()){case"th":switch(r[0].className){case"datepicker-switch":this.showMode(1);break;case"prev":case"next":var i=c.modes[this.viewMode].navStep*(r[0].className=="prev"?-1:1);switch(this.viewMode){case 0:this.viewDate=this.moveMonth(this.viewDate,i);break;case 1:case 2:this.viewDate=this.moveYear(this.viewDate,i);break}this.fill();break;case"today":var s=new Date;s=t(s.getFullYear(),s.getMonth(),s.getDate(),0,0,0);this.showMode(-2);var o=this.o.todayBtn=="linked"?null:"view";this._setDate(s,o);break;case"clear":var u;if(this.isInput)u=this.element;else if(this.component)u=this.element.find("input");if(u)u.val("").change();this._trigger("changeDate");this.update();if(this.o.autoclose)this.hide();break}break;case"span":if(!r.is(".disabled")){this.viewDate.setUTCDate(1);if(r.is(".month")){var a=1;var f=r.parent().find("span").index(r);var l=this.viewDate.getUTCFullYear();this.viewDate.setUTCMonth(f);this._trigger("changeMonth",this.viewDate);if(this.o.minViewMode===1){this._setDate(t(l,f,a,0,0,0,0))}}else{var l=parseInt(r.text(),10)||0;var a=1;var f=0;this.viewDate.setUTCFullYear(l);this._trigger("changeYear",this.viewDate);if(this.o.minViewMode===2){this._setDate(t(l,f,a,0,0,0,0))}}this.showMode(-1);this.fill()}break;case"td":if(r.is(".day")&&!r.is(".disabled")){var a=parseInt(r.text(),10)||1;var l=this.viewDate.getUTCFullYear(),f=this.viewDate.getUTCMonth();if(r.is(".old")){if(f===0){f=11;l-=1}else{f-=1}}else if(r.is(".new")){if(f==11){f=0;l+=1}else{f+=1}}this._setDate(t(l,f,a,0,0,0,0))}break}}},_setDate:function(e,t){if(!t||t=="date")this.date=new Date(e);if(!t||t=="view")this.viewDate=new Date(e);this.fill();this.setValue();this._trigger("changeDate");var n;if(this.isInput){n=this.element}else if(this.component){n=this.element.find("input")}if(n){n.change();if(this.o.autoclose&&(!t||t=="date")){this.hide()}}},moveMonth:function(e,t){if(!t)return e;var n=new Date(e.valueOf()),r=n.getUTCDate(),i=n.getUTCMonth(),s=Math.abs(t),o,u;t=t>0?1:-1;if(s==1){u=t==-1?function(){return n.getUTCMonth()==i}:function(){return n.getUTCMonth()!=o};o=i+t;n.setUTCMonth(o);if(o<0||o>11)o=(o+12)%12}else{for(var a=0;a<s;a++)n=this.moveMonth(n,t);o=n.getUTCMonth();n.setUTCDate(r);u=function(){return o!=n.getUTCMonth()}}while(u()){n.setUTCDate(--r);n.setUTCMonth(o)}return n},moveYear:function(e,t){return this.moveMonth(e,t*12)},dateWithinRange:function(e){return e>=this.o.startDate&&e<=this.o.endDate},keydown:function(e){if(this.picker.is(":not(:visible)")){if(e.keyCode==27)this.show();return}var t=false,n,r,i,s,o;switch(e.keyCode){case 27:this.hide();e.preventDefault();break;case 37:case 39:if(!this.o.keyboardNavigation)break;n=e.keyCode==37?-1:1;if(e.ctrlKey){s=this.moveYear(this.date,n);o=this.moveYear(this.viewDate,n)}else if(e.shiftKey){s=this.moveMonth(this.date,n);o=this.moveMonth(this.viewDate,n)}else{s=new Date(this.date);s.setUTCDate(this.date.getUTCDate()+n);o=new Date(this.viewDate);o.setUTCDate(this.viewDate.getUTCDate()+n)}if(this.dateWithinRange(s)){this.date=s;this.viewDate=o;this.setValue();this.update();e.preventDefault();t=true}break;case 38:case 40:if(!this.o.keyboardNavigation)break;n=e.keyCode==38?-1:1;if(e.ctrlKey){s=this.moveYear(this.date,n);o=this.moveYear(this.viewDate,n)}else if(e.shiftKey){s=this.moveMonth(this.date,n);o=this.moveMonth(this.viewDate,n)}else{s=new Date(this.date);s.setUTCDate(this.date.getUTCDate()+n*7);o=new Date(this.viewDate);o.setUTCDate(this.viewDate.getUTCDate()+n*7)}if(this.dateWithinRange(s)){this.date=s;this.viewDate=o;this.setValue();this.update();e.preventDefault();t=true}break;case 13:this.hide();e.preventDefault();break;case 9:this.hide();break}if(t){this._trigger("changeDate");var u;if(this.isInput){u=this.element}else if(this.component){u=this.element.find("input")}if(u){u.change()}}},showMode:function(e){if(e){this.viewMode=Math.max(this.o.minViewMode,Math.min(2,this.viewMode+e))}this.picker.find(">div").hide().filter(".datepicker-"+c.modes[this.viewMode].clsName).css("display","block");this.updateNavArrows()}};var i=function(t,n){this.element=e(t);this.inputs=e.map(n.inputs,function(e){return e.jquery?e[0]:e});delete n.inputs;e(this.inputs).datepicker(n).bind("changeDate",e.proxy(this.dateUpdated,this));this.pickers=e.map(this.inputs,function(t){return e(t).data("datepicker")});this.updateDates()};i.prototype={updateDates:function(){this.dates=e.map(this.pickers,function(e){return e.date});this.updateRanges()},updateRanges:function(){var t=e.map(this.dates,function(e){return e.valueOf()});e.each(this.pickers,function(e,n){n.setRange(t)})},dateUpdated:function(t){var n=e(t.target).data("datepicker"),r=n.getUTCDate(),i=e.inArray(t.target,this.inputs),s=this.inputs.length;if(i==-1)return;if(r<this.dates[i]){while(i>=0&&r<this.dates[i]){this.pickers[i--].setUTCDate(r)}}else if(r>this.dates[i]){while(i<s&&r>this.dates[i]){this.pickers[i++].setUTCDate(r)}}this.updateDates()},remove:function(){e.map(this.pickers,function(e){e.remove()});delete this.element.data().datepicker}};var u=e.fn.datepicker;e.fn.datepicker=function(t){var n=Array.apply(null,arguments);n.shift();var u,f;this.each(function(){var f=e(this),l=f.data("datepicker"),c=typeof t=="object"&&t;if(!l){var h=s(this,"date"),p=e.extend({},a,h,c),d=o(p.language),v=e.extend({},a,d,h,c);if(f.is(".input-daterange")||v.inputs){var m={inputs:v.inputs||f.find("input").toArray()};f.data("datepicker",l=new i(this,e.extend(v,m)))}else{f.data("datepicker",l=new r(this,v))}}if(typeof t=="string"&&typeof l[t]=="function"){u=l[t].apply(l,n);if(u!==undefined)return false}});if(u!==undefined)return u;else return this};var a=e.fn.datepicker.defaults={autoclose:false,beforeShowDay:e.noop,calendarWeeks:false,clearBtn:false,daysOfWeekDisabled:[],endDate:Infinity,forceParse:true,format:"mm/dd/yyyy",keyboardNavigation:true,language:"en",minViewMode:0,rtl:false,startDate:-Infinity,startView:0,todayBtn:false,todayHighlight:false,weekStart:0};var f=e.fn.datepicker.locale_opts=["format","rtl","weekStart"];e.fn.datepicker.Constructor=r;var l=e.fn.datepicker.dates={en:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa","Su"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],today:"Today",clear:"Clear"}};var c={modes:[{clsName:"days",navFnc:"Month",navStep:1},{clsName:"months",navFnc:"FullYear",navStep:1},{clsName:"years",navFnc:"FullYear",navStep:10}],isLeapYear:function(e){return e%4===0&&e%100!==0||e%400===0},getDaysInMonth:function(e,t){return[31,c.isLeapYear(e)?29:28,31,30,31,30,31,31,30,31,30,31][t]},validParts:/dd?|DD?|mm?|MM?|yy(?:yy)?/g,nonpunctuation:/[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,parseFormat:function(e){var t=e.replace(this.validParts,"\0").split("\0"),n=e.match(this.validParts);if(!t||!t.length||!n||n.length===0){throw new Error("Invalid date format.")}return{separators:t,parts:n}},parseDate:function(n,i,s){if(n instanceof Date)return n;if(typeof i==="string")i=c.parseFormat(i);if(/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(n)){var o=/([\-+]\d+)([dmwy])/,u=n.match(/([\-+]\d+)([dmwy])/g),a,f;n=new Date;for(var h=0;h<u.length;h++){a=o.exec(u[h]);f=parseInt(a[1]);switch(a[2]){case"d":n.setUTCDate(n.getUTCDate()+f);break;case"m":n=r.prototype.moveMonth.call(r.prototype,n,f);break;case"w":n.setUTCDate(n.getUTCDate()+f*7);break;case"y":n=r.prototype.moveYear.call(r.prototype,n,f);break}}return t(n.getUTCFullYear(),n.getUTCMonth(),n.getUTCDate(),0,0,0)}var u=n&&n.match(this.nonpunctuation)||[],n=new Date,p={},d=["yyyy","yy","M","MM","m","mm","d","dd"],v={yyyy:function(e,t){return e.setUTCFullYear(t)},yy:function(e,t){return e.setUTCFullYear(2e3+t)},m:function(e,t){if(isNaN(e))return e;t-=1;while(t<0)t+=12;t%=12;e.setUTCMonth(t);while(e.getUTCMonth()!=t)e.setUTCDate(e.getUTCDate()-1);return e},d:function(e,t){return e.setUTCDate(t)}},m,g,a;v["M"]=v["MM"]=v["mm"]=v["m"];v["dd"]=v["d"];n=t(n.getFullYear(),n.getMonth(),n.getDate(),0,0,0);var y=i.parts.slice();if(u.length!=y.length){y=e(y).filter(function(t,n){return e.inArray(n,d)!==-1}).toArray()}if(u.length==y.length){for(var h=0,b=y.length;h<b;h++){m=parseInt(u[h],10);a=y[h];if(isNaN(m)){switch(a){case"MM":g=e(l[s].months).filter(function(){var e=this.slice(0,u[h].length),t=u[h].slice(0,e.length);return e==t});m=e.inArray(g[0],l[s].months)+1;break;case"M":g=e(l[s].monthsShort).filter(function(){var e=this.slice(0,u[h].length),t=u[h].slice(0,e.length);return e==t});m=e.inArray(g[0],l[s].monthsShort)+1;break}}p[a]=m}for(var h=0,w,E;h<d.length;h++){E=d[h];if(E in p&&!isNaN(p[E])){w=new Date(n);v[E](w,p[E]);if(!isNaN(w))n=w}}}return n},formatDate:function(t,n,r){if(typeof n==="string")n=c.parseFormat(n);var i={d:t.getUTCDate(),D:l[r].daysShort[t.getUTCDay()],DD:l[r].days[t.getUTCDay()],m:t.getUTCMonth()+1,M:l[r].monthsShort[t.getUTCMonth()],MM:l[r].months[t.getUTCMonth()],yy:t.getUTCFullYear().toString().substring(2),yyyy:t.getUTCFullYear()};i.dd=(i.d<10?"0":"")+i.d;i.mm=(i.m<10?"0":"")+i.m;var t=[],s=e.extend([],n.separators);for(var o=0,u=n.parts.length;o<=u;o++){if(s.length)t.push(s.shift());t.push(i[n.parts[o]])}return t.join("")},headTemplate:"<thead>"+"<tr>"+'<th class="prev"><i class="icon-arrow-left"/></th>'+'<th colspan="5" class="datepicker-switch"></th>'+'<th class="next"><i class="icon-arrow-right"/></th>'+"</tr>"+"</thead>",contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>',footTemplate:'<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'};c.template='<div class="datepicker">'+'<div class="datepicker-days">'+'<table class=" table-condensed">'+c.headTemplate+"<tbody></tbody>"+c.footTemplate+"</table>"+"</div>"+'<div class="datepicker-months">'+'<table class="table-condensed">'+c.headTemplate+c.contTemplate+c.footTemplate+"</table>"+"</div>"+'<div class="datepicker-years">'+'<table class="table-condensed">'+c.headTemplate+c.contTemplate+c.footTemplate+"</table>"+"</div>"+"</div>";e.fn.datepicker.DPGlobal=c;e.fn.datepicker.noConflict=function(){e.fn.datepicker=u;return this};e(document).on("focus.datepicker.data-api click.datepicker.data-api",'[data-provide="datepicker"]',function(t){var n=e(this);if(n.data("datepicker"))return;t.preventDefault();n.datepicker("show")});e(function(){e('[data-provide="datepicker-inline"]').datepicker()})})(window.jQuery)