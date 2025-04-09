import{T as U,c,a as i,b as s,w as S,t as n,d as u,f as k,u as t,F as f,r as y,v as m,y as h,g as C,o as p,q as E}from"./app-13978987.js";import{_ as M}from"./AdminLayout-bd13ff9d.js";import{_ as O}from"./PageHeader-8c638686.js";import{_ as $}from"./SpinnerBtn-cb152833.js";import{_ as F}from"./RichEditor-132d6d13.js";import{_ as r}from"./InputFieldError-52549d23.js";import"./dropdown-45d66330.js";import"./FloatingDropdown-0be3e47c.js";const T={class:"container p-4 sm:p-6"},I={class:"card mx-auto w-[800px]"},B={class:"card-body"},D={class:"mb-2"},j={for:""},L={value:""},N=["value"],x={class:"mb-2"},A={class:"label mb-2"},P={class:"mb-2"},z={class:"label mb-2"},G={class:"mb-2"},H={class:"label mb-2"},J={class:"mb-2 mt-3"},K={class:"mt-10 flex items-center justify-between"},Q={class:"mt-2 flex items-center gap-2"},R=["onUpdate:modelValue"],W=["onUpdate:modelValue"],X=["onClick"],Y={class:"mb-2 mt-10"},Z={class:"mb-2"},ss={class:"mb-2"},es={class:"mb-2 mt-2"},ts={class:"mb-2 mt-2"},ls={class:"mb-2 mt-3"},os={for:"toggle-status",class:"toggle toggle-sm"},as=s("div",{class:"toggle-body"},null,-1),ns={class:"label label-md"},is={class:"mb-2 mt-3"},rs={for:"toggle-featured-status",class:"toggle toggle-sm"},us=s("div",{class:"toggle-body"},null,-1),ds={class:"label label-md"},ms={class:"mb-2"},cs=C({layout:M}),ws=Object.assign(cs,{__name:"Edit",props:["buttons","service","categories"],setup(b){const v=b,d=v.service,e=U({category_id:d.category_id??"",title:d.title??"",slug:d.slug??"",icon:null,preview:null,overview:d.overview??"",faqs:d.faqs??[{question:"",answer:""}],is_active:!!d.is_active,is_featured:!!d.is_featured,seo:d.meta??{title:"",image:"",description:"",tags:""},_method:"put"}),w=()=>{e.post(route("admin.services.update",v.service),{onSuccess:()=>{E.success(trans("Updated Successfully")),e.reset()}})},q=()=>{e.faqs.push({question:"",answer:""})},V=a=>{e.faqs.splice(a,1)};return(a,o)=>(p(),c("main",T,[i(O,{title:"Edit Service",buttons:b.buttons},null,8,["buttons"]),s("div",I,[s("div",B,[s("form",{onSubmit:S(w,["prevent"])},[s("div",D,[s("label",j,n(a.trans("Category")),1),u(s("select",{"onUpdate:modelValue":o[0]||(o[0]=l=>t(e).category_id=l),class:"select"},[s("option",L,n(a.trans("SELECT")),1),(p(!0),c(f,null,y(b.categories,l=>(p(),c("option",{value:l.id,key:l.id},n(l.title),9,N))),128))],512),[[k,t(e).category_id]]),i(r,{message:t(e).errors.category_id},null,8,["message"])]),s("div",x,[s("label",A,n(a.trans("Title")),1),u(s("input",{type:"text","onUpdate:modelValue":o[1]||(o[1]=l=>t(e).title=l),class:"input"},null,512),[[m,t(e).title]]),i(r,{message:t(e).errors.title},null,8,["message"])]),s("div",P,[s("label",z,n(a.trans("Icon")),1),s("input",{type:"file",onChange:o[2]||(o[2]=l=>t(e).icon=l.target.files[0]),class:"input"},null,32),i(r,{message:t(e).errors.icon},null,8,["message"])]),s("div",G,[s("label",H,n(a.trans("Preview")),1),s("input",{type:"file",onChange:o[3]||(o[3]=l=>t(e).preview=l.target.files[0]),class:"input"},null,32),i(r,{message:t(e).errors.preview},null,8,["message"])]),s("div",J,[s("label",null,n(a.trans("Overview")),1),i(F,{modelValue:t(e).overview,"onUpdate:modelValue":o[4]||(o[4]=l=>t(e).overview=l)},null,8,["modelValue"]),i(r,{message:t(e).errors.overview},null,8,["message"])]),s("div",K,[s("h4",null,n(a.trans("Faq's")),1),s("button",{type:"button",class:"btn btn-primary",onClick:o[5]||(o[5]=l=>q())},"+")]),(p(!0),c(f,null,y(t(e).faqs,(l,g)=>(p(),c("div",{key:g},[s("div",Q,[u(s("input",{type:"text","onUpdate:modelValue":_=>l.question=_,class:"input",placeholder:"question"},null,8,R),[[m,l.question]]),u(s("input",{type:"text","onUpdate:modelValue":_=>l.answer=_,class:"input",placeholder:"answer"},null,8,W),[[m,l.answer]]),s("button",{type:"button",class:"btn btn-danger",onClick:_=>V(g)},"x",8,X)]),i(r,{message:t(e).errors["faqs."+g+".question"]},null,8,["message"]),i(r,{message:t(e).errors["faqs."+g+".answer"]},null,8,["message"])]))),128)),s("h6",Y,n(a.trans("SEO Settings")),1),s("div",Z,[s("label",null,n(a.trans("SEO Meta Title")),1),u(s("input",{"onUpdate:modelValue":o[6]||(o[6]=l=>t(e).seo.title=l),type:"text",class:"input"},null,512),[[m,t(e).seo.title]]),i(r,{message:t(e).errors["seo.title"]},null,8,["message"])]),s("div",ss,[s("label",null,n(a.trans("SEO Meta Image")),1),s("input",{onChange:o[7]||(o[7]=l=>t(e).seo.image=l.target.files[0]),type:"file",class:"input",accept:"image/*"},null,32),i(r,{message:t(e).errors["seo.image"]},null,8,["message"])]),s("div",es,[s("label",null,n(a.trans("SEO Meta Description")),1),u(s("textarea",{"onUpdate:modelValue":o[8]||(o[8]=l=>t(e).seo.description=l),class:"input h-100"},null,512),[[m,t(e).seo.description]]),i(r,{message:t(e).errors["seo.description"]},null,8,["message"])]),s("div",ts,[s("label",null,n(a.trans("SEO Meta Tags")),1),u(s("input",{"onUpdate:modelValue":o[9]||(o[9]=l=>t(e).seo.tags=l),type:"text",class:"input"},null,512),[[m,t(e).seo.tags]]),i(r,{message:t(e).errors["seo.tags"]},null,8,["message"])]),s("div",ls,[s("div",null,[s("label",os,[u(s("input",{"onUpdate:modelValue":o[10]||(o[10]=l=>t(e).is_active=l),class:"toggle-input peer sr-only",id:"toggle-status",type:"checkbox"},null,512),[[h,t(e).is_active]]),as,s("span",ns,n(a.trans("Is Active?")),1)])])]),s("div",is,[s("div",null,[s("label",rs,[u(s("input",{"onUpdate:modelValue":o[11]||(o[11]=l=>t(e).is_featured=l),class:"toggle-input peer sr-only",id:"toggle-featured-status",type:"checkbox"},null,512),[[h,t(e).is_featured]]),us,s("span",ds,n(a.trans("Is Featured?")),1)])])]),s("div",ms,[i($,{classes:"btn btn-primary",processing:t(e).processing,"btn-text":a.trans("Update")},null,8,["processing","btn-text"])])],32)])])]))}});export{ws as default};
