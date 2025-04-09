import{s as q,l as z,A as j,p as a,T as I,h as O,c as d,b as t,a as l,t as e,u as s,F as p,r as g,i as R,w as V,d as h,f,g as Y,o as i,n as G,v as E}from"./app-13978987.js";import{_ as H}from"./AdminLayout-bd13ff9d.js";import{_ as J}from"./PageHeader-8c638686.js";import{_ as K}from"./Paginate-f61b79b2.js";import{h as P}from"./moment-a9aaa855.js";import Q from"./OverviewGrid-21ea6fc2.js";import{_ as U}from"./SpinnerBtn-cb152833.js";import{d as w}from"./drawer-fe4c5e1a.js";import{_ as W}from"./NoDataFound-bc81d7fa.js";import{_ as x}from"./InputFieldError-52549d23.js";import"./dropdown-45d66330.js";const X={class:"container p-4 sm:p-6"},Z={class:"space-y-6"},tt={class:"table-responsive whitespace-nowrap rounded-primary"},st={class:"table"},et={class:"text-right"},ot={key:0},at={class:"text-left"},nt={class:"text-left"},lt={class:"text-left"},it={class:"text-left"},dt={class:""},rt={class:"dropdown","data-placement":"bottom-start"},ct={class:"dropdown-toggle"},ut={class:"dropdown-content w-40"},_t={class:"dropdown-list"},mt={class:"dropdown-list-item"},bt=["onClick"],pt={class:"dropdown-list-item"},ht=["onClick"],vt={id:"addNewItemDrawer",class:"drawer drawer-right w-[600px]"},gt={class:"drawer-header"},ft={type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},wt={class:"drawer-body"},xt={class:"mb-2"},yt={class:"label mb-1"},kt={value:""},Ct=["value"],At={class:"label mb-1"},St=["onUpdate:modelValue"],Dt={class:"mb-2"},$t={class:"label mb-1"},It={value:"active"},Vt={value:"inactive"},Et={class:"drawer-footer"},Ut={class:"flex gap-2"},Mt={type:"button",class:"btn btn-secondary w-full","data-dismiss":"drawer"},Bt={id:"editItemDrawer",class:"drawer drawer-right"},Nt={class:"drawer-header"},Tt={type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},Ft={class:"drawer-body"},Lt={class:"mb-2"},qt={class:"label mb-1"},zt={value:""},jt=["value"],Ot={class:"label mb-1"},Rt=["onUpdate:modelValue"],Yt={class:"mb-2"},Gt={class:"label mb-1"},Ht={value:"active"},Jt={value:"inactive"},Kt={class:"drawer-footer"},Pt={class:"flex gap-2"},Qt={type:"button",class:"btn btn-secondary w-full","data-dismiss":"drawer"},Wt=Y({layout:H}),rs=Object.assign(Wt,{__name:"Index",props:["brandAudiences","categories","total","active","inActive","buttons"],setup(_){const{deleteRow:M,textExcerpt:y}=q();z(()=>{w.init()});const k=_,B=j(()=>[{value:k.total,title:a("Total"),iconClass:"bx:badge"},{value:k.active,title:a("Active"),iconClass:"bx:badge-check"},{value:k.inActive,title:a("Inactive"),iconClass:"bx:x-circle"}]),r=I({category_id:"",segments:[{id:1,text:""},{id:2,text:""},{id:3,text:""}],status:"active"}),N=()=>{r.post(route("admin.brand-audiences.store"),{onSuccess:()=>{r.reset(),w.of("#addNewItemDrawer").hide()}})},n=I({category_id:"",segments:[{id:1,text:""},{id:2,text:""},{id:3,text:""}],status:"active"}),T=m=>{n.id=m.id,n.category_id=m.category_id,n.segments=m.segments,n.status=m.status,w.of("#editItemDrawer").show()},F=()=>{n.put(route("admin.brand-audiences.update",n.id),{onSuccess:()=>{n.value={},w.of("#editItemDrawer").hide()}})};return(m,u)=>{const v=O("Icon");return i(),d(p,null,[t("main",X,[l(J,{title:"Brand Identities",buttons:_.buttons},null,8,["buttons"]),t("div",Z,[l(Q,{items:B.value,grid:"3"},null,8,["items"]),t("div",tt,[t("table",st,[t("thead",null,[t("tr",null,[t("th",null,e(s(a)("Category")),1),t("th",null,e(s(a)("Segment 1")),1),t("th",null,e(s(a)("Segment 2")),1),t("th",null,e(s(a)("Segment 3")),1),t("th",null,e(s(a)("Status")),1),t("th",null,e(s(a)("Created At")),1),t("th",null,[t("p",et,e(s(a)("Action")),1)])])]),_.brandAudiences.total?(i(),d("tbody",ot,[(i(!0),d(p,null,g(_.brandAudiences.data,o=>{var c,b,C,A,S,D,$;return i(),d("tr",{key:o.id},[t("td",null,e((c=o.category)==null?void 0:c.title),1),t("td",at,e(s(y)((C=(b=o.segments)==null?void 0:b[0])==null?void 0:C.text,30)),1),t("td",nt,e(s(y)((S=(A=o.segments)==null?void 0:A[1])==null?void 0:S.text,30)),1),t("td",lt,e(s(y)(($=(D=o.segments)==null?void 0:D[2])==null?void 0:$.text,30)),1),t("td",it,[t("span",{class:G(["badge",o.status=="active"?"badge-success":"badge-danger"])},e(o.status=="active"?s(a)("Active"):s(a)("Draft")),3)]),t("td",null,e(s(P)(o.created_at).format("D-MMM-Y")),1),t("td",dt,[t("div",rt,[t("div",ct,[l(v,{class:"text-2xl",icon:"bx:dots-horizontal-rounded"})]),t("div",ut,[t("ul",_t,[t("li",mt,[t("button",{onClick:L=>T(o),class:"dropdown-link"},[l(v,{icon:"fe:edit"}),t("span",null,e(s(a)("Edit")),1)],8,bt)]),t("li",pt,[t("button",{as:"button",class:"dropdown-link",onClick:L=>s(M)(m.route("admin.brand-audiences.destroy",o.id))},[l(v,{icon:"fe:trash"}),t("span",null,e(s(a)("Delete")),1)],8,ht)])])])])])])}),128))])):(i(),R(W,{key:1,"for-table":"true"}))]),l(K,{links:_.brandAudiences.links},null,8,["links"])])])]),t("div",vt,[t("form",{onSubmit:V(N,["prevent"])},[t("div",gt,[t("h5",null,e(s(a)("Add New Audience")),1),t("button",ft,[l(v,{class:"text-xl",icon:"mdi:close"})])]),t("div",wt,[t("div",xt,[t("label",yt,e(s(a)("Category")),1),h(t("select",{"onUpdate:modelValue":u[0]||(u[0]=o=>s(r).category_id=o),class:"select"},[t("option",kt,e(s(a)("SELECT")),1),(i(!0),d(p,null,g(_.categories,o=>(i(),d("option",{value:o.id,key:o.id},e(o.title),9,Ct))),128))],512),[[f,s(r).category_id]]),l(x,{message:s(r).errors.category_id},null,8,["message"])]),(i(!0),d(p,null,g(s(r).segments,(o,c)=>(i(),d("div",{class:"mb-2",key:c},[t("label",At,e(s(a)(`Segment ${c+1}`)),1),h(t("input",{"onUpdate:modelValue":b=>o.text=b,type:"text",class:"input"},null,8,St),[[E,o.text]]),l(x,{message:s(r).errors[`segments.${c}.text`]},null,8,["message"])]))),128)),t("div",Dt,[t("label",$t,e(s(a)("Status")),1),h(t("select",{required:"","onUpdate:modelValue":u[1]||(u[1]=o=>s(r).status=o),class:"select",name:"status"},[t("option",It,e(s(a)("Active")),1),t("option",Vt,e(s(a)("Draft")),1)],512),[[f,s(r).status]])])]),t("div",Et,[t("div",Ut,[t("button",Mt,[t("span",null,e(s(a)("Close")),1)]),l(U,{classes:"btn btn-primary w-full",processing:s(r).processing,"btn-text":s(a)("Create")},null,8,["processing","btn-text"])])])],32)]),t("div",Bt,[t("form",{onSubmit:V(F,["prevent"])},[t("div",Nt,[t("h5",null,e(s(a)("Edit Audience")),1),t("button",Tt,[l(v,{class:"text-xl",icon:"mdi:close"})])]),t("div",Ft,[t("div",Lt,[t("label",qt,e(s(a)("Category")),1),h(t("select",{"onUpdate:modelValue":u[2]||(u[2]=o=>s(n).category_id=o),class:"select"},[t("option",zt,e(s(a)("SELECT")),1),(i(!0),d(p,null,g(_.categories,o=>(i(),d("option",{value:o.id,key:o.id},e(o.title),9,jt))),128))],512),[[f,s(n).category_id]]),l(x,{message:s(n).errors.category_id},null,8,["message"])]),(i(!0),d(p,null,g(s(n).segments,(o,c)=>(i(),d("div",{class:"mb-2",key:c},[t("label",Ot,e(s(a)(`Segment ${c+1}`)),1),h(t("input",{"onUpdate:modelValue":b=>o.text=b,type:"text",class:"input"},null,8,Rt),[[E,o.text]]),l(x,{message:s(n).errors[`segments.${c}.text`]},null,8,["message"])]))),128)),t("div",Yt,[t("label",Gt,e(s(a)("Status")),1),h(t("select",{required:"","onUpdate:modelValue":u[3]||(u[3]=o=>s(n).status=o),class:"select",name:"status"},[t("option",Ht,e(s(a)("Active")),1),t("option",Jt,e(s(a)("Draft")),1)],512),[[f,s(n).status]])])]),t("div",Kt,[t("div",Pt,[t("button",Qt,[t("span",null,e(s(a)("Close")),1)]),l(U,{classes:"btn btn-primary w-full",processing:s(n).processing,"btn-text":s(a)("Update")},null,8,["processing","btn-text"])])])],32)])],64)}}});export{rs as default};
