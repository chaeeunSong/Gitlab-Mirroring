(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[32],{396:function(e,t,i){"use strict";i.r(t);var l=i(0),s=i(4),n=i.n(s),o=i(113),d=i(266),c=i(32),r=i(306),a=i(33),b=i(20),u=i(309),h=i(307),p=i(308),m=e=>{let{showCompanyField:t=!1,showApartmentField:i=!1,showPhoneField:s=!1,requireCompanyField:n=!1,requirePhoneField:o=!1}=e;const{defaultAddressFields:d,billingFields:c,setBillingFields:m,setPhone:w}=Object(r.a)(),{dispatchCheckoutEvent:F}=Object(a.a)(),{isEditor:g}=Object(b.a)();Object(l.useEffect)(()=>{s||w("")},[s,w]);const j=Object(l.useMemo)(()=>({company:{hidden:!t,required:n},address_2:{hidden:!i}}),[t,n,i]),O=g?h.a:l.Fragment;return Object(l.createElement)(O,null,Object(l.createElement)(u.a,{id:"billing",type:"billing",onChange:e=>{m(e),F("set-billing-address")},values:c,fields:Object.keys(d),fieldConfig:j}),s&&Object(l.createElement)(p.a,{isRequired:o,value:c.phone,onChange:e=>{w(e),F("set-phone-number",{step:"billing"})}}))},w=i(1),F=i(238),g={...Object(F.a)({defaultTitle:Object(w.__)("Billing address","woo-gutenberg-products-block"),defaultDescription:Object(w.__)("Enter the address that matches your card or payment method.","woo-gutenberg-products-block")}),className:{type:"string",default:""},lock:{type:"object",default:{move:!0,remove:!0}}},j=i(137);t.default=Object(o.withFilteredAttributes)(g)(e=>{let{title:t,description:i,showStepNumber:s,children:o,className:a}=e;const{isProcessing:b}=Object(c.b)(),{showBillingFields:u}=Object(r.a)(),{requireCompanyField:h,requirePhoneField:p,showApartmentField:w,showCompanyField:F,showPhoneField:g}=Object(j.b)();return u?Object(l.createElement)(d.a,{id:"billing-fields",disabled:b,className:n()("wc-block-checkout__billing-fields",a),title:t,description:i,showStepNumber:s},Object(l.createElement)(m,{requireCompanyField:h,showApartmentField:w,showCompanyField:F,showPhoneField:g,requirePhoneField:p}),o):null})}}]);