import{d as f,T as b,e as v,f as x,g as o,u as e,o as h,h as a,a as t,i as u,n as l,j as c}from"./app-c4fe6d5f.js";import{a as j,_ as C,C as y}from"./Card-fe219246.js";import{_ as w}from"./Label.vue_vue_type_script_setup_true_lang-6dfd2c29.js";import{_ as S}from"./Textarea.vue_vue_type_script_setup_true_lang-01aa52f4.js";import"./vue-select-cc72a998.js";const V=t("div",{class:"flex justify-between items-center"},[t("h5",{class:"font-bold text-xl"},"Persetujuan")],-1),B={class:"flex justify-between items-center space-x-4"},P={class:"w-full mb-4"},g={class:"flex justify-end space-x-2"},k=["onSubmit"],$=["onSubmit"],R=f({__name:"Persetujuan.p",props:{id_rap:{}},setup(p){const n=p,s=b({catatan:null});function _(){s.post(route("rap.approve",n.id_rap))}function m(){s.post(route("rap.refuse",n.id_rap))}return(N,r)=>{const i=v("ease-button");return h(),x(e(y),{class:"h-fit"},{default:o(()=>[a(e(j),{class:"mb-2"},{default:o(()=>[V]),_:1}),a(e(C),null,{default:o(()=>[t("div",B,[t("div",P,[a(e(w),{value:"Catatan"}),a(e(S),{modelValue:e(s).catatan,"onUpdate:modelValue":r[0]||(r[0]=d=>e(s).catatan=d),placeholder:"Beri catatan"},null,8,["modelValue"])]),t("div",g,[t("form",{onSubmit:u(m,["prevent"])},[a(i,l(c({variant:"danger",type:"submit",text:"Tolak"})),null,16)],40,k),t("form",{onSubmit:u(_,["prevent"])},[a(i,l(c({type:"submit",text:"Setujui"})),null,16)],40,$)])])]),_:1})]),_:1})}}});export{R as _};