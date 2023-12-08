import{d as D,l as E,i as L,m as N,f as S,g as I,Q as P,a as Q,b as M,_ as V,c as K}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-b69e3ed2.js";import{d as T,j as R,o as r,e as g,a,w as e,u as o,c as p,h as c,O as y,B as $,F as h,k as B,b as s,t as m,i as j,A as z,v as J,n as Z,Z as G,p as H}from"./app-a9c22e82.js";import{a as O,b as d,c as U,d as W}from"./QTable-0e41b0f2.js";import{Q as w}from"./datetime-dc60c162.js";import{Q as X,_ as Y}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-29a71a0e.js";import{u as ee}from"./use-quasar-954ed4d5.js";import{_ as ae,a as ne,b as te,c as oe}from"./PengajuanDanaDeleteDialog.vue_vue_type_script_setup_true_lang-f1609c38.js";import"./QImg-b742b038.js";import"./use-dialog-plugin-component-646efe56.js";import"./money-915f7772.js";import"./QForm-332245d0.js";import"./options-4b88285e.js";const le={class:"q-pa-md"},re={key:1,class:"text-h6"},se=T({__name:"PengajuanDirectTable",props:{rows:{},formOptions:{}},setup(v){const _=v,l=ee();function C(t){l.dialog({component:Y,componentProps:{proyek:t}})}function b(){l.dialog({component:ae,componentProps:{options:_.formOptions}})}function f(){l.dialog({component:ne,componentProps:{options:_.formOptions}}).onOk(t=>{l.notify({type:t.type,message:t.message,position:"top"})})}function q(t){l.dialog({component:te,componentProps:{pengajuanDana:t,options:_.formOptions}}).onOk(i=>{l.notify({type:i.type,message:i.message,position:"top"})})}function F(t){l.dialog({component:oe,componentProps:{id_pengajuan_dana:t}}).onOk(i=>{l.notify({type:i.type,message:i.message,position:"top"})})}const x=[{name:"index",label:"#",field:"index"},{name:"nama_proyek",label:"Nama Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"tahun_anggaran",label:"Tahun Anggaran",field:"tahun_anggaran",align:"left",sortable:!0},{name:"keperluan",label:"Keperluan",field:"keperluan",align:"left",sortable:!0},{name:"jenis_transaksi",label:"Jenis Transaksi",field:"jenis_transaksi",align:"left",sortable:!0},{name:"status_pengajuan",label:"Status",field:"status_pengajuan",align:"left",sortable:!0},{name:"actions",label:"Actions",field:"",align:"left"}],k=R(!1);function A(){k.value=!k.value}return(t,i)=>(r(),g("div",le,[a(U,{flat:"",bordered:"","row-key":"id_rap",rows:t.rows,columns:x,"rows-per-page-options":[10,15,20,25,50,0],fullscreen:k.value},{"top-left":e(()=>[o(D)("create & modify pengajuan dana")?(r(),p(c,{key:0,"no-caps":"",label:"Tambah Pengajuan Direct",icon:"add",color:"primary",onClick:f})):(r(),g("div",re,"List Pengajuan Dana"))]),"top-right":e(()=>[Object.keys(t.$page.props.query).length?(r(),p(c,{key:0,flat:"","no-caps":"",label:"Clear Filter",icon:"clear",color:"secondary",onClick:i[0]||(i[0]=n=>o(y).visit(t.route("pengajuan_dana_direct")))})):$("",!0),a(c,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:b}),a(c,{flat:"",dense:"",icon:k.value?"fullscreen_exit":"fullscreen",onClick:A,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(O,{props:n},{default:e(()=>[(r(!0),g(h,null,B(n.cols,u=>(r(),p(W,{key:u.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[s(m(u.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(O,{props:n},{default:e(()=>[a(d,{key:"index",props:n},{default:e(()=>[s(m(++n.rowIndex),1)]),_:2},1032,["props"]),a(d,{key:"nama_proyek",props:n},{default:e(()=>[a(c,{flat:"","no-caps":"",dense:"",color:"primary",ripple:!1,label:n.row.nama_proyek,onClick:u=>C(n.row)},{default:e(()=>[a(w,{anchor:"bottom middle",self:"top middle"},{default:e(()=>[s(" Lihat Detail ")]),_:1})]),_:2},1032,["label","onClick"])]),_:2},1032,["props"]),a(d,{key:"tahun_anggaran",props:n,onClick:j(u=>o(y).visit(t.route("detail_pengajuan_dana_direct",n.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:e(()=>[s(m(n.row.tahun_anggaran),1)]),_:2},1032,["props","onClick"]),a(d,{key:"keperluan",props:n,onClick:j(u=>o(y).visit(t.route("detail_pengajuan_dana_direct",n.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:e(()=>[s(m(n.row.keperluan),1)]),_:2},1032,["props","onClick"]),a(d,{key:"jenis_transaksi",props:n,onClick:j(u=>o(y).visit(t.route("detail_pengajuan_dana_direct",n.row.id_pengajuan_dana)),["prevent"]),style:{cursor:"pointer"}},{default:e(()=>[s(m(n.row.jenis_transaksi),1)]),_:2},1032,["props","onClick"]),a(d,{key:"status_pengajuan",props:n},{default:e(()=>[o(E)(n.row.status_aktivitas)?(r(),p(c,{key:0,flat:"",dense:"",round:"",color:"grey-6",icon:"warning",size:"sm"},{default:e(()=>[a(w,null,{default:e(()=>[s("Ditolak")]),_:1})]),_:1})):$("",!0),a(o(z),{href:t.route("detail_pengajuan_dana_direct",n.row.id_pengajuan_dana)},{default:e(()=>[a(X,{color:n.row.status_pengajuan==400?"red":"primary",label:n.row.status_pengajuan==400?"Closed":"Open"},null,8,["color","label"])]),_:2},1032,["href"])]),_:2},1032,["props"]),a(d,{key:"actions",props:n},{default:e(()=>[o(L)()||o(D)("create & modify pengajuan dana")&&o(N)(n.row.status_pengajuan)?(r(),p(c,{key:0,dense:"",flat:"",color:"blue-grey",icon:"more_vert"},{default:e(()=>[a(S,{"auto-close":"","transition-show":"scale","transition-hide":"scale"},{default:e(()=>[a(I,{dense:"",style:{"min-width":"100px"}},{default:e(()=>[a(P,{clickable:""},{default:e(()=>[a(Q,{onClick:u=>q(n.row)},{default:e(()=>[s(" Edit ")]),_:2},1032,["onClick"])]),_:2},1024),a(J),a(P,{clickable:""},{default:e(()=>[a(Q,{class:"text-red",onClick:u=>F(n.row.id_pengajuan_dana)},{default:e(()=>[s(" Delete ")]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)):(r(),p(c,{key:1,dense:"",flat:"",color:"grey-6",icon:"block"},{default:e(()=>[a(w,null,{default:e(()=>[s("Required permission")]),_:1})]),_:1}))]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows","fullscreen"])]))}}),je=T({__name:"PengajuanDirectPage",props:{pengajuanDana:{},formOptions:{}},setup(v){const _=[{label:"Keuangan",url:"#"},{label:"Pengajuan Direct",url:"#"}];return(l,C)=>{const b=Z("in-link");return r(),g(h,null,[a(o(G),{title:"Pengajuan Direct"}),a(V,null,{breadcrumbs:e(()=>[a(M,{align:"left"},{default:e(()=>[(r(),g(h,null,B(_,f=>H(a(K,{key:f.label,label:f.label},null,8,["label"]),[[b,f.url]])),64))]),_:1})]),default:e(()=>[a(o(se),{rows:l.pengajuanDana,"form-options":l.formOptions},null,8,["rows","form-options"])]),_:1})],64)}}});export{je as default};