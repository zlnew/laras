import{d as D,K as T,T as $,e as f,c as g,h as e,u as a,g as n,F as h,o as d,Z as V,n as p,j as i,a as l,m as j,i as L,q as N,f as k,l as y,y as x,t as r}from"./app-9f499f35.js";import{_ as S,a as q,C as E}from"./Content-4404493d.js";import{C as R,a as z,_ as F}from"./Card-b1401f32.js";import{T as H,a as J,_ as c,b as o,c as K,d as s}from"./Table-e8d21086.js";import{_ as M}from"./Input.vue_vue_type_script_setup_true_lang-995ff141.js";import{t as b}from"./number-6d20867b.js";import{l as O}from"./date-7cb373b2.js";import"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-569f49cb.js";import"./_plugin-vue_export-helper-c27b6911.js";const U=["onSubmit"],Z={class:"flex justify-between items-center space-x-2"},A={class:"line-clamp-2 hover:line-clamp-none"},G={class:"font-semibold text-dark"},I={class:"text-dark"},Q={class:"font-semibold text-dark"},ua=D({__name:"PengajuanDana",props:{pengajuan_dana:{}},setup(W){const v=T().props.query,u=$({nama_proyek:v.nama_proyek});function P(){u.get(route("laporan.pengajuan_dana"))}return(_,m)=>{const w=f("ease-button"),C=f("EaseButton");return d(),g(h,null,[e(a(V),{title:"Monitoring Pengajuan Dana"}),e(S,null,{breadcrumb:n(()=>[e(q,p(i({second:"Reports",current:"Pengajuan Dana"})),null,16)]),default:n(()=>[e(E,null,{default:n(()=>[e(a(R),null,{default:n(()=>[e(a(z),{class:"mb-4"},{default:n(()=>[l("form",{onSubmit:L(P,["prevent"])},[l("div",Z,[e(a(M),j({modelValue:a(u).nama_proyek,"onUpdate:modelValue":m[0]||(m[0]=t=>a(u).nama_proyek=t)},{type:"search",size:"lg",placeholder:"Cari Berdasarkan Nama Proyek",autocomplete:"off"}),null,16,["modelValue"]),e(w,p(i({type:"submit",text:"Cari",loading:a(u).processing,onLoading:()=>({text:!1})})),null,16)])],40,U)]),_:1}),e(a(F),{table:""},{default:n(()=>[e(a(H),null,{default:n(()=>[e(a(J),null,{default:n(()=>[e(a(c),null,{default:n(()=>[e(a(o),{value:"Nama Proyek"}),e(a(o),{value:"Keperluan"}),e(a(o),{value:"Tanggal Pengajuan"}),e(a(o),{"text-align":"right",value:"Jumlah Pengajuan Dana"}),e(a(o),{"text-align":"right",value:"Jumlah Disetujui"}),e(a(o),{"text-align":"center",value:"Status"})]),_:1})]),_:1}),e(a(K),null,{default:n(()=>[_.pengajuan_dana.data.length?(d(!0),g(h,{key:0},N(_.pengajuan_dana.data,(t,B)=>(d(),k(a(c),j({key:t.id_proyek},{last:B===_.pengajuan_dana.data.length-1}),{default:n(()=>[e(a(s),null,{default:n(()=>[e(a(x),{class:"link",href:"#"},{default:n(()=>[l("span",A,r(t.nama_proyek),1)]),_:2},1024)]),_:2},1024),e(a(s),{whitespace:"nowrap"},{default:n(()=>[l("span",G,r(t.keperluan),1)]),_:2},1024),e(a(s),{whitespace:"nowrap"},{default:n(()=>[y(r(a(O)(t.tanggal_pengajuan)),1)]),_:2},1024),e(a(s),{"text-align":"right",whitespace:"nowrap"},{default:n(()=>[l("span",I,r(a(b)(t.jumlah_pengajuan_dana)),1)]),_:2},1024),e(a(s),{"text-align":"right",whitespace:"nowrap"},{default:n(()=>[l("span",Q,r(a(b)(t.jumlah_disetujui)),1)]),_:2},1024),e(a(s),{"text-align":"center"},{default:n(()=>[e(a(x),{href:_.route("pengajuan_dana.detail",t.id_pengajuan_dana)},{default:n(()=>[e(C,p(i({text:t.status_pengajuan==400?"Closed":"Open",variant:t.status_pengajuan==400?"danger-transparent":"transparent"})),null,16)]),_:2},1032,["href"])]),_:2},1024)]),_:2},1040))),128)):(d(),k(a(c),{key:1,last:""},{default:n(()=>[e(a(s),{colspan:"6","text-align":"center"},{default:n(()=>[y(" Pengajuan Dana tidak ditemukan ")]),_:1})]),_:1}))]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})],64)}}});export{ua as default};
