import{d as C,T as U,e as w,c as p,h as l,g as r,u as a,i as x,o as g,a as o,m as u,F as j,q as h,w as R,s as $,t as i,l as z,n as S,j as M}from"./app-803e4503.js";import{u as A}from"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-e580dfec.js";import{M as B,a as D,_ as F}from"./Footer-87f34d66.js";import{_ as J}from"./Head.vue_vue_type_script_setup_true_lang-5a39fa07.js";import{_ as b}from"./Input.vue_vue_type_script_setup_true_lang-15558a1c.js";import{_ as m}from"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import{_ as d}from"./Error.vue_vue_type_script_setup_true_lang-e2e0b7ba.js";import{_ as v}from"./Select.vue_vue_type_script_setup_true_lang-a0912154.js";import{_ as T}from"./SearchDropdown.vue_vue_type_script_setup_true_lang-429e5f30.js";import{t as N}from"./number-6d20867b.js";const L=["onSubmit"],q={class:"w-full mb-4"},E=o("option",{value:""},"Pilih Uraian",-1),K=["value"],G={class:"w-full mb-4"},H={class:"w-full mb-4 grid grid-cols-2 gap-4"},O=o("option",{value:""},"Pilih Jenis Pembayaran",-1),Q=["value"],W={class:"w-full mb-4"},X={class:"flex"},ra=C({__name:"Create.m",props:{id_pengajuan_dana:{},detail_rap:{},rekening:{}},setup(k){const f=k,c=A(),n=U({uraian:null,id_detail_rap:null,id_rekening:null,jenis_pembayaran:null,jumlah_pengajuan:0}),V=["Transfer","Cash"];function y(t){console.log(t);const s=f.detail_rap.find(_=>_.id_detail_rap==t);s?n.jumlah_pengajuan=s.harga_satuan:n.reset("jumlah_pengajuan")}function P(){n.post(route("pengajuan_dana.store",f.id_pengajuan_dana),{onSuccess:()=>{c.close()}})}return(t,s)=>{const _=w("ease-button");return g(),p("form",{onSubmit:x(P,["prevent"])},[l(a(F),{size:"2xl"},{default:r(()=>[l(a(J),{title:"Form Tambah Uraian Pengajuan dana"}),l(a(B),null,{default:r(()=>[o("div",q,[l(a(m),{for:"id_detail_rap",value:"Uraian RAP"}),l(a(v),u({modelValue:a(n).id_detail_rap,"onUpdate:modelValue":s[0]||(s[0]=e=>a(n).id_detail_rap=e),onChange:s[1]||(s[1]=e=>y(e.target.value))},{id:"id_detail_rap",size:"lg"}),{default:r(()=>[E,(g(!0),p(j,null,h(t.detail_rap,e=>(g(),p("option",{value:e.id_detail_rap},i(e.uraian),9,K))),256))]),_:1},16,["modelValue"]),l(a(d),{class:"mt-2",message:a(n).errors.id_detail_rap},null,8,["message"])]),o("div",G,[l(a(m),{for:"uraian",value:"Uraian Pengajuan Dana"}),l(a(b),u({modelValue:a(n).uraian,"onUpdate:modelValue":s[2]||(s[2]=e=>a(n).uraian=e)},{type:"text",id:"uraian",size:"lg",autocomplete:"off",placeholder:"Uraian Pengajuan Dana"}),null,16,["modelValue"]),l(a(d),{class:"mt-2",message:a(n).errors.uraian},null,8,["message"])]),o("div",H,[o("div",null,[l(a(m),{for:"jenis_pembayaran",value:"Jenis Pembayaran"}),l(a(v),{modelValue:a(n).jenis_pembayaran,"onUpdate:modelValue":s[3]||(s[3]=e=>a(n).jenis_pembayaran=e),id:"jenis_pembayaran",size:"lg"},{default:r(()=>[O,(g(),p(j,null,h(V,e=>o("option",{value:e},i(e),9,Q)),64))]),_:1},8,["modelValue"]),l(a(d),{class:"mt-2",message:a(n).errors.jenis_pembayaran},null,8,["message"])]),o("div",null,[l(a(m),{for:"jumlah_pengajuan",value:"Jumlah Pengajuan"}),R(o("small",{class:"ml-1"},": "+i(a(N)(a(n).jumlah_pengajuan)),513),[[$,a(n).jumlah_pengajuan]]),l(a(b),u({modelValue:a(n).jumlah_pengajuan,"onUpdate:modelValue":s[4]||(s[4]=e=>a(n).jumlah_pengajuan=e)},{type:"number",id:"jumlah_pengajuan",size:"lg",autocomplete:"off",placeholder:"Jumlah Pengajuan"}),null,16,["modelValue"]),l(a(d),{class:"mt-2",message:a(n).errors.jumlah_pengajuan},null,8,["message"])])]),o("div",W,[l(a(m),{for:"id_rekening",value:"Rekening"}),l(a(T),u({modelValue:a(n).id_rekening,"onUpdate:modelValue":s[5]||(s[5]=e=>a(n).id_rekening=e)},{id:"id_rekening",index:"id_rekening",options:t.rekening,searchKeys:["nama_bank","nomor_rekening","nama_rekening"],placeholder:"Pilih Rekening"}),{"selected-option":r(e=>[o("div",X,[o("span",null,[o("strong",null,i(e.nama_bank),1),z(" | "+i(e.nomor_rekening)+" - "+i(e.nama_rekening),1)])])]),option:r(e=>[o("strong",null,i(e.nama_bank),1),o("p",null,i(e.nomor_rekening)+" - "+i(e.nama_rekening),1)]),_:1},16,["modelValue"]),l(a(d),{class:"mt-2",message:a(n).errors.id_rekening},null,8,["message"])])]),_:1}),l(a(D),null,{default:r(()=>[l(_,u({onClick:a(c).close},{variant:"transparent",type:"button",text:"Close"}),null,16,["onClick"]),l(_,S(M({type:"submit",text:"Create",loading:a(n).processing,onLoading:()=>({text:"Creating data..."})})),null,16)]),_:1})]),_:1})],40,L)}}});export{ra as _};
