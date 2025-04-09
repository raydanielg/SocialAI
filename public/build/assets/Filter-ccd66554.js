import{T as k,h as T,o,c as i,b as e,t as a,F as _,r as H,i as M,u as c,z as L,e as l,a as w,w as F,d as b,v as S,f as j}from"./app-13978987.js";const x={class:"flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0"},N={class:"flex w-full items-center justify-between gap-x-4 md:w-auto"},V={class:"flex w-full items-center justify-between gap-x-4 md:w-auto"},z={key:0,class:"flex flex-wrap gap-1"},B=["data-target"],q=["innerHTML"],C=["href","download","innerHTML"],D={key:1,class:"dropdown","data-placement":"bottom-end"},U={class:"dropdown-toggle"},E={type:"button",class:"btn bg-white font-medium shadow-sm dark:bg-slate-800"},I={class:"dropdown-content w-72 !overflow-visible"},A={class:"dropdown-list space-y-4 p-4"},G={class:"dropdown-list-item"},J={class:"my-1 text-sm font-medium"},K={class:"mb-2"},O={key:0,class:"dropdown-list-item"},P={class:"mb-2"},Q={value:"email"},R={key:0,value:"name"},W={key:1,value:"ticket_no"},X={key:2,value:"subject"},Y={key:3,value:"title"},Z={class:"dropdown-list-item"},$={class:"btn btn-primary w-full"},te={__name:"Filter",props:["request","hidden","title","action","buttons","filterType","options"],setup(m){var p,u;const t=m,r=k({search:((p=t==null?void 0:t.request)==null?void 0:p.search)??"",type:((u=t==null?void 0:t.request)==null?void 0:u.type)??"email",action:t.action??null}),v=()=>{let n=r.action||location.href;r.get(n)};return(n,d)=>{var h,y;const f=T("Icon");return o(),i("div",x,[e("div",N,a(t.title??""),1),e("div",V,[((h=t.buttons)==null?void 0:h.length)!=0?(o(),i("div",z,[(o(!0),i(_,null,H(m.buttons,s=>(o(),i(_,{key:s.index},[s.as=="button"?(o(),i("button",{key:0,type:"button",onClick:d[0]||(d[0]=g=>g.preventDefault()),"data-toggle":"modal","data-target":s.target,class:"btn btn-primary btn-sm"},[e("div",{innerHTML:n.sanitizeHtml(s.name)},null,8,q)],8,B)):s.as=="a"?(o(),i("a",{key:1,href:s.url,download:s.download?"true":"false",innerHTML:n.sanitizeHtml(s.name),class:"btn btn-primary btn-sm"},null,8,C)):s.as!="button"||s.as!="a"?(o(),M(c(L),{key:2,href:s.url,class:"btn btn-primary btn-sm",innerHTML:n.sanitizeHtml(s.name)},null,8,["href","innerHTML"])):l("",!0)],64))),128))])):l("",!0),t.hidden!="filter"?(o(),i("div",D,[e("div",U,[e("button",E,[w(f,{icon:"fe:filter"}),e("span",null,a(n.trans("Filter")),1),w(f,{icon:"bx:chevron-down"})])]),e("div",I,[e("form",{onSubmit:F(v,["prevent"])},[e("ul",A,[e("li",G,[e("h2",J,a(n.trans("Status")),1),e("div",K,[b(e("input",{type:"text",name:"search","onUpdate:modelValue":d[1]||(d[1]=s=>c(r).search=s),class:"input",placeholder:"Search......"},null,512),[[S,c(r).search]])])]),((y=t.hidden)==null?void 0:y.type)!="type"?(o(),i("li",O,[e("div",P,[b(e("select",{class:"select",name:"type","onUpdate:modelValue":d[2]||(d[2]=s=>c(r).type=s)},[e("option",Q,a(n.trans("User Email")),1),t.filterType!="support"&&t.filterType!="notification"?(o(),i("option",R,a(n.trans("Name")),1)):l("",!0),t.filterType=="support"?(o(),i("option",W,a(n.trans("Ticket No")),1)):l("",!0),t.filterType=="support"?(o(),i("option",X,a(n.trans("Subject")),1)):l("",!0),t.filterType=="notification"?(o(),i("option",Y,a(n.trans("Title")),1)):l("",!0)],512),[[j,c(r).type]])])])):l("",!0),e("li",Z,[e("button",$,a(n.trans("Filter")),1)])])],32)])])):l("",!0)])])}}};export{te as _};
