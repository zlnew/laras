import{_ as q,a as z,C as I}from"./Content-4404493d.js";import{C as Z,a as G,_ as J}from"./Card-b1401f32.js";import{T as Q,a as W,_ as w,b as u,c as X,d as s}from"./Table-e8d21086.js";import{d as Y,K as aa,b as f,k as ta,e as T,c as U,h as a,u as t,g as e,F as j,o as i,Z as ea,n as g,j as P,a as h,f as _,l,p as m,q as ra,t as p,m as A}from"./app-9f499f35.js";import{t as D}from"./number-6d20867b.js";import{M as B}from"./modal-56d32abb.js";import{T as F}from"./toastify-d3dc56de.js";import{_ as na}from"./Create.m.vue_vue_type_script_setup_true_lang-69f3b728.js";import{_ as sa}from"./Edit.m.vue_vue_type_script_setup_true_lang-4fc2e1d1.js";import{_ as la}from"./Delete.m.vue_vue_type_script_setup_true_lang-d8599993.js";import{_ as oa}from"./Informasi.p.vue_vue_type_script_setup_true_lang-5f0ca637.js";import{_ as ia}from"./Timeline.p.vue_vue_type_script_setup_true_lang-178bac7d.js";import{_ as ua}from"./Pengajuan.p.vue_vue_type_script_setup_true_lang-03b5f6d4.js";import{_ as pa}from"./Persetujuan.p.vue_vue_type_script_setup_true_lang-4b7cd608.js";import{T as _a}from"./Foot-1a693c41.js";import"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-569f49cb.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Footer-5cc51b7e.js";import"./Head.vue_vue_type_script_setup_true_lang-6ca4f119.js";import"./Input.vue_vue_type_script_setup_true_lang-995ff141.js";import"./Label.vue_vue_type_script_setup_true_lang-b00eec72.js";import"./Error.vue_vue_type_script_setup_true_lang-35daa2cd.js";import"./Select.vue_vue_type_script_setup_true_lang-b9782f71.js";import"./Textarea.vue_vue_type_script_setup_true_lang-8926a642.js";import"./date-7cb373b2.js";const ca={class:"flex justify-between items-center"},da=h("h5",{class:"font-bold text-xl text-dark"},"Uraian Rencana Anggaran Proyek",-1),fa={class:"flex"},ma={class:"grid grid-cols-3 gap-6"},ga={class:"col-span-2"},Oa=Y({__name:"Index",props:{rap:{},detail_rap:{},satuan:{},timeline:{}},setup(M){const n=M,c=aa(),v=c.props.role,k=c.props.permissions,$=f(()=>{const r=n.rap.status_rap==400?"Closed":"On Progress";return{...n.rap,status_rap_in_string:r}}),x=f(()=>n.detail_rap.map(r=>{const b=D(r.harga_satuan),d=D(r.harga_satuan*r.volume);return{...r,harga_satuan_in_rupiah:b,total_harga_in_rupiah:d}})),S=f(()=>{const r=n.detail_rap.reduce((b,d)=>b+parseFloat(d.harga_satuan.toString())*parseFloat(d.volume.toString()),0);return{rap:D(r)}}),y=f(()=>!!(v==="admin"||k.includes("create rap")&&k.includes("update rap")&&k.includes("delete rap"))),C=f(()=>n.rap.status_aktivitas==="Dibuat"),V=f(()=>!!(k.includes("approve rap")&&(v==="admin"||v==="kepala divisi"&&n.rap.status_aktivitas==="Diajukan"||v==="direktur utama"&&n.rap.status_aktivitas==="Diperiksa")));function E(){B.pop(na,{id_rap:n.rap.id_rap,satuan:n.satuan})}function H(r){B.pop(sa,{detail_rap:r,satuan:n.satuan})}function L(r){B.pop(la,{id_detail_rap:r})}return ta(()=>{c.props.flash.success&&F.success(c.props.flash.success),c.props.flash.error&&F.error(c.props.flash.error)}),(r,b)=>{const d=T("fas-icon"),N=T("ease-button"),R=T("EaseButton");return i(),U(j,null,[a(t(ea),{title:"Detail RAP"}),a(q,null,{breadcrumb:e(()=>[a(z,g(P({second:"RAP",current:n.rap.nama_proyek+" - "+n.rap.tahun_anggaran})),null,16)]),default:e(()=>[a(I,null,{default:e(()=>[a(oa,g(P({rap:$.value})),null,16),a(t(Z),null,{default:e(()=>[a(t(G),null,{default:e(()=>[h("div",ca,[da,y.value&&C.value?(i(),_(N,{key:0,onClick:E,slotted:""},{default:e(()=>[a(d,{icon:"fa-solid fa-plus",class:"mr-1"}),l(" Tambah Uraian ")]),_:1})):m("",!0)])]),_:1}),a(t(J),{table:""},{default:e(()=>[a(t(Q),null,{default:e(()=>[a(t(W),null,{default:e(()=>[a(t(w),null,{default:e(()=>[a(t(u),{value:"#"}),a(t(u),{value:"Uraian"}),a(t(u),{value:"Satuan"}),a(t(u),{"text-align":"right",value:"Harga"}),a(t(u),{"text-align":"center",value:"Volume"}),a(t(u),{"text-align":"right",value:"Total Harga"}),a(t(u),{value:"Status"}),a(t(u),{value:"Keterangan"}),y.value&&C.value?(i(),_(t(u),{key:0})):m("",!0)]),_:1})]),_:1}),a(t(X),null,{default:e(()=>[x.value.length?(i(!0),U(j,{key:0},ra(x.value,(o,O)=>(i(),_(t(w),{key:o.id_detail_rap},{default:e(()=>[a(t(s),null,{default:e(()=>[l(p(O+1),1)]),_:2},1024),a(t(s),{whitespace:"nowrap",class:"font-semibold text-dark"},{default:e(()=>[l(p(o.uraian),1)]),_:2},1024),a(t(s),{whitespace:"nowrap"},{default:e(()=>[l(p(o.nama_satuan),1)]),_:2},1024),a(t(s),{whitespace:"nowrap","text-align":"right"},{default:e(()=>[l(p(o.harga_satuan_in_rupiah),1)]),_:2},1024),a(t(s),{whitespace:"nowrap","text-align":"center"},{default:e(()=>[l(p(o.volume),1)]),_:2},1024),a(t(s),{whitespace:"nowrap","text-align":"right"},{default:e(()=>[l(p(o.total_harga_in_rupiah),1)]),_:2},1024),a(t(s),{whitespace:"normal"},{default:e(()=>[l(p(o.status_uraian),1)]),_:2},1024),a(t(s),{whitespace:"normal"},{default:e(()=>[l(p(o.keterangan),1)]),_:2},1024),y.value&&C.value?(i(),_(t(s),{key:0,whitespace:"nowrap"},{default:e(()=>[h("div",fa,[a(R,{onClick:K=>H(o),variant:"link",text:"Edit"},null,8,["onClick"]),a(R,{onClick:K=>L(o.id_detail_rap),variant:"danger-link",text:"Delete"},null,8,["onClick"])])]),_:2},1024)):m("",!0)]),_:2},1024))),128)):(i(),_(t(w),{key:1,last:""},{default:e(()=>[a(t(s),{colspan:"9",textAlign:"center"},{default:e(()=>[l(" Uraian tidak ditemukan ")]),_:1})]),_:1}))]),_:1}),x.value.length?(i(),_(t(_a),{key:0},{default:e(()=>[a(t(w),{last:""},{default:e(()=>[a(t(s),{"text-align":"right",colspan:"5",class:"font-semibold"},{default:e(()=>[l(" Total RAP ")]),_:1}),a(t(s),{"text-align":"right",colspan:"1",class:"font-semibold"},{default:e(()=>[l(p(S.value.rap),1)]),_:1})]),_:1})]),_:1})):m("",!0)]),_:1})]),_:1})]),_:1}),h("div",ma,[h("div",ga,[a(ia,g(P({timeline:r.timeline})),null,16)]),y.value&&C.value?(i(),_(ua,g(A({key:0},{id_rap:$.value.id_rap,uraian_length:x.value.length})),null,16)):m("",!0),V.value?(i(),_(pa,g(A({key:1},{id_rap:$.value.id_rap})),null,16)):m("",!0)])]),_:1})]),_:1})],64)}}});export{Oa as default};
