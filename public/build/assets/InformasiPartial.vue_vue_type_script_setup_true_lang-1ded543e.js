import{a as i,_ as r,C as p}from"./Card-7d71d8a7.js";import{l as g}from"./date-7cb373b2.js";import{d as c,b as h,f as m,g as l,u as o,o as f,h as d,a,t,y as k}from"./app-75a3a99f.js";const x=a("div",{class:"flex justify-between items-center"},[a("h5",{class:"font-bold text-xl text-dark"},"Informasi Penagihan")],-1),j=a("td",null,"Proyek",-1),y=a("td",{class:"pl-6 pr-3"},":",-1),C={class:"font-medium text-dark"},b=a("td",null,"Tahun Anggaran",-1),P=a("td",{class:"pl-6 pr-3"},":",-1),v={class:"font-medium text-dark"},B=a("td",null,"Pengguna Jasa",-1),w=a("td",{class:"pl-6 pr-3"},":",-1),I={class:"font-medium text-dark"},N=a("td",null,"Keperluan",-1),S=a("td",{class:"pl-6 pr-3"},":",-1),T={class:"font-medium text-dark"},V=a("td",null,"Tanggal Pengajuan",-1),z=a("td",{class:"pl-6 pr-3"},":",-1),A={class:"font-medium text-dark"},D=a("td",null,"Status Pengajuan",-1),H=a("td",{class:"pl-6 pr-3"},":",-1),O=c({__name:"InformasiPartial",props:{keuangan:{},penagihan:{}},setup(_){const s=_,e=h(()=>{const n=s.penagihan.tanggal_pengajuan?g(s.penagihan.tanggal_pengajuan):"Belum diajukan",u=s.penagihan.status_penagihan==400?"Closed":"Open";return{...s.penagihan,tanggal_pengajuan_in_string:n,status_penagihan_in_string:u}});return(n,u)=>(f(),m(o(p),{class:"w-fit"},{default:l(()=>[d(o(i),null,{default:l(()=>[x]),_:1}),d(o(r),null,{default:l(()=>[a("table",null,[a("tbody",null,[a("tr",null,[j,y,a("td",null,[a("span",C,t(n.keuangan.nama_proyek),1)])]),a("tr",null,[b,P,a("td",null,[a("span",v,t(n.keuangan.tahun_anggaran),1)])]),a("tr",null,[B,w,a("td",null,[a("span",I,t(n.keuangan.pengguna_jasa),1)])]),a("tr",null,[N,S,a("td",null,[a("span",T,t(n.keuangan.keperluan),1)])]),a("tr",null,[V,z,a("td",null,[a("span",A,t(e.value.tanggal_pengajuan_in_string),1)])]),a("tr",null,[D,H,a("td",null,[a("span",{class:k(["font-semibold",{"text-primary":e.value.status_penagihan==100,"text-danger":e.value.status_penagihan==400}])},t(e.value.status_penagihan_in_string),3)])])])])]),_:1})]),_:1}))}});export{O as _};