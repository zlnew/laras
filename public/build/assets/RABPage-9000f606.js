import{d as J,l as ee,i as oe,m as ae,f as te,g as le,Q as $,a as R,b as re,_ as ne,c as se}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{d as B,j as F,o as _,e as A,a as e,w as o,u as t,c as g,h as u,O as ie,A as O,F as K,k as Y,b as m,t as b,z as ue,s as x,K as de,T as E,p as H,q as Q,i as M,g as h,N as S,P as V,f as pe,v as j,x as T,W as ce,D as me,m as _e,Z as fe,n as ge}from"./app-794bfe05.js";import{a as W,b as P,c as be,d as ye,Q as q}from"./QTable-08481d58.js";import{Q as U}from"./QTooltip-1b7cd048.js";import{Q as Z,_ as ke}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-88e8d317.js";import{u as he}from"./use-quasar-1e1c8a18.js";import{u as D,Q as z}from"./use-dialog-plugin-component-24b3795d.js";import{Q as L}from"./QForm-95ef4f4f.js";import{m as I}from"./options-4b88285e.js";import"./QImg-766bfd11.js";import"./money-3074a8fc.js";const ve={class:"q-pa-md"},we={key:1,class:"text-h6"},Ce=B({__name:"RABTable",props:{rows:{},formOptions:{}},setup(v){const n=v,d=he();function w(r){d.dialog({component:ke,componentProps:{proyek:r}})}function y(){d.dialog({component:Qe,componentProps:{options:n.formOptions}})}function f(){d.dialog({component:Ae,componentProps:{options:n.formOptions}}).onOk(r=>{d.notify({type:r.type,message:r.message,position:"top"})})}function k(r){d.dialog({component:qe,componentProps:{rab:r,options:n.formOptions}}).onOk(l=>{d.notify({type:l.type,message:l.message,position:"top"})})}function C(r){d.dialog({component:He,componentProps:{id_rab:r}}).onOk(l=>{d.notify({type:l.type,message:l.message,position:"top"})})}const p=[{name:"index",label:"#",field:"index"},{name:"nama_proyek",label:"Nama Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"pengguna_jasa",label:"Pengguna Jasa",field:"pengguna_jasa",align:"left",sortable:!0},{name:"penyedia_jasa",label:"Penyedia Jasa",field:"penyedia_jasa",align:"left",sortable:!0},{name:"tahun_anggaran",label:"Tahun Anggaran",field:"tahun_anggaran",align:"left",sortable:!0},{name:"status_rab",label:"Status",field:"status_rab",align:"left",sortable:!0},{name:"actions",label:"Actions",field:"",align:"left"}],s=F(!1);function c(){s.value=!s.value}return(r,l)=>(_(),A("div",ve,[e(be,{flat:"",bordered:"","row-key":"id_rab",rows:r.rows,columns:p,"rows-per-page-options":[10,15,20,25,50,0],fullscreen:s.value},{"top-left":o(()=>[t(J)("create & modify rab")?(_(),g(u,{key:0,"no-caps":"",label:"Tambah RAB",icon:"add",color:"primary",onClick:f})):(_(),A("div",we,"List RAB"))]),"top-right":o(()=>[Object.keys(r.$page.props.query).length?(_(),g(u,{key:0,flat:"","no-caps":"",label:"Clear Filter",icon:"clear",color:"secondary",onClick:l[0]||(l[0]=a=>t(ie).visit(r.route("rab")))})):O("",!0),e(u,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:y}),e(u,{flat:"",dense:"",icon:s.value?"fullscreen_exit":"fullscreen",onClick:c,class:"q-ml-md"},null,8,["icon"])]),header:o(a=>[e(W,{props:a},{default:o(()=>[(_(!0),A(K,null,Y(a.cols,i=>(_(),g(ye,{key:i.name,props:a,style:{"font-weight":"bold"}},{default:o(()=>[m(b(i.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:o(a=>[e(W,{props:a},{default:o(()=>[e(P,{key:"index",props:a},{default:o(()=>[m(b(++a.rowIndex),1)]),_:2},1032,["props"]),e(P,{key:"nama_proyek",props:a},{default:o(()=>[e(u,{flat:"","no-caps":"",dense:"",color:"primary",ripple:!1,label:a.row.nama_proyek,onClick:i=>w(a.row)},{default:o(()=>[e(U,{anchor:"bottom middle",self:"top middle"},{default:o(()=>[m(" Lihat Detail ")]),_:1})]),_:2},1032,["label","onClick"])]),_:2},1032,["props"]),e(P,{key:"pengguna_jasa",props:a},{default:o(()=>[m(b(a.row.pengguna_jasa),1)]),_:2},1032,["props"]),e(P,{key:"penyedia_jasa",props:a},{default:o(()=>[m(b(a.row.penyedia_jasa),1)]),_:2},1032,["props"]),e(P,{key:"tahun_anggaran",props:a},{default:o(()=>[m(b(a.row.tahun_anggaran),1)]),_:2},1032,["props"]),e(P,{key:"status_rab",props:a},{default:o(()=>[t(ee)(a.row.status_aktivitas)?(_(),g(u,{key:0,flat:"",dense:"",round:"",color:"grey-6",icon:"warning",size:"sm"},{default:o(()=>[e(U,null,{default:o(()=>[m("Ditolak")]),_:1})]),_:1})):O("",!0),e(t(ue),{href:r.route("detail_rab",a.row.id_rab)},{default:o(()=>[e(Z,{color:a.row.status_rab==400?"red":"primary",label:a.row.status_rab==400?"Closed":"Open"},null,8,["color","label"])]),_:2},1032,["href"])]),_:2},1032,["props"]),e(P,{key:"actions",props:a},{default:o(()=>[t(oe)()||t(J)("create & modify rab")&&t(ae)(a.row.status_rab)?(_(),g(u,{key:0,dense:"",flat:"",color:"blue-grey",icon:"more_vert"},{default:o(()=>[e(te,{"auto-close":"","transition-show":"scale","transition-hide":"scale"},{default:o(()=>[e(le,{dense:"",style:{"min-width":"100px"}},{default:o(()=>[e($,{clickable:""},{default:o(()=>[e(R,{onClick:i=>k(a.row)},{default:o(()=>[m(" Edit ")]),_:2},1032,["onClick"])]),_:2},1024),e(x),e($,{clickable:""},{default:o(()=>[e(R,{class:"text-red",onClick:i=>C(a.row.id_rab)},{default:o(()=>[m(" Delete ")]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)):(_(),g(u,{key:1,dense:"",flat:"",color:"grey-6",icon:"block"},{default:o(()=>[e(U,null,{default:o(()=>[m("Required permission")]),_:1})]),_:1}))]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows","fullscreen"])]))}}),Re=h("div",{class:"text-h6"},"Pencarian RAB",-1),$e={class:"q-gutter-md"},xe={class:"text-primary"},Qe=B({__name:"RABSearchDialog",props:{options:{}},emits:[...D.emits],setup(v){const n=v,{dialogRef:d,onDialogOK:w,onDialogCancel:y,onDialogHide:f}=D(),k=F(n.options.currentProyek);function C(l,a){a(()=>{k.value=I(l,n.options.currentProyek,["nama_proyek","tahun_anggaran"])})}const s=de().props.query,c=E({id_proyek:s.id_proyek,status_rab:s.status_rab});function r(){c.get(route("rab"),{onSuccess:()=>{w()}})}return(l,a)=>(_(),g(H,{ref_key:"dialogRef",ref:d,onHide:t(f)},{default:o(()=>[e(T,{style:{width:"700px","max-width":"80vw"}},{default:o(()=>[e(Q,{class:"row items-center q-pb-none"},{default:o(()=>[Re,e(z),e(u,{flat:"",round:"",dense:"",icon:"close",onClick:t(y)},null,8,["onClick"])]),_:1}),e(x),e(L,{onSubmit:M(r,["prevent"])},{default:o(()=>[e(Q,{class:"scroll"},{default:o(()=>[h("div",$e,[e(q,{outlined:"",clearable:"","use-input":"","use-chips":"","emit-value":"","map-options":"",multiple:"","hide-bottom-space":"","input-debounce":"500",label:"Proyek",modelValue:t(c).id_proyek,"onUpdate:modelValue":a[0]||(a[0]=i=>t(c).id_proyek=i),"option-value":"id_proyek","option-label":i=>`${i.nama_proyek} | ${i.tahun_anggaran}`,options:k.value,error:!!t(c).errors.id_proyek,"error-message":t(c).errors.id_proyek,onFilter:C},{option:o(({itemProps:i,opt:N,selected:G,toggleOption:X})=>[e($,S(V(i)),{default:o(()=>[e(R,{side:""},{default:o(()=>[e(pe,{size:"sm","model-value":G,"onUpdate:modelValue":je=>X(N)},null,8,["model-value","onUpdate:modelValue"])]),_:2},1024),e(R,null,{default:o(()=>[h("strong",xe,b(N.nama_proyek),1),m(" "+b(N.tahun_anggaran),1)]),_:2},1024)]),_:2},1040)]),"no-option":o(()=>[e($,null,{default:o(()=>[e(R,{class:"text-grey"},{default:o(()=>[m(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","option-label","options","error","error-message"]),e(q,{outlined:"",clearable:"","fill-input":"",label:"Status RAB",modelValue:t(c).status_rab,"onUpdate:modelValue":a[1]||(a[1]=i=>t(c).status_rab=i),options:[100,400]},{"selected-item":o(i=>[e(Z,{color:i.opt==400?"red":"primary",label:i.opt==400?"Closed":"Open"},null,8,["color","label"])]),option:o(i=>[e($,S(V(i.itemProps)),{default:o(()=>[e(R,null,{default:o(()=>[m(b(i.opt==400?"Closed":"Open"),1)]),_:2},1024)]),_:2},1040)]),_:1},8,["modelValue"])])]),_:1}),e(x),e(j,{align:"right"},{default:o(()=>[e(u,{flat:"",type:"submit",label:"Search",color:"primary",loading:t(c).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),De=h("div",{class:"text-h6"},"Tambah RAB",-1),Pe={class:"q-gutter-md"},Be={class:"text-primary"},Ae=B({__name:"RABCreateDialog",props:{options:{}},emits:[...D.emits],setup(v){const n=v,{dialogRef:d,onDialogOK:w,onDialogCancel:y,onDialogHide:f}=D(),k=F(n.options.proyek);function C(c,r){r(()=>{k.value=I(c,n.options.proyek,["nama_proyek","tahun_anggaran"])})}const p=E({id_proyek:null});function s(){p.post(route("rab.store"),{onSuccess:c=>{w({type:"positive",message:c.props.flash.success})}})}return(c,r)=>(_(),g(H,{ref_key:"dialogRef",ref:d,"no-backdrop-dismiss":!0,onHide:t(f)},{default:o(()=>[e(T,{style:{width:"700px","max-width":"80vw"}},{default:o(()=>[e(Q,{class:"row items-center q-pb-none"},{default:o(()=>[De,e(z),e(u,{flat:"",round:"",dense:"",icon:"close",onClick:t(y)},null,8,["onClick"])]),_:1}),e(x),e(L,{onSubmit:M(s,["prevent"])},{default:o(()=>[e(Q,{class:"scroll"},{default:o(()=>[h("div",Pe,[e(q,{outlined:"","use-input":"","use-chips":"","emit-value":"","map-options":"","hide-bottom-space":"","input-debounce":"500",label:"Pilih Proyek",modelValue:t(p).id_proyek,"onUpdate:modelValue":r[0]||(r[0]=l=>t(p).id_proyek=l),"option-value":"id_proyek","option-label":l=>`${l.nama_proyek} | ${l.tahun_anggaran}`,options:k.value,error:!!t(p).errors.id_proyek,"error-message":t(p).errors.id_proyek,onFilter:C},{option:o(l=>[e($,S(V(l.itemProps)),{default:o(()=>[e(R,null,{default:o(()=>[h("strong",Be,b(l.opt.nama_proyek),1),m(" "+b(l.opt.tahun_anggaran),1)]),_:2},1024)]),_:2},1040)]),"no-option":o(()=>[e($,null,{default:o(()=>[e(R,{class:"text-grey"},{default:o(()=>[m(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","option-label","options","error","error-message"])])]),_:1}),e(x),e(j,{align:"right"},{default:o(()=>[t(p).hasErrors?(_(),g(u,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:r[1]||(r[1]=l=>t(p).clearErrors())})):O("",!0),e(u,{flat:"",label:"Reset",color:"secondary",onClick:r[2]||(r[2]=l=>t(p).reset())}),e(u,{flat:"",type:"submit",label:"Submit",color:"primary",loading:t(p).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),Oe=h("div",{class:"text-h6"},"Edit RAB",-1),Se={class:"q-gutter-md"},Ve={class:"text-primary"},qe=B({__name:"RABEditDialog",props:{rab:{},options:{}},emits:[...D.emits],setup(v){const n=v,{dialogRef:d,onDialogOK:w,onDialogCancel:y,onDialogHide:f}=D(),k={id_proyek:n.rab.id_proyek,nama_proyek:n.rab.nama_proyek,tahun_anggaran:n.rab.tahun_anggaran};ce(()=>{n.options.proyek.push(k)});const C=F(n.options.proyek);function p(r,l){l(()=>{C.value=I(r,n.options.proyek,["nama_proyek","tahun_anggaran"])})}const s=E({id_rab:n.rab.id_rab,id_proyek:n.rab.id_proyek});function c(){s.patch(route("rab.update",n.rab.id_rab),{onSuccess:r=>{w({type:"positive",message:r.props.flash.success})}})}return(r,l)=>(_(),g(H,{ref_key:"dialogRef",ref:d,"no-backdrop-dismiss":!0,onHide:t(f)},{default:o(()=>[e(T,{style:{width:"700px","max-width":"80vw"}},{default:o(()=>[e(Q,{class:"row items-center q-pb-none"},{default:o(()=>[Oe,e(z),e(u,{flat:"",round:"",dense:"",icon:"close",onClick:t(y)},null,8,["onClick"])]),_:1}),e(x),e(L,{onSubmit:M(c,["prevent"])},{default:o(()=>[e(Q,{class:"scroll"},{default:o(()=>[h("div",Se,[e(q,{outlined:"","use-input":"","use-chips":"","emit-value":"","map-options":"","hide-bottom-space":"","input-debounce":"500",label:"Pilih Proyek",modelValue:t(s).id_proyek,"onUpdate:modelValue":l[0]||(l[0]=a=>t(s).id_proyek=a),"option-value":"id_proyek","option-label":a=>`${a.nama_proyek} | ${a.tahun_anggaran}`,options:C.value,error:!!t(s).errors.id_proyek,"error-message":t(s).errors.id_proyek,onFilter:p},{option:o(a=>[e($,S(V(a.itemProps)),{default:o(()=>[e(R,null,{default:o(()=>[h("strong",Ve,b(a.opt.nama_proyek),1),m(" "+b(a.opt.tahun_anggaran),1)]),_:2},1024)]),_:2},1040)]),"no-option":o(()=>[e($,null,{default:o(()=>[e(R,{class:"text-grey"},{default:o(()=>[m(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","option-label","options","error","error-message"])])]),_:1}),e(x),e(j,{align:"right"},{default:o(()=>[t(s).hasErrors?(_(),g(u,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:l[1]||(l[1]=a=>t(s).clearErrors())})):O("",!0),e(u,{flat:"",label:"Reset",color:"secondary",onClick:l[2]||(l[2]=a=>t(s).reset())}),e(u,{flat:"",type:"submit",label:"Update",color:"primary",loading:t(s).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),Fe=h("div",{class:"text-h6"},"Delete Confirmation",-1),Ee=h("span",{class:"q-ml-sm"},"Are you sure want to delete this data?",-1),He=B({__name:"RABDeleteDialog",props:{id_rab:{}},emits:[...D.emits],setup(v){const n=v,{dialogRef:d,onDialogOK:w,onDialogCancel:y,onDialogHide:f}=D(),k=E({id_rab:n.id_rab});function C(){k.delete(route("rab.destroy",n.id_rab),{onSuccess:p=>{w({type:"positive",message:p.props.flash.success})}})}return(p,s)=>(_(),g(H,{ref_key:"dialogRef",ref:d,"no-backdrop-dismiss":!0,onHide:t(f)},{default:o(()=>[e(T,null,{default:o(()=>[e(Q,{class:"row items-center q-pb-none"},{default:o(()=>[Fe]),_:1}),e(x),e(Q,{class:"row items-center"},{default:o(()=>[e(me,{icon:"dangerous",color:"red","text-color":"white"}),Ee]),_:1}),e(j,{align:"right"},{default:o(()=>[e(u,{flat:"",label:"Cancel",color:"primary",onClick:t(y)},null,8,["onClick"]),e(u,{flat:"",label:"Yes, delete it",color:"red",onClick:C})]),_:1})]),_:1})]),_:1},8,["onHide"]))}}),Ze=B({__name:"RABPage",props:{rab:{},formOptions:{}},setup(v){const n=[{label:"Main",url:"#"},{label:"RAB",url:"#"}];return(d,w)=>{const y=_e("in-link");return _(),A(K,null,[e(t(fe),{title:"RAB"}),e(ne,null,{breadcrumbs:o(()=>[e(re,{align:"left"},{default:o(()=>[(_(),A(K,null,Y(n,f=>ge(e(se,{key:f.label,label:f.label},null,8,["label"]),[[y,f.url]])),64))]),_:1})]),default:o(()=>[e(t(Ce),{rows:d.rab,"form-options":d.formOptions},null,8,["rows","form-options"])]),_:1})],64)}}});export{Ze as default};
