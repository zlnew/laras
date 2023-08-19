import{C as k,b as q,_ as B,c as U}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{d as g,T as v,o as c,c as V,w as a,a as r,q as p,g as t,Q as m,u as e,s as Q,v as x,h as y,i as C,x as $,D as F,t as w,K as N,m as D,e as b,Z as E,F as h,k as A,n as z}from"./app-794bfe05.js";import{Q as P}from"./QForm-95ef4f4f.js";import{u as S}from"./use-quasar-1e1c8a18.js";import"./QImg-766bfd11.js";const L=t("div",{class:"text-h6"},"Change Password",-1),I={class:"q-gutter-md"},K=g({__name:"ChangePasswordForm",setup(_){const d=S(),s=v({current_password:null,password:null,confirmed_password:null});function o(){s.patch(route("password.update"),{onSuccess:i=>{d.notify({color:"positive",message:i.props.flash.success,position:"top"})}})}return(i,l)=>(c(),V($,{flat:"",bordered:""},{default:a(()=>[r(p,null,{default:a(()=>[L]),_:1}),r(P,{onSubmit:C(o,["prevent"])},{default:a(()=>[r(p,null,{default:a(()=>[t("div",I,[r(m,{outlined:"","hide-bottom-space":"",modelValue:e(s).current_password,"onUpdate:modelValue":l[0]||(l[0]=n=>e(s).current_password=n),type:"password",label:"Current Password",error:!!e(s).errors.current_password,"error-message":e(s).errors.current_password},null,8,["modelValue","error","error-message"]),r(m,{outlined:"","hide-bottom-space":"",modelValue:e(s).password,"onUpdate:modelValue":l[1]||(l[1]=n=>e(s).password=n),type:"password",label:"New Password",error:!!e(s).errors.password,"error-message":e(s).errors.password},null,8,["modelValue","error","error-message"]),r(m,{outlined:"","hide-bottom-space":"",modelValue:e(s).confirmed_password,"onUpdate:modelValue":l[2]||(l[2]=n=>e(s).confirmed_password=n),type:"password",label:"Confirm New Password",error:!!e(s).errors.confirmed_password,"error-message":e(s).errors.confirmed_password},null,8,["modelValue","error","error-message"])])]),_:1}),r(Q),r(x,{align:"right"},{default:a(()=>[r(y,{flat:"",color:"primary",type:"submit",label:"Change",loading:e(s).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1}))}}),M={class:"row items-center no-wrap"},T={class:"q-mr-md"},Z=["src"],j={class:"col"},G={class:"text-h6"},H={class:"text-subtitle2 text-capitalize"},J={class:"q-gutter-md"},O=g({__name:"UpdateProfileForm",props:{data:{}},setup(_){const d=_,s=S(),o=v({name:d.data.user.name,email:d.data.user.email});function i(){o.patch(route("profile.update"),{onSuccess:l=>{s.notify({color:"positive",message:l.props.flash.success,position:"top"})}})}return(l,n)=>(c(),V($,{flat:"",bordered:""},{default:a(()=>[r(p,null,{default:a(()=>[t("div",M,[t("div",T,[r(F,{size:"48px"},{default:a(()=>[t("img",{src:e(k)(e(o).name)},null,8,Z)]),_:1})]),t("div",j,[t("div",G,w(l.data.user.name),1),t("div",H,w(l.data.role),1)])])]),_:1}),r(P,{onSubmit:C(i,["prevent"])},{default:a(()=>[r(p,null,{default:a(()=>[t("div",J,[r(m,{outlined:"",counter:"","hide-bottom-space":"",modelValue:e(o).name,"onUpdate:modelValue":n[0]||(n[0]=u=>e(o).name=u),label:"Nama Lengkap",maxlength:"30",error:!!e(o).errors.name,"error-message":e(o).errors.name},null,8,["modelValue","error","error-message"]),r(m,{outlined:"",counter:"","hide-bottom-space":"",modelValue:e(o).email,"onUpdate:modelValue":n[1]||(n[1]=u=>e(o).email=u),label:"Email Address",maxlength:"30",error:!!e(o).errors.email,"error-message":e(o).errors.email},null,8,["modelValue","error","error-message"])])]),_:1}),r(Q),r(x,{align:"right"},{default:a(()=>[r(y,{flat:"",color:"primary",type:"submit",label:"Save",loading:e(o).processing},null,8,["loading"])]),_:1})]),_:1},8,["onSubmit"])]),_:1}))}}),R={class:"q-pa-md"},W={class:"row q-col-gutter-x-md"},X={class:"col-12 col-md-7"},Y={class:"col-12 col-md-5"},te=g({__name:"ProfilePage",setup(_){const d=[{label:"Profile",url:"#"},{label:"Edit",url:"#"}],s=N(),o=s.props.auth.user,i=s.props.auth.role;return(l,n)=>{const u=D("in-link");return c(),b(h,null,[r(e(E),{title:"Profile"}),r(B,null,{breadcrumbs:a(()=>[r(q,{align:"left"},{default:a(()=>[(c(),b(h,null,A(d,f=>z(r(U,{key:f.label,label:f.label},null,8,["label"]),[[u,f.url]])),64))]),_:1})]),default:a(()=>[t("div",R,[t("div",W,[t("div",X,[r(e(O),{data:{user:e(o),role:e(i)}},null,8,["data"])]),t("div",Y,[r(e(K),{data:{user:e(o)}},null,8,["data"])])])])]),_:1})],64)}}});export{te as default};
