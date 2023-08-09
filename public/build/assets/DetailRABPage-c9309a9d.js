import{i as E,d as U,e as I,f as ne,g as ie,Q as N,a as K,b as ue,o as de,_ as me,c as ce}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-f8fe08d2.js";import{d as D,l as pe,T as H,j,o as p,e as F,a as e,C as Y,w as t,b as c,u as a,c as k,h as b,Q as V,t as v,g as d,A as T,y as fe,F as Z,k as oe,s as S,p as L,q as Q,i as G,v as M,x as X,D as _e,E as be,m as ge,Z as he,n as ke}from"./app-651f5c8c.js";import{a as q,b as u,c as ve,d as ye,Q as re}from"./QTable-db3b72cd.js";import{Q as P}from"./QTooltip-b7a3ad90.js";import{u as J}from"./use-quasar-1175def4.js";import{a as $,t as A}from"./money-3074a8fc.js";import{u as B,Q as W}from"./use-dialog-plugin-component-e23f8103.js";import{c as we,Q as te,a as xe,b as le,_ as Ce}from"./QFile-a5c521b8.js";import{Q as ee}from"./QForm-5f0747c8.js";import{m as se}from"./options-964f32b0.js";import"./QImg-3654d7aa.js";import"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-7b2e019a.js";const Re={class:"q-pa-md"},Ve={class:"q-gutter-sm"},Ae={key:1},$e={key:1},Se=D({__name:"RABItemTable",props:{rows:{},data:{},formOptions:{}},setup(y){const s=y,f=pe(()=>{const _=s.rows.reduce((O,ae)=>O+$(ae.harga_satuan)*$(ae.volume),0),C=$(r.tax)/100*_,n=$(r.additional_tax)/100*_;return{dpp:_,ppn:C,pph:n}}),r=H({tax:s.data.rab.tax,additional_tax:s.data.rab.additional_tax});function w(){r.patch(route("rab.update_tax",s.data.rab.id_rab))}const g=J();function i(){g.dialog({component:De,componentProps:{id_rab:s.data.rab.id_rab}}).onOk(_=>{g.notify({type:_.type,message:_.message,position:"top"})})}function R(){g.dialog({component:Ke,componentProps:{rab:s.data.rab,options:s.formOptions}}).onOk(_=>{g.notify({type:_.type,message:_.message,position:"top"})})}function o(_){g.dialog({component:ea,componentProps:{detailRab:_,options:s.formOptions}}).onOk(C=>{g.notify({type:C.type,message:C.message,position:"top"})})}function x(_){g.dialog({component:oa,componentProps:{id_detail_rab:_}}).onOk(C=>{g.notify({type:C.type,message:C.message,position:"top"})})}const h=[{name:"index",label:"#",field:"index"},{name:"uraian",label:"Uraian",field:"uraian",align:"left",sortable:!0},{name:"nama_satuan",label:"Satuan",field:"nama_satuan",align:"left",sortable:!0},{name:"harga_satuan",label:"Harga Satuan",field:"harga_satuan",align:"right",sortable:!0},{name:"volume",label:"Volume",field:"volume",align:"left",sortable:!0},{name:"total_harga",label:"Total Harga",field:"",align:"right",sortable:!0},{name:"keterangan",label:"Ket",field:"keterangan",align:"left",sortable:!0},{name:"actions",label:"Actions",field:"",align:"left"}],l=j(!1);function m(){l.value=!l.value}const z=j("");return(_,C)=>(p(),F("div",Re,[e(ve,{flat:"",bordered:"","row-key":"id_detail_rab",rows:_.rows,columns:h,"rows-per-page-options":[10,15,20,25,50,0],fullscreen:l.value,filter:z.value},Y({"top-left":t(()=>[d("div",Ve,[a(E)()||a(U)("create & modify rab")&&a(I)(_.data.rab)?(p(),k(b,{key:0,"no-caps":"",label:"Tambah Uraian RAB",icon:"add",color:"primary",onClick:R})):T("",!0),a(E)()||a(U)("create & modify rab")&&a(I)(_.data.rab)?(p(),k(b,{key:1,"no-caps":"",label:"Import dari CSV/XLS",icon:"upload_file",color:"green-8",onClick:i})):T("",!0)])]),"top-right":t(()=>[e(V,{dense:"",debounce:"300",modelValue:z.value,"onUpdate:modelValue":C[0]||(C[0]=n=>z.value=n),placeholder:"Search"},{append:t(()=>[e(fe,{name:"search"})]),_:1},8,["modelValue"]),e(b,{flat:"",dense:"",icon:l.value?"fullscreen_exit":"fullscreen",onClick:m,class:"q-ml-md"},null,8,["icon"])]),header:t(n=>[e(q,{props:n},{default:t(()=>[(p(!0),F(Z,null,oe(n.cols,O=>(p(),k(ye,{key:O.name,props:n,style:{"font-weight":"bold"}},{default:t(()=>[c(v(O.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:t(n=>[e(q,{props:n},{default:t(()=>[e(u,{key:"index",props:n},{default:t(()=>[c(v(++n.rowIndex),1)]),_:2},1032,["props"]),e(u,{key:"uraian",props:n},{default:t(()=>[c(v(n.row.uraian),1)]),_:2},1032,["props"]),e(u,{key:"nama_satuan",props:n},{default:t(()=>[c(v(n.row.nama_satuan),1)]),_:2},1032,["props"]),e(u,{key:"harga_satuan",props:n},{default:t(()=>[c(v(a(A)(n.row.harga_satuan)),1)]),_:2},1032,["props"]),e(u,{key:"volume",props:n},{default:t(()=>[c(v(n.row.volume),1)]),_:2},1032,["props"]),e(u,{key:"total_harga",props:n},{default:t(()=>[c(v(a(A)(n.row.harga_satuan*n.row.volume)),1)]),_:2},1032,["props"]),e(u,{key:"keterangan",props:n},{default:t(()=>[c(v(n.row.keterangan),1)]),_:2},1032,["props"]),e(u,{key:"actions",props:n},{default:t(()=>[a(E)()||a(U)("create & modify rab")&&a(I)(_.data.rab)?(p(),k(b,{key:0,dense:"",flat:"",color:"blue-grey",icon:"more_vert"},{default:t(()=>[e(ne,{"auto-close":"","transition-show":"scale","transition-hide":"scale"},{default:t(()=>[e(ie,{dense:"",style:{"min-width":"100px"}},{default:t(()=>[e(N,{clickable:""},{default:t(()=>[e(K,{onClick:O=>o(n.row)},{default:t(()=>[c(" Edit ")]),_:2},1032,["onClick"])]),_:2},1024),e(S),e(N,{clickable:""},{default:t(()=>[e(K,{class:"text-red",onClick:O=>x(n.row.id_detail_rab)},{default:t(()=>[c(" Delete ")]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)):(p(),k(b,{key:1,dense:"",flat:"",color:"grey-6",icon:"block"},{default:t(()=>[e(P,null,{default:t(()=>[c("Required permission")]),_:1})]),_:1}))]),_:2},1032,["props"])]),_:2},1032,["props"])]),_:2},[_.rows.length?{name:"bottom-row",fn:t(()=>[e(q,{"no-hover":""},{default:t(()=>[e(u,{colspan:"4",style:{border:"none"}}),e(u,{class:"text-right"},{default:t(()=>[c(" PPN ")]),_:1}),e(u,{class:"text-right"},{default:t(()=>[a(E)()||a(U)("create & modify rab")&&a(I)(_.data.rab)?(p(),k(V,{key:0,dense:"","reverse-fill-mask":"","hide-bottom-space":"",mask:"#.##","fill-mask":"0",modelValue:a(r).tax,"onUpdate:modelValue":C[1]||(C[1]=n=>a(r).tax=n),hint:"Click the button on the right to save","hide-hint":!a(r).isDirty},Y({_:2},[a(r).isDirty?{name:"append",fn:t(()=>[e(b,{flat:"",dense:"",icon:"check",onClick:w},{default:t(()=>[e(P,null,{default:t(()=>[c("Click to update")]),_:1})]),_:1})]),key:"0"}:void 0]),1032,["modelValue","hide-hint"])):(p(),F("span",Ae,v(_.data.rab.tax)+"%",1))]),_:1}),e(u,{colspan:"2",style:{border:"none"}})]),_:1}),e(q,{"no-hover":""},{default:t(()=>[e(u,{colspan:"4",style:{border:"none"}}),e(u,{class:"text-right"},{default:t(()=>[c(" PPH ")]),_:1}),e(u,{class:"text-right"},{default:t(()=>[a(E)()||a(U)("create & modify rab")&&a(I)(_.data.rab)?(p(),k(V,{key:0,dense:"","reverse-fill-mask":"","hide-bottom-space":"",mask:"#.##","fill-mask":"0",modelValue:a(r).additional_tax,"onUpdate:modelValue":C[2]||(C[2]=n=>a(r).additional_tax=n),hint:"Click the button on the right to save","hide-hint":!a(r).isDirty},Y({_:2},[a(r).isDirty?{name:"append",fn:t(()=>[e(b,{flat:"",dense:"",icon:"check",onClick:w},{default:t(()=>[e(P,null,{default:t(()=>[c("Click to update")]),_:1})]),_:1})]),key:"0"}:void 0]),1032,["modelValue","hide-hint"])):(p(),F("span",$e,v(_.data.rab.additional_tax)+"%",1))]),_:1}),e(u,{colspan:"2",style:{border:"none"}})]),_:1}),e(q,{"no-hover":""},{default:t(()=>[e(u,{colspan:"4",style:{border:"none"}}),e(u,{class:"text-right"},{default:t(()=>[c(" Total RAB ")]),_:1}),e(u,{class:"text-right text-weight-bold"},{default:t(()=>[c(v(a(A)(f.value.dpp)),1)]),_:1}),e(u,{colspan:"2",style:{border:"none"}})]),_:1}),e(q,{"no-hover":""},{default:t(()=>[e(u,{colspan:"4",style:{border:"none"}}),e(u,{class:"text-right"},{default:t(()=>[c(" Nilai Kontrak ")]),_:1}),e(u,{class:"text-right text-weight-bold"},{default:t(()=>[c(v(a(A)(f.value.dpp+f.value.ppn)),1)]),_:1}),e(u,{colspan:"2",style:{border:"none"}})]),_:1}),e(q,{"no-hover":""},{default:t(()=>[e(u,{colspan:"4",style:{border:"none"}}),e(u,{class:"text-right"},{default:t(()=>[c(" Netto ")]),_:1}),e(u,{class:"text-right text-weight-bold"},{default:t(()=>[c(v(a(A)(f.value.dpp-f.value.pph)),1)]),_:1}),e(u,{colspan:"2",style:{border:"none"}})]),_:1})]),key:"0"}:void 0]),1032,["rows","fullscreen","filter"])]))}}),Qe=d("div",{class:"text-h6"},"Import Uraian RAB",-1),Be={class:"q-gutter-md"},De=D({__name:"RABItemImportDialog",props:{id_rab:{}},emits:[...B.emits],setup(y){const s=y,{dialogRef:f,onDialogOK:r,onDialogCancel:w,onDialogHide:g}=B(),i=H({file:null});function R(){i.post(route("detail_rab.import",s.id_rab),{onSuccess:o=>{r({type:"positive",message:o.props.flash.success})}})}return(o,x)=>(p(),k(L,{ref_key:"dialogRef",ref:f,"no-backdrop-dismiss":!0,onHide:a(g)},{default:t(()=>[e(X,{style:{width:"500px","max-width":"80vw"}},{default:t(()=>[e(Q,{class:"row items-center q-pb-none"},{default:t(()=>[Qe,e(W),e(b,{flat:"",round:"",dense:"",icon:"close",onClick:a(w)},null,8,["onClick"])]),_:1}),e(S),e(ee,{onSubmit:G(R,["prevent"])},{default:t(()=>[e(Q,{class:"scroll"},{default:t(()=>[d("div",Be,[e(b,{color:"green-8",icon:"download",label:"Template",href:"/storage/uploads/template_uraian_rab.xlsx"},{default:t(()=>[e(P,null,{default:t(()=>[c("Download template CSV/XLS")]),_:1})]),_:1}),e(we,{outlined:"",counter:"","hide-bottom-space":"",modelValue:a(i).file,"onUpdate:modelValue":x[0]||(x[0]=h=>a(i).file=h),label:"Pick file",hint:"Format: csv, xls, xlsx",error:!!a(i).errors.file,"error-message":a(i).errors.file},null,8,["modelValue","error","error-message"])])]),_:1}),e(S),e(M,{align:"right"},{default:t(()=>[a(i).hasErrors?(p(),k(b,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:x[1]||(x[1]=h=>a(i).clearErrors())})):T("",!0),e(b,{flat:"",label:"Reset",color:"secondary",onClick:x[2]||(x[2]=h=>a(i).reset())}),e(b,{flat:"",type:"submit",label:"Import",color:"primary",loading:a(i).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),qe=d("div",{class:"text-h6"},"Tambah Uraian RAB",-1),Ue={class:"q-gutter-md"},Te={class:"row"},He={class:"col-12 col-md-6 q-pr-sm"},Oe={class:"col-12 col-md-6 q-pl-sm"},Ie={class:"row"},Fe={class:"col-12 col-md-6 q-pr-sm"},Ee={class:"col-12 col-md-6 q-pl-sm text-right"},Pe=d("div",{class:"text-secondary text-caption"},"Total Harga",-1),Ne={class:"text-weight-bold text-subtitle1"},Ke=D({__name:"RABItemCreateDialog",props:{rab:{},options:{}},emits:[...B.emits],setup(y){const s=y,{dialogRef:f,onDialogOK:r,onDialogCancel:w,onDialogHide:g}=B(),i=j(s.options.satuan);function R(h,l){l(()=>{i.value=se(h,s.options.satuan,["nama_satuan"])})}const o=H({uraian:null,harga_satuan:0,volume:0,keterangan:null,id_satuan:null});function x(){o.post(route("detail_rab.store",s.rab.id_rab),{onSuccess:h=>{r({type:"positive",message:h.props.flash.success})}})}return(h,l)=>(p(),k(L,{ref_key:"dialogRef",ref:f,"no-backdrop-dismiss":!0,onHide:a(g)},{default:t(()=>[e(X,{style:{width:"700px","max-width":"80vw"}},{default:t(()=>[e(Q,{class:"row items-center q-pb-none"},{default:t(()=>[qe,e(W),e(b,{flat:"",round:"",dense:"",icon:"close",onClick:a(w)},null,8,["onClick"])]),_:1}),e(S),e(ee,{onSubmit:G(x,["prevent"])},{default:t(()=>[e(Q,{class:"scroll"},{default:t(()=>[d("div",Ue,[e(V,{outlined:"",autogrow:"","hide-bottom-space":"",label:"Uraian",modelValue:a(o).uraian,"onUpdate:modelValue":l[0]||(l[0]=m=>a(o).uraian=m),error:!!a(o).errors.uraian,"error-message":a(o).errors.uraian},null,8,["modelValue","error","error-message"]),e(re,{outlined:"",clearable:"","use-input":"","use-chips":"","emit-value":"","map-options":"","hide-bottom-space":"","input-debounce":"500",label:"Satuan",modelValue:a(o).id_satuan,"onUpdate:modelValue":l[1]||(l[1]=m=>a(o).id_satuan=m),"option-value":"id_satuan","option-label":"nama_satuan",options:i.value,error:!!a(o).errors.id_satuan,"error-message":a(o).errors.id_satuan,onFilter:R},{"no-option":t(()=>[e(N,null,{default:t(()=>[e(K,{class:"text-grey"},{default:t(()=>[c(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","options","error","error-message"]),d("div",Te,[d("div",He,[e(V,{outlined:"","reverse-fill-mask":"","hide-bottom-space":"",label:"Harga Satuan",mask:"#.##","fill-mask":"0",modelValue:a(o).harga_satuan,"onUpdate:modelValue":l[2]||(l[2]=m=>a(o).harga_satuan=m),hint:a(A)(a(o).harga_satuan),"hide-hint":a(o).harga_satuan<1,error:!!a(o).errors.harga_satuan,"error-message":a(o).errors.harga_satuan,"input-class":"text-right"},null,8,["modelValue","hint","hide-hint","error","error-message"])]),d("div",Oe,[e(V,{outlined:"","reverse-fill-mask":"","hide-bottom-space":"",label:"Volume",mask:"#.##","fill-mask":"0",modelValue:a(o).volume,"onUpdate:modelValue":l[3]||(l[3]=m=>a(o).volume=m),error:!!a(o).errors.volume,"error-message":a(o).errors.volume,"input-class":"text-right"},null,8,["modelValue","error","error-message"])])]),d("div",Ie,[d("div",Fe,[e(V,{outlined:"",autogrow:"","hide-bottom-space":"",label:"Keterangan",modelValue:a(o).keterangan,"onUpdate:modelValue":l[4]||(l[4]=m=>a(o).keterangan=m),error:!!a(o).errors.keterangan,"error-message":a(o).errors.keterangan},null,8,["modelValue","error","error-message"])]),d("div",Ee,[Pe,d("div",Ne,v(a(A)(a(o).harga_satuan*a(o).volume)),1)])])])]),_:1}),e(S),e(M,{align:"right"},{default:t(()=>[a(o).hasErrors?(p(),k(b,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:l[5]||(l[5]=m=>a(o).clearErrors())})):T("",!0),e(b,{flat:"",label:"Reset",color:"secondary",onClick:l[6]||(l[6]=m=>a(o).reset())}),e(b,{flat:"",type:"submit",label:"Submit",color:"primary",loading:a(o).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),je=d("div",{class:"text-h6"},"Edit Uraian RAB",-1),Le={class:"q-gutter-md"},Me={class:"row"},Xe={class:"col-12 col-md-6 q-pr-sm"},ze={class:"col-12 col-md-6 q-pl-sm"},Ye={class:"row"},Ze={class:"col-12 col-md-6 q-pr-sm"},Ge={class:"col-12 col-md-6 q-pl-sm text-right"},Je=d("div",{class:"text-secondary text-caption"},"Total Harga",-1),We={class:"text-weight-bold text-subtitle1"},ea=D({__name:"RABItemEditDialog",props:{detailRab:{},options:{}},emits:[...B.emits],setup(y){const s=y,{dialogRef:f,onDialogOK:r,onDialogCancel:w,onDialogHide:g}=B(),i=j(s.options.satuan);function R(h,l){l(()=>{i.value=se(h,s.options.satuan,["nama_satuan"])})}const o=H({uraian:s.detailRab.uraian,harga_satuan:s.detailRab.harga_satuan,volume:s.detailRab.volume,keterangan:s.detailRab.keterangan,id_satuan:s.detailRab.id_satuan});function x(){o.patch(route("detail_rab.update",s.detailRab.id_detail_rab),{onSuccess:h=>{r({type:"positive",message:h.props.flash.success})}})}return(h,l)=>(p(),k(L,{ref_key:"dialogRef",ref:f,"no-backdrop-dismiss":!0,onHide:a(g)},{default:t(()=>[e(X,{style:{width:"700px","max-width":"80vw"}},{default:t(()=>[e(Q,{class:"row items-center q-pb-none"},{default:t(()=>[je,e(W),e(b,{flat:"",round:"",dense:"",icon:"close",onClick:a(w)},null,8,["onClick"])]),_:1}),e(S),e(ee,{onSubmit:G(x,["prevent"])},{default:t(()=>[e(Q,{class:"scroll"},{default:t(()=>[d("div",Le,[e(V,{outlined:"",autogrow:"","hide-bottom-space":"",label:"Uraian",modelValue:a(o).uraian,"onUpdate:modelValue":l[0]||(l[0]=m=>a(o).uraian=m),error:!!a(o).errors.uraian,"error-message":a(o).errors.uraian},null,8,["modelValue","error","error-message"]),e(re,{outlined:"",clearable:"","use-input":"","use-chips":"","emit-value":"","map-options":"","hide-bottom-space":"","input-debounce":"500",label:"Satuan",modelValue:a(o).id_satuan,"onUpdate:modelValue":l[1]||(l[1]=m=>a(o).id_satuan=m),"option-value":"id_satuan","option-label":"nama_satuan",options:i.value,error:!!a(o).errors.id_satuan,"error-message":a(o).errors.id_satuan,onFilter:R},{"no-option":t(()=>[e(N,null,{default:t(()=>[e(K,{class:"text-grey"},{default:t(()=>[c(" No results ")]),_:1})]),_:1})]),_:1},8,["modelValue","options","error","error-message"]),d("div",Me,[d("div",Xe,[e(V,{outlined:"","reverse-fill-mask":"","hide-bottom-space":"",label:"Harga Satuan",mask:"#.##","fill-mask":"0",modelValue:a(o).harga_satuan,"onUpdate:modelValue":l[2]||(l[2]=m=>a(o).harga_satuan=m),hint:a(A)(a($)(a(o).harga_satuan)),"hide-hint":a($)(a(o).harga_satuan)<1,error:!!a(o).errors.harga_satuan,"error-message":a(o).errors.harga_satuan,"input-class":"text-right"},null,8,["modelValue","hint","hide-hint","error","error-message"])]),d("div",ze,[e(V,{outlined:"","reverse-fill-mask":"","hide-bottom-space":"",label:"Volume",mask:"#.##","fill-mask":"0",modelValue:a(o).volume,"onUpdate:modelValue":l[3]||(l[3]=m=>a(o).volume=m),error:!!a(o).errors.volume,"error-message":a(o).errors.volume,"input-class":"text-right"},null,8,["modelValue","error","error-message"])])]),d("div",Ye,[d("div",Ze,[e(V,{outlined:"",autogrow:"","hide-bottom-space":"",label:"Keterangan",modelValue:a(o).keterangan,"onUpdate:modelValue":l[4]||(l[4]=m=>a(o).keterangan=m),error:!!a(o).errors.keterangan,"error-message":a(o).errors.keterangan},null,8,["modelValue","error","error-message"])]),d("div",Ge,[Je,d("div",We,v(a(A)(a($)(a(o).harga_satuan)*a($)(a(o).volume))),1)])])])]),_:1}),e(S),e(M,{align:"right"},{default:t(()=>[a(o).hasErrors?(p(),k(b,{key:0,flat:"",label:"Clear Errors",color:"red",onClick:l[5]||(l[5]=m=>a(o).clearErrors())})):T("",!0),e(b,{flat:"",label:"Reset",color:"secondary",onClick:l[6]||(l[6]=m=>a(o).reset())}),e(b,{flat:"",type:"submit",label:"Update",color:"primary",loading:a(o).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1})]),_:1},8,["onHide"]))}}),aa=d("div",{class:"text-h6"},"Delete Confirmation",-1),ta=d("span",{class:"q-ml-sm"},"Are you sure want to delete this data?",-1),oa=D({__name:"RABItemDeleteDialog",props:{id_detail_rab:{}},emits:[...B.emits],setup(y){const s=y,{dialogRef:f,onDialogOK:r,onDialogCancel:w,onDialogHide:g}=B(),i=H({id_detail_rab:s.id_detail_rab});function R(){i.delete(route("detail_rab.destroy",s.id_detail_rab),{onSuccess:o=>{r({type:"positive",message:o.props.flash.success})}})}return(o,x)=>(p(),k(L,{ref_key:"dialogRef",ref:f,"no-backdrop-dismiss":!0,onHide:a(g)},{default:t(()=>[e(X,null,{default:t(()=>[e(Q,{class:"row items-center q-pb-none"},{default:t(()=>[aa]),_:1}),e(S),e(Q,{class:"row items-center"},{default:t(()=>[e(_e,{icon:"dangerous",color:"red","text-color":"white"}),ta]),_:1}),e(M,{align:"right"},{default:t(()=>[e(b,{flat:"",label:"Cancel",color:"primary",onClick:a(w)},null,8,["onClick"]),e(b,{flat:"",label:"Yes, delete it",color:"red",onClick:R})]),_:1})]),_:1})]),_:1},8,["onHide"]))}}),ra=D({__name:"RABApprovalForm",props:{data:{}},setup(y){const s=y,f=J(),r=H({catatan:""});function w(){r.post(route("rab.approve",s.data.id_rab),{onSuccess:o=>{f.notify({type:"positive",message:o.props.flash.success,position:"top"})}})}function g(){r.post(route("rab.reject",s.data.id_rab),{onSuccess:o=>{f.notify({type:"positive",message:o.props.flash.success,position:"top"})}})}function i(){f.dialog({title:"Approval Confirmation",message:"Are you sure want to perform this action?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"positive",cancel:!0,persistent:!0}).onOk(o=>{r.catatan=o,w()})}function R(){f.dialog({title:"Rejection Confirmation",message:"Are you sure want to perform this action?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"negative",cancel:!0,persistent:!0}).onOk(o=>{r.catatan=o,g()})}return(o,x)=>(p(),k(le,{position:"bottom-right",offset:[18,18]},{default:t(()=>[e(xe,{color:"primary",icon:"keyboard_arrow_left",direction:"left"},{label:t(({opened:h})=>[d("div",{class:be({"example-fab-animate--hover":h!==!0})},v(h!==!0?"Approval":"Close"),3)]),default:t(()=>[e(te,{color:"green-5",label:"Setujui",icon:"check",onClick:i}),e(te,{color:"red",label:"Tolak",icon:"clear",onClick:R})]),_:1})]),_:1}))}}),la=D({__name:"RABSubmissionForm",props:{data:{}},setup(y){const s=y,f=J(),r=H({catatan:""});function w(){r.post(route("rab.submit",s.data.id_rab),{onSuccess:i=>{f.notify({type:"positive",message:i.props.flash.success,position:"top"})}})}function g(){f.dialog({title:"Submission Confirmation",message:"Are you sure want to submit this data?",prompt:{outlined:!0,autogrow:!0,model:"",type:"text",placeholder:"Tambahkan Catatan"},color:"primary",cancel:!0,persistent:!0}).onOk(i=>{r.catatan=i,w()})}return(i,R)=>(p(),k(le,{position:"bottom-right",offset:[18,18]},{default:t(()=>[e(b,{rounded:"",color:"primary",label:"Submit","icon-right":"check",onClick:g},{default:t(()=>[e(P,null,{default:t(()=>[c("Click to submit")]),_:1})]),_:1})]),_:1}))}}),ha=D({__name:"DetailRABPage",props:{detailRab:{},formOptions:{},rab:{},timeline:{}},setup(y){const s=y,f=[{label:"Main",url:"#"},{label:"RAB",url:route("rab")},{label:s.rab.nama_proyek,url:"#"}];return(r,w)=>{const g=ge("in-link");return p(),F(Z,null,[e(a(he),{title:"RAB"}),e(me,null,{breadcrumbs:t(()=>[e(ue,{align:"left"},{default:t(()=>[(p(),F(Z,null,oe(f,i=>ke(e(ce,{label:i.label},null,8,["label"]),[[g,i.url]])),64))]),_:1})]),default:t(()=>[e(Ce,{title:"RAB","timeline-title":"Timeline Pengajuan RAB",data:{proyek:r.rab,status:r.rab.status_rab,timeline:r.timeline}},null,8,["data"]),e(a(Se),{rows:r.detailRab,data:{rab:r.rab},"form-options":r.formOptions},null,8,["rows","data","form-options"]),a(U)("create & modify rab")&&a(I)(r.rab)&&r.detailRab.length?(p(),k(a(la),{key:0,data:{id_rab:r.rab.id_rab}},null,8,["data"])):T("",!0),a(U)("approve rab")&&a(de)(r.rab)?(p(),k(a(ra),{key:1,data:{id_rab:r.rab.id_rab}},null,8,["data"])):T("",!0)]),_:1})],64)}}});export{ha as default};
