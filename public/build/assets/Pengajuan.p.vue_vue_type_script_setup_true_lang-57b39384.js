import{d,T as m,e as u,f,g as n,u as a,o as p,h as t,a as e,i as b,n as x,j as h}from"./app-75a3a99f.js";import{a as v,_ as C,C as y}from"./Card-7d71d8a7.js";import{_ as j}from"./Label.vue_vue_type_script_setup_true_lang-21506f02.js";import{_ as w}from"./Textarea.vue_vue_type_script_setup_true_lang-3b042892.js";const V=e("div",{class:"flex justify-between items-center"},[e("h5",{class:"font-bold text-xl text-dark"},"Submit Pembayaran")],-1),B={class:"flex justify-between items-center space-x-4"},P={class:"w-full mb-4"},S={class:"flex justify-end space-x-2"},g=["onSubmit"],L=d({__name:"Pengajuan.p",props:{id_pencairan_dana:{}},setup(i){const r=i,s=m({catatan:null});function c(){s.post(route("pencairan_dana.submit",r.id_pencairan_dana))}return(k,o)=>{const l=u("ease-button");return p(),f(a(y),{class:"h-fit"},{default:n(()=>[t(a(v),{class:"mb-2"},{default:n(()=>[V]),_:1}),t(a(C),null,{default:n(()=>[e("div",B,[e("div",P,[t(a(j),{value:"Catatan"}),t(a(w),{modelValue:a(s).catatan,"onUpdate:modelValue":o[0]||(o[0]=_=>a(s).catatan=_),placeholder:"Beri catatan"},null,8,["modelValue"])]),e("div",S,[e("form",{onSubmit:b(c,["prevent"])},[t(l,x(h({type:"submit",text:"Submit"})),null,16)],40,g)])])]),_:1})]),_:1})}}});export{L as _};