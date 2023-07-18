import{d as U,T as y,e as C,c as r,h as t,g as u,u as a,i as x,o as d,a as i,m as _,F as B,q as P,t as h,p as M,n as S,j as $}from"./app-803e4503.js";import{u as k}from"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-e580dfec.js";import{M as w,a as z,_ as R}from"./Footer-87f34d66.js";import{_ as A}from"./Head.vue_vue_type_script_setup_true_lang-5a39fa07.js";import{_ as f}from"./Input.vue_vue_type_script_setup_true_lang-15558a1c.js";import{_ as m}from"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import{_ as c}from"./Error.vue_vue_type_script_setup_true_lang-e2e0b7ba.js";import{_ as F}from"./Select.vue_vue_type_script_setup_true_lang-a0912154.js";import"./vue-select-834fdd5f.js";import{t as j}from"./number-6d20867b.js";const N=["onSubmit"],D={class:"w-full mb-4"},E=i("option",{value:""},"Pilih Uraian",-1),L=["value"],q={class:"w-full mb-4 grid grid-cols-2 gap-4"},H={key:0,class:"w-full mb-4"},J={id:"jumlah_penagihan",class:"mt-2"},aa=U({__name:"EditModal",props:{detail_penagihan:{},detail_rab:{}},setup(v){const l=v,g=k(),e=y({id_detail_rab:l.detail_penagihan.id_detail_rab,volume_penagihan:l.detail_penagihan.volume_penagihan,harga_satuan:l.detail_penagihan.harga_satuan});function b(p){const n=l.detail_rab.find(s=>s.id_detail_rab==p);n?e.harga_satuan=n.harga_satuan:e.reset("harga_satuan")}function V(){e.patch(route("penagihan.update",l.detail_penagihan.id_detail_penagihan),{onSuccess:()=>{g.close()}})}return(p,n)=>{const s=C("ease-button");return d(),r("form",{onSubmit:x(V,["prevent"])},[t(a(R),{size:"2xl"},{default:u(()=>[t(a(A),{title:"Form Ubah Uraian Penagihan"}),t(a(w),null,{default:u(()=>[i("div",D,[t(a(m),{for:"id_detail_rab",value:"Uraian RAB"}),t(a(F),_({modelValue:a(e).id_detail_rab,"onUpdate:modelValue":n[0]||(n[0]=o=>a(e).id_detail_rab=o),onChange:n[1]||(n[1]=o=>b(o.target.value))},{id:"id_detail_rab",size:"lg"}),{default:u(()=>[E,(d(!0),r(B,null,P(p.detail_rab,o=>(d(),r("option",{value:o.id_detail_rab},h(o.uraian),9,L))),256))]),_:1},16,["modelValue"]),t(a(c),{class:"mt-2",message:a(e).errors.id_detail_rab},null,8,["message"])]),i("div",q,[i("div",null,[t(a(m),{for:"volume_penagihan",value:"Volume"}),t(a(f),_({modelValue:a(e).volume_penagihan,"onUpdate:modelValue":n[2]||(n[2]=o=>a(e).volume_penagihan=o)},{type:"number",id:"volume_penagihan",size:"lg",placeholder:"Volume Penagihan"}),null,16,["modelValue"]),t(a(c),{class:"mt-2",message:a(e).errors.volume_penagihan},null,8,["message"])]),i("div",null,[t(a(m),{for:"harga_satuan",value:"Harga Satuan"}),t(a(f),_({modelValue:a(e).harga_satuan,"onUpdate:modelValue":n[3]||(n[3]=o=>a(e).harga_satuan=o)},{type:"text",id:"harga_satuan",size:"lg",readonly:!0}),null,16,["modelValue"])])]),a(e).volume_penagihan>0?(d(),r("div",H,[t(a(m),{for:"jumlah_penagihan",value:"Jumlah Penagihan"}),i("p",J,h(a(j)(a(e).volume_penagihan*a(e).harga_satuan)),1)])):M("",!0)]),_:1}),t(a(z),null,{default:u(()=>[t(s,_({onClick:a(g).close},{variant:"transparent",type:"button",text:"Close"}),null,16,["onClick"]),t(s,S($({type:"submit",text:"Update",loading:a(e).processing,onLoading:()=>({text:"Updating data..."})})),null,16)]),_:1})]),_:1})],40,N)}}});export{aa as _};
