import{S as t,i as e,s as n,q as o,v as r,b as s,w as a,t as l,x as i,y as c,z as f,C as u,D as p,R as m,T as d,U as g,_ as h,P as $}from"./main-f3bc643b.js";import{B as k}from"./BlockMaker-6b9ad4a5.js";function x(t,e,n){const o=t.slice();return o[3]=e[n],o[5]=n,o}function b(t){let e,n,s=t[0].skeleton+"";return{c(){e=new $(!1),n=o(),e.a=n},m(t,o){e.m(s,t,o),r(t,n,o)},p(t,n){1&n&&s!==(s=t[0].skeleton+"")&&e.p(s)},i:u,o:u,d(t){t&&i(n),t&&e.d()}}}function B(t){let e,n,c=t[0].innerBlocks,u=[];for(let e=0;e<c.length;e+=1)u[e]=w(x(t,c,e));const m=t=>s(u[t],1,1,(()=>{u[t]=null}));return{c(){for(let t=0;t<u.length;t+=1)u[t].c();e=o()},m(t,o){for(let e=0;e<u.length;e+=1)u[e].m(t,o);r(t,e,o),n=!0},p(t,n){if(3&n){let o;for(c=t[0].innerBlocks,o=0;o<c.length;o+=1){const r=x(t,c,o);u[o]?(u[o].p(r,n),l(u[o],1)):(u[o]=w(r),u[o].c(),l(u[o],1),u[o].m(e.parentNode,e))}for(f(),o=c.length;o<u.length;o+=1)m(o);a()}},i(t){if(!n){for(let t=0;t<c.length;t+=1)l(u[t]);n=!0}},o(t){u=u.filter(Boolean);for(let t=0;t<u.length;t+=1)s(u[t]);n=!1},d(t){p(u,t),t&&i(e)}}}function w(t){let e,n;return e=new k({props:{attributes:t[3],index:t[5],item:{isWooCart:!0,wooCart:t[1]}}}),{c(){m(e.$$.fragment)},m(t,o){d(e,t,o),n=!0},p(t,n){const o={};1&n&&(o.attributes=t[3]),2&n&&(o.item={isWooCart:!0,wooCart:t[1]}),e.$set(o)},i(t){n||(l(e.$$.fragment,t),n=!0)},o(t){s(e.$$.fragment,t),n=!1},d(t){g(e,t)}}}function C(t){let e,n,c,u;const p=[B,b],m=[];function d(t,e){return t[1]&&t[0].innerBlocks?0:t[0].skeleton?1:-1}return~(e=d(t))&&(n=m[e]=p[e](t)),{c(){n&&n.c(),c=o()},m(t,n){~e&&m[e].m(t,n),r(t,c,n),u=!0},p(t,[o]){let r=e;e=d(t),e===r?~e&&m[e].p(t,o):(n&&(f(),s(m[r],1,1,(()=>{m[r]=null})),a()),~e?(n=m[e],n?n.p(t,o):(n=m[e]=p[e](t),n.c()),l(n,1),n.m(c.parentNode,c)):n=null)},i(t){u||(l(n),u=!0)},o(t){s(n),u=!1},d(t){~e&&m[e].d(t),t&&i(c)}}}function P(t,e,n){let o;c(t,h,(t=>n(1,o=t)));let{cartProps:r}=e,{index:s}=e;return t.$$set=t=>{"cartProps"in t&&n(0,r=t.cartProps),"index"in t&&n(2,s=t.index)},[r,o,s]}class j extends t{constructor(t){super(),e(this,t,P,C,n,{cartProps:0,index:2})}}export{j as default};