import{s as N,T as P,m as $,c as i,a as r,b as e,k as x,t as o,u as t,e as _,w as M,F as p,r as v,d as c,v as u,f as y,g as j,o as d,n as S,q}from"./app-13978987.js";import{_ as D}from"./SpinnerBtn-cb152833.js";import{_ as m}from"./InputFieldError-52549d23.js";import{_ as H}from"./AdminLayout-bd13ff9d.js";import{_ as W}from"./PageHeader-8c638686.js";import"./dropdown-45d66330.js";const B={class:"container flex-grow p-4 sm:p-6"},A={class:"mx-auto lg:w-9/12"},Q={class:"card-title mb-3"},R={key:0,class:"text-xs capitalize"},G={class:"mt-2 grid grid-cols-2 gap-4 lg:grid-cols-3"},K=["onClick"],L={class:"mb-1"},O={class:"card card-body"},X={class:"mb-2"},J={class:"label mb-1"},Y={class:"mb-2"},Z={class:"label mb-1"},ee={class:"grid grid-cols-1 gap-4 lg:grid-cols-2"},se={class:"mb-2"},te={class:"label mb-1"},le={class:"mb-2"},ae={class:"label mb-1"},oe={class:"grid grid-cols-1 gap-4 lg:grid-cols-2"},ne={class:"label mb-1"},ie=e("option",{value:"",disabled:"",selected:""},"Select",-1),de=["value"],re={class:"label mb-1"},me={key:0,class:"card card-body grid grid-cols-2 gap-x-5 gap-y-4"},ce={class:"col-span-full mb-2"},ue={class:"label mb-1"},pe={class:"mb-2"},_e={class:"label mb-1"},ge={class:"flex"},be={class:"label card w-20 rounded-md px-2 py-1 text-center"},ve=e("p",{class:"text-sm"},"* Width and Height should be same px",-1),he={class:"mb-2"},ye={class:"label mb-1"},fe={class:"flex"},xe={class:"label card w-20 rounded-md px-2 py-1 text-center"},ke=e("p",{class:"text-sm"},"* Width and Height should be same px",-1),Ve={class:"mb-2"},we={class:"label mb-1"},Ue={class:"flex"},Se={class:"label card w-20 rounded-md px-2 py-1 text-center"},Ce={class:"mb-2"},ze={class:"label mb-1"},Te={class:"flex"},Fe={class:"label card w-20 rounded-md px-2 py-1 text-center"},Ie={class:"col-span-full flex gap-2"},Ee={key:0,class:"flex-1"},Ne={class:"label mb-1"},Pe=e("option",{value:"null",disabled:"",selected:""},"Select",-1),$e=["value"],Me={class:"flex-1"},je={class:"label mb-1"},qe=e("option",{value:"null",disabled:"",selected:""},"Select",-1),De=["value"],He={class:"flex-1"},We={class:"label mb-1"},Be=e("option",{value:"null",disabled:"",selected:""},"Select",-1),Ae=["value"],Qe={key:2,class:"mb-2 flex-1"},Re={class:"label mb-1"},Ge={key:1,class:"card card-body grid grid-cols-2 gap-4"},Ke={class:"label mb-1"},Le=e("option",{value:"",disabled:"",selected:""},"Select",-1),Oe=["value"],Xe={class:"label mb-1"},Je={class:"label mb-1"},Ye={key:2,class:"card card-body grid grid-cols-2 gap-4"},Ze={key:0},es={class:"label mb-1"},ss=e("option",{value:"null",disabled:"",selected:""},"Select",-1),ts=["value"],ls={class:"label mb-1"},as=e("small",null,"(Decoder iterations)",-1),os=["href"],ns={key:3,class:"card card-body space-y-4"},is={class:"label mb-1"},ds={class:"label mb-1"},rs={class:"card card-body"},ms={class:"flex justify-between"},cs={class:"flex-1 space-y-1"},us={class:"label mb-1"},ps=["onUpdate:modelValue"],_s=e("option",{value:"",disabled:"",selected:""},"Select",-1),gs=["value"],bs={class:"flex-1 space-y-1"},vs={class:"label mb-1"},hs=["onUpdate:modelValue"],ys={class:"flex-1 space-y-1"},fs={class:"label mb-1"},xs=["onUpdate:modelValue"],ks={class:"text-right"},Vs=["onClick"],ws={class:"card card-body"},Us={class:"mb-2"},Ss={class:"label mb-1"},Cs={class:"mb-3 flex flex-wrap items-center gap-1"},zs=["onClick"],Ts={class:"mb-2"},Fs=j({layout:H}),js=Object.assign(Fs,{__name:"Edit",props:["template","buttons","segments","models","voices","image_models","image_ratios","image_sizes","instructions"],setup(h){var U;const{trim:V}=N(),k=h,C=[{title:"text",icon:"bx-news"},{title:"image",icon:"bx-image"},{title:"video",icon:"bxs-videos"},{title:"audio",icon:"bxs-microphone-alt"},{title:"voice_clone",icon:"bx-user-voice"}],z={text:"word",video:"seconds",voice_clone:"clone",image:"image",audio:"audio"},w={type:"",name:"",placeholder:"",value:""},s=P({...k.template,fields:((U=k.template)==null?void 0:U.fields)??[{...w}],_method:"put"}),T=()=>{s.fields.push({...w})},F=n=>{s.fields.splice(n,1)},I=()=>{s.post(route("admin.ai-templates.update",k.template),{onSuccess:()=>{q.success("Template has been updated successfully")}})},f=$(""),E=n=>{let a=f.value.selectionStart,l=s.prompt;s.prompt=l.slice(0,a)+n+l.slice(a);let g=a+n.length;setTimeout(()=>{f.value.setSelectionRange(g,g),f.value.focus()},100)};return(n,a)=>(d(),i("main",B,[r(W,{title:n.trans("Edit Template"),buttons:h.buttons},null,8,["title","buttons"]),e("div",A,[e("h3",Q,[x(o(n.trans("Edit Template"))+" ",1),h.template.ai_model?(d(),i("span",R,"( "+o(t(V)(h.template.ai_model))+" )",1)):_("",!0)]),e("form",{onSubmit:M(I,["prevent"]),class:"space-y-7"},[e("div",G,[(d(),i(p,null,v(C,l=>(d(),i(p,{key:l.title},[t(s).prompt_type==l.title?(d(),i("button",{key:0,type:"button",class:S(["card flex h-20 items-center justify-center gap-2 rounded-md text-sm capitalize hover:bg-secondary-950",{"border border-primary-600":t(s).prompt_type==l.title}]),onClick:g=>t(s).prompt_type=l.title},[e("i",{class:S(["bx text-2xl",l.icon])},null,2),e("span",L,o(l.title),1)],10,K)):_("",!0)],64))),64))]),e("div",O,[e("div",X,[e("label",J,o(n.trans("Title")),1),c(e("input",{type:"text","onUpdate:modelValue":a[0]||(a[0]=l=>t(s).title=l),class:"input"},null,512),[[u,t(s).title]]),r(m,{message:t(s).errors.title},null,8,["message"])]),e("div",Y,[e("label",Z,o(n.trans("Description")),1),c(e("textarea",{"onUpdate:modelValue":a[1]||(a[1]=l=>t(s).description=l),class:"textarea"},null,512),[[u,t(s).description]]),r(m,{message:t(s).errors.description},null,8,["message"])]),e("div",ee,[e("div",se,[e("label",te,o(n.trans("Icon")),1),e("input",{type:"file",accept:"image/*",onChange:a[2]||(a[2]=l=>t(s).icon=l.target.files[0]),class:"input"},null,32),r(m,{message:t(s).errors.icon},null,8,["message"])]),e("div",le,[e("label",ae,o(n.trans("Preview")),1),e("input",{type:"file",accept:"image/*",onChange:a[3]||(a[3]=l=>t(s).preview=l.target.files[0]),class:"input"},null,32),r(m,{message:t(s).errors.preview},null,8,["message"])])]),e("div",oe,[e("div",null,[e("label",ne,o(n.trans("Status")),1),c(e("select",{class:"select capitalize","onUpdate:modelValue":a[4]||(a[4]=l=>t(s).status=l)},[ie,(d(),i(p,null,v(["active","draft"],l=>e("option",{value:l,key:l},o(l),9,de)),64))],512),[[y,t(s).status]]),r(m,{message:t(s).errors.status},null,8,["message"])]),e("div",null,[e("label",re,[x(o(n.trans("Credit Charge"))+" ",1),e("small",null,"("+o(n.trans("per"))+" "+o(z[t(s).prompt_type])+")",1)]),c(e("input",{type:"number","onUpdate:modelValue":a[5]||(a[5]=l=>t(s).credit_charge=l),class:"input"},null,512),[[u,t(s).credit_charge]]),r(m,{message:t(s).errors.credit_charge},null,8,["message"])])])]),t(s).prompt_type=="image"?(d(),i("div",me,[e("div",ce,[e("label",ue,o(n.trans("Negative Prompt")),1),c(e("textarea",{"onUpdate:modelValue":a[6]||(a[6]=l=>t(s).meta.negative_prompt=l),ref_key:"bodyEl",ref:f,class:"textarea"},null,512),[[u,t(s).meta.negative_prompt]]),r(m,{message:t(s).errors["meta.negative_prompt"]},null,8,["message"])]),t(s).ai_model=="stablediffusion"?(d(),i(p,{key:0},[e("div",pe,[e("label",_e,o(n.trans("Image Width")),1),e("div",ge,[c(e("input",{step:"8","onUpdate:modelValue":a[7]||(a[7]=l=>t(s).meta.image_width=l),class:"w-full cursor-pointer accent-primary-600",type:"range",min:"512",max:"1024"},null,512),[[u,t(s).meta.image_width]]),e("span",be,o(t(s).meta.image_width||0)+" px ",1)]),ve,r(m,{message:t(s).errors["meta.image_width"]},null,8,["message"])]),e("div",he,[e("label",ye,o(n.trans("Image Height")),1),e("div",fe,[c(e("input",{step:"8","onUpdate:modelValue":a[8]||(a[8]=l=>t(s).meta.image_height=l),class:"w-full cursor-pointer accent-primary-600",type:"range",min:"512",max:"1024"},null,512),[[u,t(s).meta.image_height]]),e("span",xe,o(t(s).meta.image_height||0)+" px ",1)]),ke,r(m,{message:t(s).errors["meta.image_height"]},null,8,["message"])]),e("div",Ve,[e("label",we,o(n.trans("Guidance Scale")),1),e("div",Ue,[c(e("input",{step:"2","onUpdate:modelValue":a[9]||(a[9]=l=>t(s).meta.guidance_scale=l),class:"w-full cursor-pointer accent-primary-600",type:"range",min:"0",max:"20"},null,512),[[u,t(s).meta.guidance_scale]]),e("span",Se,o(t(s).meta.guidance_scale||0),1)]),r(m,{message:t(s).errors["meta.guidance_scale"]},null,8,["message"])]),e("div",Ce,[e("label",ze,o(n.trans("Steps")),1),e("div",Te,[c(e("input",{step:"5","onUpdate:modelValue":a[10]||(a[10]=l=>t(s).meta.steps=l),class:"w-full cursor-pointer accent-primary-600",type:"range",min:"10",max:"512"},null,512),[[u,t(s).meta.steps]]),e("span",Fe,o(t(s).meta.steps||0)+" px ",1)]),r(m,{message:t(s).errors["meta.steps"]},null,8,["message"])])],64)):_("",!0),e("div",Ie,[t(s).ai_model=="stability_ai"?(d(),i("div",Ee,[e("label",Ne,o(n.trans("Image Aspect Ratio"))+"*",1),c(e("select",{class:"select capitalize","onUpdate:modelValue":a[11]||(a[11]=l=>t(s).meta.aspect_ratio=l)},[Pe,(d(!0),i(p,null,v(h.image_ratios,l=>(d(),i("option",{value:l,key:l},o(l),9,$e))),128))],512),[[y,t(s).meta.aspect_ratio]]),r(m,{message:t(s).errors["meta.aspect_ratio"]},null,8,["message"])])):_("",!0),t(s).ai_model=="dalle_3"?(d(),i(p,{key:1},[e("div",Me,[e("label",je,o(n.trans("Image Size"))+"*",1),c(e("select",{class:"select capitalize","onUpdate:modelValue":a[12]||(a[12]=l=>t(s).meta.image_size=l)},[qe,(d(!0),i(p,null,v(h.image_sizes,l=>(d(),i("option",{value:l,key:l},o(l),9,De))),128))],512),[[y,t(s).meta.image_size]]),r(m,{message:t(s).errors["meta.image_size"]},null,8,["message"])]),e("div",He,[e("label",We,o(n.trans("Image Quality"))+"*",1),c(e("select",{class:"select capitalize","onUpdate:modelValue":a[13]||(a[13]=l=>t(s).meta.image_quality=l)},[Be,(d(),i(p,null,v(["standard","hd"],l=>e("option",{value:l,key:l},o(l),9,Ae)),64))],512),[[y,t(s).meta.image_quality]]),r(m,{message:t(s).errors["meta.image_quality"]},null,8,["message"])])],64)):_("",!0),t(s).ai_model=="stablediffusion"||t(s).ai_model=="stability_ai"?(d(),i("div",Qe,[e("label",Re,o(n.trans("Seed")),1),c(e("input",{type:"number","onUpdate:modelValue":a[14]||(a[14]=l=>t(s).meta.seed=l),class:"input"},null,512),[[u,t(s).meta.seed]]),r(m,{message:t(s).errors["meta.seed"]},null,8,["message"])])):_("",!0)])])):_("",!0),t(s).prompt_type=="text"?(d(),i("div",Ge,[e("div",null,[e("label",Ke,o(n.trans("Ai Model"))+"*",1),c(e("select",{class:"select capitalize","onUpdate:modelValue":a[15]||(a[15]=l=>t(s).meta.model=l)},[Le,(d(!0),i(p,null,v(h.models,l=>(d(),i("option",{value:l,key:l},o(l),9,Oe))),128))],512),[[y,t(s).meta.model]]),r(m,{message:t(s).errors["meta.model"]},null,8,["message"])]),e("div",null,[e("label",Xe,o(n.trans("Max Token")),1),c(e("input",{type:"number","onUpdate:modelValue":a[16]||(a[16]=l=>t(s).meta.max_token=l),class:"input"},null,512),[[u,t(s).meta.max_token]]),r(m,{message:t(s).errors.max_token},null,8,["message"])]),e("div",null,[e("label",Je,o(n.trans("Max Word")),1),c(e("input",{type:"number","onUpdate:modelValue":a[17]||(a[17]=l=>t(s).meta.max_word=l),class:"input"},null,512),[[u,t(s).meta.max_word]]),r(m,{message:t(s).errors["meta.max_word"]},null,8,["message"])])])):_("",!0),t(s).prompt_type=="voice_clone"||t(s).prompt_type=="audio"?(d(),i("div",Ye,[t(s).prompt_type=="voice_clone"?(d(),i("div",Ze,[e("label",es,o(n.trans("Voices"))+"*",1),c(e("select",{class:"select capitalize","onUpdate:modelValue":a[18]||(a[18]=l=>t(s).meta.voice_id=l),required:""},[ss,(d(!0),i(p,null,v(h.voices,l=>(d(),i("option",{value:l,key:l},o(t(V)(l)),9,ts))),128))],512),[[y,t(s).meta.voice_id]]),r(m,{message:t(s).errors["meta.voice_id"]},null,8,["message"])])):_("",!0),e("div",null,[e("label",ls,[x(o(n.trans("Quality"))+"* ",1),as]),c(e("input",{type:"number",required:"","onUpdate:modelValue":a[19]||(a[19]=l=>t(s).meta.decoder_iterations=l),class:"input"},null,512),[[u,t(s).meta.decoder_iterations]]),r(m,{message:t(s).errors["meta.decoder_iterations"]},null,8,["message"]),e("small",null,[e("a",{href:n.sanitizeHtml(h.instructions[t(s).prompt_type]),target:"_blank"}," * "+o(n.trans("instructions")),9,os)])])])):_("",!0),t(s).prompt_type=="video"?(d(),i("div",ns,[e("div",null,[e("label",is,[x(o(n.trans("Video length"))+" ",1),e("small",null,"("+o(n.trans("Max Seconds"))+")",1)]),c(e("input",{type:"number","onUpdate:modelValue":a[20]||(a[20]=l=>t(s).meta.max_seconds=l),class:"input"},null,512),[[u,t(s).meta.max_seconds]]),r(m,{message:t(s).errors["meta.max_seconds"]},null,8,["message"])]),e("div",null,[e("label",ds,o(n.trans("Negative Prompt")),1),c(e("textarea",{"onUpdate:modelValue":a[21]||(a[21]=l=>t(s).meta.negative_prompt=l),ref_key:"bodyEl",ref:f,class:"textarea"},null,512),[[u,t(s).meta.negative_prompt]]),r(m,{message:t(s).errors["meta.negative_prompt"]},null,8,["message"])])])):_("",!0),e("div",rs,[e("div",ms,[e("h5",null,o(n.trans("Input Fields")),1),e("button",{type:"button",class:"btn btn-primary",onClick:T},"+")]),(d(!0),i(p,null,v(t(s).fields,(l,g)=>(d(),i("div",{key:g,class:"flex flex-col justify-between gap-3 lg:flex-row lg:items-center"},[e("div",cs,[e("label",us,o(n.trans("Field Type")),1),c(e("select",{class:"select","onUpdate:modelValue":b=>l.type=b},[_s,(d(),i(p,null,v(["input","textarea"],b=>e("option",{value:b,key:b},o(b),9,gs)),64))],8,ps),[[y,l.type]]),r(m,{message:t(s).errors["fields."+g+".type"]},null,8,["message"])]),e("div",bs,[e("label",vs,o(n.trans("Field Name")),1),c(e("input",{type:"text","onUpdate:modelValue":b=>l.name=b,class:"input"},null,8,hs),[[u,l.name]]),r(m,{message:t(s).errors["fields."+g+".name"]},null,8,["message"])]),e("div",ys,[e("label",fs,o(n.trans("Field Placeholder")),1),c(e("input",{type:"text","onUpdate:modelValue":b=>l.placeholder=b,class:"input"},null,8,xs),[[u,l.placeholder]]),r(m,{message:t(s).errors["fields."+g+".placeholder"]},null,8,["message"])]),e("div",ks,[e("button",{type:"button",class:"btn btn-danger mt-5",onClick:b=>F(g)}," X ",8,Vs)])]))),128))]),e("div",ws,[e("div",Us,[e("label",Ss,o(n.trans("Custom Prompt")),1),c(e("textarea",{"onUpdate:modelValue":a[22]||(a[22]=l=>t(s).prompt=l),ref_key:"bodyEl",ref:f,class:"textarea"},null,512),[[u,t(s).prompt]]),r(m,{message:t(s).errors.prompt},null,8,["message"])]),e("ul",Cs,[(d(!0),i(p,null,v(t(s).fields.filter(l=>l.name.length).map(l=>`[${l.name}]`),l=>(d(),i("li",{onClick:g=>E(l),key:l,class:"rounded border p-1"},o(l),9,zs))),128))]),e("div",Ts,[r(D,{processing:t(s).processing,"btn-text":n.trans("Update")},null,8,["processing","btn-text"])])])],32)])]))}});export{js as default};
