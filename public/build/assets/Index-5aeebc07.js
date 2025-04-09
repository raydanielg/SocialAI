import{s as V,l as M,p as e,T as U,m as N,h as j,c as r,b as t,a as i,t as a,u as s,F as g,r as f,i as B,w as x,d as p,v as y,f as v,g as E,o as c,n as F,j as I,z as q,q as T,O as z}from"./app-13978987.js";import{_ as L}from"./AdminLayout-bd13ff9d.js";import{_ as O}from"./PageHeader-8c638686.js";import{h as R}from"./moment-a9aaa855.js";import{_ as Y}from"./NoDataFound-bc81d7fa.js";import G from"./OverviewGrid-21ea6fc2.js";import{_ as k}from"./SpinnerBtn-cb152833.js";import{d as h}from"./drawer-fe4c5e1a.js";import"./dropdown-45d66330.js";const H={class:"container p-4 sm:p-6"},J={class:"space-y-6"},K={class:"card"},P={class:"table-responsive whitespace-nowrap rounded-primary"},Q={class:"table"},W={class:"w-2/12"},X={class:"w-2/12"},Z={class:"w-2/12"},tt={class:"text-center"},st={class:"w-2/12"},et={class:"w-2/12"},at={class:"mr-auto w-2/12"},ot={class:"text-end"},nt={key:0},lt={class:"text-left"},it={class:"text-left"},dt={class:"text-center"},ct={class:"text-left"},rt={class:"flex justify-end"},ut={class:"dropdown","data-placement":"bottom-start"},_t={class:"dropdown-toggle"},pt={class:"dropdown-content w-40"},mt={class:"dropdown-list"},gt={class:"dropdown-list-item"},vt=["onClick"],ht={class:"dropdown-list-item"},bt={id:"addNewTagDrawer",class:"drawer drawer-right"},ft={class:"drawer-header"},wt={type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},xt={class:"drawer-body"},yt={class:"mb-2"},Tt={class:"mb-2"},kt={value:"1"},Ct={value:"0"},Dt={class:"mb-2"},St=["value"],At={class:"drawer-footer"},$t={class:"flex justify-end gap-2"},Vt={type:"button",class:"btn btn-secondary","data-dismiss":"drawer"},Mt={id:"editTagDrawer",class:"drawer drawer-right"},Ut={class:"drawer-header"},Nt={type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},jt={class:"drawer-body"},Bt={class:"mb-2"},Et={class:"mb-2"},Ft={value:"1"},It={value:"0"},qt={class:"mb-2"},zt=["value"],Lt={class:"drawer-footer"},Ot={class:"flex justify-end gap-2"},Rt={type:"button",class:"btn btn-secondary","data-dismiss":"drawer"},Yt=E({layout:L}),ts=Object.assign(Yt,{__name:"Index",props:["tags","totalTags","activeTags","inActiveTags","languages","buttons"],setup(_){const{deleteRow:C}=V();M(()=>{h.init()});const b=_,D=[{value:b.totalTags,title:e("Total Tags"),iconClass:"bx:bar-chart"},{value:b.activeTags,title:e("Active Tags"),iconClass:"bx:check-circle"},{value:b.inActiveTags,title:e("Inactive Tags"),iconClass:"bx:x-circle"}],d=U({title:"",status:"active",language:""}),l=N({}),S=()=>{d.post(route("admin.tag.store"),{onSuccess:()=>{d.reset(),T.success(e("Tag has been added successfully")),h.of("#addNewTagDrawer").hide()}})},A=w=>{l.value={...w},h.of("#editTagDrawer").show()},$=()=>{z.patch(route("admin.tag.update",l.value.id),l.value,{onSuccess:()=>{l.value={},T.success(e("Tag has been updated successfully")),h.of("#editTagDrawer").hide()}})};return(w,n)=>{const m=j("Icon");return c(),r(g,null,[t("main",H,[i(O,{title:"Tags",buttons:_.buttons},null,8,["buttons"]),t("div",J,[i(G,{items:D,grid:"3"}),t("div",K,[t("div",P,[t("table",Q,[t("thead",null,[t("tr",null,[t("th",W,a(s(e)("Name")),1),t("th",X,a(s(e)("Slug")),1),t("th",Z,[t("p",tt,a(s(e)("Uses for blog")),1)]),t("th",st,a(s(e)("Status")),1),t("th",et,a(s(e)("Created At")),1),t("th",at,[t("p",ot,a(s(e)("Action")),1)])])]),_.tags.total?(c(),r("tbody",nt,[(c(!0),r(g,null,f(_.tags.data,o=>(c(),r("tr",{key:o.id},[t("td",lt,a(o.title),1),t("td",it,a(o.slug),1),t("td",null,[t("p",dt,a(o.postcategories_count),1)]),t("td",ct,[t("span",{class:F(["badge",[o.status==1?"badge-primary":"badge-danger"]])},a(o.status==1?s(e)("Active"):s(e)("Draft")),3)]),t("td",null,a(s(R)(o.created_at).format("D-MMM-Y")),1),t("td",null,[t("div",rt,[t("div",ut,[t("div",_t,[i(m,{class:"text-2xl",icon:"bx:dots-horizontal-rounded"})]),t("div",pt,[t("ul",mt,[t("li",gt,[t("button",{onClick:u=>A(o),class:"dropdown-link"},[i(m,{icon:"fe:edit"}),t("span",null,a(s(e)("Edit")),1)],8,vt)]),t("li",ht,[i(s(q),{as:"button",class:"dropdown-link",onClick:u=>s(C)("/admin/tag/"+o.id)},{default:I(()=>[i(m,{icon:"fe:trash"}),t("span",null,a(s(e)("Delete")),1)]),_:2},1032,["onClick"])])])])])])])]))),128))])):(c(),B(Y,{key:1,"for-table":"true"}))])])])])]),t("div",bt,[t("form",{onSubmit:n[3]||(n[3]=x(o=>S(),["prevent"]))},[t("div",ft,[t("h5",null,a(s(e)("Add New Tag")),1),t("button",wt,[i(m,{class:"text-xl",icon:"mdi:close"})])]),t("div",xt,[t("div",yt,[t("label",null,a(s(e)("Title")),1),p(t("input",{"onUpdate:modelValue":n[0]||(n[0]=o=>s(d).title=o),type:"text",name:"title",class:"input",required:""},null,512),[[y,s(d).title]])]),t("div",Tt,[t("label",null,a(s(e)("Status")),1),p(t("select",{"onUpdate:modelValue":n[1]||(n[1]=o=>s(d).status=o),class:"select",name:"status"},[t("option",kt,a(s(e)("Active")),1),t("option",Ct,a(s(e)("Deactive")),1)],512),[[v,s(d).status]])]),t("div",Dt,[t("label",null,a(s(e)("Language")),1),p(t("select",{"onUpdate:modelValue":n[2]||(n[2]=o=>s(d).language=o),class:"select",name:"language"},[(c(!0),r(g,null,f(_.languages,(o,u)=>(c(),r("option",{key:u,value:u},a(o),9,St))),128))],512),[[v,s(d).language]])])]),t("div",At,[t("div",$t,[t("button",Vt,[t("span",null,a(s(e)("Close")),1)]),i(k,{classes:"btn btn-primary",processing:s(d).processing,"btn-text":s(e)("Save Tag")},null,8,["processing","btn-text"])])])],32)]),t("div",Mt,[t("form",{onSubmit:n[7]||(n[7]=x(o=>$(),["prevent"]))},[t("div",Ut,[t("h5",null,a(s(e)("Edit Tag")),1),t("button",Nt,[i(m,{class:"text-xl",icon:"mdi:close"})])]),t("div",jt,[t("div",Bt,[t("label",null,a(s(e)("Title")),1),p(t("input",{"onUpdate:modelValue":n[4]||(n[4]=o=>l.value.title=o),type:"text",name:"title",id:"title",class:"input",required:""},null,512),[[y,l.value.title]])]),t("div",Et,[t("label",null,a(s(e)("Status")),1),p(t("select",{"onUpdate:modelValue":n[5]||(n[5]=o=>l.value.status=o),class:"select",name:"status",id:"status"},[t("option",Ft,a(s(e)("Active")),1),t("option",It,a(s(e)("Deactive")),1)],512),[[v,l.value.status]])]),t("div",qt,[t("label",null,a(s(e)("Language")),1),p(t("select",{"onUpdate:modelValue":n[6]||(n[6]=o=>l.value.lang=o),class:"select",name:"language",id:"language"},[(c(!0),r(g,null,f(_.languages,(o,u)=>(c(),r("option",{key:u,value:u},a(o),9,zt))),128))],512),[[v,l.value.lang]])])]),t("div",Lt,[t("div",Ot,[t("button",Rt,[t("span",null,a(s(e)("Close")),1)]),i(k,{classes:"btn btn-primary",processing:l.value.processing,"btn-text":s(e)("Save Changes")},null,8,["processing","btn-text"])])])],32)])],64)}}});export{ts as default};
