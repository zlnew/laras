import{d as c,c as h,a as e,r as g,t as x,u as s,F as b,o as u,b as v,w,v as k,T as y,e as $,f as V,g as B,h as a,Z as C,i as S,m as p,n as L,j as z}from"./app-803e4503.js";import{_}from"./Input.vue_vue_type_script_setup_true_lang-15558a1c.js";import{_ as m}from"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import{_ as f}from"./Error.vue_vue_type_script_setup_true_lang-e2e0b7ba.js";import"./vue-select-834fdd5f.js";const D={class:"mt-0 transition-all duration-200 ease-soft-in-out"},E={class:"py-12"},P={class:"container"},F={class:"flex flex-wrap -mx-3"},M={class:"w-8/12 max-w-full px-3 mx-auto mt-1 text-center flex-0"},U={class:"mb-0 text-slate-400"},j=c({__name:"GuestLayout",setup(d){const t=new Date().getFullYear();return(r,n)=>(u(),h(b,null,[e("main",D,[g(r.$slots,"default")]),e("footer",E,[e("div",P,[e("div",F,[e("div",M,[e("p",U," Copyright © "+x(s(t))+" Creatoku All Rights Reserved. ",1)])])])])],64))}}),R=["value"],N=c({__name:"Checkbox",props:{checked:{type:Boolean},value:{}},emits:["update:checked"],setup(d,{emit:t}){const r=d,n=v({get(){return r.checked},set(o){t("update:checked",o)}});return(o,i)=>w((u(),h("input",{type:"checkbox",value:o.value,"onUpdate:modelValue":i[0]||(i[0]=l=>n.value=l),class:"rounded border-light text-primary shadow-sm focus:ring-primary"},null,8,R)),[[k,n.value]])}}),Y={class:"relative bg-white flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen"},A={class:"container z-10"},G={class:"flex flex-wrap mt-0 -mx-3"},I={class:"flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12"},T={class:"relative flex flex-col min-w-0 mt-32 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border"},Z=e("div",{class:"p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl"},[e("h3",{class:"mb-2 text-3xl relative z-10 font-bold text-transparent text-gradient"},"Selamat Datang"),e("p",{class:"mb-0 text-slate-500"},"Silahkan masukkan email dan password anda untuk melanjutkan.")],-1),q={class:"flex-auto p-6"},H=["onSubmit"],J={class:"mb-4"},K={class:"mb-4"},O={class:"mb-4 space-x-2"},Q={class:"text-center"},W=e("div",{class:"w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12"},[e("div",{class:"absolute top-0 hidden w-3/5 h-full -mr-32 -right-40 md:block"},[e("div",{style:{"background-image":"url('/storage/login_bg.jpg')"},class:"absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover overflow-hidden -skew-x-10 rounded-bl-xl"}),e("img",{src:"/storage/logo.png",class:"absolute w-1/2 bg-white p-2 bottom-20 mr-40 right-40",alt:"Laras Sembada Logo"}),e("div",{class:"absolute bottom-6 mr-40 right-40"},[e("h4",{class:"text-[25.7px] text-white font-outline-1 drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]"}," Membangun Masa Depan Bersama ")])])],-1),ae=c({__name:"Login",setup(d){const t=y({email:"",password:"",remember:!1}),r=()=>{t.post(route("login"),{onFinish:()=>t.reset("password")})};return(n,o)=>{const i=$("EaseButton");return u(),V(j,null,{default:B(()=>[a(s(C),{title:"Login"}),e("section",null,[e("div",Y,[e("div",A,[e("div",G,[e("div",I,[e("div",T,[Z,e("div",q,[e("form",{onSubmit:S(r,["prevent"])},[a(s(m),{for:"email",value:"Email"}),e("div",J,[a(s(_),p({modelValue:s(t).email,"onUpdate:modelValue":o[0]||(o[0]=l=>s(t).email=l)},{type:"text",id:"email",size:"lg",autocomplete:"off",placeholder:"Email"}),null,16,["modelValue"]),a(s(f),{class:"mt-2",message:s(t).errors.email},null,8,["message"])]),a(s(m),{for:"password",value:"Password"}),e("div",K,[a(s(_),p({modelValue:s(t).password,"onUpdate:modelValue":o[1]||(o[1]=l=>s(t).password=l)},{type:"password",id:"password",size:"lg",autocomplete:"off",placeholder:"Password"}),null,16,["modelValue"]),a(s(f),{class:"mt-2",message:s(t).errors.password},null,8,["message"])]),e("div",O,[a(s(N),{id:"remember_me",name:"remember",checked:s(t).remember,"onUpdate:checked":o[2]||(o[2]=l=>s(t).remember=l)},null,8,["checked"]),a(s(m),{for:"remember_me",value:"Ingat Saya"})]),e("div",Q,[a(i,L(z({type:"submit",variant:"primary",text:"Log in",class:"w-full",loading:s(t).processing,onLoading:()=>({text:"Verifying user"})})),null,16)])],40,H)])])]),W])])])])]),_:1})}}});export{ae as default};
