import{S as e,i as t,s as l,$ as r,F as n,P as i,G as a,V as c,q as s,a0 as o,v as u,H as f,a1 as d,t as m,z as p,b as g,w as y,x as h,W as $,D as T,R as D,T as I,U as b,a5 as x,B as C,a6 as F,a7 as v,h as S,a8 as B,a9 as k,y as w,J as O,L as P,o as Q,aa as N,ab as V,Q as A,a3 as j,C as q,k as E,ac as J,ad as K,l as L,p as _,m as H,r as M,j as G,K as z,ae as R,af as U,n as W}from"./main-f3bc643b.js";import{B as X}from"./BlockMaker-6b9ad4a5.js";function Y(e){let t,l=!1,r=!1,n=!1;return e.selected?(l=e.selected===e.dynamicField.value,e.selected!=e.dynamicField.value&&(t=e.dynamicField.value)):t=e.dynamicField.value,0===e.termCounter?.[e.dynamicField.value]&&(r=!0),r||e.groupTabIndex||(n=!0,e.groupTabIndex=!0),{isActive:l,changeValue:t,isDisabled:r,isTabIndex:n}}function Z(e){let t,l=!1,r=!1,n=!1;if(e.selected){let r=e.selected.split(",");Array.isArray(r)?r.includes(e.dynamicField.value||e.dynamicField.slug)||r.includes(e.dynamicField?.value?.toString())?(l=!0,t=r.filter((t=>t!=e.dynamicField.slug&&t!=e.dynamicField.value))):(t=[...r],t.push(e.dynamicField.value||e.dynamicField.slug)):e.selected===(e.dynamicField.value||e.dynamicField.slug)&&(l=!0,t="")}else t=[e.dynamicField.value||e.dynamicField.slug];return 0===e.termCounter?.[e.dynamicField.value]&&(r=!0),r||e.groupTabIndex||(n=!0,e.groupTabIndex=!0),{isActive:l,changeValue:t,isDisabled:r,isTabIndex:n}}function ee(e,t,l){const r=e.slice();return r[14]=t[l],r[16]=l,r}function te(e){let t,l,r;return{c(){t=c("("),l=c(e[9]),r=c(")")},m(e,n){u(e,t,n),u(e,l,n),u(e,r,n)},p(e,t){512&t&&$(l,e[9])},d(e){e&&h(t),e&&h(l),e&&h(r)}}}function le(e){let t,l,r=e[0].children,n=[];for(let t=0;t<r.length;t+=1)n[t]=re(ee(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(63&l){let a;for(r=e[0].children,a=0;a<r.length;a+=1){const i=ee(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=re(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function re(e){let t,l;return t=new ae({props:{selected:e[1],selectOption:e[14],termCounter:e[2],groupTabIndex:e[3],childIndex:e[4]?e[4]+1:1,filterCountItems:e[5]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};2&l&&(r.selected=e[1]),1&l&&(r.selectOption=e[14]),4&l&&(r.termCounter=e[2]),8&l&&(r.groupTabIndex=e[3]),16&l&&(r.childIndex=e[4]?e[4]+1:1),32&l&&(r.filterCountItems=e[5]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function ne(e){let t,l,$,T,D,I,b,x,C,F=e[9]&&te(e),v=[{...e[8]},{disabled:e[10]},{__value:I=e[0]?e[6]?e[0][e[6]]:e[0].value:""}],S={};for(let e=0;e<v.length;e+=1)S=r(S,v[e]);let B=e[0].children&&le(e);return{c(){t=n("option"),l=new i(!1),$=a(),T=c(e[11]),D=a(),F&&F.c(),b=a(),B&&B.c(),x=s(),l.a=$,o(t,S)},m(r,n){u(r,t,n),l.m(e[7],t),f(t,$),f(t,T),f(t,D),F&&F.m(t,null),u(r,b,n),B&&B.m(r,n),u(r,x,n),C=!0},p(e,[r]){(!C||128&r)&&l.p(e[7]),e[9]?F?F.p(e,r):(F=te(e),F.c(),F.m(t,null)):F&&(F.d(1),F=null),o(t,S=d(v,[256&r&&{...e[8]},(!C||1024&r)&&{disabled:e[10]},(!C||65&r&&I!==(I=e[0]?e[6]?e[0][e[6]]:e[0].value:""))&&{__value:I}])),e[0].children?B?(B.p(e,r),1&r&&m(B,1)):(B=le(e),B.c(),m(B,1),B.m(x.parentNode,x)):B&&(p(),g(B,1,1,(()=>{B=null})),y())},i(e){C||(m(B),C=!0)},o(e){g(B),C=!1},d(e){e&&h(t),F&&F.d(),e&&h(b),B&&B.d(e),e&&h(x)}}}function ie(e,t,l){let r,n,i,{selectOption:a}=t,{selected:c}=t,{termCounter:s}=t,{groupTabIndex:o}=t,{childIndex:u}=t,{filterCountItems:f}=t,{filterTaxField:d}=t,{hasToBeSelected:m}=t,p=a.name?a.name:a.label?a.label:"",g={},y="";return u&&(y=Array.from({length:u},((e,t)=>"&nbsp;"))),e.$$set=e=>{"selectOption"in e&&l(0,a=e.selectOption),"selected"in e&&l(1,c=e.selected),"termCounter"in e&&l(2,s=e.termCounter),"groupTabIndex"in e&&l(3,o=e.groupTabIndex),"childIndex"in e&&l(4,u=e.childIndex),"filterCountItems"in e&&l(5,f=e.filterCountItems),"filterTaxField"in e&&l(6,d=e.filterTaxField),"hasToBeSelected"in e&&l(12,m=e.hasToBeSelected)},e.$$.update=()=>{1&e.$$.dirty&&!a.value&&a.slug&&l(0,a.value=a.slug,a),4099&e.$$.dirty&&(c===a.value||m)&&l(8,g.selected=!0,g),15&e.$$.dirty&&l(13,n=Y({selected:c,dynamicField:a,termCounter:s,groupTabIndex:o})),8192&e.$$.dirty&&l(10,r=n?.isDisabled),128&e.$$.dirty&&Array.isArray(y)&&l(7,y=y.join("")),37&e.$$.dirty&&f&&s[a.value]&&l(9,i=s?.[a.value])},[a,c,s,o,u,f,d,y,g,i,r,p,m,n]}class ae extends e{constructor(e){super(),t(this,e,ie,ne,l,{selectOption:0,selected:1,termCounter:2,groupTabIndex:3,childIndex:4,filterCountItems:5,filterTaxField:6,hasToBeSelected:12})}}function ce(e){if(e.specificTarget){let t;e.setFirst&&e.setFirst(),t="true"===e.changeValue||"false"!==e.changeValue&&(Array.isArray(e.changeValue)&&1===e.changeValue.length?e.changeValue.join("|"):e.changeValue?e.changeValue:"");let l=!1;e.specificTarget.includes("|")&&(l=!0);let r,n=e.selected;n&&(n=n.split(","),Array.isArray(n)&&n.includes(e.filterValue)&&(r=!0));const i=e.termCounter?.[e.filterValue];"buttonmultiple"!==e.type&&"filtercheckbox"!==e.type||0==i&&i?r?x({id:e.filterQueryID,objectPath:l,param:e.specificTarget}):C({id:e.filterQueryID,objectPath:l,param:e.specificTarget,value:t,originalParam:e.target,filterDefaults:e.filterDefaults}):r&&n&&1===n.length&&n[0]===e.filterValue?x({id:e.filterQueryID,objectPath:l,param:e.specificTarget}):C({id:e.filterQueryID,objectPath:l,param:e.specificTarget,value:t,originalParam:e.target,filterDefaults:e.filterDefaults})}}function se(e,t,l){let r;return e.filters&&e.filters[e.filterQueryID]&&Object.entries(e.filters).forEach((e=>{e[1]&&Object.entries(e[1]).forEach((n=>{t===n[1].filterTarget&&("userinput"===n[1].filterSource?r=l:"static"===n[1].filterSource?n[1].filterStaticData&&n[1].filterStaticData.forEach((e=>{l===e.value&&e.label&&(r=e.label)})):"dynamic"===n[1].filterSource&&n[1].dynamicFields&&n[1].dynamicFields.length&&(e[1]&&Object.entries(e[1]).forEach((e=>{e[1].filterTarget===t&&e[1].dynamicFields.forEach((e=>{e[n[1].filterTaxField]&&e[n[1].filterTaxField]==l&&(r=e.name)}))})),r||n[1].dynamicFields.forEach((e=>{l===e.slug&&e.name&&(r=e.name)}))))}))})),r}function oe(e,t,l){const r=e.slice();return r[48]=t[l],r[50]=l,r}function ue(e,t,l){const r=e.slice();return r[52]=t[l],r[50]=l,r}function fe(e,t,l){const r=e.slice();return r[48]=t[l],r[50]=l,r}function de(e,t,l){const r=e.slice();return r[48]=t[l],r[50]=l,r}function me(e,t,l){const r=e.slice();return r[48]=t[l],r[50]=l,r}function pe(e,t,l){const r=e.slice();return r[44]=t[l],r[46]=l,r}function ge(e,t,l){const r=e.slice();return r[44]=t[l],r[46]=l,r}function ye(e){let t,l,r,i,a,c=e[4]&&e[4].length&&Ie(e);return{c(){t=n("button"),c&&c.c(),A(t,"type","button"),A(t,"class","cc-filter-clear"),A(t,"aria-label","Clear Filtering"),t.disabled=l=!e[26]||null},m(l,n){u(l,t,n),c&&c.m(t,null),r=!0,i||(a=j(t,"click",e[42]),i=!0)},p(e,n){e[4]&&e[4].length?c?(c.p(e,n),16&n[0]&&m(c,1)):(c=Ie(e),c.c(),m(c,1),c.m(t,null)):c&&(p(),g(c,1,1,(()=>{c=null})),y()),(!r||67108864&n[0]&&l!==(l=!e[26]||null))&&(t.disabled=l)},i(e){r||(m(c),r=!0)},o(e){g(c),r=!1},d(e){e&&h(t),c&&c.d(),i=!1,a()}}}function he(e){let t,l,r=e[21],n=[];for(let t=0;t<r.length;t+=1)n[t]=we(ue(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(3224048&l[0]){let a;for(r=e[21],a=0;a<r.length;a+=1){const i=ue(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=we(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function $e(e){let t,l,r=e[4]&&e[4].length&&Oe(e);return{c(){r&&r.c(),t=s()},m(e,n){r&&r.m(e,n),u(e,t,n),l=!0},p(e,l){e[4]&&e[4].length?r?(r.p(e,l),16&l[0]&&m(r,1)):(r=Oe(e),r.c(),m(r,1),r.m(t.parentNode,t)):r&&(p(),g(r,1,1,(()=>{r=null})),y())},i(e){l||(m(r),l=!0)},o(e){g(r),l=!1},d(e){r&&r.d(e),e&&h(t)}}}function Te(e){let t,l,r,i,a,c,s,o,f=e[4]&&e[4].length&&Ve(e);return{c(){t=n("button"),f&&f.c(),A(t,"type","button"),A(t,"aria-disabled",l=!!e[29]||null),t.disabled=r=!!e[29]||null,A(t,"aria-pressed",e[31]),A(t,"tabindex",i=e[1]?e[31]?0:-1:e[28]?0:-1),A(t,"class",a=`cc-filter-item${e[31]?" selected":""}${e[29]?" disabled":""}`),A(t,"style",e[25])},m(l,r){u(l,t,r),f&&f.m(t,null),c=!0,s||(o=j(t,"click",e[38]),s=!0)},p(e,n){e[4]&&e[4].length?f?(f.p(e,n),16&n[0]&&m(f,1)):(f=Ve(e),f.c(),m(f,1),f.m(t,null)):f&&(p(),g(f,1,1,(()=>{f=null})),y()),(!c||536870912&n[0]&&l!==(l=!!e[29]||null))&&A(t,"aria-disabled",l),(!c||536870912&n[0]&&r!==(r=!!e[29]||null))&&(t.disabled=r),(!c||1&n[1])&&A(t,"aria-pressed",e[31]),(!c||268435458&n[0]|1&n[1]&&i!==(i=e[1]?e[31]?0:-1:e[28]?0:-1))&&A(t,"tabindex",i),(!c||536870912&n[0]|1&n[1]&&a!==(a=`cc-filter-item${e[31]?" selected":""}${e[29]?" disabled":""}`))&&A(t,"class",a),(!c||33554432&n[0])&&A(t,"style",e[25])},i(e){c||(m(f),c=!0)},o(e){g(f),c=!1},d(e){e&&h(t),f&&f.d(),s=!1,o()}}}function De(e){let t,l,r,i,a,c,o,d=e[17]&&Ee(e);const $=[Ke,Je],T=[];function D(e,t){return"dynamic"===e[6]?0:"static"===e[6]?1:-1}return~(r=D(e))&&(i=T[r]=$[r](e)),{c(){t=n("select"),d&&d.c(),l=s(),i&&i.c()},m(n,i){u(n,t,i),d&&d.m(t,null),f(t,l),~r&&T[r].m(t,null),a=!0,c||(o=j(t,"change",e[37]),c=!0)},p(e,n){e[17]?d?d.p(e,n):(d=Ee(e),d.c(),d.m(t,l)):d&&(d.d(1),d=null);let a=r;r=D(e),r===a?~r&&T[r].p(e,n):(i&&(p(),g(T[a],1,1,(()=>{T[a]=null})),y()),~r?(i=T[r],i?i.p(e,n):(i=T[r]=$[r](e),i.c()),m(i,1),i.m(t,null)):i=null)},i(e){a||(m(i),a=!0)},o(e){g(i),a=!1},d(e){e&&h(t),d&&d.d(),~r&&T[r].d(),c=!1,o()}}}function Ie(e){let t,l,r=e[4],n=[];for(let t=0;t<r.length;t+=1)n[t]=Ce(oe(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(65968&l[0]){let a;for(r=e[4],a=0;a<r.length;a+=1){const i=oe(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=Ce(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function be(e){let t,l,r=e[48].innerHTML+"";return{c(){t=new i(!1),l=a(),t.a=l},m(e,n){t.m(r,e,n),u(e,l,n)},p(e,l){16&l[0]&&r!==(r=e[48].innerHTML+"")&&t.p(r)},i:q,o:q,d(e){e&&t.d(),e&&h(l)}}}function xe(e){let t,l;return t=new X({props:{attributes:e[48],index:e[50],item:{filterType:e[5],filterID:e[7],filterTarget:e[8],filterTaxField:e[16]},general:null,blockContext:null,queryType:null,dynamicData:null}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};16&l[0]&&(r.attributes=e[48]),65952&l[0]&&(r.item={filterType:e[5],filterID:e[7],filterTarget:e[8],filterTaxField:e[16]}),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function Ce(e){let t,l,r,n,i;const a=[xe,be],c=[];function o(e,l){return 16&l[0]&&(t=null),null==t&&(t=!!e[48].blockName.includes("cwicly")),t?0:1}return l=o(e,[-1,-1]),r=c[l]=a[l](e),{c(){r.c(),n=s()},m(e,t){c[l].m(e,t),u(e,n,t),i=!0},p(e,t){let i=l;l=o(e,t),l===i?c[l].p(e,t):(p(),g(c[i],1,1,(()=>{c[i]=null})),y(),r=c[l],r?r.p(e,t):(r=c[l]=a[l](e),r.c()),m(r,1),r.m(n.parentNode,n))},i(e){i||(m(r),i=!0)},o(e){g(r),i=!1},d(e){c[l].d(e),e&&h(n)}}}function Fe(e){let t,l,r,i,c,s=e[4]&&e[4].length&&ve(e);function o(){return e[41](e[52])}return{c(){t=n("button"),s&&s.c(),l=a(),A(t,"type","button"),A(t,"tabindex",0),A(t,"aria-pressed",""),A(t,"class","cc-filter-selection")},m(e,n){u(e,t,n),s&&s.m(t,null),f(t,l),r=!0,i||(c=j(t,"click",o),i=!0)},p(r,n){(e=r)[4]&&e[4].length?s?(s.p(e,n),16&n[0]&&m(s,1)):(s=ve(e),s.c(),m(s,1),s.m(t,l)):s&&(p(),g(s,1,1,(()=>{s=null})),y())},i(e){r||(m(s),r=!0)},o(e){g(s),r=!1},d(e){e&&h(t),s&&s.d(),i=!1,c()}}}function ve(e){let t,l,r=e[4],n=[];for(let t=0;t<r.length;t+=1)n[t]=ke(fe(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(2163184&l[0]){let a;for(r=e[4],a=0;a<r.length;a+=1){const i=fe(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=ke(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function Se(e){let t,l,r=e[48].innerHTML+"";return{c(){t=new i(!1),l=a(),t.a=l},m(e,n){t.m(r,e,n),u(e,l,n)},p(e,l){16&l[0]&&r!==(r=e[48].innerHTML+"")&&t.p(r)},i:q,o:q,d(e){e&&t.d(),e&&h(l)}}}function Be(e){let t,l;return t=new X({props:{attributes:e[48],index:e[50],item:{filterType:e[5],filterID:e[7],filterTarget:e[8],selection:e[52],filterTaxField:e[16]},general:null,blockContext:null,queryType:null,dynamicData:null,filterSource:e[6]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};16&l[0]&&(r.attributes=e[48]),2163104&l[0]&&(r.item={filterType:e[5],filterID:e[7],filterTarget:e[8],selection:e[52],filterTaxField:e[16]}),64&l[0]&&(r.filterSource=e[6]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function ke(e){let t,l,r,n,i;const a=[Be,Se],c=[];function o(e,l){return 16&l[0]&&(t=null),null==t&&(t=!!e[48].blockName.includes("cwicly")),t?0:1}return l=o(e,[-1,-1]),r=c[l]=a[l](e),{c(){r.c(),n=s()},m(e,t){c[l].m(e,t),u(e,n,t),i=!0},p(e,t){let i=l;l=o(e,t),l===i?c[l].p(e,t):(p(),g(c[i],1,1,(()=>{c[i]=null})),y(),r=c[l],r?r.p(e,t):(r=c[l]=a[l](e),r.c()),m(r,1),r.m(n.parentNode,n))},i(e){i||(m(r),i=!0)},o(e){g(r),i=!1},d(e){c[l].d(e),e&&h(n)}}}function we(e){let t,l,r=e[52].name&&Fe(e);return{c(){r&&r.c(),t=s()},m(e,n){r&&r.m(e,n),u(e,t,n),l=!0},p(e,l){e[52].name?r?(r.p(e,l),2097152&l[0]&&m(r,1)):(r=Fe(e),r.c(),m(r,1),r.m(t.parentNode,t)):r&&(p(),g(r,1,1,(()=>{r=null})),y())},i(e){l||(m(r),l=!0)},o(e){g(r),l=!1},d(e){r&&r.d(e),e&&h(t)}}}function Oe(e){let t,l,r=e[4],n=[];for(let t=0;t<r.length;t+=1)n[t]=Ne(de(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(820735&l[0]){let a;for(r=e[4],a=0;a<r.length;a+=1){const i=de(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=Ne(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function Pe(e){let t;return{c(){t=n("div"),t.textContent="not cwicly block"},m(e,l){u(e,t,l)},p:q,i:q,o:q,d(e){e&&h(t)}}}function Qe(e){let t,l;return t=new X({props:{attributes:e[48],index:e[50],item:{filter:e[0],filterType:e[5],filterID:e[7],itemscount:e[2]?.[e[0].value],filterTarget:e[8]},general:null,blockContext:null,queryType:null,dynamicData:null,filterSource:e[6],selected:e[1],filterDataType:e[15]}}),t.$on("filteruserinput",(function(...t){return e[39](e[48],...t)})),t.$on("rangeselectchange",e[40]),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(l,r){e=l;const n={};16&r[0]&&(n.attributes=e[48]),421&r[0]&&(n.item={filter:e[0],filterType:e[5],filterID:e[7],itemscount:e[2]?.[e[0].value],filterTarget:e[8]}),64&r[0]&&(n.filterSource=e[6]),2&r[0]&&(n.selected=e[1]),32768&r[0]&&(n.filterDataType=e[15]),t.$set(n)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function Ne(e){let t,l,r,n,i;const a=[Qe,Pe],c=[];function o(e,l){return 16&l[0]&&(t=null),null==t&&(t=!!e[48].blockName.includes("cwicly")),t?0:1}return l=o(e,[-1,-1]),r=c[l]=a[l](e),{c(){r.c(),n=s()},m(e,t){c[l].m(e,t),u(e,n,t),i=!0},p(e,t){let i=l;l=o(e,t),l===i?c[l].p(e,t):(p(),g(c[i],1,1,(()=>{c[i]=null})),y(),r=c[l],r?r.p(e,t):(r=c[l]=a[l](e),r.c()),m(r,1),r.m(n.parentNode,n))},i(e){i||(m(r),i=!0)},o(e){g(r),i=!1},d(e){c[l].d(e),e&&h(n)}}}function Ve(e){let t,l,r=e[4],n=[];for(let t=0;t<r.length;t+=1)n[t]=qe(me(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(437&l[0]){let a;for(r=e[4],a=0;a<r.length;a+=1){const i=me(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=qe(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function Ae(e){let t;return{c(){t=n("div"),t.textContent="not cwicly block"},m(e,l){u(e,t,l)},p:q,i:q,o:q,d(e){e&&h(t)}}}function je(e){let t,l;return t=new X({props:{attributes:e[48],index:e[50],item:{filter:e[0],filterType:e[5],filterID:e[7],itemscount:e[2]?.[e[0].value],filterTarget:e[8]},general:null,blockContext:null,queryType:null,dynamicData:null}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};16&l[0]&&(r.attributes=e[48]),421&l[0]&&(r.item={filter:e[0],filterType:e[5],filterID:e[7],itemscount:e[2]?.[e[0].value],filterTarget:e[8]}),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function qe(e){let t,l,r,n,i;const a=[je,Ae],c=[];function o(e,l){return 16&l[0]&&(t=null),null==t&&(t=!!e[48].blockName.includes("cwicly")),t?0:1}return l=o(e,[-1,-1]),r=c[l]=a[l](e),{c(){r.c(),n=s()},m(e,t){c[l].m(e,t),u(e,n,t),i=!0},p(e,t){let i=l;l=o(e,t),l===i?c[l].p(e,t):(p(),g(c[i],1,1,(()=>{c[i]=null})),y(),r=c[l],r?r.p(e,t):(r=c[l]=a[l](e),r.c()),m(r,1),r.m(n.parentNode,n))},i(e){i||(m(r),i=!0)},o(e){g(r),i=!1},d(e){c[l].d(e),e&&h(n)}}}function Ee(e){let t,l,i=[e[27],{__value:""}],a={};for(let e=0;e<i.length;e+=1)a=r(a,i[e]);return{c(){t=n("option"),l=c(e[17]),o(t,a)},m(e,r){u(e,t,r),f(t,l)},p(e,r){131072&r[0]&&$(l,e[17]),o(t,a=d(i,[134217728&r[0]&&e[27],{__value:""}]))},d(e){e&&h(t)}}}function Je(e){let t,l,r=e[14],n=[];for(let t=0;t<r.length;t+=1)n[t]=Le(pe(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(149518&l[0]){let a;for(r=e[14],a=0;a<r.length;a+=1){const i=pe(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=Le(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function Ke(e){let t,l,r=e[24],n=[];for(let t=0;t<r.length;t+=1)n[t]=_e(ge(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(16975886&l[0]){let a;for(r=e[24],a=0;a<r.length;a+=1){const i=ge(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=_e(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function Le(e){let t,l;return t=new ae({props:{hasToBeSelected:0===e[46]&&!e[1]&&!e[17],childIndex:null,selected:e[1],selectOption:e[44],termCounter:e[2],groupTabIndex:e[3],filterCountItems:e[11]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};131074&l[0]&&(r.hasToBeSelected=0===e[46]&&!e[1]&&!e[17]),2&l[0]&&(r.selected=e[1]),16384&l[0]&&(r.selectOption=e[44]),4&l[0]&&(r.termCounter=e[2]),8&l[0]&&(r.groupTabIndex=e[3]),2048&l[0]&&(r.filterCountItems=e[11]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function _e(e){let t,l;return t=new ae({props:{hasToBeSelected:0===e[46]&&!e[1]&&!e[17],childIndex:null,selected:e[1],selectOption:e[44],termCounter:e[2],groupTabIndex:e[3],filterCountItems:e[11],filterTaxField:e[16]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};131074&l[0]&&(r.hasToBeSelected=0===e[46]&&!e[1]&&!e[17]),2&l[0]&&(r.selected=e[1]),16777216&l[0]&&(r.selectOption=e[44]),4&l[0]&&(r.termCounter=e[2]),8&l[0]&&(r.groupTabIndex=e[3]),2048&l[0]&&(r.filterCountItems=e[11]),65536&l[0]&&(r.filterTaxField=e[16]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function He(e){let t,l,r,n;const i=[De,Te,$e,he,ye],a=[];function c(e,t){return"select"===e[5]?0:"buttonsingle"===e[5]||"buttonmultiple"===e[5]?1:"custom"===e[5]||"rangeselection"===e[5]?2:"userselection"===e[5]&&e[21]&&e[21].length?3:"clearselection"===e[5]&&e[26]?4:-1}return~(t=c(e))&&(l=a[t]=i[t](e)),{c(){l&&l.c(),r=s()},m(e,l){~t&&a[t].m(e,l),u(e,r,l),n=!0},p(e,n){let s=t;t=c(e),t===s?~t&&a[t].p(e,n):(l&&(p(),g(a[s],1,1,(()=>{a[s]=null})),y()),~t?(l=a[t],l?l.p(e,n):(l=a[t]=i[t](e),l.c()),m(l,1),l.m(r.parentNode,r)):l=null)},i(e){n||(m(l),n=!0)},o(e){g(l),n=!1},d(e){~t&&a[t].d(e),e&&h(r)}}}function Me(e,t,l){let r,n,i,a,c,s;w(e,O,(e=>l(22,c=e))),w(e,P,(e=>l(23,s=e)));let o,u,f,d,{dynamicField:m}=t,{dynamicFields:p}=t,{selected:g}=t,{termCounter:y}=t,{groupTabIndex:h}=t,{innerBlocks:$}=t,{type:T}=t,{filterSource:D}=t,{filterQueryID:I}=t,{filterBlockID:b}=t,{specificTarget:A}=t,{termsCount:j}=t,{target:q}=t,{filterCountItems:E}=t,{params:J}=t,{queryArgs:K}=t,{staticData:L}=t,{filterDataType:_}=t,{filterTaxField:H}=t,{filterPlaceholder:M}=t,{filterDefaults:G}=t,{setFirst:z}=t,{selectionKey:R}=t,{selectionValue:U}=t;Q((()=>{"buttonsingle"!==T&&"buttonmultiple"!==T||m.value||(H&&m[H]?l(0,m.value=m[H],m):m.value||l(0,m.value=m.slug,m))})),"buttonsingle"!==T&&"buttonmultiple"!==T||(f=function(e){let t="";return e.wooColor&&(t+=`--cc-wac:${e.wooColor};`),e.wooImage&&(t+=`--background-image:url("${e.wooImage}");`),t}(m));let W,X=[],ee={};return e.$$set=e=>{"dynamicField"in e&&l(0,m=e.dynamicField),"dynamicFields"in e&&l(32,p=e.dynamicFields),"selected"in e&&l(1,g=e.selected),"termCounter"in e&&l(2,y=e.termCounter),"groupTabIndex"in e&&l(3,h=e.groupTabIndex),"innerBlocks"in e&&l(4,$=e.innerBlocks),"type"in e&&l(5,T=e.type),"filterSource"in e&&l(6,D=e.filterSource),"filterQueryID"in e&&l(7,I=e.filterQueryID),"filterBlockID"in e&&l(33,b=e.filterBlockID),"specificTarget"in e&&l(8,A=e.specificTarget),"termsCount"in e&&l(9,j=e.termsCount),"target"in e&&l(10,q=e.target),"filterCountItems"in e&&l(11,E=e.filterCountItems),"params"in e&&l(12,J=e.params),"queryArgs"in e&&l(13,K=e.queryArgs),"staticData"in e&&l(14,L=e.staticData),"filterDataType"in e&&l(15,_=e.filterDataType),"filterTaxField"in e&&l(16,H=e.filterTaxField),"filterPlaceholder"in e&&l(17,M=e.filterPlaceholder),"filterDefaults"in e&&l(18,G=e.filterDefaults),"setFirst"in e&&l(19,z=e.setFirst),"selectionKey"in e&&l(20,R=e.selectionKey),"selectionValue"in e&&l(34,U=e.selectionValue)},e.$$.update=()=>{if(111&e.$$.dirty[0]|2&e.$$.dirty[1]&&("buttonsingle"===T?l(35,u=Y({selected:g,dynamicField:m,termCounter:y,groupTabIndex:h})):"buttonmultiple"===T?l(35,u=Z({selected:g,dynamicField:m,termCounter:y,groupTabIndex:h})):"select"===T&&"dynamic"===D&&l(24,o=N(p,"term_id","parent"))),16&e.$$.dirty[1]&&l(31,r=u?.isActive),16&e.$$.dirty[1]&&l(30,n=u?.changeValue),16&e.$$.dirty[1]&&l(29,i=u?.isDisabled),16&e.$$.dirty[1]&&l(28,a=u?.isTabIndex),15728800&e.$$.dirty[0]|44&e.$$.dirty[1]&&"userselection"===T&&(l(36,d=function(e,t){let l;return e.filters&&e.filters[e.filterQueryID]&&Object.entries(e.filters).forEach((r=>{r[1]&&Object.entries(r[1]).forEach((r=>{t===r[1].filterTarget&&r[1].filterQueryID===e.filterQueryID&&(l={type:r[1].filterType,source:r[1].filterSource,show:r[1].filterShowInSelection,prefix:r[1].prefix,suffix:r[1].suffix})}))})),l}({filters:c,filterQueryID:I,filterBlockID:b},R)),d&&0!=d.show)){if(V({$filters:c,selectionValue:U,selectionKey:R,filterQueryID:I}))X&&X.length>0&&l(21,X=[]);else{let e=d.prefix?d.prefix:"",t=d.suffix?d.suffix:"";if("rangeselection"===d.type){let r=U.split(",");"dynamic"===d.source&&(CCers.woo&&CCers.woo.currency?"left"===CCers.woo?.currencyPosition?e=CCers.woo.currency:"left_space"===CCers.woo?.currencyPosition?e=`${CCers.woo.currency}&nbsp;`:"right"===CCers.woo?.currencyPosition?t=CCers.woo.currency:"right_space"===CCers.woo?.currencyPosition&&(t=`&nbsp;${CCers.woo.currency}`):e="$"),l(21,X=[{name:`${e}${r[0]}${t}${r[1]?` - ${e}${r[1]}${t}`:""}`,value:""}])}else l(21,X=[]),U.split(",").forEach((l=>{let r;s[R].includes(",")&&"rangeselection"!=d.type&&(r=s[R].split(","),r=r.filter((e=>e!==l)),r=r.join(","));se({filters:c,filterQueryID:I,filterBlockID:b},R,l)&&X.push({name:`${e}${se({filters:c,filterQueryID:I,filterBlockID:b},R,l)}${t}`,value:r})}))}}13635744&e.$$.dirty[0]|8&e.$$.dirty[1]&&"clearselection"===T&&l(26,W=function(e){if(e.params){const t=F(e),l=v(e);let r=!1;return Object.entries(e.params).forEach((n=>{if(e.urlParams.hasOwnProperty(n[1])&&e.urlParams[n[1]]&&"page"!=n[0]&&"paged"!=n[0]&&!l.includes(n[1])){const l=e.urlParams[n[1]].split(",");t&&t[n[1]]&&t[n[1]].length===l.length&&t[n[1]].every(((e,t)=>l.includes(e)))||(r=!0)}})),r}}({params:J,urlParams:s,$filters:c,selectionValue:U,selectionKey:R,filterQueryID:I})),e.$$.dirty[0],2&e.$$.dirty[0]&&(g||l(27,ee={selected:!0}))},[m,g,y,h,$,T,D,I,A,j,q,E,J,K,L,_,H,M,G,z,R,X,c,s,o,f,W,ee,a,i,n,r,p,b,U,u,d,e=>ce({filterValue:e.target.value,changeValue:e.target.value,selected:g,type:T,target:q,filterQueryID:I,specificTarget:A||q,termsCount:j,setFirst:z,filterDefaults:G}),()=>ce({filterValue:m.value,changeValue:n,selected:g,type:T,target:q,filterQueryID:I,specificTarget:A,termsCount:j,setFirst:z,filterDefaults:G}),(e,t)=>ce({filterValue:t.detail.text,changeValue:"filtercheckbox"!=e?.attrs?.input?.inputTemplate?t.detail.text:Z({selected:g,dynamicField:m,termCounter:y,groupTabIndex:h}).changeValue,selected:g,type:t.detail.inputType,target:q,filterQueryID:I,specificTarget:A||q,setFirst:z,filterDefaults:G}),e=>ce({filterValue:e.detail.text,changeValue:e.detail.text,selected:g,type:e.detail.inputType,target:q,filterQueryID:I,specificTarget:A||q,setFirst:z,filterDefaults:G}),e=>function(e){let t,l=!1,r=S(e.selectionKey,e.params);r&&r.includes("|")&&(l=B(r,e.queryArgs)),t=e.filterNewValue&&e.filterNewValue.includes(",")?e.filterNewValue.split(","):e.filterNewValue,t?C({id:e.filterQueryID,objectPath:l,param:r,value:t}):x({id:e.filterQueryID,objectPath:l,param:r})}({selectionKey:R,params:J,queryArgs:K,filterNewValue:e.value,filterQueryID:I,specificTarget:A}),()=>{var e;k({id:(e={filterQueryID:I,filters:c,urlParams:s}).filterQueryID,filters:e.filters,urlParams:e.urlParams})}]}class Ge extends e{constructor(e){super(),t(this,e,Me,He,l,{dynamicField:0,dynamicFields:32,selected:1,termCounter:2,groupTabIndex:3,innerBlocks:4,type:5,filterSource:6,filterQueryID:7,filterBlockID:33,specificTarget:8,termsCount:9,target:10,filterCountItems:11,params:12,queryArgs:13,staticData:14,filterDataType:15,filterTaxField:16,filterPlaceholder:17,filterDefaults:18,setFirst:19,selectionKey:20,selectionValue:34},null,[-1,-1])}}function ze(e,t=!1,l){if(l.filterCountItems&&l.$queries[l.filterQueryID]?.args?.queryargs){const r=l.$queries[l.filterQueryID].args?.params;let n=JSON.parse(JSON.stringify(l.$queries[l.filterQueryID].args.queryargs)),i=S(l.target,r);if(i&&i.includes("|")?G(n,e,i):n[l.target]=t?e:"true"===e||!0===e||"false"!==e&&!1!==e&&e,delete n.limit,delete n.page,delete n.paged,delete n.orderby,delete n.order,n=JSON.stringify(n),l.$termsCount[l.filterQueryID])return l.$termsCount[l.filterQueryID][E(n)]}}function Re(e,t,l){const r=e.slice();return r[38]=t[l][0],r[39]=t[l][1],r}function Ue(e,t,l){const r=e.slice();return r[33]=t[l],r}function We(e,t,l){const r=e.slice();return r[33]=t[l],r}function Xe(e){let t,l;return t=new Ge({props:{params:e[1],queryArgs:null,selectionKey:null,selectionValue:null,dynamicField:null,dynamicFields:null,selected:e[6],termCounter:e[3],groupTabIndex:e[19],innerBlocks:e[8],filterSource:e[12],type:e[13],filterQueryID:e[9],filterBlockID:e[10],specificTarget:e[5],termsCount:W,target:e[11],filterCountItems:e[16],filterTaxField:e[17],setFirst:e[20],filterDefaults:e[4]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};2&l[0]&&(r.params=e[1]),64&l[0]&&(r.selected=e[6]),8&l[0]&&(r.termCounter=e[3]),32&l[0]&&(r.specificTarget=e[5]),16&l[0]&&(r.filterDefaults=e[4]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function Ye(e){let t,l,r=Object.entries(e[2]),n=[];for(let t=0;t<r.length;t+=1)n[t]=tt(Re(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(1785854&l[0]){let a;for(r=Object.entries(e[2]),a=0;a<r.length;a+=1){const i=Re(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=tt(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function Ze(e){let t,l,r,n;const i=[rt,lt],a=[];function c(e,t){return e[0]&&e[0].length||"pricingrange"===e[15]?0:1}return t=c(e),l=a[t]=i[t](e),{c(){l.c(),r=s()},m(e,l){a[t].m(e,l),u(e,r,l),n=!0},p(e,n){let s=t;t=c(e),t===s?a[t].p(e,n):(p(),g(a[s],1,1,(()=>{a[s]=null})),y(),l=a[t],l?l.p(e,n):(l=a[t]=i[t](e),l.c()),m(l,1),l.m(r.parentNode,r))},i(e){n||(m(l),n=!0)},o(e){g(l),n=!1},d(e){a[t].d(e),e&&h(r)}}}function et(e){let t,l,r,n;const i=[st,ct],a=[];return t=function(e,t){return"select"===e[13]?0:1}(e),l=a[t]=i[t](e),{c(){l.c(),r=s()},m(e,l){a[t].m(e,l),u(e,r,l),n=!0},p(e,t){l.p(e,t)},i(e){n||(m(l),n=!0)},o(e){g(l),n=!1},d(e){a[t].d(e),e&&h(r)}}}function tt(e){let t,l;return t=new Ge({props:{params:e[1],queryArgs:e[7],dynamicField:null,dynamicFields:null,selectionKey:e[38],selectionValue:e[39],selected:e[6],termCounter:e[3],groupTabIndex:e[19],innerBlocks:e[8],filterSource:e[12],type:e[13],filterQueryID:e[9],filterBlockID:e[10],specificTarget:e[5],termsCount:W,target:e[11],filterCountItems:e[16],filterTaxField:e[17],setFirst:e[20],filterDefaults:e[4]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};2&l[0]&&(r.params=e[1]),128&l[0]&&(r.queryArgs=e[7]),4&l[0]&&(r.selectionKey=e[38]),4&l[0]&&(r.selectionValue=e[39]),64&l[0]&&(r.selected=e[6]),8&l[0]&&(r.termCounter=e[3]),32&l[0]&&(r.specificTarget=e[5]),16&l[0]&&(r.filterDefaults=e[4]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function lt(e){let t;return{c(){t=n("div"),A(t,"class","cc-loading-skeleton")},m(e,l){u(e,t,l)},p:q,i:q,o:q,d(e){e&&h(t)}}}function rt(e){let t,l,r,n;const i=[it,nt],a=[];return t=function(e,t){return"select"===e[13]||"pricingrange"===e[15]?0:1}(e),l=a[t]=i[t](e),{c(){l.c(),r=s()},m(e,l){a[t].m(e,l),u(e,r,l),n=!0},p(e,t){l.p(e,t)},i(e){n||(m(l),n=!0)},o(e){g(l),n=!1},d(e){a[t].d(e),e&&h(r)}}}function nt(e){let t,l,r=e[0],n=[];for(let t=0;t<r.length;t+=1)n[t]=at(Ue(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(1785721&l[0]){let a;for(r=e[0],a=0;a<r.length;a+=1){const i=Ue(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=at(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function it(e){let t,l;return t=new Ge({props:{params:null,queryArgs:null,selectionKey:null,selectionValue:null,dynamicField:null,dynamicFields:e[0],selected:e[6],termCounter:e[3],groupTabIndex:e[19],innerBlocks:e[8],filterSource:e[12],type:e[13],filterQueryID:e[9],filterBlockID:e[10],filterDataType:e[15],specificTarget:e[5],termsCount:W,target:e[11],filterCountItems:e[16],filterTaxField:e[17],filterPlaceholder:e[18],setFirst:e[20],filterDefaults:e[4]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};1&l[0]&&(r.dynamicFields=e[0]),64&l[0]&&(r.selected=e[6]),8&l[0]&&(r.termCounter=e[3]),32&l[0]&&(r.specificTarget=e[5]),16&l[0]&&(r.filterDefaults=e[4]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function at(e){let t,l;return t=new Ge({props:{params:null,queryArgs:null,selectionKey:null,selectionValue:null,dynamicFields:null,dynamicField:e[33],selected:e[6],termCounter:e[3],groupTabIndex:e[19],innerBlocks:e[8],filterSource:e[12],type:e[13],filterQueryID:e[9],filterBlockID:e[10],specificTarget:e[5],termsCount:W,target:e[11],filterCountItems:e[16],filterTaxField:e[17],setFirst:e[20],filterDefaults:e[4]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};1&l[0]&&(r.dynamicField=e[33]),64&l[0]&&(r.selected=e[6]),8&l[0]&&(r.termCounter=e[3]),32&l[0]&&(r.specificTarget=e[5]),16&l[0]&&(r.filterDefaults=e[4]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function ct(e){let t,l,r=e[14],n=[];for(let t=0;t<r.length;t+=1)n[t]=ot(We(e,r,t));const i=e=>g(n[e],1,1,(()=>{n[e]=null}));return{c(){for(let e=0;e<n.length;e+=1)n[e].c();t=s()},m(e,r){for(let t=0;t<n.length;t+=1)n[t].m(e,r);u(e,t,r),l=!0},p(e,l){if(1671032&l[0]){let a;for(r=e[14],a=0;a<r.length;a+=1){const i=We(e,r,a);n[a]?(n[a].p(i,l),m(n[a],1)):(n[a]=ot(i),n[a].c(),m(n[a],1),n[a].m(t.parentNode,t))}for(p(),a=r.length;a<n.length;a+=1)i(a);y()}},i(e){if(!l){for(let e=0;e<r.length;e+=1)m(n[e]);l=!0}},o(e){n=n.filter(Boolean);for(let e=0;e<n.length;e+=1)g(n[e]);l=!1},d(e){T(n,e),e&&h(t)}}}function st(e){let t,l;return t=new Ge({props:{params:null,queryArgs:null,selectionKey:null,selectionValue:null,dynamicField:null,staticData:e[14],selected:e[6],termCounter:e[3],groupTabIndex:e[19],innerBlocks:e[8],filterSource:e[12],type:e[13],filterQueryID:e[9],filterBlockID:e[10],specificTarget:e[5],termsCount:W,target:e[11],filterCountItems:e[16],filterPlaceholder:e[18],setFirst:e[20],filterDefaults:e[4]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};64&l[0]&&(r.selected=e[6]),8&l[0]&&(r.termCounter=e[3]),32&l[0]&&(r.specificTarget=e[5]),16&l[0]&&(r.filterDefaults=e[4]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function ot(e){let t,l;return t=new Ge({props:{params:null,queryArgs:null,selectionKey:null,selectionValue:null,dynamicFields:null,dynamicField:e[33],selected:e[6],termCounter:e[3],groupTabIndex:e[19],innerBlocks:e[8],filterSource:e[12],type:e[13],filterQueryID:e[9],filterBlockID:e[10],specificTarget:e[5],termsCount:W,target:e[11],filterCountItems:e[16],setFirst:e[20],filterDefaults:e[4]}}),{c(){D(t.$$.fragment)},m(e,r){I(t,e,r),l=!0},p(e,l){const r={};64&l[0]&&(r.selected=e[6]),8&l[0]&&(r.termCounter=e[3]),32&l[0]&&(r.specificTarget=e[5]),16&l[0]&&(r.filterDefaults=e[4]),t.$set(r)},i(e){l||(m(t.$$.fragment,e),l=!0)},o(e){g(t.$$.fragment,e),l=!1},d(e){b(t,e)}}}function ut(e){let t,l,r,n;const i=[et,Ze,Ye,Xe],a=[];return~(t=function(e,t){return"static"===e[12]&&e[14]&&e[14].length?0:"dynamic"===e[12]?1:"userselection"===e[13]?2:"clearselection"===e[13]||"rangeselection"===e[13]||"userinput"===e[12]&&"custom"===e[13]?3:-1}(e))&&(l=a[t]=i[t](e)),{c(){l&&l.c(),r=s()},m(e,l){~t&&a[t].m(e,l),u(e,r,l),n=!0},p(e,t){l&&l.p(e,t)},i(e){n||(m(l),n=!0)},o(e){g(l),n=!1},d(e){~t&&a[t].d(e),e&&h(r)}}}function ft(e,t,l){let r,n,i,a,c,s,o,u,f,d;w(e,J,(e=>l(25,c=e))),w(e,W,(e=>l(26,s=e))),w(e,z,(e=>l(27,o=e))),w(e,P,(e=>l(2,u=e))),w(e,U,(e=>l(28,f=e))),w(e,K,(e=>l(29,d=e)));let{filter:m}=t,{filterBlocksLength:p}=t,{index:g}=t;const y=m.attrs.filter,h=m.innerBlocks,$=y.filterQueryID,T=y.blockId,D=y.filterTarget,I=y.filterSource,b=y.filterType,x=y.filterStaticData,C=y.filterData,F=y.filterDataType,v=y.filterCountItems,B=y.filterTaxField,k=y.filterPlaceholder;let N,V,A,j,q=(G=!1,function(){var e;G||(G=!0,(e={filterQueryID:$,$apiParams:d}).$apiParams?.terms&&Object.keys(e.$apiParams.terms).length>0&&Object.keys(e.$apiParams.terms).forEach((t=>{const l=E(JSON.stringify(e.$apiParams.terms[t]));L(l)||(_(l),H("cwicly/v1/terms_col",{termsCol:JSON.stringify(e.$apiParams.terms[t]),hash:l},"GET").then((e=>{J.update((t=>({...JSON.parse(JSON.stringify(t)),...e}))),M(l)})))})))});var G;function X(){o[$]?.isLoaded?.includes(D)||z.update((e=>{const t=JSON.parse(JSON.stringify(e));return t[$]?.isLoaded?t[$].isLoaded.push(D):t[$].isLoaded=[D],t}))}return Q((()=>{const e=function(e){if("dynamic"===e.source){let t,l;if(e.filterDataType&&"taxonomy"===e.filterDataType&&e.filterData){const r={taxonomy:[]};e.filterData.forEach((e=>{e.value&&r.taxonomy.push(e.value)})),r.taxonomy=JSON.stringify(r.taxonomy),e.filterProps.filterInclude&&(r.include=[],e.filterProps.filterInclude.forEach((e=>{e.value&&r.include.push(e.value)}))),e.filterProps.filterExclude&&(r.exclude=[],e.filterProps.filterExclude.forEach((e=>{e.value&&r.exclude.push(e.value)}))),e.filterProps.filterOrderBy&&(r.orderby=e.filterProps.filterOrderBy),e.filterProps.filterOrder&&(r.order=e.filterProps.filterOrder&&e.filterProps.filterOrder.toLowerCase()),e.filterProps.filterChildless&&(r.childless=!0),e.filterProps.filterHideEmpty&&(r.hide_empty=!0);const n=E(JSON.stringify(r));t=n,J&&J[n]&&!e.dynamicFields.length?l=K.terms[e.filterQueryID][E(JSON.stringify(r))]:K.update((t=>{const l=JSON.parse(JSON.stringify(t));return l.terms[e.filterQueryID]?l.terms[e.filterQueryID][n]=r:l.terms[e.filterQueryID]={[n]:r},l}))}return{termsArgs:t,dynamicFields:l}}}({source:I,filterQueryID:$,filterDataType:F,filterData:C,filterProps:y,dynamicFields:V});if(l(24,N=e?.termsArgs),l(0,V=e?.dynamicFields),R(U,f+=1,f),"static"===I)x&&l(4,j=x.filter((e=>e.default)).map((e=>e.value)));else if("dynamic"===I&&y.filterDynamicDefaults){let e;y.filterTaxField&&(e=y.filterTaxField),l(4,j=y.filterDynamicDefaults.map((t=>e?t.value[e]:t.value.slug)))}})),e.$$set=e=>{"filter"in e&&l(21,m=e.filter),"filterBlocksLength"in e&&l(22,p=e.filterBlocksLength),"index"in e&&l(23,g=e.index)},e.$$.update=()=>{if(281018368&e.$$.dirty[0]&&p===g+1&&f===p&&q(),134217728&e.$$.dirty[0]&&l(1,r=o[$]?.args?.params),134217728&e.$$.dirty[0]&&l(7,n=o[$]?.args?.queryargs),134217732&e.$$.dirty[0]&&l(6,i=function(e,t,l,r,n,i){let a;if(t&&Object.entries(t).forEach((t=>{t[0]===e&&(i(),a=t[1])})),!a&&!r?.[n]?.isLoaded?.includes(e)&&l){if(a=[],l&&"static"===l.filterSource)l?.filterStaticData&&l.filterStaticData.forEach((e=>{e.default&&a.push(e.value)}));else if(l&&"dynamic"===l.filterSource&&l?.filterDynamicDefaults){let e;l.filterTaxField&&(e=l.filterTaxField),l.filterDynamicDefaults.forEach((t=>{const l=e?t.value[e]:t.value.slug;a.push(l)}))}a=a.toString()}return a}(D,u,y,o,$,X)),2&e.$$.dirty[0]&&l(5,a=S(D,r)),52428800&e.$$.dirty[0]&&c[N]){let e;c[N]instanceof Object?(l(0,V=Object.values(c[N])),e=Object.values(c[N])):(l(0,V=c[N]),e=c[N]),O.update((t=>{const l=JSON.parse(JSON.stringify(t));return l[$]&&l[$][m.id]&&(l[$][m.id].dynamicFields=e),l}))}201326593&e.$$.dirty[0]&&l(3,A=function(e){if("static"===e.source&&e.staticData&&e.staticData.length){const t={};return e.staticData.map((l=>{const r=ze(l.value,!1,e);(r||0===r)&&(t[l.id]=r)})),t}if("dynamic"===e.source&&e.dynamicFields&&e.dynamicFields.length){const t={};return e.dynamicFields.map((l=>{const r=ze(l.slug,!0,e);(r||0===r)&&(t[l.slug]=r)})),t}}({source:I,target:D,staticData:x,dynamicFields:V,filterQueryID:$,filterCountItems:v,$queries:o,$termsCount:s}))},[V,r,u,A,j,a,i,n,h,$,T,D,I,b,x,F,v,B,k,undefined,X,m,p,g,N,c,s,o,f]}class dt extends e{constructor(e){super(),t(this,e,ft,ut,l,{filter:21,filterBlocksLength:22,index:23},null,[-1,-1])}}export{dt as default};
