import{d as g,T as h,e as y,c as r,h as a,g as n,u as e,i as v,o as l,a as u,m as i,F as b,q as C,n as P,j as V,t as _}from"./app-ff9ff714.js";import{u as x}from"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-a432a803.js";import{M,a as $,_ as S}from"./Footer-61a96086.js";import{_ as w}from"./Head.vue_vue_type_script_setup_true_lang-f77b6573.js";import{_ as d}from"./Label.vue_vue_type_script_setup_true_lang-cb48c286.js";import{_ as f}from"./Error.vue_vue_type_script_setup_true_lang-c6dbfeeb.js";import{_ as B}from"./Select.vue_vue_type_script_setup_true_lang-1001c70b.js";import{_ as F}from"./Textarea.vue_vue_type_script_setup_true_lang-5abc66b8.js";import"./vue-select-61ccd8a2.js";const z=["onSubmit"],T={class:"w-full mb-4"},L=u("option",{value:""},"Pilih",-1),N=["value"],U={class:"w-full mb-4"},J=g({__name:"CreatePenagihanModal",props:{daftar_proyek:{}},setup(j){const m=x(),o=h({id_proyek:null,keperluan:null,for:"penagihan"});function c(){o.post(route("keuangan.store"),{onSuccess:()=>{m.close()}})}return(k,t)=>{const p=y("ease-button");return l(),r("form",{onSubmit:v(c,["prevent"])},[a(e(S),{size:"5xl"},{default:n(()=>[a(e(w),{title:"Form Tambah Penagihan"}),a(e(M),null,{default:n(()=>[u("div",T,[a(e(d),{for:"id_proyek",value:"Pilih Proyek"}),a(e(B),i({modelValue:e(o).id_proyek,"onUpdate:modelValue":t[0]||(t[0]=s=>e(o).id_proyek=s)},{id:"id_proyek",size:"lg"}),{default:n(()=>[L,(l(!0),r(b,null,C(k.daftar_proyek,s=>(l(),r("option",{value:s.id_proyek},_(s.nama_proyek)+" - "+_(s.tahun_anggaran),9,N))),256))]),_:1},16,["modelValue"]),a(e(f),{class:"mt-2",message:e(o).errors.id_proyek},null,8,["message"])]),u("div",U,[a(e(d),{for:"keperluan",value:"Keperluan"}),a(e(F),i({modelValue:e(o).keperluan,"onUpdate:modelValue":t[1]||(t[1]=s=>e(o).keperluan=s)},{id:"keperluan",placeholder:"Tulis keperluan"}),null,16,["modelValue"]),a(e(f),{class:"mt-2",message:e(o).errors.keperluan},null,8,["message"])])]),_:1}),a(e($),null,{default:n(()=>[a(p,i({onClick:e(m).close},{variant:"transparent",type:"button",text:"Close"}),null,16,["onClick"]),a(p,P(V({type:"submit",text:"Create",loading:e(o).processing,onLoading:()=>({text:"Creating data..."})})),null,16)]),_:1})]),_:1})],40,z)}}});export{J as _};