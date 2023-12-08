import{P as B,L as O,M as x,ax as V,l as d,a7 as Q,U as l,a0 as T,ay as z,az as F,z as H,ak as M,al as A,a4 as I,d as E,o as y,c as S,w as i,u as $,q as K,a as n,s as C,g as p,t as _,h as b,v as U,e as L,k as X,F as Y,y as N,b as g,B as w}from"./app-a9c22e82.js";import{Q as q}from"./datetime-dc60c162.js";import{u as G}from"./use-quasar-954ed4d5.js";import{l as J,o as W,h as Z}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-b69e3ed2.js";import"./QTable-0e41b0f2.js";import{f as ee,_ as te}from"./ProyekDeleteDialog.vue_vue_type_script_setup_true_lang-29a71a0e.js";import{u as j,Q as ae}from"./use-dialog-plugin-component-646efe56.js";const ie={position:{type:String,default:"bottom-right",validator:e=>["top-right","top-left","bottom-right","bottom-left","top","right","bottom","left"].includes(e)},offset:{type:Array,validator:e=>e.length===2},expand:Boolean};function oe(){const{props:e,proxy:{$q:o}}=B(),t=O(V,x);if(t===x)return console.error("QPageSticky needs to be child of QLayout"),x;const f=d(()=>{const r=e.position;return{top:r.indexOf("top")>-1,right:r.indexOf("right")>-1,bottom:r.indexOf("bottom")>-1,left:r.indexOf("left")>-1,vertical:r==="top"||r==="bottom",horizontal:r==="left"||r==="right"}}),u=d(()=>t.header.offset),a=d(()=>t.right.offset),s=d(()=>t.footer.offset),m=d(()=>t.left.offset),c=d(()=>{let r=0,v=0;const h=f.value,P=o.lang.rtl===!0?-1:1;h.top===!0&&u.value!==0?v=`${u.value}px`:h.bottom===!0&&s.value!==0&&(v=`${-s.value}px`),h.left===!0&&m.value!==0?r=`${P*m.value}px`:h.right===!0&&a.value!==0&&(r=`${-P*a.value}px`);const k={transform:`translate(${r}, ${v})`};return e.offset&&(k.margin=`${e.offset[1]}px ${e.offset[0]}px`),h.vertical===!0?(m.value!==0&&(k[o.lang.rtl===!0?"right":"left"]=`${m.value}px`),a.value!==0&&(k[o.lang.rtl===!0?"left":"right"]=`${a.value}px`)):h.horizontal===!0&&(u.value!==0&&(k.top=`${u.value}px`),s.value!==0&&(k.bottom=`${s.value}px`)),k}),D=d(()=>`q-page-sticky row flex-center fixed-${e.position} q-page-sticky--${e.expand===!0?"expand":"shrink"}`);function R(r){const v=Q(r.default);return l("div",{class:D.value,style:c.value},e.expand===!0?v:[l("div",v)])}return{$layout:t,getStickyContent:R}}const qe=T({name:"QPageSticky",props:ie,setup(e,{slots:o}){const{getStickyContent:t}=oe();return()=>t(o)}}),ne=T({name:"QTimelineEntry",props:{heading:Boolean,tag:{type:String,default:"h3"},side:{type:String,default:"right",validator:e=>["left","right"].includes(e)},icon:String,avatar:String,color:String,title:String,subtitle:String,body:String},setup(e,{slots:o}){const t=O(z,x);if(t===x)return console.error("QTimelineEntry needs to be child of QTimeline"),x;const f=d(()=>`q-timeline__entry q-timeline__entry--${e.side}`+(e.icon!==void 0||e.avatar!==void 0?" q-timeline__entry--icon":"")),u=d(()=>`q-timeline__dot text-${e.color||t.color}`),a=d(()=>t.layout==="comfortable"&&t.side==="left");return()=>{const s=F(o.default,[]);if(e.body!==void 0&&s.unshift(e.body),e.heading===!0){const D=[l("div"),l("div"),l(e.tag,{class:"q-timeline__heading-title"},s)];return l("div",{class:"q-timeline__heading"},a.value===!0?D.reverse():D)}let m;e.icon!==void 0?m=[l(H,{class:"row items-center justify-center",name:e.icon})]:e.avatar!==void 0&&(m=[l("img",{class:"q-timeline__dot-img",src:e.avatar})]);const c=[l("div",{class:"q-timeline__subtitle"},[l("span",{},Q(o.subtitle,[e.subtitle]))]),l("div",{class:u.value},m),l("div",{class:"q-timeline__content"},[l("h6",{class:"q-timeline__title"},Q(o.title,[e.title]))].concat(s))];return l("li",{class:f.value},a.value===!0?c.reverse():c)}}}),se=T({name:"QTimeline",props:{...M,color:{type:String,default:"primary"},side:{type:String,default:"right",validator:e=>["left","right"].includes(e)},layout:{type:String,default:"dense",validator:e=>["dense","comfortable","loose"].includes(e)}},setup(e,{slots:o}){const t=B(),f=A(e,t.proxy.$q);I(z,e);const u=d(()=>`q-timeline q-timeline--${e.layout} q-timeline--${e.layout}--${e.side}`+(f.value===!0?" q-timeline--dark":""));return()=>l("ul",{class:u.value},Q(o.default))}}),le={class:"text-h6"},re={class:"q-px-lg q-py-md"},ce={class:"text-subtitle1"},ue={class:"text-caption text-grey-8"},de={class:"text-weight-bold"},fe={class:"text-capitalize"},me=E({__name:"TimelineDialog",props:{title:{},timeline:{}},emits:[...j.emits],setup(e){const{dialogRef:o,onDialogCancel:t,onDialogHide:f}=j(),u=s=>{switch(s){case"Dibuat":return"commit";case"Diajukan":return"send";case"Dibayar":return"price_check";case"Ditolak":return"priority_high";case"Disetujui":return"done_all";case"Diterima Bertahap":return"done";case"Diterima":return"done_all"}},a=s=>{switch(s){case"Dibuat":return"secondary";case"Diajukan":return"primary";case"Dibayar":return"primary";case"Ditolak":return"red";case"Disetujui":return"green";case"Diterima Bertahap":return"green";case"Diterima":return"green"}};return(s,m)=>(y(),S(K,{ref_key:"dialogRef",ref:o,onHide:$(f)},{default:i(()=>[n(N,{style:{width:"700px","max-width":"80vw"}},{default:i(()=>[n(C,{class:"row items-center q-pb-none"},{default:i(()=>[p("div",le,_(s.title),1),n(ae),n(b,{flat:"",round:"",dense:"",icon:"close",onClick:$(t)},null,8,["onClick"])]),_:1}),n(U),n(C,{class:"scroll"},{default:i(()=>[p("div",re,[n(se,{layout:"comfortable",color:"secondary"},{default:i(()=>[(y(!0),L(Y,null,X(s.timeline,c=>(y(),S(ne,{key:c.id_timeline,subtitle:$(ee)(c.created_at),body:c.catatan,color:a(c.status_aktivitas),icon:u(c.status_aktivitas)},{title:i(()=>[p("div",ce,_(c.status_aktivitas),1),p("div",ue,[g(" Oleh "),p("span",de,_(c.user_name),1),g(" - "),p("span",fe,_(c.user_role),1)])]),_:2},1032,["subtitle","body","color","icon"]))),128))]),_:1})])]),_:1})]),_:1})]),_:1},8,["onHide"]))}}),pe={class:"q-px-md q-pt-md"},_e={class:"row justify-between items-center"},ge={class:"text-h6 line-clamp"},Se=E({__name:"ModuleTopSection",props:{data:{},title:{},timelineTitle:{}},setup(e){const o=e,t=G();function f(){t.dialog({component:te,componentProps:{proyek:o.data.proyek}})}function u(){t.dialog({component:me,componentProps:{title:o.timelineTitle,timeline:o.data.timeline}})}return(a,s)=>(y(),L("div",pe,[n(N,{flat:"",bordered:""},{default:i(()=>[p("div",_e,[n(C,{class:"col-6"},{default:i(()=>[n(b,{flat:"","no-caps":"",dense:"",onClick:f},{default:i(()=>[p("div",ge,_(a.title)+" - "+_(a.data.proyek.nama_proyek),1),n(q,null,{default:i(()=>[g(_(a.data.proyek.nama_proyek),1)]),_:1})]),_:1})]),_:1}),n(C,{class:"q-gutter-x-sm"},{default:i(()=>[$(J)(a.data.proyek)?(y(),S(b,{key:0,flat:"",dense:"",round:"",color:"grey-6",icon:"warning"},{default:i(()=>[n(q,null,{default:i(()=>[g("Ditolak")]),_:1})]),_:1})):w("",!0),$(W)(a.data.proyek)?(y(),S(b,{key:1,flat:"",dense:"",round:"",color:"grey",icon:"done_all"},{default:i(()=>[n(q,null,{default:i(()=>[g("Telah Disetujui")]),_:1})]),_:1})):w("",!0),$(Z)(a.data.proyek)?(y(),S(b,{key:2,flat:"",dense:"",round:"",color:"grey",icon:"rotate_right"},{default:i(()=>[n(q,null,{default:i(()=>[g("Menunggu Persetujuan")]),_:1})]),_:1})):w("",!0),n(b,{rounded:"","icon-right":"expand_more",label:a.data.status==="400"?"Closed":"Open",color:a.data.status==="400"?"red":"primary",onClick:u},{default:i(()=>[n(q,null,{default:i(()=>[g("Lihat Timeline "+_(a.title),1)]),_:1})]),_:1},8,["label","color"])]),_:1})])]),_:1})]))}});export{qe as Q,Se as _};