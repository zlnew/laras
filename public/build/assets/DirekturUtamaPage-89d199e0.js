import{Q as B,a as q,b as U,_ as N,c as V}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-37451739.js";import{d as S,j as w,K as O,o as b,c as P,w as e,g as x,a,b as t,e as T,k as F,F as D,t as s,u as o,O as $,l as I,h as R,m as J,Z as L,n as E}from"./app-9a281e26.js";import{_ as Z}from"./DashboardOverview.vue_vue_type_script_setup_true_lang-1276f93e.js";import{Q as z,a as g,b as i,c as A,d as Q}from"./QTable-055131ee.js";import{t as f,a as u}from"./money-3074a8fc.js";import{f as G}from"./options-964f32b0.js";import{Q as C}from"./QTooltip-2e5a4439.js";import{u as H}from"./use-quasar-a06a674a.js";import{_ as M}from"./PiutangFilterDialog.vue_vue_type_script_setup_true_lang-af23450a.js";import"./QImg-75496342.js";import"./use-dialog-plugin-component-33e3ef66.js";import"./QForm-2af13f93.js";const W={class:"row items-center q-col-gutter-sm"},X=x("div",{class:"text-caption"},"Filter by",-1),Y=S({__name:"ProyekTable",props:{rows:{},options:{}},setup(j){const k=j,c=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"penyedia_jasa",label:"Penyedia Jasa",field:"penyedia_jasa",align:"left",sortable:!0},{name:"nilai_kontrak",label:"Nilai Kontrak",field:"nilai_kontrak",align:"right",sortable:!0},{name:"rap",label:"RAP",field:"rap",align:"right",sortable:!0},{name:"pengajuan_sebelumnya",label:"Pengajuan Sebelumnya",field:"pengajuan_sebelumnya",align:"right",sortable:!0},{name:"pengajuan_dalam_proses",label:"Pengajuan Dalam Proses",field:"pengajuan_dalam_proses",align:"right",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"right",sortable:!0},{name:"sisa_anggaran",label:"Sisa Anggaran",field:"sisa_anggaran",align:"right",sortable:!0},{name:"estimasi_laba",label:"Estimasi Laba",field:"estimasi_laba",align:"right",sortable:!0}],y=w(k.options.tahunAnggaran);function d(r,_){_(()=>{y.value=G(r,k.options.tahunAnggaran)})}const m=O().props.query,p=w(m.tahun_anggaran);function l(r){$.get(route("dashboard.direktur_utama",r),{},{preserveScroll:!0,preserveState:!0})}return(r,_)=>(b(),P(A,{flat:"",bordered:"",title:"Proyek Aktif",rows:r.rows,columns:c,"row-key":"id_proyek"},{"top-right":e(()=>[x("div",W,[X,a(z,{dense:"",filled:"","use-input":"","input-debounce":"500",label:"Tahun Anggaran",modelValue:p.value,"onUpdate:modelValue":[_[0]||(_[0]=n=>p.value=n),_[1]||(_[1]=n=>l({tahun_anggaran:n}))],options:y.value,onFilter:d},{"no-option":e(()=>[a(B,null,{default:e(()=>[a(q,{class:"text-grey"},{default:e(()=>[t(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","options"])])]),header:e(n=>[a(g,{props:n},{default:e(()=>[(b(!0),T(D,null,F(n.cols,v=>(b(),P(Q,{key:v.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(s(v.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(g,{props:n},{default:e(()=>[a(i,{key:"index",props:n},{default:e(()=>[t(s(++n.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"proyek",props:n},{default:e(()=>[t(s(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(i,{key:"penyedia_jasa",props:n},{default:e(()=>[t(s(n.row.penyedia_jasa),1)]),_:2},1032,["props"]),a(i,{key:"nilai_kontrak",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.nilai_kontrak))),1)]),_:2},1032,["props"]),a(i,{key:"rap",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.rap))),1)]),_:2},1032,["props"]),a(i,{key:"pengajuan_sebelumnya",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.pengajuan_sebelumnya))),1)]),_:2},1032,["props"]),a(i,{key:"pengajuan_dalam_proses",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.pengajuan_dalam_proses))),1)]),_:2},1032,["props"]),a(i,{key:"total_pengajuan",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.total_pengajuan))),1)]),_:2},1032,["props"]),a(i,{key:"sisa_anggaran",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.sisa_anggaran))),1)]),_:2},1032,["props"]),a(i,{key:"estimasi_laba",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.estimasi_laba)))+" ("+s(o(u)(n.row.persentase_laba).toFixed(2))+" %) ",1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows"]))}}),ee=S({__name:"SisaDanaRekeningTable",props:{rows:{}},setup(j){const k=j,c=I(()=>k.rows.map(l=>{const r=u(l.nilai_kontrak);return u(l.total_pengajuan_dana)+u(l.total_penagihan),u(l.total_pencairan_dana)+u(l.total_penagihan_diterima),{...l,sisa_dana:r-u(l.total_pencairan_dana)+u(l.total_penagihan_diterima)}})),y=[{name:"index",label:"#",field:"index"},{name:"rekening",label:"Rekening",field:"nama_rekening",align:"left",sortable:!0},{name:"sisa_dana",label:"Sisa Dana",field:"",align:"right",sortable:!0}],d=w(!1);function h(){d.value=!d.value}const m=w(),p=I(()=>{var r;return{sisa_dana:(r=m.value)==null?void 0:r.computedRows.reduce((_,n)=>_+u(n.sisa_dana),0)}});return(l,r)=>(b(),P(o(A),{ref_key:"table",ref:m,flat:"",bordered:"",title:"Sisa Dana Rekening",fullscreen:d.value,rows:c.value,columns:y,"row-key":"id_rekening",class:"table"},{"top-right":e(()=>[a(R,{flat:"",dense:"",icon:d.value?"fullscreen_exit":"fullscreen",onClick:h,class:"q-ml-md"},null,8,["icon"])]),header:e(_=>[a(g,{props:_},{default:e(()=>[(b(!0),T(D,null,F(_.cols,n=>(b(),P(Q,{key:n.name,props:_,style:{"font-weight":"bold"}},{default:e(()=>[t(s(n.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(_=>[a(g,{props:_},{default:e(()=>[a(i,{key:"index",props:_},{default:e(()=>[t(s(++_.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"rekening",props:_},{default:e(()=>[t(s(_.row.nama_rekening),1)]),_:2},1032,["props"]),a(i,{key:"sisa_dana",props:_},{default:e(()=>[t(s(o(f)(_.row.sisa_dana)),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"2"},{default:e(()=>[t("Total Sisa Dana")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(p.value.sisa_dana)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const ae=S({__name:"ProyeksiInvoiceProyekTable",props:{rows:{}},setup(j){const k=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"invoice_sebelumnya",label:"Invoice Sebelumnya",field:"invoice_sebelumnya",align:"right",sortable:!0},{name:"invoice_saat_ini",label:"Invoice Saat Ini",field:"invoice_saat_ini",align:"right",sortable:!0},{name:"sisa_netto_kontrak",label:"Sisa Netto Kontrak",field:"sisa_netto_kontrak",align:"right",sortable:!0}],c=w(!1);function y(){c.value=!c.value}const d=w(),h=I(()=>{var r,_,n;const m=(r=d.value)==null?void 0:r.computedRows.reduce((v,K)=>v+u(K.invoice_sebelumnya),0),p=(_=d.value)==null?void 0:_.computedRows.reduce((v,K)=>v+u(K.invoice_saat_ini),0),l=(n=d.value)==null?void 0:n.computedRows.reduce((v,K)=>v+u(K.sisa_netto_kontrak),0);return{invoice_sebelumnya:m,invoice_saat_ini:p,sisa_netto_kontrak:l}});return(m,p)=>(b(),P(o(A),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Invoice Proyek",fullscreen:c.value,rows:m.rows,columns:k,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(R,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:y,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(g,{props:l},{default:e(()=>[(b(!0),T(D,null,F(l.cols,r=>(b(),P(Q,{key:r.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(s(r.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(g,{props:l},{default:e(()=>[a(i,{key:"index",props:l},{default:e(()=>[t(s(++l.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"proyek",props:l},{default:e(()=>[t(s(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(i,{key:"invoice_sebelumnya",props:l},{default:e(()=>[t(s(o(f)(o(u)(l.row.invoice_sebelumnya))),1)]),_:2},1032,["props"]),a(i,{key:"invoice_saat_ini",props:l},{default:e(()=>[t(s(o(f)(o(u)(l.row.invoice_saat_ini))),1)]),_:2},1032,["props"]),a(i,{key:"sisa_netto_kontrak",props:l},{default:e(()=>[t(s(o(f)(o(u)(l.row.sisa_netto_kontrak))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"4"},{default:e(()=>[t("Total Invoice Sebelumnya")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(h.value.invoice_sebelumnya)),1)]),_:1})]),_:1}),a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"4"},{default:e(()=>[t("Total Invoice Saat Ini")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(h.value.invoice_saat_ini)),1)]),_:1})]),_:1}),a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"4"},{default:e(()=>[t("Total Sisa Netto Kontrak")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(h.value.sisa_netto_kontrak)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const le=S({__name:"ProyeksiKebutuhanDanaProyekTable",props:{rows:{}},setup(j){const k=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"total_pengajuan",label:"Total Pengajuan",field:"total_pengajuan",align:"left",sortable:!0},{name:"jumlah_belum_dibayar",label:"Jumlah Belum Dibayar",field:"jumlah_belum_dibayar",align:"right",sortable:!0}],c=w(!1);function y(){c.value=!c.value}const d=w(),h=I(()=>{var p;return{jumlah_belum_dibayar:(p=d.value)==null?void 0:p.computedRows.reduce((l,r)=>l+u(r.jumlah_belum_dibayar),0)}});return(m,p)=>(b(),P(o(A),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Kebutuhan Dana Proyek",fullscreen:c.value,rows:m.rows,columns:k,"row-key":"id_proyek",class:"table"},{"top-right":e(()=>[a(R,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:y,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(g,{props:l},{default:e(()=>[(b(!0),T(D,null,F(l.cols,r=>(b(),P(Q,{key:r.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(s(r.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(g,{props:l},{default:e(()=>[a(i,{key:"index",props:l},{default:e(()=>[t(s(++l.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"proyek",props:l},{default:e(()=>[t(s(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(i,{key:"total_pengajuan",props:l},{default:e(()=>[t(s(l.row.total_pengajuan)+" Pengajuan ",1)]),_:2},1032,["props"]),a(i,{key:"jumlah_belum_dibayar",props:l},{default:e(()=>[t(s(o(f)(o(u)(l.row.jumlah_belum_dibayar))),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"3"},{default:e(()=>[t("Total Belum Dibayar")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(h.value.jumlah_belum_dibayar)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const ne=S({__name:"ProyeksiUtangTable",props:{rows:{}},setup(j){const k=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_utang",label:"Jumlah Utang",field:"jumlah_utang",align:"right",sortable:!0}],c=w(!1);function y(){c.value=!c.value}const d=w(),h=I(()=>{var p;return{utang:(p=d.value)==null?void 0:p.computedRows.reduce((l,r)=>l+u(r.jumlah_utang),0)}});return(m,p)=>(b(),P(o(A),{ref_key:"table",ref:d,flat:"",bordered:"",title:"Proyeksi Utang",fullscreen:c.value,rows:m.rows,columns:k,"row-key":"id_pencairan_dana",class:"table"},{"top-right":e(()=>[a(R,{flat:"",dense:"",icon:c.value?"fullscreen_exit":"fullscreen",onClick:y,class:"q-ml-md"},null,8,["icon"])]),header:e(l=>[a(g,{props:l},{default:e(()=>[(b(!0),T(D,null,F(l.cols,r=>(b(),P(Q,{key:r.name,props:l,style:{"font-weight":"bold"}},{default:e(()=>[t(s(r.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(l=>[a(g,{props:l,onClick:r=>o($).visit(m.route("detail_pencairan_dana",l.row.id_pencairan_dana)),style:{cursor:"pointer"}},{default:e(()=>[a(i,{key:"index",props:l},{default:e(()=>[t(s(++l.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"proyek",props:l},{default:e(()=>[t(s(l.row.nama_proyek),1)]),_:2},1032,["props"]),a(i,{key:"keperluan",props:l},{default:e(()=>[t(s(l.row.keperluan),1)]),_:2},1032,["props"]),a(i,{key:"jumlah_utang",props:l},{default:e(()=>[t(s(o(f)(o(u)(l.row.jumlah_utang))),1)]),_:2},1032,["props"]),a(C,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(h.value.utang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const te=S({__name:"ProyeksiPiutangTable",props:{rows:{},options:{}},setup(j){const k=j,c=[{name:"index",label:"#",field:"index"},{name:"proyek",label:"Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jumlah_piutang",label:"Jumlah Piutang",field:"jumlah_piutang",align:"right",sortable:!0}],y=w(!1);function d(){y.value=!y.value}const h=w(),m=I(()=>{var _;return{piutang:(_=h.value)==null?void 0:_.computedRows.reduce((n,v)=>n+u(v.jumlah_piutang),0)}}),p=H();function l(){p.dialog({component:M,componentProps:{options:k.options,data:{route:route("dashboard.direktur_utama")}}})}return(r,_)=>(b(),P(o(A),{ref_key:"table",ref:h,flat:"",bordered:"",title:"Proyeksi Piutang",fullscreen:y.value,rows:r.rows,columns:c,"row-key":"id_penagihan",class:"table"},{"top-right":e(()=>[a(R,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:l}),a(R,{flat:"",dense:"",icon:y.value?"fullscreen_exit":"fullscreen",onClick:d,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(g,{props:n},{default:e(()=>[(b(!0),T(D,null,F(n.cols,v=>(b(),P(Q,{key:v.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[t(s(v.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(g,{props:n,onClick:v=>o($).visit(r.route("detail_penagihan",n.row.id_penagihan)),style:{cursor:"pointer"}},{default:e(()=>[a(i,{key:"index",props:n},{default:e(()=>[t(s(++n.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"proyek",props:n},{default:e(()=>[t(s(n.row.nama_proyek),1)]),_:2},1032,["props"]),a(i,{key:"keperluan",props:n},{default:e(()=>[t(s(n.row.keperluan),1)]),_:2},1032,["props"]),a(i,{key:"jumlah_piutang",props:n},{default:e(()=>[t(s(o(f)(o(u)(n.row.jumlah_piutang))),1)]),_:2},1032,["props"]),a(C,null,{default:e(()=>[t("Lihat Detail")]),_:1})]),_:2},1032,["props","onClick"])]),"bottom-row":e(()=>[a(g,{"no-hover":"",class:"text-weight-bold text-right"},{default:e(()=>[a(i,{colspan:"3"},{default:e(()=>[t("Total")]),_:1}),a(i,null,{default:e(()=>[t(s(o(f)(m.value.piutang)),1)]),_:1})]),_:1})]),_:1},8,["fullscreen","rows"]))}});const oe={class:"q-pa-md"},re={class:"row q-col-gutter-md"},se={class:"col-12"},ie={class:"col-12 col-md-6"},ue={class:"col-12 col-md-6"},_e={class:"col-12"},de={class:"col-12 col-md-6"},ce={class:"col-12 col-md-6"},xe=S({__name:"DirekturUtamaPage",props:{proyek:{},sisaDanaRekening:{},proyeksiInvoiceProyek:{},proyeksiKebutuhanDanaProyek:{},proyeksiUtang:{},proyeksiPiutang:{},overview:{},options:{}},setup(j){const k=j,c=[{label:"Dashboard",url:"#"},{label:"Overview",url:"#"}],y=I(()=>{const d=k.sisaDanaRekening.reduce((l,r)=>{const _=u(r.nilai_kontrak);return u(r.total_pengajuan_dana)+u(r.total_penagihan),u(r.total_pencairan_dana)+u(r.total_penagihan_diterima),l+(_-u(r.total_pencairan_dana)+u(r.total_penagihan_diterima))},0),h=k.proyeksiInvoiceProyek.reduce((l,r)=>{const _=u(r.invoice_sebelumnya),n=u(r.invoice_saat_ini);return l+(_+n)},0),m=k.proyeksiKebutuhanDanaProyek.reduce((l,r)=>l+u(r.jumlah_belum_dibayar),0),p=d+h-m;return k.overview.push({title:"Proyeksi Kas Akhir Bulan",color:"positive",data:f(p)}),k.overview});return(d,h)=>{const m=J("in-link");return b(),T(D,null,[a(o(L),{title:"Dashboard"}),a(N,null,{breadcrumbs:e(()=>[a(U,{align:"left"},{default:e(()=>[(b(),T(D,null,F(c,p=>E(a(V,{label:p.label},null,8,["label"]),[[m,p.url]])),64))]),_:1})]),default:e(()=>[a(o(Z),{overview:y.value},null,8,["overview"]),x("div",oe,[x("div",re,[x("div",se,[a(o(Y),{rows:d.proyek,options:d.options},null,8,["rows","options"])]),x("div",ie,[a(o(ee),{rows:d.sisaDanaRekening},null,8,["rows"])]),x("div",ue,[a(o(le),{rows:d.proyeksiKebutuhanDanaProyek},null,8,["rows"])]),x("div",_e,[a(o(ae),{rows:d.proyeksiInvoiceProyek},null,8,["rows"])]),x("div",de,[a(o(ne),{rows:d.proyeksiUtang},null,8,["rows"])]),x("div",ce,[a(o(te),{rows:d.proyeksiPiutang,options:d.options},null,8,["rows","options"])])])])]),_:1})],64)}}});export{xe as default};
