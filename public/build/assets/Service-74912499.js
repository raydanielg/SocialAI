import{m as v,a3 as g,c as _,b as e,t as n,d as o,v as r,a as i,u as b,w as V,k as d,o as c}from"./app-13978987.js";import{_ as u}from"./ImageInput.vue_vue_type_script_setup_true_lang-4a03e2f5.js";import{_ as f}from"./SpinnerBtn-cb152833.js";import{u as U}from"./optionUpdate-b5f61f3c.js";const k={class:"mb-10 mt-2 rounded border p-3 dark:border-gray-600"},B={class:"mb-2"},y={class:"mb-2"},S={class:"mb-10 mt-2 rounded border p-3 dark:border-gray-600"},T={class:"mb-2"},h=e("small",null,[d("Note: use "),e("code",null,"<span>text</span>"),d(" to make text italic and "),e("code",null,"<br/>"),d(" to line break ")],-1),I={class:"mb-2"},N={class:"mb-2"},w={class:"mb-10 mt-2 rounded border p-3 dark:border-gray-600"},x={class:"mb-2"},M={class:"mb-2"},$={class:"mb-2"},D={class:"mb-2"},E={class:"mb-2"},C={__name:"Service",props:["data"],setup(p){const t=v({...p.data}),m=U();return g(()=>{["service","hero","sidebar_card"].forEach(l=>t.value[l]=t.value[l]||{})}),(s,l)=>(c(),_("form",{method:"POST",onSubmit:l[14]||(l[14]=V(a=>b(m).submit("service_page",t.value),["prevent"])),enctype:"multipart/form-data"},[e("h6",null,n(s.trans("Banner Section")),1),e("div",k,[e("div",B,[e("label",null,n(s.trans("Title")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[0]||(l[0]=a=>t.value.hero.title1=a)},null,512),[[r,t.value.hero.title1]])]),e("div",y,[e("label",null,n(s.trans("Title 2")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[1]||(l[1]=a=>t.value.hero.title2=a)},null,512),[[r,t.value.hero.title2]])]),i(u,{label:s.trans("Banner Image"),modelValue:t.value.hero.banner_img,"onUpdate:modelValue":l[2]||(l[2]=a=>t.value.hero.banner_img=a),class:"mb-2"},null,8,["label","modelValue"])]),e("h6",null,n(s.trans("Service Page")),1),e("div",S,[e("div",T,[e("label",null,n(s.trans("Title")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[3]||(l[3]=a=>t.value.service.title=a)},null,512),[[r,t.value.service.title]]),h]),e("div",I,[e("label",null,n(s.trans("Right Button Text")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[4]||(l[4]=a=>t.value.service.btn_text=a)},null,512),[[r,t.value.service.btn_text]])]),e("div",N,[e("label",null,n(s.trans("Right Button Link")),1),o(e("input",{type:"url",class:"input","onUpdate:modelValue":l[5]||(l[5]=a=>t.value.service.btn_link=a)},null,512),[[r,t.value.service.btn_link]])]),i(u,{label:s.trans("Background Image"),modelValue:t.value.service.bg_img,"onUpdate:modelValue":l[6]||(l[6]=a=>t.value.service.bg_img=a),class:"mb-2"},null,8,["label","modelValue"]),i(u,{label:s.trans("BG bottom-right Image"),modelValue:t.value.service.bg_bottom_right_image,"onUpdate:modelValue":l[7]||(l[7]=a=>t.value.service.bg_bottom_right_image=a),class:"mb-2"},null,8,["label","modelValue"])]),e("h6",null,n(s.trans("Sidebar card")),1),e("div",w,[e("div",x,[e("label",null,n(s.trans("Title")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[8]||(l[8]=a=>t.value.sidebar_card.title=a)},null,512),[[r,t.value.sidebar_card.title]])]),e("div",M,[e("label",null,n(s.trans("Sub title")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[9]||(l[9]=a=>t.value.sidebar_card.sub_title=a)},null,512),[[r,t.value.sidebar_card.sub_title]])]),e("div",$,[e("label",null,n(s.trans("Button Text")),1),o(e("input",{type:"text",class:"input","onUpdate:modelValue":l[10]||(l[10]=a=>t.value.sidebar_card.btn_text=a)},null,512),[[r,t.value.sidebar_card.btn_text]])]),e("div",D,[e("label",null,n(s.trans("Button Link")),1),o(e("input",{type:"url",class:"input","onUpdate:modelValue":l[11]||(l[11]=a=>t.value.sidebar_card.btn_link=a)},null,512),[[r,t.value.sidebar_card.btn_link]])]),i(u,{label:s.trans("BG Image"),modelValue:t.value.sidebar_card.bg_img,"onUpdate:modelValue":l[12]||(l[12]=a=>t.value.sidebar_card.bg_img=a)},null,8,["label","modelValue"]),i(u,{label:s.trans("Bottom Image"),modelValue:t.value.sidebar_card.bottom_img,"onUpdate:modelValue":l[13]||(l[13]=a=>t.value.sidebar_card.bottom_img=a),class:"mb-2"},null,8,["label","modelValue"])]),e("div",E,[i(f,{processing:b(m).processing,"btn-text":s.trans("Save Changes")},null,8,["processing","btn-text"])])],32))}};export{C as default};
