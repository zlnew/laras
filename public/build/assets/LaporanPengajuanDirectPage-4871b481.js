import{l as R,b as E,_ as V,c as S}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-b69e3ed2.js";import{d as F,l as A,j as b,m as J,o as p,e as v,a,w as n,g as M,c as D,u as t,O as c,h as u,B as T,b as o,F as P,k as N,t as d,i as m,A as z,n as I,Z as K,p as Z}from"./app-a9c22e82.js";import{Q as y}from"./datetime-dc60c162.js";import{a as B,b as i,c as G,d as H}from"./QTable-0e41b0f2.js";import{Q as U,_ as W}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-29a71a0e.js";import{c as X,e as Y,t as ee}from"./pdf-4d5b7e28.js";import{u as ae}from"./use-quasar-954ed4d5.js";import{t as O,a as x}from"./money-915f7772.js";import{b as ne}from"./LaporanPengajuanProyekSearchDialog.vue_vue_type_script_setup_true_lang-e918f65f.js";import"./QImg-b742b038.js";import"./use-dialog-plugin-component-646efe56.js";import"./QForm-332245d0.js";import"./options-4b88285e.js";const te={class:"q-pa-md"},le={class:"q-gutter-sm"},re=F({__name:"LaporanPengajuanDirectTable",props:{rows:{},formOptions:{}},setup($){const f=$,g=A(()=>f.rows.map(l=>{const r=l.status_pengajuan==="400"?"Closed":"Open";return{...l,status:r}})),w=ae();function h(l){w.dialog({component:W,componentProps:{proyek:l}})}function _(){w.dialog({component:ne,componentProps:{options:f.formOptions}})}const L=[{name:"index",label:"#",field:"index"},{name:"nama_proyek",label:"Nama Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"tahun_anggaran",label:"Tahun Anggaran",field:"tahun_anggaran",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jenis_transaksi",label:"Jenis Transaksi",field:"jenis_transaksi",align:"left",sortable:!0},{name:"nilai_pengajuan",label:"Nilai Pengajuan Dana",field:"nilai_pengajuan",align:"right",sortable:!0},{name:"jumlah_disetujui",label:"Disetujui",field:"jumlah_disetujui",align:"right",sortable:!0},{name:"status",label:"Status",field:"status_pengajuan",align:"left",sortable:!0}],k=b(!1);function q(){k.value=!k.value}const j=b(),C=b(),Q=b();return J(()=>{var l,r,e;C.value={columns:(l=j.value)==null?void 0:l.columns,body:{rows:(r=j.value)==null?void 0:r.computedRows,props:["index","nama_proyek","tahun_anggaran","keperluan","jenis_transaksi","nilai_pengajuan","jumlah_disetujui","status"]}},Q.value=X({rows:(e=j.value)==null?void 0:e.computedRows,props:["nama_proyek","tahun_anggaran","keperluan","jenis_transaksi","nilai_pengajuan","jumlah_disetujui","status"]})}),(l,r)=>(p(),v("div",te,[a(t(G),{ref_key:"table",ref:j,flat:"",bordered:"","row-key":"id_rab",title:"Laporan Pengajuan Direct",rows:g.value,columns:L,"rows-per-page-options":[10,15,20,25,50,0],fullscreen:k.value},{"top-right":n(()=>[M("div",le,[Object.keys(l.$page.props.query).length?(p(),D(u,{key:0,flat:"","no-caps":"",label:"Clear Filter",icon:"clear",color:"secondary",onClick:r[0]||(r[0]=e=>t(c).visit(l.route("laporan.pengajuan_direct")))})):T("",!0),a(u,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:_}),a(u,{flat:"",dense:"",label:"xls",color:"green",onClick:r[1]||(r[1]=e=>t(Y)().exportDataFromJSON({data:Q.value,name:"pengajuan-dana",type:"xls"}))},{default:n(()=>[a(y,null,{default:n(()=>[o("Export to xls")]),_:1})]),_:1}),a(u,{flat:"",dense:"",label:"pdf",color:"red-8",onClick:r[2]||(r[2]=e=>t(ee)({filename:"pengajuan_dana",header:"Pengajuan Dana",columns:C.value.columns,body:C.value.body}))},{default:n(()=>[a(y,null,{default:n(()=>[o("Export to pdf")]),_:1})]),_:1}),a(u,{flat:"",dense:"",icon:k.value?"fullscreen_exit":"fullscreen",onClick:q,class:"q-ml-md"},null,8,["icon"])])]),header:n(e=>[a(B,{props:e},{default:n(()=>[(p(!0),v(P,null,N(e.cols,s=>(p(),D(H,{key:s.name,props:e,style:{"font-weight":"bold"}},{default:n(()=>[o(d(s.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:n(e=>[a(B,{props:e},{default:n(()=>[a(i,{key:"index",props:e},{default:n(()=>[o(d(++e.rowIndex),1)]),_:2},1032,["props"]),a(i,{key:"nama_proyek",props:e},{default:n(()=>[a(u,{flat:"","no-caps":"",dense:"",color:"primary",ripple:!1,label:e.row.nama_proyek,onClick:s=>h(e.row)},{default:n(()=>[a(y,{anchor:"bottom middle",self:"top middle"},{default:n(()=>[o(" Lihat Detail ")]),_:1})]),_:2},1032,["label","onClick"])]),_:2},1032,["props"]),a(i,{key:"tahun_anggaran",props:e,onClick:m(s=>t(c).visit(l.route("detail_pengajuan_dana_direct",e.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:n(()=>[o(d(e.row.tahun_anggaran),1)]),_:2},1032,["props","onClick"]),a(i,{key:"keperluan",props:e,onClick:m(s=>t(c).visit(l.route("detail_pengajuan_dana_direct",e.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:n(()=>[o(d(e.row.keperluan),1)]),_:2},1032,["props","onClick"]),a(i,{key:"jenis_transaksi",props:e,onClick:m(s=>t(c).visit(l.route("detail_pengajuan_dana_direct",e.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:n(()=>[o(d(e.row.jenis_transaksi),1)]),_:2},1032,["props","onClick"]),a(i,{key:"nilai_pengajuan",props:e,onClick:m(s=>t(c).visit(l.route("detail_pengajuan_dana_direct",e.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:n(()=>[o(d(t(O)(t(x)(e.row.nilai_pengajuan))),1)]),_:2},1032,["props","onClick"]),a(i,{key:"jumlah_disetujui",props:e,onClick:m(s=>t(c).visit(l.route("detail_pengajuan_dana_direct",e.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:n(()=>[o(d(t(O)(t(x)(e.row.jumlah_disetujui))),1)]),_:2},1032,["props","onClick"]),a(i,{key:"status",props:e},{default:n(()=>[t(R)(e.row.status_aktivitas)?(p(),D(u,{key:0,flat:"",dense:"",round:"",color:"grey-6",icon:"warning",size:"sm"},{default:n(()=>[a(y,null,{default:n(()=>[o("Ditolak")]),_:1})]),_:1})):T("",!0),a(t(z),{href:l.route("detail_pengajuan_dana_direct",e.row.id_pengajuan_dana)},{default:n(()=>[a(U,{color:e.row.status_pengajuan==400?"red":"primary",label:e.row.status_pengajuan==400?"Closed":"Open"},null,8,["color","label"])]),_:2},1032,["href"])]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows","fullscreen"])]))}}),be=F({__name:"LaporanPengajuanDirectPage",props:{pengajuanDana:{},formOptions:{}},setup($){const f=[{label:"Reports",url:"#"},{label:"Pengajuan Direct",url:"#"}];return(g,w)=>{const h=I("in-link");return p(),v(P,null,[a(t(K),{title:"Laporan Pengajuan Direct"}),a(V,null,{breadcrumbs:n(()=>[a(E,{align:"left"},{default:n(()=>[(p(),v(P,null,N(f,_=>Z(a(S,{key:_.label,label:_.label},null,8,["label"]),[[h,_.url]])),64))]),_:1})]),default:n(()=>[a(t(re),{rows:g.pengajuanDana,"form-options":g.formOptions},null,8,["rows","form-options"])]),_:1})],64)}}});export{be as default};