import{b as q,_ as N,c as U}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{d as R,l as I,j as w,o as m,c as x,w as e,a,h as S,e as j,k as F,F as T,b as t,t as r,u as o,O as $,m as A,Z as J,g as D,n as L}from"./app-794bfe05.js";import{_ as O}from"./DashboardOverview.vue_vue_type_script_setup_true_lang-1a0f6fb5.js";import{a as f,b as n,c as C,d as K}from"./QTable-08481d58.js";import{a as d,t as y}from"./money-3074a8fc.js";import{Q}from"./QTooltip-1b7cd048.js";import{u as V}from"./use-quasar-1e1c8a18.js";import{_ as E}from"./PiutangFilterDialog.vue_vue_type_script_setup_true_lang-da0822f8.js";import"./QImg-766bfd11.js";import"./use-dialog-plugin-component-24b3795d.js";import"./QForm-95ef4f4f.js";import"./options-4b88285e.js";const Z=R({__name:"SisaDanaRekeningTable",props:{rows:{}},setup(P){const v=P,s=I(()=>v.rows.map(l=>{const u=d(l.nilai_kontrak),_=d(l.total_pengajuan_dana),i=d(l.total_pencairan_dana)+d(l.total_penagihan_diterima);return{...l,sisa_dana:u+_-i}})),g=[{name:"index",label:"#",field:"index"},{name:"rekening",label:"Rekening",field:"nama_rekening",align:"left",sortable:!0},{name:"sisa_dana",label:"Sisa Dana",field:"",align:"right",sortable:!0}],c=w(!1);function b(){c.value=!c.value}const k=w(),p=I(()=>{var u;return{sisaDana:(u=k.value)==null?void 0:u.computedRows.reduce((_,i)=>_+d(i.sisa_dana),0)}});return(l,u)=>(m(),x(o(C),{ref_key:"table",ref:k,flat:"",bordered:"",title:"Sisa Dana Rekening",fullscreen:c.value,rows:s.value,columns:g,"row-key":"id_rekening",class:"table"},{"top-right":e(()=>[a(S,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:b,class:"q-ml-md"},null,8,["icon"])]),header:e(_=>[a(f,{props:_},{default:e(()=>[(m(!0),j(T,null,F(_.cols,i=>(m(),x(K,{key:i.name,props:_,style:{"font-weight":"bold"}},{default:e(()=>[t(r(i.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(_=>[a(f,{props:_},{default:e(()=>[a(n,{key:"index",props:_},{default:e(()=>[t(r(++_.rowIndex),1)]),_:2},1032,["props"]),a(n,{key:"rekening",props:_},{default:e(()=>[t(r(_.row.nama_rekening),1)]),_:2},1032,["props"]),a(n,{key:"sisa_dana",props:_},{default:e(()=>[t(r(o(y)(_.row.sisa_dana)),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"2"},{default:e(()=>[t("Total Sisa Dana")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(p.value.sisaDana)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const z=R({__name:"ProyeksiInvoiceProyekTable",props:{rows:{}},setup(P){const v=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"invoice_sebelumnya",label:"Invoice Sebelumnya",field:"invoice_sebelumnya",align:"right",sortable:!0},{name:"invoice_saat_ini",label:"Invoice Saat Ini",field:"invoice_saat_ini",align:"right",sortable:!0},{name:"sisa_netto_kontrak",label:"Sisa Netto Kontrak",field:"sisa_netto_kontrak",align:"right",sortable:!0}],s=w(!1);function g(){s.value=!s.value}const c=w(),b=I(()=>{var u,_,i;const k=(u=c.value)==null?void 0:u.computedRows.reduce((h,B)=>h+d(B.invoice_sebelumnya),0),p=(_=c.value)==null?void 0:_.computedRows.reduce((h,B)=>h+d(B.invoice_saat_ini),0),l=(i=c.value)==null?void 0:i.computedRows.reduce((h,B)=>h+d(B.sisa_netto_kontrak),0);return{invoiceSebelumnya:k,invoiceSaatIni:p,sisaNettoKontrak:l}});return(k,p)=>(m(),x(o(C),{ref_key:"table",ref:c,flat:"",bordered:"",title:"Proyeksi Invoice Proyek",fullscreen:s.value,rows:k.rows,columns:v,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(S,{flat:"",dense:"",icon:s.value?"fullscreen_exit":"fullscreen",onClick:g,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(f,{props:l},{default:e(()=>[(m(!0),j(T,null,F(l.cols,u=>(m(),x(K,{key:u.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(f,{props:l},{default:e(()=>[a(n,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(n,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(n,{key:"invoice_sebelumnya",props:l},{default:e(()=>[t(r(o(y)(o(d)(l.row.invoice_sebelumnya))),1)]),_:2},1032,["props"]),a(n,{key:"invoice_saat_ini",props:l},{default:e(()=>[t(r(o(y)(o(d)(l.row.invoice_saat_ini))),1)]),_:2},1032,["props"]),a(n,{key:"sisa_netto_kontrak",props:l},{default:e(()=>[t(r(o(y)(o(d)(l.row.sisa_netto_kontrak))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"4"},{default:e(()=>[t("Total Invoice Sebelumnya")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(b.value.invoiceSebelumnya)),1)]),_:1})]),_:1}),a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"4"},{default:e(()=>[t("Total Invoice Saat Ini")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(b.value.invoiceSaatIni)),1)]),_:1})]),_:1}),a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"4"},{default:e(()=>[t("Total Sisa Netto Kontrak")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(b.value.sisaNettoKontrak)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const G=R({__name:"ProyeksiKebutuhanDanaProyekTable",props:{rows:{}},setup(P){const v=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"left",sortable:!0},{name:"jumlah_belum_dibayar",label:"Jumlah Belum Dibayar",field:"jumlah_belum_dibayar",align:"right",sortable:!0}],s=w(!1);function g(){s.value=!s.value}const c=w(),b=I(()=>{var p;return{jumlahBelumDibayar:(p=c.value)==null?void 0:p.computedRows.reduce((l,u)=>l+d(u.jumlah_belum_dibayar),0)}});return(k,p)=>(m(),x(o(C),{ref_key:"table",ref:c,flat:"",bordered:"",title:"Proyeksi Kebutuhan Dana Proyek",fullscreen:s.value,rows:k.rows,columns:v,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(S,{flat:"",dense:"",icon:s.value?"fullscreen_exit":"fullscreen",onClick:g,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(f,{props:l},{default:e(()=>[(m(!0),j(T,null,F(l.cols,u=>(m(),x(K,{key:u.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(f,{props:l},{default:e(()=>[a(n,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(n,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(n,{key:"total_pengajuan",props:l},{default:e(()=>[t(r(l.row.total_pengajuan)+" Pengajuan ",1)]),_:2},1032,["props"]),a(n,{key:"jumlah_belum_dibayar",props:l},{default:e(()=>[t(r(o(y)(o(d)(l.row.jumlah_belum_dibayar))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"3"},{default:e(()=>[t("Total Belum Dibayar")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(b.value.jumlahBelumDibayar)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const H=R({__name:"ProyeksiUtangTable",props:{rows:{}},setup(P){const v=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_utang",label:"Jumlah Utang",field:"jumlah_utang",align:"right",sortable:!0}],s=w(!1);function g(){s.value=!s.value}const c=w(),b=I(()=>{var p;return{utang:(p=c.value)==null?void 0:p.computedRows.reduce((l,u)=>l+d(u.jumlah_utang),0)}});return(k,p)=>(m(),x(o(C),{ref_key:"table",ref:c,flat:"",bordered:"",title:"Proyeksi Utang",fullscreen:s.value,rows:k.rows,columns:v,"row-key":"id_pencairan_dana",class:"table"},{"top-right":e(()=>[a(S,{flat:"",dense:"",icon:s.value?"fullscreen_exit":"fullscreen",onClick:g,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(f,{props:l},{default:e(()=>[(m(!0),j(T,null,F(l.cols,u=>(m(),x(K,{key:u.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(f,{props:l,onClick:u=>o($).visit(k.route("detail_pencairan_dana",l.row.id_pencairan_dana)),style:{cursor:"pointer"}},{default:e(()=>[a(n,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(n,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(n,{key:"keperluan",props:l},{default:e(()=>[t(r(l.row.keperluan),1)]),_:2},1032,["props"]),a(n,{key:"jumlah_utang",props:l},{default:e(()=>[t(r(o(y)(o(d)(l.row.jumlah_utang))),1)]),_:2},1032,["props"]),a(Q,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(b.value.utang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const M=R({__name:"ProyeksiPiutangTable",props:{rows:{},options:{}},setup(P){const v=P,s=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_piutang",label:"Jumlah Piutang",field:"jumlah_piutang",align:"right",sortable:!0}],g=w(!1);function c(){g.value=!g.value}const b=w(),k=I(()=>{var _;return{piutang:(_=b.value)==null?void 0:_.computedRows.reduce((i,h)=>i+d(h.jumlah_piutang),0)}}),p=V();function l(){p.dialog({component:E,componentProps:{options:v.options,data:{route:route("dashboard.admin")}}})}return(u,_)=>(m(),x(o(C),{ref_key:"table",ref:b,flat:"",bordered:"",title:"Proyeksi Piutang",fullscreen:g.value,rows:u.rows,columns:s,"row-key":"id_penagihan",class:"table"},{"top-right":e(()=>[a(S,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:l}),a(S,{flat:"",dense:"",icon:g.value?"fullscreen_exit":"fullscreen",onClick:c,class:"q-ml-md"},null,8,["icon"])]),header:e(i=>[a(f,{props:i},{default:e(()=>[(m(!0),j(T,null,F(i.cols,h=>(m(),x(K,{key:h.name,props:i,style:{"font-weight":"bold"}},{default:e(()=>[t(r(h.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(i=>[a(f,{props:i,onClick:h=>o($).visit(u.route("detail_penagihan",i.row.id_penagihan)),style:{cursor:"pointer"}},{default:e(()=>[a(n,{key:"index",props:i},{default:e(()=>[t(r(++i.rowIndex),1)]),_:2},1032,["props"]),a(n,{key:"proyek",props:i},{default:e(()=>[t(r(i.row.nama_proyek),1)]),_:2},1032,["props"]),a(n,{key:"keperluan",props:i},{default:e(()=>[t(r(i.row.keperluan),1)]),_:2},1032,["props"]),a(n,{key:"jumlah_piutang",props:i},{default:e(()=>[t(r(o(y)(o(d)(i.row.jumlah_piutang))),1)]),_:2},1032,["props"]),a(Q,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(f,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(n,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(n,null,{default:e(()=>[t(r(o(y)(k.value.piutang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const W={class:"q-pa-md"},X={class:"row q-col-gutter-md"},Y={class:"col-12 col-md-6"},ee={class:"col-12 col-md-6"},ae={class:"col-12"},le={class:"col-12 col-md-6"},te={class:"col-12 col-md-6"},ke=R({__name:"KeuanganPage",props:{sisaDanaRekening:{},proyeksiInvoiceProyek:{},proyeksiKebutuhanDanaProyek:{},proyeksiUtang:{},proyeksiPiutang:{},options:{},overview:{}},setup(P){const v=[{label:"Dashboard",url:"#"},{label:"Overview",url:"#"}];return(s,g)=>{const c=A("in-link");return m(),j(T,null,[a(o(J),{title:"Dashboard"}),a(N,null,{breadcrumbs:e(()=>[a(q,{align:"left"},{default:e(()=>[(m(),j(T,null,F(v,b=>L(a(U,{key:b.label,label:b.label},null,8,["label"]),[[c,b.url]])),64))]),_:1})]),default:e(()=>[a(o(O),{overview:s.overview},null,8,["overview"]),D("div",W,[D("div",X,[D("div",Y,[a(o(Z),{rows:s.sisaDanaRekening},null,8,["rows"])]),D("div",ee,[a(o(G),{rows:s.proyeksiKebutuhanDanaProyek},null,8,["rows"])]),D("div",ae,[a(o(z),{rows:s.proyeksiInvoiceProyek},null,8,["rows"])]),D("div",le,[a(o(H),{rows:s.proyeksiUtang},null,8,["rows"])]),D("div",te,[a(o(M),{rows:s.proyeksiPiutang,options:s.options},null,8,["rows","options"])])])])]),_:1})],64)}}});export{ke as default};
