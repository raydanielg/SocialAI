import{T as _,c as m,a as i,b as e,w as v,t as n,d,f,u as t,F as y,r as w,v as u,y as c,g as h,o as p,q as V}from"./app-13978987.js";import{_ as S}from"./AdminLayout-bd13ff9d.js";import{_ as U}from"./PageHeader-8c638686.js";import{_ as k}from"./SpinnerBtn-cb152833.js";import{_ as C}from"./RichEditor-132d6d13.js";import{_ as r}from"./InputFieldError-52549d23.js";import"./dropdown-45d66330.js";import"./FloatingDropdown-0be3e47c.js";const E={class:"container p-4 sm:p-6"},M={class:"card mx-auto w-[800px]"},O={class:"card-body"},T={class:"mb-2"},$={for:""},x={value:""},B=["value"],D={class:"mb-2"},F={class:"label mb-2"},I={class:"mb-2"},j={class:"label mb-2"},A={class:"mb-2"},L={class:"label mb-2"},N={class:"mb-2 mt-2"},P={class:"mb-2 mt-3"},q={class:"mb-2 mt-2"},R={class:"mb-2"},z={class:"label mb-2"},G={class:"mb-2"},H={class:"label mb-2"},J={class:"mb-2 mt-10"},K={class:"mb-2"},Q={class:"mb-2"},W={class:"mb-2 mt-2"},X={class:"mb-2 mt-2"},Y={class:"mb-2 mt-3"},Z={for:"toggle-status",class:"toggle toggle-sm"},ee=e("div",{class:"toggle-body"},null,-1),se={class:"label label-md"},te={class:"mb-2 mt-3"},le={for:"toggle-featured-status",class:"toggle toggle-sm"},oe=e("div",{class:"toggle-body"},null,-1),ae={class:"label label-md"},ne={class:"mb-2"},ie=h({layout:S}),_e=Object.assign(ie,{__name:"Create",props:["buttons","categories"],setup(g){const s=_({category_id:"",title:"",slug:"",preview:"",banner_preview:"",description:"",overview:"",output:"",client:"",preview_link:"",is_active:!0,is_featured:!1,seo:{title:"",image:"",description:"",tags:""}}),b=()=>{s.post(route("admin.projects.store"),{onSuccess:()=>{V.success(trans("Added Successfully")),s.reset()}})};return(a,o)=>(p(),m("main",E,[i(U,{title:"Create Service",buttons:g.buttons},null,8,["buttons"]),e("div",M,[e("div",O,[e("form",{onSubmit:v(b,["prevent"])},[e("div",T,[e("label",$,n(a.trans("Category")),1),d(e("select",{"onUpdate:modelValue":o[0]||(o[0]=l=>t(s).category_id=l),class:"select"},[e("option",x,n(a.trans("SELECT")),1),(p(!0),m(y,null,w(g.categories,l=>(p(),m("option",{value:l.id,key:l.id},n(l.title),9,B))),128))],512),[[f,t(s).category_id]]),i(r,{message:t(s).errors.category_id},null,8,["message"])]),e("div",D,[e("label",F,n(a.trans("Title")),1),d(e("input",{type:"text","onUpdate:modelValue":o[1]||(o[1]=l=>t(s).title=l),class:"input"},null,512),[[u,t(s).title]]),i(r,{message:t(s).errors.title},null,8,["message"])]),e("div",I,[e("label",j,n(a.trans("Preview")),1),e("input",{type:"file",onChange:o[2]||(o[2]=l=>t(s).preview=l.target.files[0]),class:"input"},null,32),i(r,{message:t(s).errors.preview},null,8,["message"])]),e("div",A,[e("label",L,n(a.trans("Banner preview")),1),e("input",{type:"file",onChange:o[3]||(o[3]=l=>t(s).banner_preview=l.target.files[0]),class:"input"},null,32),i(r,{message:t(s).errors.banner_preview},null,8,["message"])]),e("div",N,[e("label",null,n(a.trans("Description")),1),d(e("textarea",{"onUpdate:modelValue":o[4]||(o[4]=l=>t(s).description=l),class:"textarea",maxlength:"500"},null,512),[[u,t(s).description]]),i(r,{message:t(s).errors.description},null,8,["message"])]),e("div",P,[e("label",null,n(a.trans("Overview")),1),i(C,{modelValue:t(s).overview,"onUpdate:modelValue":o[5]||(o[5]=l=>t(s).overview=l)},null,8,["modelValue"]),i(r,{message:t(s).errors.overview},null,8,["message"])]),e("div",q,[e("label",null,n(a.trans("Solution & Result")),1),d(e("textarea",{"onUpdate:modelValue":o[6]||(o[6]=l=>t(s).output=l),class:"textarea",maxlength:"500"},null,512),[[u,t(s).output]]),i(r,{message:t(s).errors.output},null,8,["message"])]),e("div",R,[e("label",z,n(a.trans("Client")),1),d(e("input",{type:"text","onUpdate:modelValue":o[7]||(o[7]=l=>t(s).client=l),class:"input"},null,512),[[u,t(s).client]]),i(r,{message:t(s).errors.client},null,8,["message"])]),e("div",G,[e("label",H,n(a.trans("Preview link")),1),d(e("input",{type:"text","onUpdate:modelValue":o[8]||(o[8]=l=>t(s).preview_link=l),class:"input"},null,512),[[u,t(s).preview_link]]),i(r,{message:t(s).errors.preview_link},null,8,["message"])]),e("h6",J,n(a.trans("SEO Settings")),1),e("div",K,[e("label",null,n(a.trans("SEO Meta Title")),1),d(e("input",{"onUpdate:modelValue":o[9]||(o[9]=l=>t(s).seo.title=l),type:"text",class:"input"},null,512),[[u,t(s).seo.title]]),i(r,{message:t(s).errors["seo.title"]},null,8,["message"])]),e("div",Q,[e("label",null,n(a.trans("SEO Meta Image")),1),e("input",{onChange:o[10]||(o[10]=l=>t(s).seo.image=l.target.files[0]),type:"file",class:"input",accept:"image/*"},null,32),i(r,{message:t(s).errors["seo.image"]},null,8,["message"])]),e("div",W,[e("label",null,n(a.trans("SEO Meta Description")),1),d(e("textarea",{"onUpdate:modelValue":o[11]||(o[11]=l=>t(s).seo.description=l),class:"input h-100"},null,512),[[u,t(s).seo.description]]),i(r,{message:t(s).errors["seo.description"]},null,8,["message"])]),e("div",X,[e("label",null,n(a.trans("SEO Meta Tags")),1),d(e("input",{"onUpdate:modelValue":o[12]||(o[12]=l=>t(s).seo.tags=l),type:"text",class:"input"},null,512),[[u,t(s).seo.tags]]),i(r,{message:t(s).errors["seo.tags"]},null,8,["message"])]),e("div",Y,[e("div",null,[e("label",Z,[d(e("input",{"onUpdate:modelValue":o[13]||(o[13]=l=>t(s).is_active=l),class:"toggle-input peer sr-only",id:"toggle-status",type:"checkbox"},null,512),[[c,t(s).is_active]]),ee,e("span",se,n(a.trans("Is Active?")),1)])])]),e("div",te,[e("div",null,[e("label",le,[d(e("input",{"onUpdate:modelValue":o[14]||(o[14]=l=>t(s).is_featured=l),class:"toggle-input peer sr-only",id:"toggle-featured-status",type:"checkbox"},null,512),[[c,t(s).is_featured]]),oe,e("span",ae,n(a.trans("Is Featured?")),1)])])]),e("div",ne,[i(k,{classes:"btn btn-primary",processing:t(s).processing,"btn-text":a.trans("Create")},null,8,["processing","btn-text"])])],32)])])]))}});export{_e as default};
