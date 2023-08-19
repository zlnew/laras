import{T as N,b as R,_ as U,c as E}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-a4ebee6d.js";import{G as T,ak as G,H,al as J,j as p,l as b,a4 as Q,M as g,a8 as C,am as Z,a0 as K,J as W,d as O,o as m,e as f,a as r,w as d,q as D,g as F,h as $,F as V,k as S,x as X,O as j,f as Y,m as ee,u as A,Z as ae,n as te}from"./app-794bfe05.js";import{u as le}from"./use-quasar-1e1c8a18.js";import"./QImg-766bfd11.js";const re=T({name:"QSplitter",props:{...G,modelValue:{type:Number,required:!0},reverse:Boolean,unit:{type:String,default:"%",validator:e=>["%","px"].includes(e)},limits:{type:Array,validator:e=>e.length!==2||typeof e[0]!="number"||typeof e[1]!="number"?!1:e[0]>=0&&e[0]<=e[1]},emitImmediately:Boolean,horizontal:Boolean,disable:Boolean,beforeClass:[Array,String,Object],afterClass:[Array,String,Object],separatorClass:[Array,String,Object],separatorStyle:[Array,String,Object]},emits:["update:modelValue"],setup(e,{slots:i,emit:l}){const{proxy:{$q:c}}=H(),h=J(e,c),s=p(null),y={before:p(null),after:p(null)},n=b(()=>`q-splitter no-wrap ${e.horizontal===!0?"q-splitter--horizontal column":"q-splitter--vertical row"} q-splitter--${e.disable===!0?"disabled":"workable"}`+(h.value===!0?" q-splitter--dark":"")),u=b(()=>e.horizontal===!0?"height":"width"),t=b(()=>e.reverse!==!0?"before":"after"),o=b(()=>e.limits!==void 0?e.limits:e.unit==="%"?[10,90]:[50,1/0]);function z(a){return(e.unit==="%"?a:Math.round(a))+e.unit}const P=b(()=>({[t.value]:{[u.value]:z(e.modelValue)}}));let w,q,B,x,v;function I(a){if(a.isFirst===!0){const k=s.value.getBoundingClientRect()[u.value];w=e.horizontal===!0?"up":"left",q=e.unit==="%"?100:k,B=Math.min(q,o.value[1],Math.max(o.value[0],e.modelValue)),x=(e.reverse!==!0?1:-1)*(e.horizontal===!0?1:c.lang.rtl===!0?-1:1)*(e.unit==="%"?k===0?0:100/k:1),s.value.classList.add("q-splitter--active");return}if(a.isFinal===!0){v!==e.modelValue&&l("update:modelValue",v),s.value.classList.remove("q-splitter--active");return}const _=B+x*(a.direction===w?-1:1)*a.distance[e.horizontal===!0?"y":"x"];v=Math.min(q,o.value[1],Math.max(o.value[0],_)),y[t.value].value.style[u.value]=z(v),e.emitImmediately===!0&&e.modelValue!==v&&l("update:modelValue",v)}const L=b(()=>[[N,I,void 0,{[e.horizontal===!0?"vertical":"horizontal"]:!0,prevent:!0,stop:!0,mouse:!0,mouseAllDir:!0}]]);function M(a,_){a<_[0]?l("update:modelValue",_[0]):a>_[1]&&l("update:modelValue",_[1])}return Q(()=>e.modelValue,a=>{M(a,o.value)}),Q(()=>e.limits,()=>{W(()=>{M(e.modelValue,o.value)})}),()=>{const a=[g("div",{ref:y.before,class:["q-splitter__panel q-splitter__before"+(e.reverse===!0?" col":""),e.beforeClass],style:P.value.before},C(i.before)),g("div",{class:["q-splitter__separator",e.separatorClass],style:e.separatorStyle,"aria-disabled":e.disable===!0?"true":void 0},[Z("div",{class:"q-splitter__separator-area absolute-full"},C(i.separator),"sep",e.disable!==!0,()=>L.value)]),g("div",{ref:y.after,class:["q-splitter__panel q-splitter__after"+(e.reverse===!0?"":" col"),e.afterClass],style:P.value.after},C(i.after))];return g("div",{class:n.value,ref:s},K(i.default,a))}}}),se={class:"q-pa-md"},ie={class:"flex justify-between q-gutter-col-sm"},ne=F("div",{class:"text-h6"},"Edit Permissions",-1),oe=O({__name:"PermissionsForm",props:{data:{}},setup(e){const i=e,l=p(),c=p(i.data.rolePermissions),h=le();function s(){j.post(route("permissions.sync",i.data.role.id),{permissions:c.value},{onSuccess:n=>{h.notify({color:"positive",message:n.props.flash.success,position:"top"})}})}function y(n){j.get(route("permissions",{role:n}),void 0,{preserveScroll:!0})}return(n,u)=>(m(),f("div",se,[r(X,{flat:"",bordered:"",style:{width:"fit-content"}},{default:d(()=>[r(D,null,{default:d(()=>[F("div",ie,[ne,r($,{flat:"",dense:"",label:"Save Changes",color:"primary",onClick:s})])]),_:1}),r(D,null,{default:d(()=>[r(re,{modelValue:l.value,"onUpdate:modelValue":u[1]||(u[1]=t=>l.value=t)},{before:d(()=>[(m(!0),f(V,null,S(n.data.roles,t=>(m(),f("div",{key:t.id,class:"q-pr-sm"},[r($,{flat:"",dense:"","no-caps":"",label:t.name,color:n.data.role.name===t.name?"primary":"secondary",align:"left",style:{width:"100%"},class:"text-capitalize",onClick:o=>y(t.name)},null,8,["label","color","onClick"])]))),128))]),after:d(()=>[(m(!0),f(V,null,S(n.data.permissions,t=>(m(),f("div",{key:t,class:"q-pl-sm text-capitalize"},[r(Y,{modelValue:c.value,"onUpdate:modelValue":u[0]||(u[0]=o=>c.value=o),val:t,label:t},null,8,["modelValue","val","label"])]))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]))}}),fe=O({__name:"PermissionsPage",props:{roles:{},permissions:{},role:{},rolePermissions:{}},setup(e){const i=[{label:"Master",url:"#"},{label:"User Permissions",url:"#"}];return(l,c)=>{const h=ee("in-link");return m(),f(V,null,[r(A(ae),{title:"User Permissions"}),r(U,null,{breadcrumbs:d(()=>[r(R,{align:"left"},{default:d(()=>[(m(),f(V,null,S(i,s=>te(r(E,{key:s.label,label:s.label},null,8,["label"]),[[h,s.url]])),64))]),_:1})]),default:d(()=>[r(A(oe),{data:{roles:l.roles,permissions:l.permissions,role:l.role,rolePermissions:l.rolePermissions}},null,8,["data"])]),_:1})],64)}}});export{fe as default};
