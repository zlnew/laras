import{a as i,_ as u,C as _}from"./Card-7904da0e.js";import{d as c,b as p,f as m,g as e,u as l,o as f,h as r,a,t,x as h}from"./app-7652bf12.js";const g=a("div",{class:"flex justify-between items-center"},[a("h5",{class:"font-bold text-xl"},"Informasi Pencairan Dana")],-1),y=a("td",null,"Proyek",-1),k=a("td",{class:"pl-6 pr-3"},":",-1),x={class:"font-medium text-primary"},C=a("td",null,"Tahun Anggaran",-1),b=a("td",{class:"pl-6 pr-3"},":",-1),v={class:"font-medium text-primary"},P=a("td",null,"Pengguna Jasa",-1),w=a("td",{class:"pl-6 pr-3"},":",-1),B={class:"font-medium text-primary"},j=a("td",null,"Keperluan",-1),D=a("td",{class:"pl-6 pr-3"},":",-1),I={class:"font-medium text-primary"},N=a("td",null,"Status Pencairan",-1),S=a("td",{class:"pl-6 pr-3"},":",-1),H=c({__name:"Informasi.p",props:{keuangan:{},pencairan_dana:{}},setup(d){const o=d,s=p(()=>{const n=o.pencairan_dana.status_pencairan==400?"Closed":"Open";return{...o.pencairan_dana,status_pencairan_in_string:n}});return(n,V)=>(f(),m(l(_),{class:"w-fit"},{default:e(()=>[r(l(i),null,{default:e(()=>[g]),_:1}),r(l(u),null,{default:e(()=>[a("table",null,[a("tbody",null,[a("tr",null,[y,k,a("td",null,[a("span",x,t(n.keuangan.nama_proyek),1)])]),a("tr",null,[C,b,a("td",null,[a("span",v,t(n.keuangan.tahun_anggaran),1)])]),a("tr",null,[P,w,a("td",null,[a("span",B,t(n.keuangan.pengguna_jasa),1)])]),a("tr",null,[j,D,a("td",null,[a("span",I,t(n.keuangan.keperluan),1)])]),a("tr",null,[N,S,a("td",null,[a("span",{class:h(["font-semibold",{"text-primary":s.value.status_pencairan==100,"text-danger":s.value.status_pencairan==400}])},t(s.value.status_pencairan_in_string),3)])])])])]),_:1})]),_:1}))}});export{H as _};