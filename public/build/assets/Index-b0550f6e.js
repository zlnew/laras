import{_ as L,a as N,C as P}from"./Content-c6f442a5.js";import{C as E,a as M,_ as V}from"./Card-7d71d8a7.js";import{T as j,a as z,_ as d,b as c,c as D,d as l}from"./Table-3adccec2.js";import{T as h}from"./toastify-1f71f880.js";import{d as F,K as H,l as R,e as k,c as C,h as a,u as e,g as s,F as b,o as f,Z as I,n as K,j as S,a as v,p as r,s as Z,f as $,m as q,t as _}from"./app-75a3a99f.js";import{M as m}from"./modal-cb471a77.js";import{_ as A}from"./SearchModal.vue_vue_type_script_setup_true_lang-e7acca1f.js";import{_ as G}from"./CreateModal.vue_vue_type_script_setup_true_lang-6daff51c.js";import{_ as J}from"./EditModal.vue_vue_type_script_setup_true_lang-1fb107ef.js";import{_ as O}from"./DeleteModal.vue_vue_type_script_setup_true_lang-841024d1.js";import"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-9b77fc3b.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Footer-8b073701.js";import"./Head.vue_vue_type_script_setup_true_lang-0b8949ad.js";import"./Input.vue_vue_type_script_setup_true_lang-8599c816.js";import"./Label.vue_vue_type_script_setup_true_lang-21506f02.js";import"./Select.vue_vue_type_script_setup_true_lang-f552b2ec.js";import"./Error.vue_vue_type_script_setup_true_lang-f9f51393.js";const Q={class:"flex justify-between items-center"},W={class:"flex"},ka=F({__name:"Index",props:{users:{},roles:{}},setup(g){const p=g,n=H();function w(){m.pop(A,{roles:p.roles})}function x(){m.pop(G,{roles:p.roles})}function y(t){m.pop(J,{user:t,roles:p.roles})}function U(t){m.pop(O,{id:t})}return R(()=>{n.props.flash.success&&h.success(n.props.flash.success),n.props.flash.error&&h.error(n.props.flash.error)}),(t,X)=>{const u=k("fas-icon"),i=k("ease-button");return f(),C(b,null,[a(e(I),{title:"Users"}),a(L,null,{breadcrumb:s(()=>[a(N,K(S({second:"Master",current:"Users"})),null,16)]),default:s(()=>[a(P,null,{default:s(()=>[a(e(E),null,{default:s(()=>[a(e(M),{class:"mb-4"},{default:s(()=>[v("div",Q,[a(i,{onClick:x,slotted:""},{default:s(()=>[a(u,{icon:"fa-solid fa-plus",class:"mr-1"}),r(" Tambah User ")]),_:1}),a(i,{onClick:w,variant:"transparent",slotted:""},{default:s(()=>[a(u,{icon:"fa-solid fa-search",class:"mr-1"}),r(" Pencarian ")]),_:1})])]),_:1}),a(e(V),{table:""},{default:s(()=>[a(e(j),null,{default:s(()=>[a(e(z),null,{default:s(()=>[a(e(d),null,{default:s(()=>[a(e(c),{value:"Nama"}),a(e(c),{value:"Email"}),a(e(c),{value:"Role"}),a(e(c))]),_:1})]),_:1}),a(e(D),null,{default:s(()=>[t.users.data.length?(f(!0),C(b,{key:0},Z(t.users.data,(o,T)=>(f(),$(e(d),q({key:o.id},{last:T===t.users.data.length-1}),{default:s(()=>[a(e(l),{whitespace:"nowrap",class:"font-semibold text-dark"},{default:s(()=>[r(_(o.name),1)]),_:2},1024),a(e(l),{whitespace:"nowrap"},{default:s(()=>[r(_(o.email),1)]),_:2},1024),a(e(l),{whitespace:"normal",class:"capitalize font-semibold text-dark"},{default:s(()=>[r(_(o.role_name),1)]),_:2},1024),a(e(l),{whitespace:"nowrap"},{default:s(()=>[v("div",W,[a(i,{onClick:B=>y(o),variant:"link",text:"Edit"},null,8,["onClick"]),a(i,{onClick:B=>U(o.id),variant:"danger-link",text:"Delete"},null,8,["onClick"])])]),_:2},1024)]),_:2},1040))),128)):(f(),$(e(d),{key:1,last:""},{default:s(()=>[a(e(l),{colspan:"4","text-align":"center"},{default:s(()=>[r(" User tidak ditemukan ")]),_:1})]),_:1}))]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})],64)}}});export{ka as default};