function o(t){return t===null?0:parseFloat(t)}async function e(t){const n=t.replace(/,/g,""),r=parseFloat(n).toFixed(2);return o(r)}function a(t){return new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(t)}export{o as a,e as s,a as t};
