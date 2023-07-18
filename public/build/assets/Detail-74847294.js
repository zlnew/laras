import{_ as W,a as X,C as Y}from"./Content-5f80f4b2.js";import{C as aa,a as ea,_ as ta}from"./Card-7713b684.js";import{d as na,K as ia,b,z as L,k as sa,e as I,c as k,h as e,u as a,g as t,F as M,o as r,Z as la,n as v,j as S,a as x,f as d,l as c,p,q as oa,t as f,m as E}from"./app-803e4503.js";import{T as ra,a as ua,_ as h,b as m,c as ca,d as s}from"./Table-2ab96417.js";import{t as y}from"./number-6d20867b.js";import{M as V}from"./modal-cbc3ac11.js";import{T as j}from"./toastify-9205ad32.js";import{_ as da}from"./CreateModal.vue_vue_type_script_setup_true_lang-e9bf86f1.js";import{_ as _a}from"./EditModal.vue_vue_type_script_setup_true_lang-ae84e6fb.js";import{_ as pa}from"./DeleteModal.vue_vue_type_script_setup_true_lang-e2731e77.js";import{_ as fa}from"./InformasiPartial.vue_vue_type_script_setup_true_lang-b6c570d6.js";import{_ as ma}from"./TimelinePartial.vue_vue_type_script_setup_true_lang-818b83e0.js";import{_ as ha}from"./VerifikasiPartial.vue_vue_type_script_setup_true_lang-8c047c62.js";import{_ as ga}from"./PengajuanPartial.vue_vue_type_script_setup_true_lang-305c72bb.js";import{T as ka}from"./Foot-62f8c911.js";import"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-e580dfec.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Footer-87f34d66.js";import"./Head.vue_vue_type_script_setup_true_lang-5a39fa07.js";import"./Input.vue_vue_type_script_setup_true_lang-15558a1c.js";import"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import"./Error.vue_vue_type_script_setup_true_lang-e2e0b7ba.js";import"./Select.vue_vue_type_script_setup_true_lang-a0912154.js";import"./vue-select-834fdd5f.js";import"./date-7cb373b2.js";import"./Textarea.vue_vue_type_script_setup_true_lang-2965e452.js";const va={class:"flex justify-between items-center"},ba=x("h5",{class:"font-bold text-xl text-dark"},"List Penagihan",-1),ya={key:0,class:"flex"},xa={key:1},Ta={class:"grid grid-cols-3 gap-6"},Ca={class:"col-span-2"},Wa=na({__name:"Detail",props:{keuangan:{},detail_penagihan:{},penagihan:{},detail_rab:{},timeline:{}},setup(q){const _=q,g=ia(),U=g.props.role,T=g.props.permissions,C=b(()=>!!(U==="admin"||T.includes("create penagihan")&&T.includes("update penagihan")&&T.includes("delete penagihan"))),w=b(()=>_.penagihan.status_aktivitas==="Dibuat"),$=b(()=>{const i=_.penagihan.status_aktivitas;if(T.includes("approve pengajuan dana"))switch(i){case"Diajukan":return!0;default:return!1}return!1}),P=b(()=>_.detail_penagihan.map(i=>({...i}))),D=b(()=>{const i=_.detail_penagihan.reduce((l,n)=>l+n.harga_satuan*n.volume_penagihan,0),u=_.detail_penagihan.reduce((l,n)=>n.status_diterima==="400"?l+n.harga_satuan*n.volume_penagihan:l,0),o=_.detail_penagihan.reduce((l,n)=>n.status_diterima==="100"?l+n.harga_satuan*n.volume_penagihan:l,0);return{penagihan:i,diterima:u+H.value,belum_ditagihkan:o-A.value}}),B=L(),H=L(0),A=L(0);function N(i){const u=i.target;document.querySelectorAll(".verifikasi-checkbox").forEach(l=>{l instanceof HTMLInputElement&&(l.checked=u.checked)}),F()}function F(){R(),z(),J()}function R(){const i=document.querySelectorAll(".verifikasi-checkbox");let u=[];i.forEach(o=>{o instanceof HTMLInputElement&&o.checked&&o.dataset.id&&u.push(parseFloat(o.dataset.id))}),B.value=u}function z(){const i=document.querySelectorAll(".verifikasi-checkbox");let u=0;i.forEach(o=>{if(o instanceof HTMLInputElement&&o.checked){const l=parseFloat(o.dataset.amount||"0");u+=l}}),H.value=u}function J(){const i=document.querySelectorAll(".verifikasi-checkbox");let u=0;i.forEach(o=>{if(o instanceof HTMLInputElement&&o.checked){const l=parseFloat(o.dataset.amount||"0");u+=l}}),A.value=u}function K(){V.pop(da,{id_penagihan:_.penagihan.id_penagihan,detail_rab:_.detail_rab})}function Z(i){V.pop(_a,{detail_penagihan:i,detail_rab:_.detail_rab})}function G(i){V.pop(pa,{id_detail_penagihan:i})}return sa(()=>{g.props.flash.success&&j.success(g.props.flash.success),g.props.flash.error&&j.error(g.props.flash.error)}),(i,u)=>{const o=I("fas-icon"),l=I("ease-button");return r(),k(M,null,[e(a(la),{title:"Penagihan / Invoice"}),e(W,null,{breadcrumb:t(()=>[e(X,v(S({second:"Penagihan",current:_.keuangan.nama_proyek})),null,16)]),default:t(()=>[e(Y,null,{default:t(()=>[e(fa,v(S({keuangan:i.keuangan,penagihan:i.penagihan})),null,16),e(a(aa),null,{default:t(()=>[e(a(ea),{class:"mb-4"},{default:t(()=>[x("div",va,[ba,C.value&&w.value?(r(),d(l,{key:0,onClick:K,slotted:""},{default:t(()=>[e(o,{icon:"fa-solid fa-plus",class:"mr-1"}),c(" Tambah Uraian ")]),_:1})):p("",!0)])]),_:1}),e(a(ta),{table:""},{default:t(()=>[e(a(ra),null,{default:t(()=>[e(a(ua),null,{default:t(()=>[e(a(h),null,{default:t(()=>[e(a(m),{value:"#"}),e(a(m),{value:"Uraian"}),e(a(m),{value:"Volume"}),e(a(m),{value:"Satuan"}),e(a(m),{"text-align":"right",value:"Harga Satuan"}),e(a(m),{"text-align":"right",value:"Jumlah Penagihan"}),$.value?(r(),d(a(m),{key:0,value:"Verifikasi"})):p("",!0),C.value&&w.value?(r(),d(a(m),{key:1})):p("",!0)]),_:1})]),_:1}),e(a(ca),null,{default:t(()=>[P.value.length?(r(!0),k(M,{key:0},oa(P.value,(n,O)=>(r(),d(a(h),{key:n.id_detail_penagihan},{default:t(()=>[e(a(s),null,{default:t(()=>[c(f(O+1),1)]),_:2},1024),e(a(s),{whitespace:"nowrap",class:"font-semibold text-dark"},{default:t(()=>[c(f(n.uraian),1)]),_:2},1024),e(a(s),{whitespace:"nowrap"},{default:t(()=>[c(f(n.volume_penagihan),1)]),_:2},1024),e(a(s),{whitespace:"nowrap"},{default:t(()=>[c(f(n.nama_satuan),1)]),_:2},1024),e(a(s),{whitespace:"nowrap","text-align":"right"},{default:t(()=>[c(f(a(y)(n.harga_satuan)),1)]),_:2},1024),e(a(s),{whitespace:"nowrap","text-align":"right"},{default:t(()=>[c(f(a(y)(n.volume_penagihan*n.harga_satuan)),1)]),_:2},1024),$.value?(r(),d(a(s),{key:0},{default:t(()=>[n.status_diterima==="100"?(r(),k("input",E({key:0,onChange:F},{type:"checkbox",class:"verifikasi-checkbox","data-id":n.id_detail_penagihan,"data-amount":n.volume_penagihan*n.harga_satuan}),null,16)):(r(),k("input",v(E({key:1},{type:"checkbox",checked:!0,disabled:!0})),null,16))]),_:2},1024)):p("",!0),C.value&&w.value?(r(),d(a(s),{key:1,whitespace:"nowrap"},{default:t(()=>[n.status_diterima==="100"?(r(),k("div",ya,[e(l,{variant:"link",text:"Edit",onClick:Q=>Z(n)},null,8,["onClick"]),e(l,{variant:"danger-link",text:"Delete",onClick:Q=>G(n.id_detail_penagihan)},null,8,["onClick"])])):(r(),k("div",xa,[e(l,{variant:"transparent",text:"Diterima"})]))]),_:2},1024)):p("",!0)]),_:2},1024))),128)):(r(),d(a(h),{key:1,last:""},{default:t(()=>[e(a(s),{colspan:"8","text-align":"center"},{default:t(()=>[c(" Uraian tidak ditemukan ")]),_:1})]),_:1}))]),_:1}),P.value.length?(r(),d(a(ka),{key:0},{default:t(()=>[$.value?(r(),d(a(h),{key:0,last:""},{default:t(()=>[e(a(s),{colspan:"5"}),e(a(s),{"text-align":"right"},{default:t(()=>[c(" Verifikasi Semua ")]),_:1}),e(a(s),null,{default:t(()=>[x("input",{onChange:u[0]||(u[0]=n=>N(n)),type:"checkbox",title:"Verifikasi semua"},null,32)]),_:1})]),_:1})):p("",!0),e(a(h),{last:""},{default:t(()=>[e(a(s),{colspan:"4"}),e(a(s),{"text-align":"right",class:"font-semibold"},{default:t(()=>[c(" Total Penagihan ")]),_:1}),e(a(s),{"text-align":"right",class:"font-semibold"},{default:t(()=>[c(f(a(y)(D.value.penagihan)),1)]),_:1})]),_:1}),e(a(h),{last:""},{default:t(()=>[e(a(s),{colspan:"4"}),e(a(s),{"text-align":"right",class:"font-semibold"},{default:t(()=>[c(" Total Diterima ")]),_:1}),e(a(s),{"text-align":"right",class:"font-semibold"},{default:t(()=>[c(f(a(y)(D.value.diterima)),1)]),_:1})]),_:1}),e(a(h),{last:""},{default:t(()=>[e(a(s),{colspan:"4"}),e(a(s),{"text-align":"right",class:"font-semibold"},{default:t(()=>[c(" Sisa Belum Ditagihkan ")]),_:1}),e(a(s),{"text-align":"right",class:"font-semibold"},{default:t(()=>[c(f(a(y)(D.value.belum_ditagihkan)),1)]),_:1})]),_:1})]),_:1})):p("",!0)]),_:1})]),_:1})]),_:1}),x("div",Ta,[x("div",Ca,[e(ma,v(S({timeline:i.timeline})),null,16)]),C.value&&w.value?(r(),d(ga,v(E({key:0},{id_penagihan:i.penagihan.id_penagihan,detail_penagihan_length:P.value.length})),null,16)):p("",!0),$.value?(r(),d(ha,v(E({key:1},{id_penagihan:i.penagihan.id_penagihan,group_of_id_detail_penagihan:B.value,total_amount:D.value})),null,16)):p("",!0)])]),_:1})]),_:1})],64)}}});export{Wa as default};
