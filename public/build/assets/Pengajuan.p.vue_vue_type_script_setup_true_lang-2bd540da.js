import{d as _,T as d,e as p,f,g as o,u as t,o as b,h as e,a,i as h,n as x,j as v}from"./app-803e4503.js";import{a as C,_ as g,C as j}from"./Card-7713b684.js";import{_ as w}from"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import{_ as y}from"./Textarea.vue_vue_type_script_setup_true_lang-2965e452.js";import"./vue-select-834fdd5f.js";const V=a("div",{class:"flex justify-between items-center"},[a("h5",{class:"font-bold text-xl"},"Submit")],-1),B={class:"flex justify-between items-center space-x-4"},S={class:"w-full mb-4"},P={class:"flex justify-end space-x-2"},$=["onSubmit"],M=_({__name:"Pengajuan.p",props:{id_rap:{},uraian_length:{}},setup(i){const l=i,s=d({catatan:null});function r(){s.post(route("rap.submit",l.id_rap))}return(u,n)=>{const c=p("ease-button");return b(),f(t(j),{class:"h-fit"},{default:o(()=>[e(t(C),{class:"mb-2"},{default:o(()=>[V]),_:1}),e(t(g),null,{default:o(()=>[a("div",B,[a("div",S,[e(t(w),{value:"Catatan"}),e(t(y),{modelValue:t(s).catatan,"onUpdate:modelValue":n[0]||(n[0]=m=>t(s).catatan=m),placeholder:"Beri catatan (Opsional)"},null,8,["modelValue"])]),a("div",P,[a("form",{onSubmit:h(r,["prevent"])},[e(c,x(v({type:"submit",text:"Submit",disabled:u.uraian_length<1})),null,16)],40,$)])])]),_:1})]),_:1})}}});export{M as _};
