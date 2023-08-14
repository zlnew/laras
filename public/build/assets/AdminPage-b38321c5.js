import{Q as B,a as q,b as N,_ as U,c as V}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-ca464798.js";import{d as S,j as w,K as O,o as b,c as P,w as e,g as x,a,b as t,e as T,k as A,F as D,t as r,u as o,O as $,l as I,h as F,m as J,Z as L,n as E}from"./app-820d56a8.js";import{_ as Z}from"./DashboardOverview.vue_vue_type_script_setup_true_lang-f42c65bc.js";import{Q as z,a as g,b as s,c as R,d as Q}from"./QTable-7858290f.js";import{t as f,a as u}from"./money-3074a8fc.js";import{f as G}from"./options-964f32b0.js";import{Q as C}from"./QTooltip-60a2bd3d.js";import{u as H}from"./use-quasar-d1cd8476.js";import{_ as M}from"./PiutangFilterDialog.vue_vue_type_script_setup_true_lang-6ee603e8.js";import"./QImg-adc75621.js";import"./use-dialog-plugin-component-0650bf81.js";import"./QForm-406a8856.js";const W={class:"row items-center q-col-gutter-sm"},X=x("div",{class:"text-caption"},"Filter by",-1),Y=S({__name:"ProyekTable",props:{rows:{},options:{}},setup(j){const k=j,c=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"penyedia_jasa",label:"Penyedia Jasa",field:"penyedia_jasa",align:"left",sortable:!0},{name:"nilai_kontrak",label:"Nilai Kontrak",field:"nilai_kontrak",align:"right",sortable:!0},{name:"rap",label:"RAP",field:"rap",align:"right",sortable:!0},{name:"pengajuan_sebelumnya",label:"Pengajuan Sebelumnya",field:"pengajuan_sebelumnya",align:"right",sortable:!0},{name:"pengajuan_dalam_proses",label:"Pengajuan Dalam Proses",field:"pengajuan_dalam_proses",align:"right",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"right",sortable:!0},{name:"sisa_anggaran",label:"Sisa Anggaran",field:"sisa_anggaran",align:"right",sortable:!0},{name:"estimasi_laba",label:"Estimasi Laba",field:"estimasi_laba",align:"right",sortable:!0}],y=w(k.options.tahunAnggaran);function d(i,_){_(()=>{y.value=G(i,k.options.tahunAnggaran)})}const m=O().props.query,p=w(m.tahun_anggaran);function n(i){$.get(route("dashboard.admin",i),{},{preserveScroll:!0,preserveState:!0})}return(i,_)=>(b(),P(R,{flat:"",bordered:"",title:"Proyek Aktif",rows:i.rows,columns:c,"row-key":"id_proyek"},{"top-right":e(()=>[x("div",W,[X,a(z,{dense:"",filled:"","use-input":"","input-debounce":"500",label:"Tahun Anggaran",modelValue:p.value,"onUpdate:modelValue":[_[0]||(_[0]=l=>p.value=l),_[1]||(_[1]=l=>n({tahun_anggaran:l}))],options:y.value,onFilter:d},{"no-option":e(()=>[a(B,null,{default:e(()=>[a(q,{class:"text-grey"},{default:e(()=>[t(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","options"])])]),header:e(l=>[a(g,{props:l},{default:e(()=>[(b(!0),T(D,null,A(l.cols,v=>(b(),P(Q,{key:v.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(v.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(g,{props:l},{default:e(()=>[a(s,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"penyedia_jasa",props:l},{default:e(()=>[t(r(l.row.penyedia_jasa),1)]),_:2},1032,["props"]),a(s,{key:"nilai_kontrak",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.nilai_kontrak))),1)]),_:2},1032,["props"]),a(s,{key:"rap",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.rap))),1)]),_:2},1032,["props"]),a(s,{key:"pengajuan_sebelumnya",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.pengajuan_sebelumnya))),1)]),_:2},1032,["props"]),a(s,{key:"pengajuan_dalam_proses",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.pengajuan_dalam_proses))),1)]),_:2},1032,["props"]),a(s,{key:"total_pengajuan",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.total_pengajuan))),1)]),_:2},1032,["props"]),a(s,{key:"sisa_anggaran",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.sisa_anggaran))),1)]),_:2},1032,["props"]),a(s,{key:"estimasi_laba",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.estimasi_laba)))+" ("+r(o(u)(l.row.persentase_laba).toFixed(2))+" %) ",1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows"]))}}),ee=S({__name:"SisaDanaRekeningTable",props:{rows:{}},setup(j){const k=j,c=I(()=>k.rows.map(n=>{const i=u(n.nilai_kontrak),_=u(n.total_pengajuan_dana)+u(n.total_penagihan);return u(n.total_pencairan_dana)+u(n.total_penagihan_diterima),{...n,sisa_dana:i-_}})),y=[{name:"index",label:"#",field:"index"},{name:"rekening",label:"Rekening",field:"nama_rekening",align:"left",sortable:!0},{name:"sisa_dana",label:"Sisa Dana",field:"",align:"right",sortable:!0}],d=w(!1);function h(){d.value=!d.value}const m=w(),p=I(()=>{var i;return{sisa_dana:(i=m.value)==null?void 0:i.computedRows.reduce((_,l)=>_+u(l.sisa_dana),0)}});return(n,i)=>(b(),P(o(R),{ref_key:"table",ref:m,flat:"",bordered:"",title:"Sisa Dana Rekening",fullscreen:d.value,rows:c.value,columns:y,"row-key":"id_rekening",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:d.value?"fullscreen_exit":"fullscreen",onClick:h,class:"q-ml-md"},null,8,["icon"])]),header:e(_=>[a(g,{props:_},{default:e(()=>[(b(!0),T(D,null,A(_.cols,l=>(b(),P(Q,{key:l.name,props:_,style:{"font-weight":"bold"}},{default:e(()=>[t(r(l.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(_=>[a(g,{props:_},{default:e(()=>[a(s,{key:"index",props:_},{default:e(()=>[t(r(++_.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"rekening",props:_},{default:e(()=>[t(r(_.row.nama_rekening),1)]),_:2},1032,["props"]),a(s,{key:"sisa_dana",props:_},{default:e(()=>[t(r(o(f)(_.row.sisa_dana)),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"2"},{default:e(()=>[t("Total Sisa Dana")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(p.value.sisa_dana)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const ae=S({__name:"ProyeksiInvoiceProyekTable",props:{rows:{}},setup(j){const k=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"invoice_sebelumnya",label:"Invoice Sebelumnya",field:"invoice_sebelumnya",align:"right",sortable:!0},{name:"invoice_saat_ini",label:"Invoice Saat Ini",field:"invoice_saat_ini",align:"right",sortable:!0},{name:"sisa_netto_kontrak",label:"Sisa Netto Kontrak",field:"sisa_netto_kontrak",align:"right",sortable:!0}],c=w(!1);function y(){c.value=!c.value}const d=w(),h=I(()=>{var i,_,l;const m=(i=d.value)==null?void 0:i.computedRows.reduce((v,K)=>v+u(K.invoice_sebelumnya),0),p=(_=d.value)==null?void 0:_.computedRows.reduce((v,K)=>v+u(K.invoice_saat_ini),0),n=(l=d.value)==null?void 0:l.computedRows.reduce((v,K)=>v+u(K.sisa_netto_kontrak),0);return{invoice_sebelumnya:m,invoice_saat_ini:p,sisa_netto_kontrak:n}});return(m,p)=>(b(),P(o(R),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Invoice Proyek",fullscreen:c.value,rows:m.rows,columns:k,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:y,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(g,{props:n},{default:e(()=>[(b(!0),T(D,null,A(n.cols,i=>(b(),P(Q,{key:i.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(r(i.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(g,{props:n},{default:e(()=>[a(s,{key:"index",props:n},{default:e(()=>[t(r(++n.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:n},{default:e(()=>[t(r(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"invoice_sebelumnya",props:n},{default:e(()=>[t(r(o(f)(o(u)(n.row.invoice_sebelumnya))),1)]),_:2},1032,["props"]),a(s,{key:"invoice_saat_ini",props:n},{default:e(()=>[t(r(o(f)(o(u)(n.row.invoice_saat_ini))),1)]),_:2},1032,["props"]),a(s,{key:"sisa_netto_kontrak",props:n},{default:e(()=>[t(r(o(f)(o(u)(n.row.sisa_netto_kontrak))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"4"},{default:e(()=>[t("Total Invoice Sebelumnya")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(h.value.invoice_sebelumnya)),1)]),_:1})]),_:1}),a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"4"},{default:e(()=>[t("Total Invoice Saat Ini")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(h.value.invoice_saat_ini)),1)]),_:1})]),_:1}),a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"4"},{default:e(()=>[t("Total Sisa Netto Kontrak")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(h.value.sisa_netto_kontrak)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const ne=S({__name:"ProyeksiKebutuhanDanaProyekTable",props:{rows:{}},setup(j){const k=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"left",sortable:!0},{name:"jumlah_belum_dibayar",label:"Jumlah Belum Dibayar",field:"jumlah_belum_dibayar",align:"right",sortable:!0}],c=w(!1);function y(){c.value=!c.value}const d=w(),h=I(()=>{var p;return{jumlah_belum_dibayar:(p=d.value)==null?void 0:p.computedRows.reduce((n,i)=>n+u(i.jumlah_belum_dibayar),0)}});return(m,p)=>(b(),P(o(R),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Kebutuhan Dana Proyek",fullscreen:c.value,rows:m.rows,columns:k,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:y,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(g,{props:n},{default:e(()=>[(b(!0),T(D,null,A(n.cols,i=>(b(),P(Q,{key:i.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(r(i.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(g,{props:n},{default:e(()=>[a(s,{key:"index",props:n},{default:e(()=>[t(r(++n.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:n},{default:e(()=>[t(r(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"total_pengajuan",props:n},{default:e(()=>[t(r(n.row.total_pengajuan)+" Pengajuan ",1)]),_:2},1032,["props"]),a(s,{key:"jumlah_belum_dibayar",props:n},{default:e(()=>[t(r(o(f)(o(u)(n.row.jumlah_belum_dibayar))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"3"},{default:e(()=>[t("Total Belum Dibayar")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(h.value.jumlah_belum_dibayar)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const le=S({__name:"ProyeksiUtangTable",props:{rows:{}},setup(j){const k=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_utang",label:"Jumlah Utang",field:"jumlah_utang",align:"right",sortable:!0}],c=w(!1);function y(){c.value=!c.value}const d=w(),h=I(()=>{var p;return{utang:(p=d.value)==null?void 0:p.computedRows.reduce((n,i)=>n+u(i.jumlah_utang),0)}});return(m,p)=>(b(),P(o(R),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Utang",fullscreen:c.value,rows:m.rows,columns:k,"row-key":"id_pencairan_dana",class:"table"},{"top-right":e(()=>[a(F,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:y,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(g,{props:n},{default:e(()=>[(b(!0),T(D,null,A(n.cols,i=>(b(),P(Q,{key:i.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(r(i.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(g,{props:n,onClick:i=>o($).visit(m.route("detail_pencairan_dana",n.row.id_pencairan_dana)),style:{cursor:"pointer"}},{default:e(()=>[a(s,{key:"index",props:n},{default:e(()=>[t(r(++n.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:n},{default:e(()=>[t(r(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"keperluan",props:n},{default:e(()=>[t(r(n.row.keperluan),1)]),_:2},1032,["props"]),a(s,{key:"jumlah_utang",props:n},{default:e(()=>[t(r(o(f)(o(u)(n.row.jumlah_utang))),1)]),_:2},1032,["props"]),a(C,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(h.value.utang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const te=S({__name:"ProyeksiPiutangTable",props:{rows:{},options:{}},setup(j){const k=j,c=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_piutang",label:"Jumlah Piutang",field:"jumlah_piutang",align:"right",sortable:!0}],y=w(!1);function d(){y.value=!y.value}const h=w(),m=I(()=>{var _;return{piutang:(_=h.value)==null?void 0:_.computedRows.reduce((l,v)=>l+u(v.jumlah_piutang),0)}}),p=H();function n(){p.dialog({component:M,componentProps:{options:k.options,data:{route:route("dashboard.admin")}}})}return(i,_)=>(b(),P(o(R),{ref_key:"table",ref:h,flat:"",bordered:"",title:"Proyeksi Piutang",fullscreen:y.value,rows:i.rows,columns:c,"row-key":"id_penagihan",class:"table"},{"top-right":e(()=>[a(F,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:n}),a(F,{flat:"",dense:"",icon:y.value?"fullscreen_exit":"fullscreen",onClick:d,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(g,{props:l},{default:e(()=>[(b(!0),T(D,null,A(l.cols,v=>(b(),P(Q,{key:v.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(r(v.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(g,{props:l,onClick:v=>o($).visit(i.route("detail_penagihan",l.row.id_penagihan)),style:{cursor:"pointer"}},{default:e(()=>[a(s,{key:"index",props:l},{default:e(()=>[t(r(++l.rowIndex),1)]),_:2},1032,["props"]),a(s,{key:"proyek",props:l},{default:e(()=>[t(r(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(s,{key:"keperluan",props:l},{default:e(()=>[t(r(l.row.keperluan),1)]),_:2},1032,["props"]),a(s,{key:"jumlah_piutang",props:l},{default:e(()=>[t(r(o(f)(o(u)(l.row.jumlah_piutang))),1)]),_:2},1032,["props"]),a(C,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(s,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(s,null,{default:e(()=>[t(r(o(f)(m.value.piutang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const oe={class:"q-pa-md"},re={class:"row q-col-gutter-md"},se={class:"col-12"},ie={class:"col-12 col-md-6"},ue={class:"col-12 col-md-6"},_e={class:"col-12"},de={class:"col-12 col-md-6"},ce={class:"col-12 col-md-6"},xe=S({__name:"AdminPage",props:{proyek:{},sisaDanaRekening:{},proyeksiInvoiceProyek:{},proyeksiKebutuhanDanaProyek:{},proyeksiUtang:{},proyeksiPiutang:{},overview:{},options:{}},setup(j){const k=j,c=[{label:"Dashboard",url:"#"},{label:"Overview",url:"#"}],y=I(()=>{const d=k.sisaDanaRekening.reduce((n,i)=>{const _=u(i.nilai_kontrak),l=u(i.total_pengajuan_dana)+u(i.total_penagihan);return u(i.total_pencairan_dana)+u(i.total_penagihan_diterima),n+(_-l)},0),h=k.proyeksiInvoiceProyek.reduce((n,i)=>{const _=u(i.invoice_sebelumnya),l=u(i.invoice_saat_ini);return n+(_+l)},0),m=k.proyeksiKebutuhanDanaProyek.reduce((n,i)=>n+u(i.jumlah_belum_dibayar),0),p=d+h-m;return k.overview.push({title:"Proyeksi Kas Akhir Bulan",color:"positive",data:f(p)}),k.overview});return(d,h)=>{const m=J("in-link");return b(),T(D,null,[a(o(L),{title:"Dashboard"}),a(U,null,{breadcrumbs:e(()=>[a(N,{align:"left"},{default:e(()=>[(b(),T(D,null,A(c,p=>E(a(V,{label:p.label},null,8,["label"]),[[m,p.url]])),64))]),_:1})]),default:e(()=>[a(o(Z),{overview:y.value},null,8,["overview"]),x("div",oe,[x("div",re,[x("div",se,[a(o(Y),{rows:d.proyek,options:d.options},null,8,["rows","options"])]),x("div",ie,[a(o(ee),{rows:d.sisaDanaRekening},null,8,["rows"])]),x("div",ue,[a(o(ne),{rows:d.proyeksiKebutuhanDanaProyek},null,8,["rows"])]),x("div",_e,[a(o(ae),{rows:d.proyeksiInvoiceProyek},null,8,["rows"])]),x("div",de,[a(o(le),{rows:d.proyeksiUtang},null,8,["rows"])]),x("div",ce,[a(o(te),{rows:d.proyeksiPiutang,options:d.options},null,8,["rows","options"])])])])]),_:1})],64)}}});export{xe as default};