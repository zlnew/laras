import{d as c,T as p,e as u,f as m,g as a,u as e,o as _,h as n,m as i,i as g,a as f}from"./app-ff9ff714.js";import{u as k}from"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-a432a803.js";import{M as h,a as C,_ as y}from"./Footer-61a96086.js";import{_ as x}from"./Head.vue_vue_type_script_setup_true_lang-f77b6573.js";const M=f("p",null,"Apakah anda yakin ingin menghapus rekening ini? Semua data yang berkaitan dengan rekening ini akan hilang.",-1),N=c({__name:"DeleteModal",props:{id_rekening:{}},setup(r){const l=r,t=k(),o=p({});function d(){o.delete(route("rekening.destroy",l.id_rekening),{onSuccess:()=>{t.close()}})}return(b,v)=>{const s=u("ease-button");return _(),m(e(y),{size:"md"},{default:a(()=>[n(e(x),{title:"Konfirmasi Penghapusan Rekening"}),n(e(h),null,{default:a(()=>[M]),_:1}),n(e(C),null,{default:a(()=>[n(s,i({onClick:e(t).close},{type:"button",text:"Close",variant:"transparent"}),null,16,["onClick"]),n(s,i({onClick:g(d,["prevent"])},{variant:"danger-transparent",type:"submit",text:"Yes, delete it!",loading:e(o).processing,onLoading:()=>({text:"Deleting data..."})}),null,16,["onClick"])]),_:1})]),_:1})}}});export{N as _};