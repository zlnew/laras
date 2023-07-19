import{_ as L,a as j,C as q}from"./Content-bd766961.js";import{C as E,a as M,_ as V}from"./Card-e7102610.js";import{T as z,a as D,_ as x,b as g,c as F,d as f}from"./Table-278ffbd2.js";import{d as T,b as H,e as $,o as i,c as m,a as l,l as n,t as u,F as C,q as P,h as a,g as e,u as t,y as R,K as S,k as I,Z as K,n as Z,j as A,f as w,m as G}from"./app-ff9ff714.js";import{T as U}from"./toastify-36657954.js";import{M as v}from"./modal-faea5502.js";import{_ as J}from"./SearchModal.vue_vue_type_script_setup_true_lang-8adedfc9.js";import{_ as O}from"./CreateModal.vue_vue_type_script_setup_true_lang-ce853ca9.js";import{_ as Q}from"./EditModal.vue_vue_type_script_setup_true_lang-801d7b34.js";import{_ as W}from"./DeleteModal.vue_vue_type_script_setup_true_lang-6068a17f.js";import"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-a432a803.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Footer-61a96086.js";import"./Head.vue_vue_type_script_setup_true_lang-f77b6573.js";import"./Input.vue_vue_type_script_setup_true_lang-c51e0bbf.js";import"./Label.vue_vue_type_script_setup_true_lang-cb48c286.js";import"./Select.vue_vue_type_script_setup_true_lang-1001c70b.js";import"./vue-select-61ccd8a2.js";import"./Error.vue_vue_type_script_setup_true_lang-c6dbfeeb.js";const X={class:"m-6 flex justify-between items-center"},Y={class:"text-sm"},aa={class:"text-dark"},ea={class:"text-dark"},ta={class:"text-dark"},sa={class:"flex gap-2"},oa=T({__name:"Pagination",props:{pagination:{}},setup(k){const d=k,c=H(()=>d.pagination.links.map(o=>{const h="&laquo; Previous",_="Next &raquo;";let s="";return o.label===h?s="Previous":o.label===_?s="Next":s=o.label,{...o,label:s}}));return(o,h)=>{const _=$("ease-button");return i(),m("div",X,[l("p",Y,[n("Showing data from "),l("span",aa,u(o.pagination.from),1),n(" - "),l("span",ea,u(o.pagination.to),1),n(" out of "),l("span",ta,u(o.pagination.total),1),n(" total data ")]),l("ul",sa,[(i(!0),m(C,null,P(c.value,s=>(i(),m("li",null,[a(t(R),{href:s.url||""},{default:e(()=>[a(_,{variant:s.active?"primary":"transparent",disabled:s.url===null,text:s.label},null,8,["variant","disabled","text"])]),_:2},1032,["href"])]))),256))])])}}}),na={class:"flex justify-between items-center"},ra={class:"flex"},Ta=T({__name:"Index",props:{users:{},roles:{}},setup(k){const d=k,c=S();function o(){v.pop(J,{roles:d.roles})}function h(){v.pop(O,{roles:d.roles})}function _(r){v.pop(Q,{user:r,roles:d.roles})}function s(r){v.pop(W,{id:r})}return I(()=>{c.props.flash.success&&U.success(c.props.flash.success),c.props.flash.error&&U.error(c.props.flash.error)}),(r,la)=>{const y=$("fas-icon"),b=$("ease-button");return i(),m(C,null,[a(t(K),{title:"Users"}),a(L,null,{breadcrumb:e(()=>[a(j,Z(A({second:"Master",current:"Users"})),null,16)]),default:e(()=>[a(q,null,{default:e(()=>[a(t(E),null,{default:e(()=>[a(t(M),{class:"mb-4"},{default:e(()=>[l("div",na,[a(b,{onClick:h,slotted:""},{default:e(()=>[a(y,{icon:"fa-solid fa-plus",class:"mr-1"}),n(" Tambah User ")]),_:1}),a(b,{onClick:o,variant:"transparent",slotted:""},{default:e(()=>[a(y,{icon:"fa-solid fa-search",class:"mr-1"}),n(" Pencarian ")]),_:1})])]),_:1}),a(t(V),{table:""},{default:e(()=>[a(t(z),null,{default:e(()=>[a(t(D),null,{default:e(()=>[a(t(x),null,{default:e(()=>[a(t(g),{value:"Nama"}),a(t(g),{value:"Email"}),a(t(g),{value:"Role"}),a(t(g))]),_:1})]),_:1}),a(t(F),null,{default:e(()=>[r.users.data.length?(i(!0),m(C,{key:0},P(r.users.data,(p,N)=>(i(),w(t(x),G({key:p.id},{last:N===r.users.data.length-1}),{default:e(()=>[a(t(f),{whitespace:"nowrap",class:"font-semibold text-dark"},{default:e(()=>[n(u(p.name),1)]),_:2},1024),a(t(f),{whitespace:"nowrap"},{default:e(()=>[n(u(p.email),1)]),_:2},1024),a(t(f),{whitespace:"normal",class:"capitalize font-semibold text-dark"},{default:e(()=>[n(u(p.role_name),1)]),_:2},1024),a(t(f),{whitespace:"nowrap"},{default:e(()=>[l("div",ra,[a(b,{onClick:B=>_(p),variant:"link",text:"Edit"},null,8,["onClick"]),a(b,{onClick:B=>s(p.id),variant:"danger-link",text:"Delete"},null,8,["onClick"])])]),_:2},1024)]),_:2},1040))),128)):(i(),w(t(x),{key:1,last:""},{default:e(()=>[a(t(f),{colspan:"4","text-align":"center"},{default:e(()=>[n(" User tidak ditemukan ")]),_:1})]),_:1}))]),_:1})]),_:1}),a(oa,{pagination:r.users},null,8,["pagination"])]),_:1})]),_:1})]),_:1})]),_:1})],64)}}});export{Ta as default};
