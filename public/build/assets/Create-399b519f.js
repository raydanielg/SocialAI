import{T as p,c as d,a as n,b as s,t as l,w as _,d as i,v as c,u as t,g as b,o as f,q as g}from"./app-13978987.js";import{_ as m}from"./InputFieldError-52549d23.js";import{_ as h}from"./UserLayout-6a50516d.js";import{_ as v}from"./SpinnerBtn-cb152833.js";import{_ as x}from"./PageHeader-8c638686.js";import"./dropdown-45d66330.js";const y={class:"container flex-grow p-4 sm:p-6"},S={class:"space-y-6"},j={class:"card card-body mx-auto max-w-3xl"},w={class:"mb-4"},V={class:"mb-2"},$={class:"label mb-2"},k={class:"mb-2"},B={class:"label mb-2"},C={class:"button-group d-inline-flex align-items-center mt-30"},M=b({layout:h}),W=Object.assign(M,{__name:"Create",setup(T){const e=p({subject:"",message:""}),u=()=>{e.post(route("user.supports.store"),{onSuccess:()=>{g.success("Updated Successfully")}})};return(a,o)=>(f(),d("main",y,[n(x,{title:"Support",buttons:a.buttons},null,8,["buttons"]),s("div",S,[s("div",j,[s("h4",w,l(a.trans("Create Ticket")),1),s("form",{onSubmit:_(u,["prevent"])},[s("div",V,[s("label",$,l(a.trans("Subject"))+"*",1),i(s("input",{type:"text",class:"input",placeholder:"Subject","onUpdate:modelValue":o[0]||(o[0]=r=>t(e).subject=r)},null,512),[[c,t(e).subject]]),n(m,{message:t(e).errors.subject},null,8,["message"])]),s("div",k,[s("label",B,l(a.trans("Message"))+"*",1),i(s("textarea",{required:"","onUpdate:modelValue":o[1]||(o[1]=r=>t(e).message=r),class:"textarea",placeholder:"Write message...."},null,512),[[c,t(e).message]]),n(m,{message:t(e).errors.message},null,8,["message"])]),s("div",C,[n(v,{type:"submit",classes:"btn btn-primary",processing:t(e).processing,"btn-text":"Submit"},null,8,["processing"])])],32)])])]))}});export{W as default};
