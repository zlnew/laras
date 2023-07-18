import{d as w,T as C,e as y,c as m,h as s,g as i,u as a,i as U,o as d,a as l,m as n,F as x,q as z,w as c,s as v,t as _,n as $,j as B}from"./app-803e4503.js";import{u as M}from"./Modal.vue_vue_type_style_index_0_scoped_fdb70d85_lang-e580dfec.js";import{M as F,a as P,_ as H}from"./Footer-87f34d66.js";import{_ as R}from"./Head.vue_vue_type_script_setup_true_lang-5a39fa07.js";import{_ as g}from"./Input.vue_vue_type_script_setup_true_lang-15558a1c.js";import{_ as r}from"./Label.vue_vue_type_script_setup_true_lang-9987f883.js";import{_ as u}from"./Error.vue_vue_type_script_setup_true_lang-e2e0b7ba.js";import{_ as T}from"./Select.vue_vue_type_script_setup_true_lang-a0912154.js";import{_ as D}from"./Textarea.vue_vue_type_script_setup_true_lang-2965e452.js";import"./vue-select-834fdd5f.js";import{t as h}from"./number-6d20867b.js";const K=["onSubmit"],L={class:"w-full mb-4"},N={class:"w-full mb-4 grid grid-cols-2 gap-4"},j=l("option",{value:""},"Pilih Satuan",-1),q=["value"],A={class:"w-full mb-4"},E={class:"grid grid-cols-2 gap-4"},G={class:"ml-1"},I={class:"w-full"},la=w({__name:"Create.m",props:{id_rab:{},satuan:{}},setup(V){const b=V,p=M(),e=C({uraian:null,id_satuan:null,volume:0,harga_satuan:0,keterangan:null});function k(){e.post(route("detail_rab.store",b.id_rab),{onSuccess:()=>{p.close()}})}return(S,t)=>{const f=y("ease-button");return d(),m("form",{onSubmit:U(k,["prevent"])},[s(a(H),{size:"lg"},{default:i(()=>[s(a(R),{title:"Form Tambah Uraian RAB"}),s(a(F),null,{default:i(()=>[l("div",L,[s(a(r),{for:"uraian",value:"Uraian"}),s(a(g),n({modelValue:a(e).uraian,"onUpdate:modelValue":t[0]||(t[0]=o=>a(e).uraian=o)},{type:"text",id:"uraian",size:"lg",autocomplete:"off",placeholder:"Uraian"}),null,16,["modelValue"]),s(a(u),{class:"mt-2",message:a(e).errors.uraian},null,8,["message"])]),l("div",N,[l("div",null,[s(a(r),{for:"volume",value:"Volume"}),s(a(g),n({modelValue:a(e).volume,"onUpdate:modelValue":t[1]||(t[1]=o=>a(e).volume=o)},{type:"number",id:"volume",size:"lg",autocomplete:"off",placeholder:"Volume"}),null,16,["modelValue"]),s(a(u),{class:"mt-2",message:a(e).errors.volume},null,8,["message"])]),l("div",null,[s(a(r),{for:"id_satuan",value:"Satuan"}),s(a(T),n({modelValue:a(e).id_satuan,"onUpdate:modelValue":t[2]||(t[2]=o=>a(e).id_satuan=o)},{id:"id_satuan",size:"lg"}),{default:i(()=>[j,(d(!0),m(x,null,z(S.satuan,o=>(d(),m("option",{value:o.id_satuan},_(o.nama_satuan),9,q))),256))]),_:1},16,["modelValue"]),s(a(u),{class:"mt-2",message:a(e).errors.id_satuan},null,8,["message"])])]),l("div",A,[l("div",E,[l("div",null,[s(a(r),{for:"harga_satuan",value:"Harga Satuan"}),c(l("small",{class:"ml-1"}," : "+_(a(h)(a(e).harga_satuan)),513),[[v,a(e).harga_satuan]])]),c(l("div",null,[s(a(r),{for:"harga_satuan",value:"Harga Total"}),l("small",G,": "+_(a(h)(a(e).harga_satuan*a(e).volume)),1)],512),[[v,a(e).harga_satuan]])]),s(a(g),n({modelValue:a(e).harga_satuan,"onUpdate:modelValue":t[3]||(t[3]=o=>a(e).harga_satuan=o)},{type:"number",id:"harga_satuan",size:"lg",autocomplete:"off",placeholder:"Harga Satuan"}),null,16,["modelValue"]),s(a(u),{class:"mt-2",message:a(e).errors.harga_satuan},null,8,["message"])]),l("div",I,[s(a(r),{for:"keterangan",value:"Keterangan"}),s(a(D),n({modelValue:a(e).keterangan,"onUpdate:modelValue":t[4]||(t[4]=o=>a(e).keterangan=o)},{type:"text",id:"keterangan",size:"lg",autocomplete:"off",placeholder:"Keterangan"}),null,16,["modelValue"]),s(a(u),{class:"mt-2",message:a(e).errors.keterangan},null,8,["message"])])]),_:1}),s(a(P),null,{default:i(()=>[s(f,n({onClick:a(p).close},{variant:"transparent",type:"button",text:"Close"}),null,16,["onClick"]),s(f,$(B({type:"submit",text:"Create",loading:a(e).processing,onLoading:()=>({text:"Creating data..."})})),null,16)]),_:1})]),_:1})],40,K)}}});export{la as _};
