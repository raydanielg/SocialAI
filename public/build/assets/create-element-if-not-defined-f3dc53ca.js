import{b as i,a as m}from"./swiper-core-2c82c4aa.js";function o(a,f,n,l){return a.params.createElements&&Object.keys(l).forEach(e=>{if(!n[e]&&n.auto===!0){let t=i(a.el,`.${l[e]}`)[0];t||(t=m("div",l[e]),t.className=l[e],a.el.append(t)),n[e]=t,f[e]=t}}),n}export{o as c};
