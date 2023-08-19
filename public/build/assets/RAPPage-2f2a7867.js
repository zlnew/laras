import{d as J,l as ee,i as oe,m as ae,f as te,g as le,Q as R,a as C,b as re,_ as ne,c as se}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{d as A,j as E,o as _,e as O,a as e,w as o,u as t,c as g,h as p,O as ie,A as S,F as K,k as Y,b as m,t as y,z as pe,s as $,K as ue,T as H,p as j,q as x,i as M,g as h,N as V,P as q,f as de,v as T,x as N,W as ce,D as me,m as _e,Z as fe,n as ge}from"./app-794bfe05.js";import{a as W,b as D,c as ye,d as ke,Q as F}from"./QTable-08481d58.js";import{Q as U}from"./QTooltip-1b7cd048.js";import{Q as Z,_ as be}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-88e8d317.js";import{u as he}from"./use-quasar-1e1c8a18.js";import{u as Q,Q as z}from"./use-dialog-plugin-component-24b3795d.js";import{Q as L}from"./QForm-95ef4f4f.js";import{m as I}from"./options-4b88285e.js";import"./QImg-766bfd11.js";import"./money-3074a8fc.js";const ve={class:"q-pa-md"},Pe={key:1,class:"text-h6"},we=A({__name:"RAPTable",props:{rows:{},formOptions:{}},setup(v){const n=v,u=he();function P(r){u.dialog({component:be,componentProps:{proyek:r}})}function k(){u.dialog({component:xe,componentProps:{options:n.formOptions}})}function f(){u.dialog({component:Oe,componentProps:{options:n.formOptions}}).onOk(r=>{u.notify({type:r.type,message:r.message,position:"top"})})}function b(r){u.dialog({component:Fe,componentProps:{rap:r,options:n.formOptions}}).onOk(l=>{u.notify({type:l.type,message:l.message,position:"top"})})}function w(r){u.dialog({component:je,componentProps:{id_rap:r}}).onOk(l=>{u.notify({type:l.type,message:l.message,position:"top"})})}const d=[{name:"index",label:"#",field:"index"},{name:"nama_proyek",label:"Nama Proyek",field:"nama_proyek",align:"left",sortable:!0},{name:"pengguna_jasa",label:"Pengguna Jasa",field:"pengguna_jasa",align:"left",sortable:!0},{name:"penyedia_jasa",label:"Penyedia Jasa",field:"penyedia_jasa",align:"left",sortable:!0},{name:"tahun_anggaran",label:"Tahun Anggaran",field:"tahun_anggaran",align:"left",sortable:!0},{name:"status_rap",label:"Status",field:"status_rap",align:"left",sortable:!0},{name:"actions",label:"Actions",field:"",align:"left"}],s=E(!1);function c(){s.value=!s.value}return(r,l)=>(_(),O("div",ve,[e(ye,{flat:"",bordered:"","row-key":"id_rap",rows:r.rows,columns:d,"rows-per-page-options":[10,15,20,25,50,0],fullscreen:s.value},{"top-left":o(()=>[t(J)("create & modify rap")?(_(),g(p,{key:0,"no-caps":"",label:"Tambah RAP",icon:"add",color:"primary",onClick:f})):(_(),O("div",Pe,"List RAP"))]),"top-right":o(()=>[Object.keys(r.$page.props.query).length?(_(),g(p,{key:0,flat:"","no-caps":"",label:"Clear Filter",icon:"clear",color:"secondary",onClick:l[0]||(l[0]=a=>t(ie).visit(r.route("rap")))})):S("",!0),e(p,{flat:"","no-caps":"",label:"Pencarian",icon:"search",color:"primary",onClick:k}),e(p,{flat:"",dense:"",icon:s.value?"fullscreen_exit":"fullscreen",onClick:c,class:"q-ml-md"},null,8,["icon"])]),header:o(a=>[e(W,{props:a},{default:o(()=>[(_(!0),O(K,null,Y(a.cols,i=>(_(),g(ke,{key:i.name,props:a,style:{"font-weight":"bold"}},{default:o(()=>[m(y(i.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:o(a=>[e(W,{props:a},{default:o(()=>[e(D,{key:"index",props:a},{default:o(()=>[m(y(++a.rowIndex),1)]),_:2},1032,["props"]),e(D,{key:"nama_proyek",props:a},{default:o(()=>[e(p,{flat:"","no-caps":"",dense:"",color:"primary",ripple:!1,label:a.row.nama_proyek,onClick:i=>P(a.row)},{default:o(()=>[e(U,{anchor:"bottom middle",self:"top middle"},{default:o(()=>[m(" Lihat Detail ")]),_:1})]),_:2},1032,["label","onClick"])]),_:2},1032,["props"]),e(D,{key:"pengguna_jasa",props:a},{default:o(()=>[m(y(a.row.pengguna_jasa),1)]),_:2},1032,["props"]),e(D,{key:"penyedia_jasa",props:a},{default:o(()=>[m(y(a.row.penyedia_jasa),1)]),_:2},1032,["props"]),e(D,{key:"tahun_anggaran",props:a},{default:o(()=>[m(y(a.row.tahun_anggaran),1)]),_:2},1032,["props"]),e(D,{key:"status_rap",props:a},{default:o(()=>[t(ee)(a.row.status_aktivitas)?(_(),g(p,{key:0,flat:"",dense:"",round:"",color:"grey-6",icon:"warning",size:"sm"},{default:o(()=>[e(U,null,{default:o(()=>[m("Ditolak")]),_:1})]),_:1})):S("",!0),e(t(pe),{href:r.route("detail_rap",a.row.id_rap)},{default:o(()=>[e(Z,{color:a.row.status_rap==400?"red":"primary",label:a.row.status_rap==400?"Closed":"Open"},null,8,["color","label"])]),_:2},1032,["href"])]),_:2},1032,["props"]),e(D,{key:"actions",props:a},{default:o(()=>[t(oe)()||t(J)("create & modify rap")&&t(ae)(a.row.status_rap)?(_(),g(p,{key:0,dense:"",flat:"",color:"blue-grey",icon:"more_vert"},{default:o(()=>[e(te,{"auto-close":"","transition-show":"scale","transition-hide":"scale"},{default:o(()=>[e(le,{dense:"",style:{"min-width":"100px"}},{default:o(()=>[e(R,{clickable:""},{default:o(()=>[e(C,{onClick:i=>b(a.row)},{default:o(()=>[m(" Edit ")]),_:2},1032,["onClick"])]),_:2},1024),e($),e(R,{clickable:""},{default:o(()=>[e(C,{class:"text-red",onClick:i=>w(a.row.id_rap)},{default:o(()=>[m(" Delete ")]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)):(_(),g(p,{key:1,dense:"",flat:"",color:"grey-6",icon:"block"},{default:o(()=>[e(U,null,{default:o(()=>[m("Required permission")]),_:1})]),_:1}))]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:1},8,["rows","fullscreen"])]))}}),Ce=h("div",{class:"text-h6"},"Pencarian RAP",-1),Re={class:"q-gutter-md"},$e={class:"text-primary"},xe=A({__name:"RAPSearchDialog",props:{options:{}},emits:[...Q.emits],setup(v){const n=v,{dialogRef:u,onDialogOK:P,onDialogCancel:k,onDialogHide:f}=Q(),b=E(n.options.currentProyek);function w(l,a){a(()=>{b.value=I(l,n.options.currentProyek,["nama_proyek","tahun_anggaran"])})}const s=ue().props.query,c=H({id_proyek:s.id_proyek,status_rap:s.status_rap});function r(){c.get(route("rap"),{onSuccess:()=>{P()}})}return(l,a)=>(_(),g(j,{ref_key:"dialogRef",ref:u,onHide:t(f)},{default:o(()=>[e(N,{style:{width:"700px","max-width":"80vw"}},{default:o(()=>[e(x,{class:"row items-center q-pb-none"},{default:o(()=>[Ce,e(z),e(p,{flat:"",round:"",dense:"",icon:"close",onClick:t(k)},null,8,["onClick"])]),_:1}),e($),e(L,{onSubmit:M(r,["prevent"])},{default:o(()=>[e(x,{class:"scroll"},{default:o(()=>[h("div",Re,[e(F,{outlined:"",clearable:"","use-input":"","use-chips":"","emit-value":"","map-options":"",multiple:"","hide-bottom-space":"","input-debounce":"500",label:"Proyek",modelValue:t(c).id_proyek,"onUpdate:modelValue":a[0]||(a[0]=i=>t(c).id_proyek=i),"option-value":"id_proyek","option-label":i=>`${i.nama_proyek} | ${i.tahun_anggaran}`,options:b.value,error:!!t(c).errors.id_proyek,"error-message":t(c).errors.id_proyek,onFilter:w},{option:o(({itemProps:i,opt:B,selected:G,toggleOption:X})=>[e(R,V(q(i)),{default:o(()=>[e(C,{side:""},{default:o(()=>[e(de,{size:"sm","model-value":G,"onUpdate:modelValue":Te=>X(B)},null,8,["model-value","onUpdate:modelValue"])]),_:2},1024),e(C,null,{default:o(()=>[h("strong",$e,y(B.nama_proyek),1),m(" "+y(B.tahun_anggaran),1)]),_:2},1024)]),_:2},1040)]),"no-option":o(()=>[e(R,null,{default:o(()=>[e(C,{class:"text-grey"},{default:o(()=>[m(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","option-label","options","error","error-message"]),e(F,{outlined:"",clearable:"","fill-input":"",label:"Status RAP",modelValue:t(c).status_rap,"onUpdate:modelValue":a[1]||(a[1]=i=>t(c).status_rap=i),options:[100,400]},{"selected-item":o(i=>[e(Z,{color:i.opt==400?"red":"primary",label:i.opt==400?"Closed":"Open"},null,8,["color","label"])]),option:o(i=>[e(R,V(q(i.itemProps)),{default:o(()=>[e(C,null,{default:o(()=>[m(y(i.opt==400?"Closed":"Open"),1)]),_:2},1024)]),_:2},1040)]),_:1},8,["modelValue"])])]),_:1}),e($),e(T,{align:"right"},{default:o(()=>[e(p,{flat:"",type:"submit",label:"Search",color:"primary",loading:t(c).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),Qe=h("div",{class:"text-h6"},"Tambah RAP",-1),De={class:"q-gutter-md"},Ae={class:"text-primary"},Oe=A({__name:"RAPCreateDialog",props:{options:{}},emits:[...Q.emits],setup(v){const n=v,{dialogRef:u,onDialogOK:P,onDialogCancel:k,onDialogHide:f}=Q(),b=E(n.options.proyek);function w(c,r){r(()=>{b.value=I(c,n.options.proyek,["nama_proyek","tahun_anggaran"])})}const d=H({id_proyek:null});function s(){d.post(route("rap.store"),{onSuccess:c=>{P({type:"positive",message:c.props.flash.success})}})}return(c,r)=>(_(),g(j,{ref_key:"dialogRef",ref:u,"no-backdrop-dismiss":!0,onHide:t(f)},{default:o(()=>[e(N,{style:{width:"700px","max-width":"80vw"}},{default:o(()=>[e(x,{class:"row items-center q-pb-none"},{default:o(()=>[Qe,e(z),e(p,{flat:"",round:"",dense:"",icon:"close",onClick:t(k)},null,8,["onClick"])]),_:1}),e($),e(L,{onSubmit:M(s,["prevent"])},{default:o(()=>[e(x,{class:"scroll"},{default:o(()=>[h("div",De,[e(F,{outlined:"","use-input":"","use-chips":"","emit-value":"","map-options":"","hide-bottom-space":"","input-debounce":"500",label:"Pilih Proyek",modelValue:t(d).id_proyek,"onUpdate:modelValue":r[0]||(r[0]=l=>t(d).id_proyek=l),"option-value":"id_proyek","option-label":l=>`${l.nama_proyek} | ${l.tahun_anggaran}`,options:b.value,error:!!t(d).errors.id_proyek,"error-message":t(d).errors.id_proyek,onFilter:w},{option:o(l=>[e(R,V(q(l.itemProps)),{default:o(()=>[e(C,null,{default:o(()=>[h("strong",Ae,y(l.opt.nama_proyek),1),m(" "+y(l.opt.tahun_anggaran),1)]),_:2},1024)]),_:2},1040)]),"no-option":o(()=>[e(R,null,{default:o(()=>[e(C,{class:"text-grey"},{default:o(()=>[m(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","option-label","options","error","error-message"])])]),_:1}),e($),e(T,{align:"right"},{default:o(()=>[t(d).hasErrors?(_(),g(p,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:r[1]||(r[1]=l=>t(d).clearErrors())})):S("",!0),e(p,{flat:"",label:"Reset",color:"secondary",onClick:r[2]||(r[2]=l=>t(d).reset())}),e(p,{flat:"",type:"submit",label:"Submit",color:"primary",loading:t(d).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),Se=h("div",{class:"text-h6"},"Edit RAP",-1),Ve={class:"q-gutter-md"},qe={class:"text-primary"},Fe=A({__name:"RAPEditDialog",props:{rap:{},options:{}},emits:[...Q.emits],setup(v){const n=v,{dialogRef:u,onDialogOK:P,onDialogCancel:k,onDialogHide:f}=Q(),b={id_proyek:n.rap.id_proyek,nama_proyek:n.rap.nama_proyek,tahun_anggaran:n.rap.tahun_anggaran};ce(()=>{n.options.proyek.push(b)});const w=E(n.options.proyek);function d(r,l){l(()=>{w.value=I(r,n.options.proyek,["nama_proyek","tahun_anggaran"])})}const s=H({id_rap:n.rap.id_rap,id_proyek:n.rap.id_proyek});function c(){s.patch(route("rap.update",n.rap.id_rap),{onSuccess:r=>{P({type:"positive",message:r.props.flash.success})}})}return(r,l)=>(_(),g(j,{ref_key:"dialogRef",ref:u,"no-backdrop-dismiss":!0,onHide:t(f)},{default:o(()=>[e(N,{style:{width:"700px","max-width":"80vw"}},{default:o(()=>[e(x,{class:"row items-center q-pb-none"},{default:o(()=>[Se,e(z),e(p,{flat:"",round:"",dense:"",icon:"close",onClick:t(k)},null,8,["onClick"])]),_:1}),e($),e(L,{onSubmit:M(c,["prevent"])},{default:o(()=>[e(x,{class:"scroll"},{default:o(()=>[h("div",Ve,[e(F,{outlined:"","use-input":"","use-chips":"","emit-value":"","map-options":"","hide-bottom-space":"","input-debounce":"500",label:"Pilih Proyek",modelValue:t(s).id_proyek,"onUpdate:modelValue":l[0]||(l[0]=a=>t(s).id_proyek=a),"option-value":"id_proyek","option-label":a=>`${a.nama_proyek} | ${a.tahun_anggaran}`,options:w.value,error:!!t(s).errors.id_proyek,"error-message":t(s).errors.id_proyek,onFilter:d},{option:o(a=>[e(R,V(q(a.itemProps)),{default:o(()=>[e(C,null,{default:o(()=>[h("strong",qe,y(a.opt.nama_proyek),1),m(" "+y(a.opt.tahun_anggaran),1)]),_:2},1024)]),_:2},1040)]),"no-option":o(()=>[e(R,null,{default:o(()=>[e(C,{class:"text-grey"},{default:o(()=>[m(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","option-label","options","error","error-message"])])]),_:1}),e($),e(T,{align:"right"},{default:o(()=>[t(s).hasErrors?(_(),g(p,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:l[1]||(l[1]=a=>t(s).clearErrors())})):S("",!0),e(p,{flat:"",label:"Reset",color:"secondary",onClick:l[2]||(l[2]=a=>t(s).reset())}),e(p,{flat:"",type:"submit",label:"Update",color:"primary",loading:t(s).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),Ee=h("div",{class:"text-h6"},"Delete Confirmation",-1),He=h("span",{class:"q-ml-sm"},"Are you sure want to delete this data?",-1),je=A({__name:"RAPDeleteDialog",props:{id_rap:{}},emits:[...Q.emits],setup(v){const n=v,{dialogRef:u,onDialogOK:P,onDialogCancel:k,onDialogHide:f}=Q(),b=H({id_rap:n.id_rap});function w(){b.delete(route("rap.destroy",n.id_rap),{onSuccess:d=>{P({type:"positive",message:d.props.flash.success})}})}return(d,s)=>(_(),g(j,{ref_key:"dialogRef",ref:u,"no-backdrop-dismiss":!0,onHide:t(f)},{default:o(()=>[e(N,null,{default:o(()=>[e(x,{class:"row items-center q-pb-none"},{default:o(()=>[Ee]),_:1}),e($),e(x,{class:"row items-center"},{default:o(()=>[e(me,{icon:"dangerous",color:"red","text-color":"white"}),He]),_:1}),e(T,{align:"right"},{default:o(()=>[e(p,{flat:"",label:"Cancel",color:"primary",onClick:t(k)},null,8,["onClick"]),e(p,{flat:"",label:"Yes, delete it",color:"red",onClick:w})]),_:1})]),_:1})]),_:1},8,["onHide"]))}}),Ze=A({__name:"RAPPage",props:{rap:{},formOptions:{}},setup(v){const n=[{label:"Main",url:"#"},{label:"RAP",url:"#"}];return(u,P)=>{const k=_e("in-link");return _(),O(K,null,[e(t(fe),{title:"RAPP"}),e(ne,null,{breadcrumbs:o(()=>[e(re,{align:"left"},{default:o(()=>[(_(),O(K,null,Y(n,f=>ge(e(se,{key:f.label,label:f.label},null,8,["label"]),[[k,f.url]])),64))]),_:1})]),default:o(()=>[e(t(we),{rows:u.rap,"form-options":u.formOptions},null,8,["rows","form-options"])]),_:1})],64)}}});export{Ze as default};
