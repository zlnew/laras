import{_ as l}from"./_plugin-vue_export-helper-c27b6911.js";import{o as s,c as a,r as o,d as c,x as d,b as i,t as u}from"./app-9f499f35.js";const _={},f={class:"align-bottom"};function m(e,t){return s(),a("thead",f,[o(e.$slots,"default")])}const B=l(_,[["render",m]]),h={};function g(e,t){return s(),a("tbody",null,[o(e.$slots,"default")])}const k=l(h,[["render",g]]),v=c({__name:"Row",props:{last:{type:Boolean,default:!1}},setup(e){return(t,r)=>(s(),a("tr",{class:d([{"border-b":!t.last}])},[o(t.$slots,"default")],2))}}),A=c({__name:"HeadCell",props:{value:{default:""},textAlign:{default:"left"}},setup(e){const t=e,r=i(()=>{switch(t.textAlign){case"right":return"text-right";case"center":return"text-center";default:return"text-left"}});return(n,p)=>(s(),a("th",{class:d([[r.value],"px-6 py-3 text-xxs font-bold text-dark/80 uppercase align-middle bg-transparent border-b border-light shadow-none border-b-solid tracking-none whitespace-nowrap"])},u(n.value),3))}}),T=c({__name:"BodyCell",props:{textAlign:{default:"left"},whitespace:{default:"normal"}},setup(e){const t=e,r=i(()=>{switch(t.textAlign){case"right":return"text-right";case"center":return"text-center";default:return"text-left"}});return(n,p)=>(s(),a("td",{class:d([[r.value,{"whitespace-nowrap":n.whitespace=="nowrap"}],"px-6 py-3 text-sm align-middle bg-transparent shadow-transparent"])},[o(n.$slots,"default")],2))}}),x={},b={class:"items-center w-full mb-0 align-top border-gray-200 text-slate-500"};function $(e,t,r,n,p,w){return s(),a("table",b,[o(e.$slots,"default")])}const H=l(x,[["render",$]]);export{H as T,v as _,B as a,A as b,k as c,T as d};
