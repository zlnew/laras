import{i as W,d as $,e as J,b as X,h as Y,_ as aa,c as ea}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{d as T,l as M,j as q,o as f,c as C,C as na,w as e,a,b as d,t as c,u as l,y as ta,Q as A,h as P,e as S,k as z,F as B,i as F,O as la,T as R,p as ra,q as I,s as U,g as v,v as oa,A as E,x as O,E as ia,m as sa,Z as ua,n as da}from"./app-794bfe05.js";import{Q as ca,a as K,b as ma,c as N,_ as pa}from"./FileDeleteDialog.vue_vue_type_script_setup_true_lang-2c9c1f60.js";import{f as _a}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-88e8d317.js";import{b as r,a as x,c as fa,d as ba}from"./QTable-08481d58.js";import{Q as Z}from"./QTooltip-1b7cd048.js";import{Q as ya}from"./QPopupEdit-6301a0b3.js";import{u as L}from"./use-quasar-1e1c8a18.js";import{a as g,t as h}from"./money-3074a8fc.js";import{u as H,Q as ga}from"./use-dialog-plugin-component-24b3795d.js";import{Q as ha}from"./QForm-95ef4f4f.js";import{Q as G,_ as ka}from"./ModuleTopSection.vue_vue_type_script_setup_true_lang-447a80a2.js";import{Q as V,a as va}from"./QFab-b5296b6e.js";import"./QImg-766bfd11.js";import"./QFile-75288e28.js";import"./options-4b88285e.js";const Da={key:0,class:"text-primary",style:{cursor:"pointer"}},ja={key:1},wa=T({__name:"PencairanDanaItemTable",props:{rows:{},data:{}},setup(D){const p=D,m=M(()=>p.rows.map(t=>{t.pembayaran_lalu="0",t.pembayaran_saat_ini="0",p.data.detailPencairanDana&&p.data.detailPencairanDana.map(s=>{s.id_detail_pengajuan_dana==t.id_detail_pengajuan_dana&&(s.status_pembayaran==="100"&&(t.pembayaran_saat_ini=(g(t.pembayaran_saat_ini)+g(s.jumlah_pencairan)).toString()),s.status_pembayaran==="400"&&(t.pembayaran_lalu=(g(t.pembayaran_lalu)+g(s.jumlah_pencairan)).toString()))});const j=g(t.pembayaran_lalu)+g(t.pembayaran_saat_ini),n=g(t.jumlah_pengajuan)-j;return{...t,belum_dibayarkan:n}})),u=M(()=>{const t=p.rows.reduce((y,Q)=>y+g(Q.jumlah_pengajuan),0),j=m.value.reduce((y,Q)=>y+g(Q.pembayaran_lalu),0),n=m.value.reduce((y,Q)=>y+g(Q.pembayaran_saat_ini),0),s=m.value.reduce((y,Q)=>y+Q.belum_dibayarkan,0);return{pengajuan:t,pembayaranLalu:j,pembayaranSaatIni:n,belumDibayarkan:s}}),o=L(),b=[{name:"index",label:"#",field:"index"},{name:"uraian",label:"Uraian",field:"uraian",align:"left",sortable:!0},{name:"pos",label:"POS",field:"pos",align:"left",sortable:!0},{name:"jenis_pembayaran",label:"Jenis Pembayaran",field:"jenis_pembayaran",align:"left",sortable:!0},{name:"bank",label:"Bank",field:"nama_bank",align:"left",sortable:!0},{name:"rekening",label:"Rekening",field:"nomor_rekening",align:"left",sortable:!0},{name:"jumlah",label:"Jumlah Pengajuan",field:"jumlah_pengajuan",align:"right",sortable:!0},{name:"pembayaran_lalu",label:"Pembayaran Lalu",field:"",align:"right",sortable:!0},{name:"pembayaran_saat_ini",label:"Pembayaran Saat Ini",field:"",align:"right",sortable:!0},{name:"belum_dibayarkan",label:"Belum Dibayarkan",field:"",align:"right",sortable:!0}],i=q(!1);function _(){i.value=!i.value}const w=q("");function k(t,j){const n={id_detail_pengajuan_dana:j,jumlah_pencairan:g(t)};la.post(route("detail_pencairan_dana.store",p.data.pencairanDana.id_pencairan_dana),n,{onSuccess:s=>{o.notify({type:"positive",message:s.props.flash.success,position:"top"})}})}return(t,j)=>(f(),C(fa,{flat:"",bordered:"","row-key":"id_detail_pengajuan_dana",title:"Pencairan Dana",rows:m.value,columns:b,"rows-per-page-options":[10,15,20,25,50,0],fullscreen:i.value,filter:w.value,class:"no-border"},na({"top-right":e(()=>[a(A,{dense:"",debounce:"300",modelValue:w.value,"onUpdate:modelValue":j[0]||(j[0]=n=>w.value=n),placeholder:"Search"},{append:e(()=>[a(ta,{name:"search"})]),_:1},8,["modelValue"]),a(P,{flat:"",dense:"",icon:i.value?"fullscreen_exit":"fullscreen",onClick:_,class:"q-ml-md"},null,8,["icon"])]),header:e(n=>[a(x,{props:n},{default:e(()=>[(f(!0),S(B,null,z(n.cols,s=>(f(),C(ba,{key:s.name,props:n,style:{"font-weight":"bold"}},{default:e(()=>[d(c(s.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:e(n=>[a(x,{props:n},{default:e(()=>[a(r,{key:"index",props:n},{default:e(()=>[d(c(++n.rowIndex),1)]),_:2},1032,["props"]),a(r,{key:"uraian",props:n},{default:e(()=>[d(c(n.row.uraian),1)]),_:2},1032,["props"]),a(r,{key:"pos",props:n},{default:e(()=>[d(c(n.row.pos),1)]),_:2},1032,["props"]),a(r,{key:"jenis_pembayaran",props:n},{default:e(()=>[d(c(n.row.jenis_pembayaran),1)]),_:2},1032,["props"]),a(r,{key:"bank",props:n},{default:e(()=>[d(c(n.row.nama_bank),1)]),_:2},1032,["props"]),a(r,{key:"rekening",props:n},{default:e(()=>[d(c(n.row.nomor_rekening)+" - "+c(n.row.nama_rekening),1)]),_:2},1032,["props"]),a(r,{key:"jumlah",props:n},{default:e(()=>[d(c(l(h)(n.row.jumlah_pengajuan)),1)]),_:2},1032,["props"]),a(r,{key:"pembayaran_lalu",props:n},{default:e(()=>[d(c(l(h)(n.row.pembayaran_lalu)),1)]),_:2},1032,["props"]),a(r,{key:"pembayaran_saat_ini",props:n},{default:e(()=>[l(W)()||l($)("create & modify pencairan dana")&&l(J)(t.data.pencairanDana)?(f(),S("div",Da,[d(c(l(h)(n.row.pembayaran_saat_ini))+" ",1),a(Z,null,{default:e(()=>[d("Click to edit")]),_:1}),a(ya,{modelValue:n.row.pembayaran_saat_ini,"onUpdate:modelValue":s=>n.row.pembayaran_saat_ini=s,modelModifiers:{number:!0},title:"Pembayaran Saat Ini"},{default:e(s=>[a(A,{dense:"",autofocus:"",modelValue:s.value,"onUpdate:modelValue":y=>s.value=y,hint:l(h)(s.value)},{after:e(()=>[a(P,{flat:"",dense:"",color:"negative",icon:"cancel",onClick:F(s.cancel,["stop","prevent"])},null,8,["onClick"]),a(P,{flat:"",dense:"",color:"positive",icon:"check_circle",disable:s.validate(s.value)===!1||s.initialValue===s.value,onClick:[F(y=>k(s.value,n.row.id_detail_pengajuan_dana),["stop","prevent"]),s.set]},null,8,["disable","onClick"])]),_:2},1032,["modelValue","onUpdate:modelValue","hint"])]),_:2},1032,["modelValue","onUpdate:modelValue"])])):(f(),S("div",ja,c(l(h)(n.row.pembayaran_saat_ini)),1))]),_:2},1032,["props"]),a(r,{key:"belum_dibayarkan",props:n},{default:e(()=>[d(c(l(h)(n.row.belum_dibayarkan)),1)]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:2},[m.value.length?{name:"bottom-row",fn:e(()=>[a(x,{"no-hover":""},{default:e(()=>[a(r,{colspan:"5",style:{border:"none"}}),a(r,{class:"text-right"},{default:e(()=>[d(" Total Pengajuan ")]),_:1}),a(r,{class:"text-right text-weight-bold"},{default:e(()=>[d(c(l(h)(u.value.pengajuan)),1)]),_:1}),a(r,{style:{border:"none"}})]),_:1}),a(x,{"no-hover":""},{default:e(()=>[a(r,{colspan:"5",style:{border:"none"}}),a(r,{class:"text-right"},{default:e(()=>[d(" Total Pembayaran Lalu ")]),_:1}),a(r,{class:"text-right text-weight-bold"},{default:e(()=>[d(c(l(h)(u.value.pembayaranLalu)),1)]),_:1}),a(r,{style:{border:"none"}})]),_:1}),a(x,{"no-hover":""},{default:e(()=>[a(r,{colspan:"5",style:{border:"none"}}),a(r,{class:"text-right"},{default:e(()=>[d(" Total Pembayaran Saat Ini ")]),_:1}),a(r,{class:"text-right text-weight-bold"},{default:e(()=>[d(c(l(h)(u.value.pembayaranSaatIni)),1)]),_:1}),a(r,{style:{border:"none"}})]),_:1}),a(x,{"no-hover":""},{default:e(()=>[a(r,{colspan:"5",style:{border:"none"}}),a(r,{class:"text-right"},{default:e(()=>[d(" Total Belum Dibayarkan ")]),_:1}),a(r,{class:"text-right text-weight-bold"},{default:e(()=>[d(c(l(h)(u.value.belumDibayarkan)),1)]),_:1}),a(r,{style:{border:"none"}})]),_:1})]),key:"0"}:void 0]),1032,["rows","fullscreen","filter"]))}}),Pa=v("div",{class:"text-h6"},"Pencairan Dana",-1),Ca={class:"q-gutter-md"};[...H.emits];const Qa=T({__name:"PencairanDanaSubmissionForm",props:{data:{}},setup(D){const p=D,m=L(),u=R({catatan:""});function o(){u.post(route("pencairan_dana.submit",p.data.id_pencairan_dana),{onSuccess:i=>{m.notify({type:"positive",message:i.props.flash.success,position:"top"})}})}function b(){m.dialog({title:"Submission Confirmation",message:"Are you sure want to submit this data?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"primary",cancel:!0,persistent:!0}).onOk(i=>{u.catatan=i,o()})}return(i,_)=>(f(),C(G,{position:"bottom-right",offset:[18,18]},{default:e(()=>[a(P,{rounded:"",color:"primary",label:"Submit","icon-right":"check",onClick:b,class:"q-pa-md"},{default:e(()=>[a(Z,null,{default:e(()=>[d("Click to submit")]),_:1})]),_:1})]),_:1}))}}),xa=T({__name:"PencairanDanaApprovalForm",props:{data:{}},setup(D){const p=D,m=L(),u=R({catatan:""});function o(){u.post(route("pencairan_dana.confirm",p.data.id_pencairan_dana),{onSuccess:t=>{m.notify({type:"positive",message:t.props.flash.success,position:"top"})}})}function b(){u.transform(t=>({...t,bertahap:!0})).post(route("pencairan_dana.confirm",p.data.id_pencairan_dana),{onSuccess:t=>{m.notify({type:"positive",message:t.props.flash.success,position:"top"})}})}function i(){u.post(route("pencairan_dana.reject",p.data.id_pencairan_dana),{onSuccess:t=>{m.notify({type:"positive",message:t.props.flash.success,position:"top"})}})}function _(){m.dialog({title:"Receipt Confirmation",message:"Are you sure want to perform this action?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"positive",cancel:!0,persistent:!0}).onOk(t=>{u.catatan=t,o()})}function w(){m.dialog({title:"Receipt Confirmation",message:"Are you sure want to perform this action?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"secondary",cancel:!0,persistent:!0}).onOk(t=>{u.catatan=t,b()})}function k(){m.dialog({title:"Rejection Confirmation",message:"Are you sure want to perform this action?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"negative",cancel:!0,persistent:!0}).onOk(t=>{u.catatan=t,i()})}return(t,j)=>(f(),C(G,{position:"bottom-right",offset:[18,18]},{default:e(()=>[a(va,{color:"primary",icon:"keyboard_arrow_left",direction:"left"},{label:e(({opened:n})=>[v("div",{class:ia({"example-fab-animate--hover":n!==!0})},c(n!==!0?"Konfirmasi Penerimaan":"Close"),3)]),default:e(()=>[a(V,{color:"green",label:"Terima Lunas",icon:"check",onClick:_}),a(V,{color:"secondary",label:"Terima Bertahap",icon:"check",onClick:w}),a(V,{color:"red",label:"Tolak",icon:"clear",onClick:k})]),_:1})]),_:1}))}}),Sa={class:"q-px-md q-pt-md"},Ta={class:"row"},Va=v("div",{class:"col-4 text-caption"}," Keperluan ",-1),$a={class:"col-8 text-subtitle2"},qa=v("div",{class:"col-4 text-caption"}," Tanggal Pengajuan ",-1),Aa={class:"col-8 text-subtitle2"},Ba={class:"q-px-md q-pt-md"},Xa=T({__name:"DetailPencairanDanaPage",props:{pencairanDana:{},pengajuanDana:{},detailPencairanDana:{},detailPengajuanDana:{},dokumenPenunjang:{},timeline:{}},setup(D){const p=D,m=[{label:"Keuangan",url:"#"},{label:"Pencairan Dana",url:route("pencairan_dana")},{label:p.pencairanDana.nama_proyek,url:"#"}],u=q("uraian");return(o,b)=>{const i=sa("in-link");return f(),S(B,null,[a(l(ua),{title:"Pencairan Dana"}),a(aa,null,{breadcrumbs:e(()=>[a(X,{align:"left"},{default:e(()=>[(f(),S(B,null,z(m,_=>da(a(ea,{key:_.label,label:_.label},null,8,["label"]),[[i,_.url]])),64))]),_:1})]),default:e(()=>[a(ka,{title:"Pencairan Dana","timeline-title":"Timeline Pencairan Dana",data:{proyek:o.pencairanDana,status:o.pencairanDana.status_pencairan,timeline:o.timeline}},null,8,["data"]),v("div",Sa,[a(O,{flat:"",bordered:"",style:{"max-width":"500px"}},{default:e(()=>[a(I,null,{default:e(()=>[v("div",Ta,[Va,v("div",$a," : "+c(o.pengajuanDana.keperluan),1),qa,v("div",Aa," : "+c(l(_a)(o.pengajuanDana.tanggal_pengajuan)||"-"),1)])]),_:1})]),_:1})]),v("div",Ba,[a(O,{flat:"",bordered:""},{default:e(()=>[a(ca,{modelValue:u.value,"onUpdate:modelValue":b[0]||(b[0]=_=>u.value=_),class:"text-grey","active-color":"primary","indicator-color":"primary",align:"justify","narrow-indicator":""},{default:e(()=>[a(K,{"no-caps":"",name:"uraian",label:"Uraian"}),a(K,{"no-caps":"",name:"dokumen",label:"Dokumen Penunjang"})]),_:1},8,["modelValue"]),a(U),a(ma,{modelValue:u.value,"onUpdate:modelValue":b[1]||(b[1]=_=>u.value=_)},{default:e(()=>[a(N,{class:"q-pa-none",name:"uraian"},{default:e(()=>[a(l(wa),{rows:o.detailPengajuanDana,data:{pencairanDana:o.pencairanDana,pengajuanDana:o.pengajuanDana,detailPencairanDana:o.detailPencairanDana}},null,8,["rows","data"])]),_:1}),a(N,{class:"q-pa-none",name:"dokumen"},{default:e(()=>[a(l(pa),{rows:o.dokumenPenunjang,data:{model_id:o.pencairanDana.id_pencairan_dana,permissions:"create & modify pencairan dana",status_aktivitas:o.pencairanDana.status_aktivitas}},null,8,["rows","data"])]),_:1})]),_:1},8,["modelValue"])]),_:1})]),l($)("create & modify pencairan dana")&&l(J)(o.pencairanDana)&&o.detailPencairanDana.length?(f(),C(l(Qa),{key:0,data:{id_pencairan_dana:o.pencairanDana.id_pencairan_dana}},null,8,["data"])):E("",!0),l($)("confirm pencairan dana")&&l(Y)(o.pencairanDana)?(f(),C(l(xa),{key:1,data:{id_pencairan_dana:o.pencairanDana.id_pencairan_dana}},null,8,["data"])):E("",!0)]),_:1})],64)}}});export{Xa as default};
