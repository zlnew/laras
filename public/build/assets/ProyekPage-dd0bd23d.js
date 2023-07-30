import{b as q,c as F,d as h,e as P,Q as N,_ as S,a as x}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-da018ec7.js";import{d as $,t as E,o as c,e as g,a as e,w as l,h as p,c as Q,u as f,ac as L,z as M,F as y,p as O,b as n,x as i,k as V,n as A,Z as H,q as I}from"./app-71b10028.js";import{u as J,Q as v,a as r,b as z,c as K}from"./use-dialog-plugin-component-d7386d46.js";import{Q as R,t as Z,f as C,a as G,_ as U,b as W,c as X,d as Y,e as ee}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-7ccad254.js";import"./QImg-8a570513.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./QForm-04ce2fd3.js";import"./options-964f32b0.js";const ae={class:"q-pa-md"},le=$({__name:"ProyekTable",props:{rows:{},formOptions:{}},setup(b){const u=b,t=J();function w(o){t.dialog({component:U,componentProps:{proyek:o}})}function k(){t.dialog({component:W,componentProps:{rows:u.rows,options:u.formOptions}})}function m(){t.dialog({component:X,componentProps:{options:u.formOptions}}).onOk(o=>{t.notify({type:o.type,message:o.message,position:"top"})})}function T(o){t.dialog({component:Y,componentProps:{proyek:o,options:u.formOptions}}).onOk(s=>{t.notify({type:s.type,message:s.message,position:"top"})})}function j(o){t.dialog({component:ee,componentProps:{id_proyek:o}}).onOk(s=>{t.notify({type:s.type,message:s.message,position:"top"})})}const B=[{name:"nama_proyek",label:"Nama Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"pengguna_jasa",label:"Pengguna Jasa",field:"pengguna_jasa",align:"left",sortable:!0},{name:"penyedia_jasa",label:"Penyedia Jasa",field:"penyedia_jasa",align:"left",sortable:!0},{name:"tahun_anggaran",label:"Tahun Anggaran",field:"tahun_anggaran",align:"left",sortable:!0},{name:"nilai_kontrak",label:"Nilai Kontrak",field:"nilai_kontrak",align:"right",sortable:!0},{name:"tanggal_mulai",label:"Tanggal Mulai",field:"tanggal_mulai",align:"left",sortable:!0},{name:"durasi",label:"Durasi (Hari)",field:"durasi",align:"left",sortable:!0},{name:"tanggal_selesai",label:"Tanggal Selesai",field:"tanggal_selesai",align:"left",sortable:!0},{name:"status_proyek",label:"Status",field:"status_proyek",align:"left",sortable:!0},{name:"actions",label:"Actions",field:"",align:"left"}],_=E(!1);function D(){_.value=!_.value}return(o,s)=>(c(),g("div",ae,[e(z,{flat:"",bordered:"","row-key":"nama_proyek",rows:o.rows,columns:B,"rows-per-page-options":[5,10,15,20,25,50,0],fullscreen:_.value},{"top-left":l(()=>[e(p,{"no-caps":"",label:"Proyek Baru",icon:"add",color:"primary",onClick:m})]),"top-right":l(()=>[Object.keys(o.$page.props.query).length?(c(),Q(p,{key:0,flat:"","no-caps":"",label:"Clear Filter",icon:"clear",color:"secondary",onClick:s[0]||(s[0]=a=>f(L).visit(o.route("proyek")))})):M("",!0),e(p,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:k}),e(p,{flat:"",dense:"",icon:_.value?"fullscreen_exit":"fullscreen",onClick:D,class:"q-ml-md"},null,8,["icon"])]),header:l(a=>[e(v,{props:a},{default:l(()=>[(c(!0),g(y,null,O(a.cols,d=>(c(),Q(K,{key:d.name,props:a,style:{"font-weight":"bold"}},{default:l(()=>[n(i(d.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:l(a=>[e(v,{props:a},{default:l(()=>[e(r,{key:"nama_proyek",props:a},{default:l(()=>[e(p,{flat:"","no-caps":"",dense:"",color:"primary",ripple:!1,label:a.row.nama_proyek,onClick:d=>w(a.row)},{default:l(()=>[e(R,{anchor:"bottom middle",self:"top middle"},{default:l(()=>[n(" Lihat Detail ")]),_:1})]),_:2},1032,["label","onClick"])]),_:2},1032,["props"]),e(r,{key:"pengguna_jasa",props:a},{default:l(()=>[n(i(a.row.pengguna_jasa),1)]),_:2},1032,["props"]),e(r,{key:"penyedia_jasa",props:a},{default:l(()=>[n(i(a.row.penyedia_jasa),1)]),_:2},1032,["props"]),e(r,{key:"tahun_anggaran",props:a},{default:l(()=>[n(i(a.row.tahun_anggaran),1)]),_:2},1032,["props"]),e(r,{key:"nilai_kontrak",props:a},{default:l(()=>[n(i(f(Z)(a.row.nilai_kontrak)),1)]),_:2},1032,["props"]),e(r,{key:"tanggal_mulai",props:a},{default:l(()=>[n(i(f(C)(a.row.tanggal_mulai)),1)]),_:2},1032,["props"]),e(r,{key:"durasi",props:a},{default:l(()=>[n(i(a.row.durasi)+" Hari ",1)]),_:2},1032,["props"]),e(r,{key:"tanggal_selesai",props:a},{default:l(()=>[n(i(f(C)(a.row.tanggal_selesai)),1)]),_:2},1032,["props"]),e(r,{key:"status_proyek",props:a},{default:l(()=>[e(G,{color:a.row.status_proyek==400?"red":"primary",label:a.row.status_proyek==400?"Closed":"On Progress"},null,8,["color","label"])]),_:2},1032,["props"]),e(r,{key:"actions",props:a},{default:l(()=>[e(p,{dense:"",flat:"",color:"blue-grey",icon:"more_vert"},{default:l(()=>[e(q,{"auto-close":"","transition-show":"scale","transition-hide":"scale"},{default:l(()=>[e(F,{dense:"",style:{"min-width":"100px"}},{default:l(()=>[e(h,{clickable:""},{default:l(()=>[e(P,{onClick:d=>T(a.row)},{default:l(()=>[n(" Edit ")]),_:2},1032,["onClick"])]),_:2},1024),e(V),e(h,{clickable:""},{default:l(()=>[e(P,{class:"text-red",onClick:d=>j(a.row.id_proyek)},{default:l(()=>[n(" Delete ")]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows","fullscreen"])]))}}),ce=$({__name:"ProyekPage",props:{proyek:{},formOptions:{}},setup(b){const u=[{label:"Main",url:"#"},{label:"Proyek",url:"#"}];return(t,w)=>{const k=A("in-link");return c(),g(y,null,[e(f(H),{title:"Proyek"}),e(S,null,{breadcrumbs:l(()=>[e(N,{align:"left"},{default:l(()=>[(c(),g(y,null,O(u,m=>I(e(x,{label:m.label},null,8,["label"]),[[k,m.url]])),64))]),_:1})]),default:l(()=>[e(f(le),{rows:t.proyek,"form-options":t.formOptions},null,8,["rows","form-options"])]),_:1})],64)}}});export{ce as default};