import{d as c,T as m,e as p,f,g as n,u as a,o as b,h as t,a as e,i as h,n as x,j as g}from"./app-803e4503.js";import{a as j,_ as v,C}from"./Card-7713b684.js";import{_ as w}from"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import{_ as y}from"./Textarea.vue_vue_type_script_setup_true_lang-2965e452.js";import"./vue-select-834fdd5f.js";const V=e("div",{class:"flex justify-between items-center"},[e("h5",{class:"font-bold text-xl text-dark"},"Submit")],-1),B={class:"flex justify-between items-center space-x-4"},S={class:"w-full mb-4"},k={class:"flex justify-end space-x-2"},P=["onSubmit"],M=c({__name:"Pengajuan.p",props:{id_pengajuan_dana:{},detail_pengajuan_dana_length:{}},setup(i){const l=i,s=m({catatan:null});function d(){s.post(route("pengajuan_dana.submit",l.id_pengajuan_dana))}return(_,o)=>{const u=p("ease-button");return b(),f(a(C),{class:"h-fit"},{default:n(()=>[t(a(j),{class:"mb-2"},{default:n(()=>[V]),_:1}),t(a(v),null,{default:n(()=>[e("div",B,[e("div",S,[t(a(w),{value:"Catatan"}),t(a(y),{modelValue:a(s).catatan,"onUpdate:modelValue":o[0]||(o[0]=r=>a(s).catatan=r),placeholder:"Beri catatan"},null,8,["modelValue"])]),e("div",k,[e("form",{onSubmit:h(d,["prevent"])},[t(u,x(g({type:"submit",text:"Submit",disabled:_.detail_pengajuan_dana_length<1})),null,16)],40,P)])])]),_:1})]),_:1})}}});export{M as _};
