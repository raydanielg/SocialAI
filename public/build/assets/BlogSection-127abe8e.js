import{h as m}from"./moment-a9aaa855.js";import{h as u,c as a,b as t,k as d,t as o,F as g,r as v,o as l,a as _,j as h,u as f}from"./app-13978987.js";const b={class:"tp-blog-area pb-80"},k={class:"container"},w={class:"row justify-content-center"},x={class:"col-xl-5"},y={class:"tp-blog-section-box mb-50 text-center"},B={class:"tp-section-title-3"},L={class:"row"},N={class:"tp-blog-item"},Y={class:"tp-blog-thumb fix"},D=["src"],M={class:"tp-blog-meta d-flex align-items-center"},V={class:"tp-blog-category category-color-1"},j={class:"tp-blog-date"},C={class:"tp-blog-title-box"},A={__name:"BlogSection",props:["blogs"],setup(p){return(e,F)=>{const c=u("Link");return l(),a("div",b,[t("div",k,[t("div",w,[t("div",x,[t("div",y,[t("h3",B,[d(o(e.trans("Our Latest ")),1),t("span",null,o(e.trans("News and Articles")),1)])])])]),t("div",L,[(l(!0),a(g,null,v(p.blogs,s=>{var i,n;return l(),a("div",{key:s.id,class:"col-xl-4 col-lg-4 col-md-6 mb-60"},[t("div",N,[t("div",Y,[_(c,{href:e.route("blogs.show",s)},{default:h(()=>{var r;return[t("img",{src:e.sanitizeHtml((r=s.preview)==null?void 0:r.value),alt:""},null,8,D)]}),_:2},1032,["href"])]),t("div",M,[t("div",V,[t("span",null,o((n=(i=s.categories)==null?void 0:i[0])==null?void 0:n.title),1)]),t("div",j,[t("span",null,o(f(m)(s.created_at).format("DD MMM, YYYY")),1)])]),t("div",C,[_(c,{class:"tp-blog-title-sm",href:e.route("blogs.show",s)},{default:h(()=>[d(o(s.title),1)]),_:2},1032,["href"])])])])}),128))])])])}}};export{A as default};
