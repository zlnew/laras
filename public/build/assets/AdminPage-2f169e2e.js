import{Q as C,a as q,b as N,_ as U,c as V}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{d as R,j as w,K as O,o as g,c as P,w as e,g as x,a,b as t,e as D,k as A,F as T,t as r,u as o,O as B,l as S,h as F,m as J,Z as L,n as E}from"./app-794bfe05.js";import{t as f,a as _}from"./money-3074a8fc.js";import{_ as Z}from"./DashboardOverview.vue_vue_type_script_setup_true_lang-1a0f6fb5.js";import{Q as z,a as k,b as s,c as K,d as Q}from"./QTable-08481d58.js";import{f as G}from"./options-4b88285e.js";import{Q as $}from"./QTooltip-1b7cd048.js";import{u as H}from"./use-quasar-1e1c8a18.js";import{_ as M}from"./PiutangFilterDialog.vue_vue_type_script_setup_true_lang-da0822f8.js";import"./QImg-766bfd11.js";import"./use-dialog-plugin-component-24b3795d.js";import"./QForm-95ef4f4f.js";const W={class:"row items-center q-col-gutter-sm"},X=x("div",{class:"text-caption"},"Filter by",-1),Y=R({__name:"ProyekTable",props:{rows:{},options:{}},setup(j){const b=j,p=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"penyedia_jasa",label:"Penyedia Jasa",field:"penyedia_jasa",align:"left",sortable:!0},{name:"nilai_kontrak",label:"Nilai Kontrak",field:"nilai_kontrak",align:"right",sortable:!0},{name:"rap",label:"RAP",field:"rap",align:"right",sortable:!0},{name:"pengajuan_sebelumnya",label:"Pengajuan Sebelumnya",field:"pengajuan_sebelumnya",align:"right",sortable:!0},{name:"pengajuan_dalam_proses",label:"Pengajuan Dalam Proses",field:"pengajuan_dalam_proses",align:"right",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"right",sortable:!0},{name:"sisa_anggaran",label:"Sisa Anggaran",field:"sisa_anggaran",align:"right",sortable:!0},{name:"estimasi_laba",label:"Estimasi Laba",field:"estimasi_laba",align:"right",sortable:!0}],h=w(b.options.tahunAnggaran);function d(u,i){i(()=>{h.value=G(u,b.options.tahunAnggaran)})}const m=O().props.query,c=w(m.tahun_anggaran);function l(u){B.get(route("dashboard.admin",u),void 0,{preserveScroll:!0,preserveState:!0})}return(u,i)=>(g(),P(K,{flat:"",bordered:"",title:"Proyek Aktif",rows:u.rows,columns:p,"row-key":"id_proyek"},{"top-right":e(()=>[x("div",W,[X,a(z,{dense:"",filled:"","use-input":"","input-debounce":"500",label:"Tahun Anggaran",modelValue:c.value,"onUpdate:modelValue":[i[0]||(i[0]=n=>c.value=n),i[1]||(i[1]=n=>l({tahun_anggaran:n}))],options:h.value,onFilter:d},{"no-option":e(()=>[a(C,null,{default:e(()=>[a(q,{class:"text-grey"},{default:e(()=>[t(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","options"])])]),header:e(n=>[a(k,{props:n},{default:e(()=>[(g(!0),D(T,null,A(n.cols,y=>(g(),P(Q,{key:y.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(r(y.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(k,{props:n},{default:e(()=>[a(s,{key:"index",props:n},{default:e(()=>[t(r(++n.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:n},{default:e(()=>[t(r(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"penyedia_jasa",props:n},{default:e(()=>[t(r(n.row.penyedia_jasa),1)]),_:2},1032,["props"]),a(s,{key:"nilai_kontrak",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.nilai_kontrak))),1)]),_:2},1032,["props"]),a(s,{key:"rap",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.rap))),1)]),_:2},1032,["props"]),a(s,{key:"pengajuan_sebelumnya",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.pengajuan_sebelumnya))),1)]),_:2},1032,["props"]),a(s,{key:"pengajuan_dalam_proses",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.pengajuan_dalam_proses))),1)]),_:2},1032,["props"]),a(s,{key:"total_pengajuan",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.total_pengajuan))),1)]),_:2},1032,["props"]),a(s,{key:"sisa_anggaran",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.sisa_anggaran))),1)]),_:2},1032,["props"]),a(s,{key:"estimasi_laba",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.estimasi_laba)))+" ("+r(o(_)(n.row.persentase_laba).toFixed(2))+" %) ",1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows"]))}}),ee=R({__name:"SisaDanaRekeningTable",props:{rows:{}},setup(j){const b=j,p=S(()=>b.rows.map(l=>{const u=_(l.nilai_kontrak),i=_(l.total_pengajuan_dana),n=_(l.total_pencairan_dana)+_(l.total_penagihan_diterima);return{...l,sisa_dana:u+i-n}})),h=[{name:"index",label:"#",field:"index"},{name:"rekening",label:"Rekening",field:"nama_rekening",align:"left",sortable:!0},{name:"sisa_dana",label:"Sisa Dana",field:"",align:"right",sortable:!0}],d=w(!1);function v(){d.value=!d.value}const m=w(),c=S(()=>{var u;return{sisaDana:(u=m.value)==null?void 0:u.computedRows.reduce((i,n)=>i+_(n.sisa_dana),0)}});return(l,u)=>(g(),P(o(K),{ref_key:"table",ref:m,flat:"",bordered:"",title:"Sisa Dana Rekening",fullscreen:d.value,rows:p.value,columns:h,"row-key":"id_rekening",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:d.value?"fullscreen_exit":"fullscreen",onClick:v,class:"q-ml-md"},null,8,["icon"])]),header:e(i=>[a(k,{props:i},{default:e(()=>[(g(!0),D(T,null,A(i.cols,n=>(g(),P(Q,{key:n.name,props:i,style:{"font-weight":"bold"}},{default:e(()=>[t(r(n.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(i=>[a(k,{props:i},{default:e(()=>[a(s,{key:"index",props:i},{default:e(()=>[t(r(++i.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"rekening",props:i},{default:e(()=>[t(r(i.row.nama_rekening),1)]),_:2},1032,["props"]),a(s,{key:"sisa_dana",props:i},{default:e(()=>[t(r(o(f)(i.row.sisa_dana)),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"2"},{default:e(()=>[t("Total Sisa Dana")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(c.value.sisaDana)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const ae=R({__name:"ProyeksiInvoiceProyekTable",props:{rows:{}},setup(j){const b=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"invoice_sebelumnya",label:"Invoice Sebelumnya",field:"invoice_sebelumnya",align:"right",sortable:!0},{name:"invoice_saat_ini",label:"Invoice Saat Ini",field:"invoice_saat_ini",align:"right",sortable:!0},{name:"sisa_netto_kontrak",label:"Sisa Netto Kontrak",field:"sisa_netto_kontrak",align:"right",sortable:!0}],p=w(!1);function h(){p.value=!p.value}const d=w(),v=S(()=>{var u,i,n;const m=(u=d.value)==null?void 0:u.computedRows.reduce((y,I)=>y+_(I.invoice_sebelumnya),0),c=(i=d.value)==null?void 0:i.computedRows.reduce((y,I)=>y+_(I.invoice_saat_ini),0),l=(n=d.value)==null?void 0:n.computedRows.reduce((y,I)=>y+_(I.sisa_netto_kontrak),0);return{invoiceSebelumnya:m,invoiceSaatIni:c,sisaNettoKontrak:l}});return(m,c)=>(g(),P(o(K),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Invoice Proyek",fullscreen:p.value,rows:m.rows,columns:b,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:p.value?"fullscreen_exit":"fullscreen",onClick:h,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(k,{props:l},{default:e(()=>[(g(!0),D(T,null,A(l.cols,u=>(g(),P(Q,{key:u.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(k,{props:l},{default:e(()=>[a(s,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"invoice_sebelumnya",props:l},{default:e(()=>[t(r(o(f)(o(_)(l.row.invoice_sebelumnya))),1)]),_:2},1032,["props"]),a(s,{key:"invoice_saat_ini",props:l},{default:e(()=>[t(r(o(f)(o(_)(l.row.invoice_saat_ini))),1)]),_:2},1032,["props"]),a(s,{key:"sisa_netto_kontrak",props:l},{default:e(()=>[t(r(o(f)(o(_)(l.row.sisa_netto_kontrak))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"4"},{default:e(()=>[t("Total Invoice Sebelumnya")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(v.value.invoiceSebelumnya)),1)]),_:1})]),_:1}),a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"4"},{default:e(()=>[t("Total Invoice Saat Ini")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(v.value.invoiceSaatIni)),1)]),_:1})]),_:1}),a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"4"},{default:e(()=>[t("Total Sisa Netto Kontrak")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(v.value.sisaNettoKontrak)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const le=R({__name:"ProyeksiKebutuhanDanaProyekTable",props:{rows:{}},setup(j){const b=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"left",sortable:!0},{name:"jumlah_belum_dibayar",label:"Jumlah Belum Dibayar",field:"jumlah_belum_dibayar",align:"right",sortable:!0}],p=w(!1);function h(){p.value=!p.value}const d=w(),v=S(()=>{var c;return{jumlahBelumDibayar:(c=d.value)==null?void 0:c.computedRows.reduce((l,u)=>l+_(u.jumlah_belum_dibayar),0)}});return(m,c)=>(g(),P(o(K),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Kebutuhan Dana Proyek",fullscreen:p.value,rows:m.rows,columns:b,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:p.value?"fullscreen_exit":"fullscreen",onClick:h,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(k,{props:l},{default:e(()=>[(g(!0),D(T,null,A(l.cols,u=>(g(),P(Q,{key:u.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(k,{props:l},{default:e(()=>[a(s,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"total_pengajuan",props:l},{default:e(()=>[t(r(l.row.total_pengajuan)+" Pengajuan ",1)]),_:2},1032,["props"]),a(s,{key:"jumlah_belum_dibayar",props:l},{default:e(()=>[t(r(o(f)(o(_)(l.row.jumlah_belum_dibayar))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"3"},{default:e(()=>[t("Total Belum Dibayar")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(v.value.jumlahBelumDibayar)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const ne=R({__name:"ProyeksiUtangTable",props:{rows:{}},setup(j){const b=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_utang",label:"Jumlah Utang",field:"jumlah_utang",align:"right",sortable:!0}],p=w(!1);function h(){p.value=!p.value}const d=w(),v=S(()=>{var c;return{utang:(c=d.value)==null?void 0:c.computedRows.reduce((l,u)=>l+_(u.jumlah_utang),0)}});return(m,c)=>(g(),P(o(K),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Utang",fullscreen:p.value,rows:m.rows,columns:b,"row-key":"id_pencairan_dana",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:p.value?"fullscreen_exit":"fullscreen",onClick:h,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(k,{props:l},{default:e(()=>[(g(!0),D(T,null,A(l.cols,u=>(g(),P(Q,{key:u.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(k,{props:l,onClick:u=>o(B).visit(m.route("detail_pencairan_dana",l.row.id_pencairan_dana)),style:{cursor:"pointer"}},{default:e(()=>[a(s,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"keperluan",props:l},{default:e(()=>[t(r(l.row.keperluan),1)]),_:2},1032,["props"]),a(s,{key:"jumlah_utang",props:l},{default:e(()=>[t(r(o(f)(o(_)(l.row.jumlah_utang))),1)]),_:2},1032,["props"]),a($,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(v.value.utang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const te=R({__name:"ProyeksiPiutangTable",props:{rows:{},options:{}},setup(j){const b=j,p=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_piutang",label:"Jumlah Piutang",field:"jumlah_piutang",align:"right",sortable:!0}],h=w(!1);function d(){h.value=!h.value}const v=w(),m=S(()=>{var i;return{piutang:(i=v.value)==null?void 0:i.computedRows.reduce((n,y)=>n+_(y.jumlah_piutang),0)}}),c=H();function l(){c.dialog({component:M,componentProps:{options:b.options,data:{route:route("dashboard.admin")}}})}return(u,i)=>(g(),P(o(K),{ref_key:"table",ref:v,flat:"",bordered:"",title:"Proyeksi Piutang",fullscreen:h.value,rows:u.rows,columns:p,"row-key":"id_penagihan",class:"table"},{"top-right":e(()=>[a(F,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:l}),a(F,{flat:"",dense:"",icon:h.value?"fullscreen_exit":"fullscreen",onClick:d,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(k,{props:n},{default:e(()=>[(g(!0),D(T,null,A(n.cols,y=>(g(),P(Q,{key:y.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(r(y.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(k,{props:n,onClick:y=>o(B).visit(u.route("detail_penagihan",n.row.id_penagihan)),style:{cursor:"pointer"}},{default:e(()=>[a(s,{key:"index",props:n},{default:e(()=>[t(r(++n.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:n},{default:e(()=>[t(r(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"keperluan",props:n},{default:e(()=>[t(r(n.row.keperluan),1)]),_:2},1032,["props"]),a(s,{key:"jumlah_piutang",props:n},{default:e(()=>[t(r(o(f)(o(_)(n.row.jumlah_piutang))),1)]),_:2},1032,["props"]),a($,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(k,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(m.value.piutang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const oe={class:"q-pa-md"},re={class:"row q-col-gutter-md"},se={class:"col-12"},ie={class:"col-12 col-md-6"},ue={class:"col-12 col-md-6"},_e={class:"col-12"},de={class:"col-12 col-md-6"},ce={class:"col-12 col-md-6"},xe=R({__name:"AdminPage",props:{proyek:{},sisaDanaRekening:{},proyeksiInvoiceProyek:{},proyeksiKebutuhanDanaProyek:{},proyeksiUtang:{},proyeksiPiutang:{},overview:{},options:{}},setup(j){const b=j,p=[{label:"Dashboard",url:"#"},{label:"Overview",url:"#"}],h=S(()=>{const d=b.overview,v=b.sisaDanaRekening.reduce((u,i)=>{const n=_(i.nilai_kontrak),y=_(i.total_pengajuan_dana),I=_(i.total_pencairan_dana)+_(i.total_penagihan_diterima);return u+(n+y-I)},0),m=b.proyeksiInvoiceProyek.reduce((u,i)=>{const n=_(i.invoice_sebelumnya),y=_(i.invoice_saat_ini);return u+(n+y)},0),c=b.proyeksiKebutuhanDanaProyek.reduce((u,i)=>u+_(i.jumlah_belum_dibayar),0),l=v+m-c;return d.push({title:"Proyeksi Kas Akhir Bulan",color:"positive",data:f(l)}),b.overview});return(d,v)=>{const m=J("in-link");return g(),D(T,null,[a(o(L),{title:"Dashboard"}),a(U,null,{breadcrumbs:e(()=>[a(N,{align:"left"},{default:e(()=>[(g(),D(T,null,A(p,c=>E(a(V,{key:c.label,label:c.label},null,8,["label"]),[[m,c.url]])),64))]),_:1})]),default:e(()=>[a(o(Z),{overview:h.value},null,8,["overview"]),x("div",oe,[x("div",re,[x("div",se,[a(o(Y),{rows:d.proyek,options:d.options},null,8,["rows","options"])]),x("div",ie,[a(o(ee),{rows:d.sisaDanaRekening},null,8,["rows"])]),x("div",ue,[a(o(le),{rows:d.proyeksiKebutuhanDanaProyek},null,8,["rows"])]),x("div",_e,[a(o(ae),{rows:d.proyeksiInvoiceProyek},null,8,["rows"])]),x("div",de,[a(o(ne),{rows:d.proyeksiUtang},null,8,["rows"])]),x("div",ce,[a(o(te),{rows:d.proyeksiPiutang,options:d.options},null,8,["rows","options"])])])])]),_:1})],64)}}});export{xe as default};
