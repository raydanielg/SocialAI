import{h as C}from"./moment-a9aaa855.js";import{S as L,a as M}from"./swiper-vue-f3fe2caf.js";import{s as N,h as $,c,b as s,t as o,u as i,F as u,r as H,e as b,k as d,i as m,j as n,a as _,g as T,o as a,af as j}from"./app-13978987.js";import{_ as D}from"./DefaultLayout-52cb34e4.js";import E from"./Sidebar-906c5704.js";import"./swiper-core-2c82c4aa.js";import"./MobileMenu-4272ee25.js";import"./FeatureSection-b1ebef06.js";import"./SeoMeta-91cb18dc.js";import"./ToastrContainer-82d03ccc.js";const F={class:"breadcrumb__area breadcrumb-ptb-4 p-relative blue-bg-2"},U=s("div",{class:"breadcrumb__shape-1"},[s("img",{src:"/assets/img/breadcrumb/breadcrumb-shape-1.png",alt:""})],-1),O=s("div",{class:"breadcrumb__shape-2"},[s("img",{src:"/assets/img/breadcrumb/breadcrumb-shape-2.png",alt:""})],-1),Q={class:"container"},R={class:"row align-items-end"},Y={class:"col-md-9"},q={class:"blog-details-banner z-index-2"},A={class:"blog-details-title-box"},G={class:"blog-details-banner-title"},I={class:"col-md-3 mb-15"},J={class:"blog-details-social-box z-index-3 text-md-end text-start"},K=["href"],W=s("i",{class:"fab fa-facebook-f"},null,-1),X=[W],Z=["href"],ss=s("i",{class:"fab fa-twitter"},null,-1),ts=[ss],es=["href"],os=s("i",{class:"fab fa-linkedin"},null,-1),is=[os],ls=["href"],as=s("i",{class:"fab fa-instagram"},null,-1),ns=[as],cs={class:"blog-details-img-area mb-80"},ds={class:"container"},rs={class:"row"},_s={class:"col-xl-12"},hs={class:"blog-details-big-img z-index-2"},gs=["src"],bs={class:"postbox__area pb-100"},us={class:"container"},ms={class:"row"},vs={class:"col-xxl-8 col-xl-8 col-lg-8"},fs={class:"postbox__details-wrapper pr-20"},ps={class:"postbox__details-title-box pb-30"},xs={class:"postbox__details-title"},ws=["innerHTML"],ks={class:"postbox__details tagcloud mb-50"},Bs={class:"postbox__navigation-more mb-70 d-flex justify-content-between"},ys={class:"postbox__navigation-left d-flex align-items-center"},zs={class:"postbox__navigation-img rc__post-thumb"},Vs=["src"],Ps={key:0,class:"postbox__navigation-content"},Hs=s("i",{class:"far fa-arrow-left"},null,-1),Ss={key:0,class:"postbox__navigation-right d-flex align-items-center"},Cs={class:"postbox__navigation-content"},Ls=s("i",{class:"far fa-arrow-right"},null,-1),Ms={class:"postbox__navigation-img rc__post-thumb"},Ns=["src"],$s={class:"col-xxl-4 col-xl-4 col-lg-4"},Ts={class:"blog-grid-inner grey-bg pt-100 pb-50"},js={class:"container"},Ds={class:"row"},Es={class:"col-12"},Fs={class:"popular-blog-title mb-40 text-center"},Us={class:"row"},Os={class:"col-12"},Qs={class:"blog-details-slider-wrapper"},Rs={class:"tp-blog-item"},Ys={class:"tp-blog-thumb fix"},qs=["src"],As={class:"tp-blog-content"},Gs={class:"tp-blog-meta d-flex align-items-center"},Is={class:"tp-blog-category category-color-1"},Js={class:"tp-blog-date"},Ks={class:"tp-blog-title-box"},Ws=T({layout:D}),rt=Object.assign(Ws,{__name:"Show",props:["blog","categories","tags","recent_blogs","related_blogs","prevBlog","nextBlog"],setup(t){const{socialShare:h,textExcerpt:g,getQueryParams:Xs}=N();return(e,Zs)=>{var v,f,p,x,w,k,B,y;const r=$("Link");return a(),c(u,null,[s("div",F,[U,O,s("div",Q,[s("div",R,[s("div",Y,[s("div",q,[s("div",A,[s("span",null,o(((f=(v=t.blog.categories)==null?void 0:v[0])==null?void 0:f.title)||e.trans("Uncategorized")),1),s("h3",G,o(i(g)(t.blog.title,42)),1)])])]),s("div",I,[s("div",J,[s("a",{href:i(h)("facebook")},X,8,K),s("a",{href:i(h)("twitter")},ts,8,Z),s("a",{href:i(h)("linkedin")},is,8,es),s("a",{href:i(h)("instagram")},ns,8,ls)])])])])]),s("div",cs,[s("div",ds,[s("div",rs,[s("div",_s,[s("div",hs,[s("img",{src:e.sanitizeHtml(((p=t.blog.banner)==null?void 0:p.value)??((x=t.blog.preview)==null?void 0:x.value)),alt:"",class:"max-h-[400px]"},null,8,gs)])])])])]),s("div",bs,[s("div",us,[s("div",ms,[s("div",vs,[s("div",fs,[s("article",null,[s("div",ps,[s("h4",xs,o(t.blog.title),1),s("div",{innerHTML:i(j).sanitize((w=t.blog.long_description)==null?void 0:w.value)},null,8,ws)]),s("div",ks,[s("span",null,o(e.trans("Tags"))+":",1),(a(!0),c(u,null,H(t.blog.tags,l=>(a(),m(r,{href:`/blogs/tag/${l.slug}`,key:l.id},{default:n(()=>[d(o(l.title),1)]),_:2},1032,["href"]))),128))]),s("div",Bs,[s("div",ys,[s("div",zs,[t.nextBlog?(a(),c("img",{key:0,src:e.sanitizeHtml((k=t.nextBlog.preview)==null?void 0:k.value),alt:""},null,8,Vs)):b("",!0)]),t.nextBlog?(a(),c("div",Ps,[s("span",null,[Hs,d(" "+o(e.trans(" Previous post")),1)]),s("h5",null,[t.nextBlog?(a(),m(r,{key:0,href:`/blogs/${e.sanitizeHtml(t.nextBlog.slug)}`},{default:n(()=>[d(o(i(g)(t.nextBlog.title,20)),1)]),_:1},8,["href"])):b("",!0)])])):b("",!0)]),t.prevBlog?(a(),c("div",Ss,[s("div",Cs,[s("span",null,[d(o(e.trans("Next post"))+" ",1),Ls]),s("h5",null,[_(r,{href:`/blogs/${e.sanitizeHtml(t.prevBlog.slug)}`},{default:n(()=>[d(o(i(g)(t.prevBlog.title,20)),1)]),_:1},8,["href"])])]),s("div",Ms,[s("img",{src:e.sanitizeHtml((y=(B=t.prevBlog)==null?void 0:B.preview)==null?void 0:y.value),class:"",alt:""},null,8,Ns)])])):b("",!0)])])])]),s("div",$s,[_(E,{categories:t.categories,posts:t.recent_blogs,tags:t.tags},null,8,["categories","posts","tags"])])])])]),s("div",Ts,[s("div",js,[s("div",Ds,[s("div",Es,[s("div",Fs,[s("h4",null,o(e.trans("Related Posts")),1)])])]),s("div",Us,[s("div",Os,[s("div",Qs,[_(i(M),{loop:!0,slidesPerView:3,spaceBetween:30,breakpoints:{1200:{slidesPerView:3},992:{slidesPerView:2},768:{slidesPerView:2},576:{slidesPerView:1},0:{slidesPerView:1}},class:"swiper-container blog-slider-active pb-50"},{default:n(()=>[(a(!0),c(u,null,H(t.related_blogs,(l,S)=>(a(),m(i(L),{key:S,class:"swiper-slide"},{default:n(()=>{var z,V;return[s("div",Rs,[s("div",Ys,[_(r,{href:e.route("blogs.show",l)},{default:n(()=>{var P;return[s("img",{class:"w-100",src:e.sanitizeHtml((P=l.preview)==null?void 0:P.value),alt:""},null,8,qs)]}),_:2},1032,["href"])]),s("div",As,[s("div",Gs,[s("div",Is,[s("span",null,o(((V=(z=l.categories)==null?void 0:z[0])==null?void 0:V.title)||"Uncategorized"),1)]),s("div",Js,[s("span",null,o(i(C)(l.created_at).format("DD MMM, Y")),1)])]),s("div",Ks,[_(r,{class:"tp-blog-title-sm",href:e.route("blogs.show",l)},{default:n(()=>[d(o(i(g)(l.title,40)),1)]),_:2},1032,["href"])])])])]}),_:2},1024))),128))]),_:1})])])])])])],64)}}});export{rt as default};
